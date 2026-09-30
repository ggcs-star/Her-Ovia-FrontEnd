const API_BASE_URL = window.API_BASE_URL;
const token = localStorage.getItem('token');

const reviewRatings = {
    1: 'Very Bad',
    2: 'Bad',
    3: 'Okay-Okay',
    4: 'Good',
    5: 'Very Good'
};

let orders = [];
let activeOrderIndex = 0;
let activeProductIndex = 0;

document.addEventListener('DOMContentLoaded', function () {
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token || !user.id) {
        sessionStorage.setItem('redirect_after_login', '/write-review');
        window.location.href = '/user/login';
        return;
    }

    loadReviewOrders();
});

async function loadReviewOrders() {
    const container = document.getElementById('write-review-list');
    if (!container) return;

    try {
        const response = await fetch(`${API_BASE_URL}/orders?per_page=100&_=${Date.now()}`, {
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + token,
                Accept: 'application/json',
                'Cache-Control': 'no-cache'
            }
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Unable to load orders.');
        }

        const allOrders = data?.success && data?.data?.data ? data.data.data : [];

        const deliveredOrders = allOrders.filter(order =>
            String(order.status || '').toLowerCase() === 'delivered' &&
            Array.isArray(order.items) &&
            order.items.length
        );

        if (!deliveredOrders.length) {
            renderEmptyState();
            return;
        }

        orders = await Promise.all(
            deliveredOrders.map(async order => {
                const items = order.items.filter(item => getProductId(item));

                const products = await Promise.all(
                    items.map(async item => {
                        const productId = getProductId(item);

                        return {
                            item,
                            productId,
                            existingReview: await getExistingReview(productId, order.id)
                        };
                    })
                );

                return {
                    ...order,
                    reviewProducts: products
                };
            })
        );

        const firstPendingOrder = orders.findIndex(order =>
            order.reviewProducts.some(product => !product.existingReview)
        );

        activeOrderIndex = firstPendingOrder >= 0 ? firstPendingOrder : 0;
        activeProductIndex = getFirstUnreviewedProductIndex(orders[activeOrderIndex]);

        renderPage();
    } catch (error) {
        console.error('Write review orders error:', error);
        renderErrorState();
    }
}

function renderPage() {
    const container = document.getElementById('write-review-list');
    if (!container) return;

    container.innerHTML = `
        ${renderOrderStrip()}
        ${renderActiveOrder()}
        ${renderMoreOrders()}
    `;

    bindEvents();
}

function renderOrderStrip() {
    return `
        <div class="write-review-order-strip">
            ${orders.map((order, index) => {
                const reviewed = getReviewedCount(order) === order.reviewProducts.length;

                return `
                    <button type="button"
                        class="write-review-order-strip-card ${index === activeOrderIndex ? 'active' : ''}"
                        data-action="select-order"
                        data-order-index="${index}">
                        <div class="write-review-order-strip-top">
                            <div>
                                <div class="write-review-strip-date">${formatDate(order.created_at)}</div>
                                <div class="write-review-strip-number">#${escapeHtml(order.order_number || order.id || 'Order')}</div>
                            </div>
                            <span class="write-review-status ${reviewed ? 'reviewed' : 'pending'}">
                                ${reviewed ? '✓ Reviewed' : '⌛ Reviews Pending'}
                            </span>
                        </div>
                        <div class="write-review-strip-bottom">
                            <div class="write-review-strip-images">
                                ${order.reviewProducts.slice(0, 3).map(product => `
                                    <img src="${escapeAttribute(getProductImage(product.item))}"
                                        alt="${escapeAttribute(product.item.product_name || 'Product')}"
                                        onerror="this.src='https://placehold.co/80x100?text=No+Image'">
                                `).join('')}
                            </div>
                            <div class="write-review-strip-summary">
                                <strong>${order.reviewProducts.length} ${order.reviewProducts.length === 1 ? 'Item' : 'Items'}</strong>
                                ${formatCurrency(order.total)}
                            </div>
                        </div>
                    </button>
                `;
            }).join('')}
        </div>
    `;
}

function renderActiveOrder() {
    const order = orders[activeOrderIndex];
    if (!order) return '';

    const products = order.reviewProducts || [];
    const product = products[activeProductIndex] || products[0];
    if (!product) return '';

    activeProductIndex = products.indexOf(product);

    return `
        <section class="write-review-main-card">
            <div class="write-review-main-header">
                <div class="write-review-main-order">
                    <div class="write-review-order-icon">▣</div>
                    <div>
                        <h2>Order #${escapeHtml(order.order_number || order.id || 'Order')}</h2>
                        <div class="write-review-main-order-meta">
                            <span>Placed on ${formatDate(order.created_at)}</span>
                            <span>|</span>
                            <span>${products.length} ${products.length === 1 ? 'Item' : 'Items'}</span>
                            <span>|</span>
                            <strong>Total: ${formatCurrency(order.total)}</strong>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="write-review-status reviewed">✓ Delivered</span>
                    <button type="button"
                        class="write-review-order-details-btn"
                        data-action="view-order"
                        data-order-id="${escapeAttribute(order.id)}">
                        View Order Details
                    </button>
                </div>
            </div>
            <div class="write-review-workspace">
                <div class="write-review-product-list">
                    ${products.map((product, index) => renderProductSelector(product, index)).join('')}
                </div>
                ${renderProductDetail(order, product)}
            </div>
            ${renderProgress(order)}
        </section>
    `;
}

function renderProductSelector(product, index) {
    const item = product.item;
    const productName = item.product_name || item.product?.name || item.product?.product_name || 'Product';

    return `
        <button type="button"
            class="write-review-product-select ${index === activeProductIndex ? 'active' : ''}"
            data-action="select-product"
            data-product-index="${index}">
            <span class="write-review-product-number">${String(index + 1).padStart(2, '0')}</span>
            <img src="${escapeAttribute(getProductImage(item))}"
                alt="${escapeAttribute(productName)}"
                onerror="this.src='https://placehold.co/100x120?text=No+Image'">
            <span class="write-review-product-select-info">
                <span class="write-review-product-select-name">${escapeHtml(productName)}</span>
                <span class="write-review-product-select-meta">${getProductMeta(item)}</span>
                <span class="write-review-product-select-price">${formatCurrency(item.price || item.final_price || item.amount || 0)}</span>
            </span>
            <span class="write-review-product-arrow">›</span>
        </button>
    `;
}

function renderProductDetail(order, product) {
    const item = product.item;
    const review = product.existingReview;
    const productName = item.product_name || item.product?.name || item.product?.product_name || 'Product';
    const imageList = getProductImages(item);
    const rating = Number(review?.rating || 0);
    const reviewText = review?.text || review?.review || '';
    const reviewId = review?.id || '';

    return `
        <div class="write-review-detail">
            <div class="write-review-gallery">
                <div class="write-review-main-image-wrap">
                    <img class="write-review-main-image"
                        data-role="main-product-image"
                        src="${escapeAttribute(imageList[0])}"
                        alt="${escapeAttribute(productName)}"
                        onerror="this.src='https://placehold.co/700x800?text=No+Image'">
                    ${imageList.length > 1 ? `
                        <button type="button" class="write-review-gallery-arrow left" data-action="gallery-prev">‹</button>
                        <button type="button" class="write-review-gallery-arrow right" data-action="gallery-next">›</button>
                    ` : ''}
                </div>
                <div class="write-review-thumbs">
                    ${imageList.map((image, index) => `
                        <button type="button"
                            class="write-review-thumb ${index === 0 ? 'active' : ''}"
                            data-action="gallery-image"
                            data-image-index="${index}">
                            <img src="${escapeAttribute(image)}"
                                alt="Product image ${index + 1}"
                                onerror="this.src='https://placehold.co/100x120?text=No+Image'">
                        </button>
                    `).join('')}
                </div>
            </div>

            <div class="write-review-form-panel">
                <h3 class="write-review-form-title">${escapeHtml(productName)}</h3>

                <div class="write-review-product-meta">
                    ${getProductMeta(item)}
                    <span>|</span>
                    <span>${formatCurrency(item.price || item.final_price || item.amount || 0)}</span>
                </div>

                <form class="write-review-form-element"
                    data-review-id="${escapeAttribute(reviewId)}"
                    data-order-id="${escapeAttribute(order.id)}"
                    data-product-id="${escapeAttribute(product.productId)}">

                    <label class="write-review-rating-heading">Your Rating <span>*</span></label>

                    <div class="write-review-stars">
                        ${[1, 2, 3, 4, 5].map(value => `
                            <button type="button"
                                class="write-review-star ${value <= rating ? 'active' : ''}"
                                data-action="rating"
                                data-rating="${value}">
                                ${value <= rating ? '★' : '☆'}
                            </button>
                        `).join('')}
                    </div>

                    <div class="write-review-rating-title" data-role="rating-title">
                        ${rating ? reviewRatings[rating] : 'Select a rating'}
                    </div>

                    <input type="hidden" name="rating" value="${rating || ''}">
                    <input type="hidden" name="size" value="${escapeAttribute(review?.size || getItemSize(item))}">
                    <input type="hidden" name="color" value="${escapeAttribute(review?.color || getItemColor(item))}">

                    <label class="write-review-review-heading">Your Review <span>*</span></label>

                    <textarea name="review"
                        maxlength="5000"
                        required
                        placeholder="Share your experience with this product...">${escapeHtml(reviewText)}</textarea>

                    <div class="write-review-character-count">
                        <span data-role="character-count">${reviewText.length}</span>/5000
                    </div>

                    <div class="write-review-media-head">
                        <label class="write-review-media-heading">
                            Add Photos or Video
                            <span style="font-weight:400">(Optional)</span>
                        </label>
                        <span class="write-review-media-help">Up to 5 photos and 1 video</span>
                    </div>

                    <div class="write-review-upload-row">
                        <label class="write-review-upload-box">
                            <input type="file"
                                name="images"
                                accept="image/jpeg,image/png,image/webp"
                                multiple>
                            <span class="write-review-upload-content">
                                <span class="write-review-upload-icon">▧</span>
                                <span class="write-review-upload-title">Add Photos</span>
                                <span class="write-review-upload-help">JPG, PNG, WEBP · Max 5MB</span>
                            </span>
                        </label>

                        <label class="write-review-upload-box">
                            <input type="file"
                                name="video"
                                accept="video/mp4,video/quicktime,video/x-msvideo,video/webm">
                            <span class="write-review-upload-content">
                                <span class="write-review-upload-icon">▣</span>
                                <span class="write-review-upload-title">Add Video</span>
                                <span class="write-review-upload-help">MP4, MOV, AVI, WEBM · Max 20MB</span>
                            </span>
                        </label>
                    </div>

                    ${renderExistingMedia(review)}

                    <div class="write-review-media-preview" data-role="new-media-preview"></div>
                    <div class="write-review-message" data-role="message"></div>

                    <div class="write-review-form-actions">
                        <button type="button"
                            class="write-review-cancel-btn"
                            data-action="skip-product">
                            Skip this product
                        </button>
                        <button type="submit" class="write-review-submit-btn">
                            ${review ? 'Update & Save' : 'Save & Next Product →'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function renderExistingMedia(review) {
    if (!review) return '';

    const images = Array.isArray(review.images) ? review.images : [];
    const video = review.video || '';

    if (!images.length && !video) return '';

    return `
        <div class="write-review-existing-label">Your submitted media</div>
        <div class="write-review-media-preview">
            ${images.map(url => `
                <div class="write-review-media-item">
                    <img src="${escapeAttribute(url)}"
                        alt="Review image"
                        onerror="this.style.display='none'">
                </div>
            `).join('')}
            ${video ? `
                <div class="write-review-media-item">
                    <video controls preload="metadata" src="${escapeAttribute(video)}"></video>
                </div>
            ` : ''}
        </div>
    `;
}

function renderProgress(order) {
    const total = order.reviewProducts.length;
    const reviewed = getReviewedCount(order);
    const percent = total ? Math.round((reviewed / total) * 100) : 0;
    const remaining = Math.max(total - reviewed, 0);

    return `
        <div class="write-review-progress">
            <div class="write-review-progress-text">
                <strong>Order Progress:</strong> ${reviewed} of ${total} products reviewed
            </div>
            <div class="write-review-progress-track">
                <div class="write-review-progress-fill" style="width:${percent}%"></div>
            </div>
            <div class="write-review-progress-percent">${percent}%</div>
            <div class="write-review-bottom-actions">
                <button type="button"
                    class="write-review-nav-btn"
                    data-action="previous-product"
                    ${activeProductIndex <= 0 ? 'disabled' : ''}>
                    ← Previous Product
                </button>
                <button type="button"
                    class="write-review-nav-btn"
                    data-action="next-product"
                    ${activeProductIndex >= total - 1 ? 'disabled' : ''}>
                    Save & Next Product →
                </button>
                <button type="button"
                    class="write-review-finish-btn"
                    data-action="finish-order">
                    ${remaining > 0 ? `Finish Order Review (${remaining} Remaining)` : 'Finish Order Review'} →
                </button>
            </div>
        </div>
    `;
}

function renderMoreOrders() {
    const otherOrders = orders.filter((_, index) => index !== activeOrderIndex);
    if (!otherOrders.length) return '';

    return `
        <section class="write-review-more">
            <div class="write-review-more-heading">
                <h2>More Orders to Review</h2>
                <span>You can also review products from your other delivered orders.</span>
            </div>
            <div class="write-review-more-grid">
                ${otherOrders.map(order => {
                    const index = orders.indexOf(order);
                    const firstProduct = order.reviewProducts[0];
                    const reviewed = getReviewedCount(order) === order.reviewProducts.length;

                    return `
                        <button type="button"
                            class="write-review-more-card"
                            data-action="select-order"
                            data-order-index="${index}">
                            <img src="${escapeAttribute(getProductImage(firstProduct.item))}"
                                alt="Order product"
                                onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                            <span class="write-review-more-info">
                                <span class="write-review-more-date">${formatDate(order.created_at)}</span>
                                <span class="write-review-more-number">#${escapeHtml(order.order_number || order.id || 'Order')}</span>
                                <span class="write-review-status ${reviewed ? 'reviewed' : 'pending'}">
                                    ${reviewed ? '✓ Reviewed' : '⌛ Reviews Pending'}
                                </span>
                                <span class="write-review-more-meta">
                                    ${order.reviewProducts.length} ${order.reviewProducts.length === 1 ? 'Item' : 'Items'}
                                    &nbsp; | &nbsp; ${formatCurrency(order.total)}
                                </span>
                            </span>
                        </button>
                    `;
                }).join('')}
            </div>
        </section>
    `;
}

function bindEvents() {
    document.querySelectorAll('[data-action="select-order"]').forEach(button => {
        button.addEventListener('click', function () {
            const index = Number(this.dataset.orderIndex);
            if (!Number.isInteger(index) || !orders[index]) return;

            activeOrderIndex = index;
            activeProductIndex = getFirstUnreviewedProductIndex(orders[index]);
            renderPage();
            scrollToMainCard();
        });
    });

    document.querySelectorAll('[data-action="select-product"]').forEach(button => {
        button.addEventListener('click', function () {
            activeProductIndex = Number(this.dataset.productIndex);
            renderPage();
        });
    });

    document.querySelectorAll('[data-action="view-order"]').forEach(button => {
        button.addEventListener('click', function () {
            window.location.href = `/order-confirmation/${this.dataset.orderId}`;
        });
    });

    document.querySelectorAll('[data-action="previous-product"]').forEach(button => {
        button.addEventListener('click', function () {
            if (activeProductIndex > 0) {
                activeProductIndex--;
                renderPage();
            }
        });
    });

    document.querySelectorAll('[data-action="next-product"]').forEach(button => {
        button.addEventListener('click', function () {
            const products = orders[activeOrderIndex].reviewProducts;

            if (activeProductIndex < products.length - 1) {
                activeProductIndex++;
                renderPage();
            }
        });
    });

    document.querySelectorAll('[data-action="finish-order"]').forEach(button => {
        button.addEventListener('click', function () {
            const order = orders[activeOrderIndex];
            const pendingIndex = order.reviewProducts.findIndex(product => !product.existingReview);

            if (pendingIndex >= 0) {
                activeProductIndex = pendingIndex;
                renderPage();
                scrollToMainCard();
                return;
            }

            const nextOrderIndex = orders.findIndex((item, index) =>
                index !== activeOrderIndex &&
                item.reviewProducts.some(product => !product.existingReview)
            );

            if (nextOrderIndex >= 0) {
                activeOrderIndex = nextOrderIndex;
                activeProductIndex = getFirstUnreviewedProductIndex(orders[nextOrderIndex]);
                renderPage();
                scrollToMainCard();
                return;
            }

            window.location.href = '/orders';
        });
    });

    document.querySelectorAll('[data-action="rating"]').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.write-review-form-element');
            if (!form) return;

            setRating(form, Number(this.dataset.rating));
        });
    });

    document.querySelectorAll('.write-review-form-element').forEach(form => {
        form.addEventListener('submit', submitProductReview);

        const textarea = form.querySelector('textarea[name="review"]');

        if (textarea) {
            textarea.addEventListener('input', function () {
                const counter = form.querySelector('[data-role="character-count"]');
                if (counter) counter.textContent = this.value.length;
            });
        }

        const imageInput = form.querySelector('input[name="images"]');

        if (imageInput) {
            imageInput.addEventListener('change', function () {
                previewImages(form, this);
            });
        }

        const videoInput = form.querySelector('input[name="video"]');

        if (videoInput) {
            videoInput.addEventListener('change', function () {
                previewVideo(form, this);
            });
        }
    });

    document.querySelectorAll('[data-action="skip-product"]').forEach(button => {
        button.addEventListener('click', function () {
            const order = orders[activeOrderIndex];

            if (activeProductIndex < order.reviewProducts.length - 1) {
                activeProductIndex++;
                renderPage();
            }
        });
    });

    bindGalleryEvents();
}

function bindGalleryEvents() {
    let galleryIndex = 0;

    const product = orders[activeOrderIndex]?.reviewProducts?.[activeProductIndex];
    const images = getProductImages(product?.item);
    const mainImage = document.querySelector('[data-role="main-product-image"]');

    if (!mainImage || !images.length) return;

    document.querySelectorAll('[data-action="gallery-image"]').forEach(button => {
        button.addEventListener('click', function () {
            galleryIndex = Number(this.dataset.imageIndex);
            updateGallery(galleryIndex, images);
        });
    });

    document.querySelectorAll('[data-action="gallery-prev"]').forEach(button => {
        button.addEventListener('click', function () {
            galleryIndex = (galleryIndex - 1 + images.length) % images.length;
            updateGallery(galleryIndex, images);
        });
    });

    document.querySelectorAll('[data-action="gallery-next"]').forEach(button => {
        button.addEventListener('click', function () {
            galleryIndex = (galleryIndex + 1) % images.length;
            updateGallery(galleryIndex, images);
        });
    });
}

function updateGallery(index, images) {
    const mainImage = document.querySelector('[data-role="main-product-image"]');
    if (!mainImage) return;

    mainImage.src = images[index];

    document.querySelectorAll('.write-review-thumb').forEach((thumb, thumbIndex) => {
        thumb.classList.toggle('active', thumbIndex === index);
    });
}

function setRating(form, rating) {
    const input = form.querySelector('input[name="rating"]');
    const title = form.querySelector('[data-role="rating-title"]');

    if (input) input.value = rating;
    if (title) title.textContent = reviewRatings[rating] || 'Select a rating';

    form.querySelectorAll('.write-review-star').forEach(button => {
        const value = Number(button.dataset.rating);
        const active = value <= rating;

        button.classList.toggle('active', active);
        button.textContent = active ? '★' : '☆';
    });
}

async function submitProductReview(event) {
    event.preventDefault();

    const form = event.currentTarget;
    const productId = form.dataset.productId;
    const orderId = form.dataset.orderId;
    const reviewId = form.dataset.reviewId || '';
    const message = form.querySelector('[data-role="message"]');
    const submitButton = form.querySelector('.write-review-submit-btn');

    const rating = Number(form.querySelector('input[name="rating"]')?.value || 0);
    const reviewText = (form.querySelector('textarea[name="review"]')?.value || '').trim();
    const size = (form.querySelector('input[name="size"]')?.value || '').trim();
    const color = (form.querySelector('input[name="color"]')?.value || '').trim();
    const imageInput = form.querySelector('input[name="images"]');
    const videoInput = form.querySelector('input[name="video"]');

    if (!rating) {
        showMessage(message, 'Please select a rating.', 'error');
        return;
    }

    if (reviewText.length < 2) {
        showMessage(message, 'Please enter your review.', 'error');
        return;
    }

    if (!validateImages(imageInput, message)) return;
    if (!validateVideo(videoInput, message)) return;

    const formData = new FormData();

    formData.append('product_id', productId);
    formData.append('order_id', orderId);
    formData.append('rating', rating);
    formData.append('review', reviewText);

    if (size) formData.append('size', size);
    if (color) formData.append('color', color);

    if (imageInput?.files?.length) {
        Array.from(imageInput.files).forEach(file => {
            formData.append('images[]', file);
        });
    }

    if (videoInput?.files?.length) {
        formData.append('video', videoInput.files[0]);
    }

    submitButton.disabled = true;
    submitButton.textContent = reviewId ? 'Updating...' : 'Saving...';

    try {
        const url = reviewId
            ? `${API_BASE_URL}/product-reviews/${reviewId}/update`
            : `${API_BASE_URL}/product-reviews`;

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                Authorization: 'Bearer ' + token,
                Accept: 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            showMessage(message, getApiErrorMessage(data), 'error');
            return;
        }

        const updatedReview = data?.data?.review || null;

        if (updatedReview) {
            updateReviewState(updatedReview);
        }

        showMessage(
            message,
            data.message || (reviewId
                ? 'Your review has been updated successfully.'
                : 'Your review has been submitted successfully.'),
            'success'
        );

        setTimeout(() => {
            const products = orders[activeOrderIndex].reviewProducts;

            if (activeProductIndex < products.length - 1) {
                activeProductIndex++;
            }

            renderPage();
            scrollToMainCard();
        }, 700);
    } catch (error) {
        console.error('Review submit error:', error);
        showMessage(message, 'Something went wrong. Please try again.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = reviewId ? 'Update & Save' : 'Save & Next Product →';
    }
}

function updateReviewState(review) {
    const product = orders[activeOrderIndex]?.reviewProducts?.[activeProductIndex];

    if (product) {
        product.existingReview = review;
    }
}

function getFirstUnreviewedProductIndex(order) {
    if (!order?.reviewProducts?.length) return 0;

    const index = order.reviewProducts.findIndex(product => !product.existingReview);
    return index >= 0 ? index : 0;
}

function getReviewedCount(order) {
    return (order?.reviewProducts || []).filter(product => Boolean(product.existingReview)).length;
}

async function getExistingReview(productId, orderId) {
    try {
        const query = new URLSearchParams({
            product_id: productId,
            order_id: orderId
        });

        const response = await fetch(
            `${API_BASE_URL}/product-reviews/existing?${query.toString()}`,
            {
                method: 'GET',
                headers: {
                    Authorization: 'Bearer ' + token,
                    Accept: 'application/json'
                }
            }
        );

        if (!response.ok) return null;

        const data = await response.json();

        return data?.success && data?.exists ? data.data.review : null;
    } catch (error) {
        console.error('Existing review error:', error);
        return null;
    }
}

function previewImages(form, input) {
    const preview = form.querySelector('[data-role="new-media-preview"]');
    const message = form.querySelector('[data-role="message"]');

    if (!preview) return;

    preview.innerHTML = '';

    if (!validateImages(input, message)) return;

    Array.from(input.files || []).forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (event) {
            const item = document.createElement('div');
            item.className = 'write-review-media-item';

            const image = document.createElement('img');
            image.src = event.target.result;
            image.alt = 'New review photo';

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'write-review-media-remove';
            remove.textContent = '×';
            remove.dataset.index = index;

            remove.addEventListener('click', function () {
                const dt = new DataTransfer();

                Array.from(input.files).forEach((file, fileIndex) => {
                    if (fileIndex !== Number(this.dataset.index)) {
                        dt.items.add(file);
                    }
                });

                input.files = dt.files;
                previewImages(form, input);
            });

            item.appendChild(image);
            item.appendChild(remove);
            preview.appendChild(item);
        };

        reader.readAsDataURL(file);
    });
}

function previewVideo(form, input) {
    const preview = form.querySelector('[data-role="new-media-preview"]');
    const message = form.querySelector('[data-role="message"]');

    if (!preview) return;
    if (!validateVideo(input, message)) return;

    preview.querySelectorAll('video').forEach(video => {
        video.closest('.write-review-media-item')?.remove();
    });

    const file = input.files?.[0];
    if (!file) return;

    const item = document.createElement('div');
    item.className = 'write-review-media-item';

    const video = document.createElement('video');
    video.controls = true;
    video.muted = true;
    video.src = URL.createObjectURL(file);

    const remove = document.createElement('button');
    remove.type = 'button';
    remove.className = 'write-review-media-remove';
    remove.textContent = '×';

    remove.addEventListener('click', function () {
        input.value = '';
        item.remove();
    });

    item.appendChild(video);
    item.appendChild(remove);
    preview.appendChild(item);
}

function validateImages(input, message) {
    if (!input?.files) return true;

    const files = Array.from(input.files);

    if (files.length > 5) {
        showMessage(message, 'You can upload a maximum of 5 photos.', 'error');
        input.value = '';
        return false;
    }

    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

    for (const file of files) {
        if (!allowedTypes.includes(file.type)) {
            showMessage(message, 'Only JPG, PNG and WEBP images are allowed.', 'error');
            input.value = '';
            return false;
        }

        if (file.size > 5 * 1024 * 1024) {
            showMessage(message, 'Each photo must be smaller than 5 MB.', 'error');
            input.value = '';
            return false;
        }
    }

    return true;
}

function validateVideo(input, message) {
    if (!input?.files?.length) return true;

    const file = input.files[0];
    const allowedTypes = [
        'video/mp4',
        'video/quicktime',
        'video/x-msvideo',
        'video/webm'
    ];

    if (!allowedTypes.includes(file.type)) {
        showMessage(message, 'Only MP4, MOV, AVI and WEBM videos are allowed.', 'error');
        input.value = '';
        return false;
    }

    if (file.size > 20 * 1024 * 1024) {
        showMessage(message, 'Video must be smaller than 20 MB.', 'error');
        input.value = '';
        return false;
    }

    return true;
}

function showMessage(container, message, type) {
    if (!container) return;

    container.textContent = message;
    container.className = `write-review-message show ${type}`;
}

function renderEmptyState() {
    const container = document.getElementById('write-review-list');
    if (!container) return;

    container.innerHTML = `
        <div class="write-review-empty">
            <div class="write-review-empty-icon">📦</div>
            <h3>No delivered orders</h3>
            <p>You can write reviews after your order has been delivered.</p>
            <a href="/orders" class="write-review-back-btn">Back to Orders</a>
        </div>
    `;
}

function renderErrorState() {
    const container = document.getElementById('write-review-list');
    if (!container) return;

    container.innerHTML = `
        <div class="write-review-error">
            <div class="write-review-empty-icon">!</div>
            <h3>Unable to load your orders</h3>
            <p>Please refresh the page and try again.</p>
            <button type="button"
                class="write-review-back-btn"
                onclick="loadReviewOrders()">
                Try Again
            </button>
        </div>
    `;
}

function getProductId(item) {
    return item?.product_id ||
        item?.product?.id ||
        item?.product?.product_id ||
        null;
}

function getProductImages(item) {
    const raw = [];

    if (item?.image) raw.push(item.image);
    if (item?.variant?.image_url) raw.push(item.variant.image_url);

    const gallery = item?.product?.gallery_images;

    if (Array.isArray(gallery)) {
        gallery.forEach(image => {
            if (typeof image === 'string') raw.push(image);
            else if (image?.image_url) raw.push(image.image_url);
            else if (image?.url) raw.push(image.url);
        });
    }

    if (item?.product?.image_url) raw.push(item.product.image_url);
    if (item?.product?.main_image) raw.push(item.product.main_image);

    const normalized = raw
        .filter(Boolean)
        .map(image => image.startsWith('http')
            ? image
            : `https://her-ovia.s3.us-east-1.amazonaws.com/${image}`
        );

    const unique = [...new Map(
        normalized.map(image => [image.split('?')[0], image])
    ).values()];

    return unique.length
        ? unique
        : ['https://placehold.co/700x800?text=No+Image'];
}

function getProductImage(item) {
    return getProductImages(item)[0];
}

function getItemSize(item) {
    return item?.variant?.variant_value ||
        item?.variant?.value ||
        item?.size ||
        '';
}

function getItemColor(item) {
    return item?.color ||
        item?.variant?.color ||
        '';
}

function getProductMeta(item) {
    const parts = [];
    const size = getItemSize(item);
    const color = getItemColor(item);
    const quantity = Number(item?.quantity || 1);

    if (size) parts.push(`Size: ${escapeHtml(size)}`);
    if (color) parts.push(`Color: ${escapeHtml(color)}`);
    parts.push(`Qty: ${quantity}`);

    return parts.join(' &nbsp; | &nbsp; ');
}

function formatDate(value) {
    if (!value) return '-';

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) return '-';

    return date.toLocaleDateString('en-IN', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
}

function formatCurrency(value) {
    const amount = Number(value || 0);

    return amount.toLocaleString('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    });
}

function getApiErrorMessage(data) {
    let message = data?.message || 'Unable to save your review.';

    if (data?.errors) {
        const firstError = Object.values(data.errors)[0];

        if (Array.isArray(firstError) && firstError.length) {
            message = firstError[0];
        } else if (typeof firstError === 'string') {
            message = firstError;
        }
    }

    return message;
}

function scrollToMainCard() {
    document.querySelector('.write-review-main-card')?.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function escapeAttribute(value) {
    return escapeHtml(value);
}