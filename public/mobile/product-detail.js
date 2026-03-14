(function() {
    if (!document.body.classList.contains('product-detail-page') && !document.body.classList.contains('category-products-page')) return;
    
    let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    let currentProduct = null;
    let currentImages = [];
    let currentImageIndex = 0;
    let allColors = [];
    let allSizes = [];
    let selectedColor = null;
    let selectedSize = null;
    let selectedVariant = null;
    let allCoupons = [];
    let showAllOffers = false;
    let allReviews = [];
    let currentReviewIndex = 0;
    let imageTimer = null;
    
    // ✅ Session se previous page info load karo
    const fromProductPage = sessionStorage.getItem('fromProductPage');
    if (fromProductPage) {
        console.log('Returning from product page');
        sessionStorage.removeItem('fromProductPage');
    }
    
    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = cartItems.length;
        }
    }
    
    function showConfirmation(productName) {
        const existingConfirmation = document.querySelector('.add-confirmation, .cart-confirmation-popup');
        if (existingConfirmation) existingConfirmation.remove();
        
        const popup = document.createElement('div');
        popup.className = 'cart-confirmation-popup';
        popup.innerHTML = `
            <div class="cart-confirmation-overlay" onclick="closeCartConfirmation()"></div>
            <div class="cart-confirmation-content">
                <div class="cart-confirmation-icon">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#ff3f6c" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke-linecap="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="cart-confirmation-title">Added to Bag!</h3>
                <p class="cart-confirmation-product">${productName}</p>
                <div class="cart-confirmation-actions">
                    <button class="cart-confirmation-viewbag" onclick="window.location.href='/cart'">VIEW BAG</button>
                    <button class="cart-confirmation-continue" onclick="closeCartConfirmation()">CONTINUE SHOPPING</button>
                </div>
                <button class="cart-confirmation-close" onclick="closeCartConfirmation()">✕</button>
            </div>
        `;
        
        document.body.appendChild(popup);
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            const popupElement = document.querySelector('.cart-confirmation-popup');
            if (popupElement) {
                popupElement.classList.add('fade-out');
                setTimeout(() => {
                    closeCartConfirmation();
                }, 300);
            }
        }, 3000);
    }

    window.closeCartConfirmation = function() {
        const popup = document.querySelector('.cart-confirmation-popup');
        if (popup) {
            popup.remove();
            document.body.style.overflow = '';
        }
    };
    
    window.addToBag = function(product) {
    console.log('🛒 addToBag called with product:', product);
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // 🔥 ACTIVE VARIANT DHUNDHO
    const activeBtn = document.querySelector('.pdp-size-btn.active');
    let selectedVariant = null;
    
    if (product.variants && product.variants.length > 0) {
        if (activeBtn) {
            const variantId = activeBtn.dataset.variantId;
            selectedVariant = product.variants.find(v => v.id == variantId);
            console.log('Selected variant from active button:', selectedVariant);
        }
        
        if (!selectedVariant) {
            selectedVariant = product.variants[0];
            console.log('No active variant, using first:', selectedVariant);
        }
    }

    const finalPrice = selectedVariant ? parseFloat(selectedVariant.final_price) : (parseFloat(product.final_price) || 0);
    const originalPrice = selectedVariant ? parseFloat(selectedVariant.price) : (parseFloat(product.price) || 0);
    const variantType = selectedVariant?.variant_type || 'Size';
    const variantValue = selectedVariant?.variant_value || 'S';
    const variantId = selectedVariant?.id || null;
    
    const availableVariants = product.variants ? product.variants.map(v => ({
        id: v.id,
        value: v.variant_value,
        price: parseFloat(v.final_price) || 0,
        originalPrice: parseFloat(v.price) || 0
    })) : [];

    // 🔥 JO IMAGE SCREEN PE DIKH RAHI HAI WAHI LO
    let imageUrl = '';
    
    // Pehle mainImage se lo (jo currently screen par dikh rahi hai)
    const mainImage = document.getElementById('mainImage');
    if (mainImage && mainImage.src) {
        imageUrl = mainImage.src;
    }
    // Agar mainImage nahi mili to selected variant ki image lo
    else if (selectedVariant?.image_url) {
        imageUrl = selectedVariant.image_url;
    }
    // Nahi to product image lo
    else if (product.image_url) {
        imageUrl = product.image_url;
    }
    // Last option gallery
    else if (product.gallery_images && product.gallery_images.length > 0) {
        imageUrl = product.gallery_images[0];
    }

    const cartItem = {
        id: product.id,
        name: product.name,
        brand: product.brand || '',
        price: finalPrice,
        mrp: originalPrice,
        originalPrice: originalPrice,
        image: imageUrl,  // 🔥 YAHI IMAGE CART ME JAYEGI
        slug: product.slug,
        variantType: variantType,
        variantValue: variantValue,
        variantId: variantId,
        categoryId: product.category?.id,
        quantity: 1,
        availableVariants: availableVariants,
        rating: product.rating || 4.5,
        reviewCount: product.review_count || 33
    };

    const existingIndex = cart.findIndex(
        i => i.id === cartItem.id && i.variantId === cartItem.variantId
    );

    if (existingIndex >= 0) {
        cart[existingIndex].quantity += 1;
    } else {
        cart.push(cartItem);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    updateCartBadge();
    showConfirmation(product.name);
    
    setTimeout(() => {
        window.location.href = '/cart';
    }, 500);
}
    
    window.addToCartFromProduct = function() {
    const sizeError = document.querySelector('.pdp-size-error');
    
    if (!selectedSize && allSizes.length > 0) {
        if (sizeError) {
            sizeError.style.display = 'block';
        } else {
            const sizeSection = document.querySelector('.pdp-size');
            if (sizeSection) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'pdp-size-error';
                errorDiv.style.cssText = 'color: #ff3f6c; font-size: 13px; margin-top: 8px; display: block;';
                errorDiv.textContent = 'Please select a size';
                sizeSection.appendChild(errorDiv);
                
                setTimeout(() => {
                    errorDiv.style.display = 'none';
                }, 3000);
            }
        }
        
        document.querySelector('.pdp-size-options')?.classList.add('size-error-shake');
        setTimeout(() => {
            document.querySelector('.pdp-size-options')?.classList.remove('size-error-shake');
        }, 500);
        
        return;
    }
    
    const product = {
        id: currentProduct?.id,
        name: currentProduct?.name,
        brand: currentProduct?.brand,
        price: parseFloat(currentProduct?.price || 0),
        final_price: parseFloat(currentProduct?.final_price || currentProduct?.price || 0),
        image_url: document.getElementById('mainImage')?.src || currentProduct?.image_url,
        slug: currentProduct?.slug,
        category: currentProduct?.category,
        variants: currentProduct?.variants,
        gallery_images: currentProduct?.gallery_images
    };
    
    window.addToBag(product);
}
        
    window.goBack = function() {
        
        sessionStorage.setItem('fromProductPage', 'true');
        sessionStorage.setItem('returnToProduct', 'false');
        
        window.history.back();
    };
    
    function getColorNameFromCode(colorCode) {
        const colorMap = {
            '#000000': 'Black',
            '#ffffff': 'White',
            '#ff0000': 'Red',
            '#00ff00': 'Green',
            '#0000ff': 'Blue',
            '#ffff00': 'Yellow',
            '#ff00ff': 'Pink',
            '#00ffff': 'Cyan',
            '#c0c0c0': 'Silver',
            '#808080': 'Grey',
            '#800000': 'Maroon',
            '#808000': 'Olive',
            '#008000': 'Dark Green',
            '#800080': 'Purple',
            '#008080': 'Teal',
            '#000080': 'Navy',
            '#ffa500': 'Orange',
            '#ffc0cb': 'Pink',
            '#ffd700': 'Gold',
            '#d7d6d6': 'Light Grey',
            '#1785a1': 'Blue',
            '#de1b1b': 'Red',
            '#a52a2a': 'Brown',
            '#f5f5dc': 'Beige'
        };
        
        const lowerColor = colorCode.toLowerCase();
        return colorMap[lowerColor] || colorCode;
    }
    
    window.selectColor = function(element, colorCode, imageUrl, colorName) {

    // ✅ SAME COLOR DOBARA CLICK = UNSELECT
    if (selectedColor === (colorName || colorCode)) {

        selectedColor = null;
        selectedVariant = null;

        document.querySelectorAll('.pdp-color-circle, .pdp-color-name-item')
            .forEach(item => item.classList.remove('active'));

        // 🔥 GALLERY IMAGES WAPIS
        currentImages = currentProduct.gallery_images && currentProduct.gallery_images.length
            ? currentProduct.gallery_images
            : [currentProduct.image_url];

        currentImageIndex = 0;

        const mainImage = document.getElementById('mainImage');
        const counter = document.getElementById('currentImage');

        if (mainImage) mainImage.src = currentImages[0];

        if (counter) counter.textContent = `1/${currentImages.length}`;

        startImageAutoScroll();

        return;
    }

    document.querySelectorAll('.pdp-color-circle, .pdp-color-name-item')
        .forEach(item => item.classList.remove('active'));

    element.classList.add('active');

    selectedColor = colorName || colorCode;

    if (imageUrl) {

        const mainImage = document.getElementById('mainImage');

        mainImage.src = imageUrl;

        currentImages = [imageUrl];
        currentImageIndex = 0;

        const counter = document.getElementById('currentImage');

        if (counter) counter.textContent = `1/1`;
    }

    const variant = allSizes.find(v => v.color === colorCode);

    if (variant) {

        selectedVariant = variant;
        selectedSize = variant.value;

        const priceElement = document.getElementById('currentPrice');
        const buyPriceElement = document.getElementById('buyPrice');

        if (priceElement) {
            priceElement.textContent = '₹' + Number(variant.final_price || variant.price).toLocaleString('en-IN');
        }

        if (buyPriceElement) {
            buyPriceElement.textContent = Number(variant.final_price || variant.price).toLocaleString('en-IN');
        }

        document.querySelectorAll('.pdp-size-btn').forEach(btn => {

            btn.classList.remove('active');

            if (btn.textContent === variant.value) {
                btn.classList.add('active');
            }

        });
    }

    if (imageTimer) {
        clearInterval(imageTimer);
        imageTimer = null;
    }

};

    window.selectScrollColor = function(colorCode, imageUrl, colorName) {
        document.querySelectorAll('.pdp-color-circle').forEach((circle, index) => {
            const style = circle.getAttribute('style') || '';
            if (style.includes(colorCode)) {
                selectColor(circle, colorCode, imageUrl, colorName);
            }
        });
        closeColorScrollPopup();
    }
    
    window.selectVariant = function(btn, price, variantId, variantType) {
        document.querySelectorAll('.pdp-size-btn:not(.disabled)').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        selectedSize = btn.textContent;
        
        const sizeError = document.querySelector('.pdp-size-error');
        if (sizeError) {
            sizeError.style.display = 'none';
        }
        
        const variant = allSizes.find(v => v.id == variantId);
        if (variant) {
            selectedVariant = variant;
            
            const priceElement = document.getElementById('currentPrice');
            const buyPriceElement = document.getElementById('buyPrice');
            if (priceElement) {
                priceElement.textContent = '₹' + Number(variant.final_price || variant.price).toLocaleString('en-IN');
            }
            if (buyPriceElement) {
                buyPriceElement.textContent = Number(variant.final_price || variant.price).toLocaleString('en-IN');
            }
        }
    };
    
    window.changeImage = function(index) {
        const mainImage = document.getElementById('mainImage');
        const counter = document.getElementById('currentImage');
        
        if (mainImage && currentImages[index]) {
            mainImage.src = currentImages[index];
            currentImageIndex = index;
            
            if (counter) {
                counter.textContent = (index + 1) + '/' + currentImages.length;
            }
        }
    };
    
    window.nextImage = function() {
        const nextIndex = (currentImageIndex + 1) % currentImages.length;
        changeImage(nextIndex);
    };
    
    window.prevImage = function() {
        const prevIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        changeImage(prevIndex);
    };
    
    function startImageAutoScroll() {
        if (imageTimer) clearInterval(imageTimer);
        imageTimer = setInterval(() => {
            nextImage();
        }, 3000);
    }
    
    window.showSizeChart = function() {
        document.getElementById('sizeChartPopup').classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    
    window.hideSizeChart = function() {
        document.getElementById('sizeChartPopup').classList.remove('active');
        document.body.style.overflow = '';
    };
    
    window.showColorPopup = function() {
    const existingPopup = document.querySelector('.color-scroll-popup');
    if (existingPopup) existingPopup.remove();
    
    const popup = document.createElement('div');
    popup.className = 'color-scroll-popup';
    
    let colorsHtml = '<div class="color-scroll-container">';
    
    allColors.forEach((c, index) => {
        let colorImage = c.image || currentImages[0];
        
        const colorKeyword = (c.name || '').toLowerCase();
        for (let i = 0; i < currentImages.length; i++) {
            const img = currentImages[i].toLowerCase();
            if (img.includes(colorKeyword)) {
                colorImage = currentImages[i];
                break;
            }
        }
        
        const isSelected = selectedColor === c.name;
        
        colorsHtml += `
            <div class="color-scroll-item ${isSelected ? 'selected' : ''}" 
                 onclick="selectScrollColor('${c.color}', '${colorImage}', '${c.name}')">
                <div class="color-scroll-image">
                    <img src="${colorImage}" 
                         onerror="this.src='https://via.placeholder.com/80x100?text=No+Image'">
                </div>
                <div class="color-scroll-info">
                    <span class="color-scroll-dot" style="background: ${c.color}; ${c.color.toLowerCase() === '#ffffff' ? 'border:1px solid #ddd' : ''}"></span>
                    <span class="color-scroll-name">${c.name}</span>
                    ${isSelected ? '<span class="color-scroll-check">✓</span>' : ''}
                </div>
            </div>
        `;
    });
    
    colorsHtml += '</div>';
    
    popup.innerHTML = `
        <div class="color-scroll-header">
            <span>Select Color</span>
            <button class="color-scroll-close" onclick="closeColorScrollPopup()">✕</button>
        </div>
        ${colorsHtml}
    `;
    
    document.body.appendChild(popup);
    document.body.style.overflow = 'hidden';
}
    
    window.selectScrollColor = function(colorCode, imageUrl, colorName) {
        document.querySelectorAll('.pdp-color-circle').forEach((circle, index) => {
            const style = circle.getAttribute('style') || '';
            if (style.includes(colorCode)) {
                selectColor(circle, colorCode, imageUrl, colorName);
            }
        });
        closeColorScrollPopup();
    }
    
    window.closeColorScrollPopup = function() {
        const popup = document.querySelector('.color-scroll-popup');
        if (popup) {
            popup.remove();
            document.body.style.overflow = '';
        }
    };
    
    window.toggleWishlist = function(button) {
    event.stopPropagation();
    button.classList.toggle('active');
    
    // 🔥 JO IMAGE SCREEN PE DIKH RAHI HAI WAHI LO
    const mainImage = document.getElementById('mainImage');
    let imageUrl = '';
    
    // Pehle mainImage se lo
    if (mainImage && mainImage.src && mainImage.src !== '') {
        imageUrl = mainImage.src;
        console.log('Taking image from mainImage:', imageUrl);
    }
    // Agar mainImage nahi to gallery se lo
    else if (currentProduct?.gallery_images?.length > 0) {
        imageUrl = currentProduct.gallery_images[0];
        console.log('Taking image from gallery:', imageUrl);
    }
    // Last option product image
    else if (currentProduct?.image_url) {
        imageUrl = currentProduct.image_url;
        console.log('Taking image from product:', imageUrl);
    }
    
    const productData = {
        id: currentProduct?.id,
        name: currentProduct?.name,
        price: parseFloat(currentProduct?.final_price || currentProduct?.price || 0),
        image: imageUrl,
        brand: currentProduct?.brand,
        slug: currentProduct?.slug
    };
    
    console.log('Saving to wishlist:', productData);
    
    if (button.classList.contains('active')) {
        if (!wishlist.some(item => item.id == productData.id)) {
            wishlist.push(productData);
            showWishlistToast('❤️ Added to wishlist');
        }
    } else {
        wishlist = wishlist.filter(item => item.id != productData.id);
        showWishlistToast('💔 Removed from wishlist');
    }
    
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
}
    
    function showWishlistToast(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #282c3f;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            animation: fadeInOut 2s ease;
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }
    
    window.shareProduct = function() {
        if (navigator.share) {
            navigator.share({
                title: currentProduct?.name,
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied!');
        }
    };
    
    window.checkPincode = function() {
        const pincode = document.getElementById('pincode').value;
        const info = document.getElementById('deliveryInfo');
        
        if (pincode.length === 6 && /^\d+$/.test(pincode)) {
            localStorage.setItem('lastPincode', pincode);
            const date = new Date();
            date.setDate(date.getDate() + 5);
            const formattedDate = date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });
            info.innerHTML = `✅ Delivery by ${formattedDate}`;
            info.className = 'pdp-delivery-info success';
        } else {
            info.innerHTML = 'Please enter valid 6-digit pincode';
            info.className = 'pdp-delivery-info error';
        }
    };
    
    window.showOfferTerms = function(code) {
        const offer = allCoupons.find(c => c.code === code);
        if (offer) {
            alert(`${offer.code} Terms & Conditions:\n${offer.terms || 'Valid on minimum order of ₹999. Cannot be combined with other offers.'}`);
        } else {
            alert(`${code} Terms & Conditions:\nValid on minimum order of ₹999. Cannot be combined with other offers.`);
        }
    };
    
    window.toggleAllOffers = function() {
        showAllOffersPopup();
    };
    window.showAllOffersPopup = function() {

        const bankOffers = allCoupons.filter(offer => offer.coupon_type === 'BANK');
        const normalOffers = allCoupons.filter(offer => offer.coupon_type !== 'BANK');
        
        const popup = document.createElement('div');
        popup.className = 'offers-popup';
        
        let offersHtml = '<div class="offers-popup-content">';
        
        if (bankOffers.length > 0) {
            offersHtml += `
                <div class="offers-section">
                    <div class="offers-section-title">
                        <span class="offers-section-icon">🏦</span>
                        <span>Bank Offers</span>
                    </div>
            `;
            
            bankOffers.forEach(offer => {
                offersHtml += `
                    <div class="offers-popup-item bank-offer">
                        <div class="offers-popup-header-row">
                            <span class="offers-popup-badge">🏦 Bank Offer</span>
                            <span class="offers-popup-code">${offer.code}</span>
                        </div>
                        <div class="offers-popup-desc">${offer.description || offer.name || `Get ${offer.value}${offer.discount_type === 'PERCENT' ? '%' : '₹'} off`}</div>
                        <div class="offers-popup-footer">
                            <span class="offers-popup-min">Min. ₹${offer.min_order_amount || 999}</span>
                            <span class="offers-popup-tnc" onclick="showOfferTerms('${offer.code}')">View T & C</span>
                        </div>
                    </div>
                `;
            });
            
            offersHtml += '</div>';
        }
        
        if (normalOffers.length > 0) {
            offersHtml += `
                <div class="offers-section">
                    <div class="offers-section-title">
                        <span class="offers-section-icon">🎫</span>
                        <span>Coupons & Offers</span>
                    </div>
            `;
            
            normalOffers.forEach(offer => {
                offersHtml += `
                    <div class="offers-popup-item normal-offer">
                        <div class="offers-popup-header-row">
                            <span class="offers-popup-badge">🎫 Special Offer</span>
                            <span class="offers-popup-code">${offer.code}</span>
                        </div>
                        <div class="offers-popup-desc">${offer.description || offer.name || `Get ${offer.value}${offer.discount_type === 'PERCENT' ? '%' : '₹'} off`}</div>
                        <div class="offers-popup-footer">
                            <span class="offers-popup-min">Min. ₹${offer.min_order_amount || 499}</span>
                            <span class="offers-popup-tnc" onclick="showOfferTerms('${offer.code}')">View T & C</span>
                        </div>
                    </div>
                `;
            });
            
            offersHtml += '</div>';
        }
        
        offersHtml += '</div>';
        
        popup.innerHTML = `
            <div class="offers-popup-header">
                <h3>All Offers <span class="offers-count">${allCoupons.length}</span></h3>
                <button class="offers-popup-close" onclick="closeOffersPopup()">✕</button>
            </div>
            ${offersHtml}
        `;
        
        document.body.appendChild(popup);
        document.body.style.overflow = 'hidden';
    };
    window.closeOffersPopup = function() {
        const popup = document.querySelector('.offers-popup');
        if (popup) {
            popup.remove();
            document.body.style.overflow = '';
        }
    };
    window.changeReview = function(index) {
        if (index >= 0 && index < allReviews.length) {
            currentReviewIndex = index;
            renderCurrentReview();
        }
    };
    
    window.nextReview = function() {
        currentReviewIndex = (currentReviewIndex + 1) % allReviews.length;
        renderCurrentReview();
    };
    
    window.prevReview = function() {
        currentReviewIndex = (currentReviewIndex - 1 + allReviews.length) % allReviews.length;
        renderCurrentReview();
    };
    
    function renderCurrentReview() {
        const review = allReviews[currentReviewIndex];
        if (!review) return;
        
        const reviewContainer = document.getElementById('currentReview');
        if (!reviewContainer) return;
        
        const reviewStars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
        
        reviewContainer.innerHTML = `
            <div class="pdp-review">
                <div class="pdp-review-header">
                    <span class="pdp-reviewer">${review.reviewer}</span>
                    <span class="pdp-review-rating">${reviewStars}</span>
                    <span class="pdp-review-date">${review.date}</span>
                </div>
                <div class="pdp-review-title">${review.title}</div>
                <div class="pdp-review-text">${review.text}</div>
            </div>
        `;
        
        const dots = document.querySelectorAll('.pdp-review-dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentReviewIndex);
        });
    }
    
    function renderOffers() {
        const container = document.getElementById('offersContainer');
        if (!container) return;
        
        const currentPrice = parseFloat(selectedVariant?.final_price || displayPrice || 0);
        
        const applicableCoupons = allCoupons.filter(coupon => {
            const minAmount = parseFloat(coupon.min_order_amount || 0);
            return currentPrice >= minAmount;
        });
        
        if (!applicableCoupons || applicableCoupons.length === 0) {
            container.innerHTML = '<div class="pdp-offer-card">No offers available for this product</div>';
            return;
        }
        
        const offersToShow = showAllOffers ? applicableCoupons : applicableCoupons.slice(0, 1);
        
        container.innerHTML = offersToShow.map(offer => {
            const isBank = offer.coupon_type === 'BANK';
            return `
                <div class="pdp-offer-card ${isBank ? 'bank-offer' : ''}">
                    <div class="pdp-offer-header">
                        <span class="pdp-offer-badge">${isBank ? '🏦 Bank Offer' : '🎫 Special Offer'}</span>
                        <span class="pdp-offer-code">${offer.code}</span>
                    </div>
                    <div class="pdp-offer-desc">${offer.description || offer.name || `Get ${offer.value}${offer.discount_type === 'PERCENT' ? '%' : '₹'} off`}</div>
                    <span class="pdp-offer-tnc" onclick="showOfferTerms('${offer.code}')">View T & C</span>
                </div>
            `;
        }).join('');
        
        if (applicableCoupons.length > 1) {
            container.innerHTML += `
                <div class="pdp-offer-more" onclick="toggleAllOffers()">
                    ${showAllOffers ? 'Show Less ▲' : `+${applicableCoupons.length - 1} more offers ▼`}
                </div>
            `;
        }
    }
    
    function formatDescription(description) {
        if (!description) return [];
        return description.split('\n').map(line => line.replace(/^[•\s]*/, '').trim()).filter(line => line);
    }
    
    async function fetchProduct() {
        if (document.body.classList.contains('category-products-page')) return;
        
        const pathParts = window.location.pathname.split('/');
        const slug = pathParts[pathParts.length - 1];
        const API_URL = `https://retailadmin.ggconsultancy.services/api/products/${slug}`;
        
        try {
            const response = await fetch(API_URL);
            const data = await response.json();
            
            if (data.success && data.data) {
                currentProduct = data.data;
                await fetchBrandFromCategory();
                await Promise.all([
                    fetchCoupons(),
                    fetchReviews()
                ]);
                renderProduct(data.data);
                startImageAutoScroll();
            } else {
                showError('Product not found');
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Failed to load product');
        }
    }
    
    async function fetchBrandFromCategory() {
        if (!currentProduct?.category?.id) return;
        
        try {
            const res = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${currentProduct.category.id}/products`);
            const data = await res.json();
            
            if (data.success && data.data?.products) {
                const productInCategory = data.data.products.find(p => p.id == currentProduct.id);
                if (productInCategory?.brand) {
                    currentProduct.brand = productInCategory.brand;
                    console.log('Brand fetched:', currentProduct.brand);
                }
            }
        } catch (error) {
            console.error('Error fetching brand:', error);
        }
    }
    
    async function fetchCoupons() {
        try {
            const res = await fetch('https://retailadmin.ggconsultancy.services/api/coupons');
            const data = await res.json();
            if (data.success && data.data) {
                allCoupons = data.data; 
            }
        } catch (error) {
            console.error('Error fetching coupons:', error);
            allCoupons = [];
        }
    }
    
    async function fetchReviews() {
        allReviews = [
            {
                id: 1,
                reviewer: 'Priya S.',
                rating: 5,
                date: '2 days ago',
                title: 'Beautiful but size up if between sizes.',
                text: 'The dress is stunning and the quality is good. I was between S and M, so I chose M and it fits comfortably.',
                images: [
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=100&h=100&fit=crop',
                    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=100&h=100&fit=crop'
                ]
            },
            {
                id: 2,
                reviewer: 'Rahul K.',
                rating: 4,
                date: '1 week ago',
                title: 'Perfect for vacation.',
                text: 'The slit and floral print look so elegant. It\'s comfortable even in warm weather. True to size and exactly like the pictures.',
                images: [
                    'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=100&h=100&fit=crop'
                ]
            },
            {
                id: 3,
                reviewer: 'Anjali M.',
                rating: 5,
                date: '2 weeks ago',
                title: 'Excellent quality and fit!',
                text: 'The fabric is soft and breathable. Perfect for summer. I received many compliments.'
            }
        ];
    }
    
    function getColorCount(product) {
        const variants = product.variants || [];
        const uniqueColors = new Set();
        variants.forEach(v => {
            if (v.color) uniqueColors.add(v.color);
        });
        return uniqueColors.size || 1;
    }
    
    function renderProduct(product) {
        const container = document.getElementById('product-container');
        
        const galleryImages = product.gallery_images || [];
        currentImages = galleryImages.length > 0 ? galleryImages : (product.image_url ? [product.image_url] : []);
        
        if (currentImages.length === 0) {
            currentImages = ['https://via.placeholder.com/400x600?text=No+Image'];
        }
        
        const variants = product.variants || [];
        
        const colorMap = new Map();
        variants.forEach(v => {
            if (v.color && !colorMap.has(v.color)) {
                const colorName = v.color_name || getColorNameFromCode(v.color);
                colorMap.set(v.color, {
                    color: v.color,
                    name: colorName,
                    image: v.image_url || product.image_url || currentImages[0]
                });
            }
        });
        
        allColors = Array.from(colorMap.values());
        
        if (allColors.length === 0) {
            allColors = [
                { color: '#000000', name: 'Black', image: product.image_url || currentImages[0] }
            ];
        }
        
        allSizes = [];
        variants.forEach(v => {
            if (v.variant_value) {
                allSizes.push({
                    id: v.id,
                    type: v.variant_type || 'Size',  
                    value: v.variant_value,
                    price: parseFloat(v.price || 0),
                    final_price: parseFloat(v.final_price || v.price || 0),
                    stock: v.quantity || 5,
                    color: v.color,
                    inStock: v.in_stock !== false
                });
            }
        });
        
        if (allSizes.length === 0) {
            const defaultPrice = parseFloat(product.final_price || product.price || 1200);
            allSizes = [
                { value: 'S', price: defaultPrice, final_price: defaultPrice, stock: 5, color: allColors[0]?.color },
                { value: 'M', price: defaultPrice, final_price: defaultPrice, stock: 5, color: allColors[0]?.color },
                { value: 'L', price: defaultPrice, final_price: defaultPrice, stock: 5, color: allColors[0]?.color },
                { value: 'XL', price: defaultPrice, final_price: defaultPrice, stock: 5, color: allColors[0]?.color }
            ];
        }
        
        let displayPrice = 0;
        let originalPrice = 0;
        let discountPercentage = 0;
        
        if (allSizes.length > 0) {
            const firstVariant = allSizes[0];
            displayPrice = firstVariant.final_price;
            originalPrice = firstVariant.price;
            
            if (originalPrice > displayPrice) {
                discountPercentage = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
            }
        } else {
            displayPrice = parseFloat(product.final_price || product.price || 1200);
            originalPrice = parseFloat(product.price || 1500);
            if (originalPrice > displayPrice) {
                discountPercentage = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
            }
        }
        
        const brand = product.brand || 'H&M';
        const name = product.name || 'Maxi Dress';
        const rating = 4.5;
        const reviewCount = 33;
        
        const fullStars = Math.floor(rating);
        const halfStar = rating % 1 >= 0.5;
        let starsHtml = '';
        for (let i = 0; i < fullStars; i++) starsHtml += '★';
        if (halfStar) starsHtml += '½';
        for (let i = starsHtml.length; i < 5; i++) starsHtml += '☆';
        
        const descriptionPoints = [];
        if (product.style) descriptionPoints.push(`Style: ${product.style}`);
        if (product.neckline) descriptionPoints.push(`Neckline: ${product.neckline}`);
        if (product.length) descriptionPoints.push(`Length: ${product.length}`);
        if (product.fit) descriptionPoints.push(`Fit: ${product.fit}`);
        if (product.fabric) descriptionPoints.push(`Fabric: ${product.fabric}`);
        
        if (descriptionPoints.length === 0 && product.description) {
            const lines = product.description.split('\n');
            lines.forEach(line => {
                const cleanLine = line.replace(/^[•\s]*/, '').trim();
                if (cleanLine) descriptionPoints.push(cleanLine);
            });
        }
        
        if (descriptionPoints.length === 0) {
            descriptionPoints.push('Style: Wrap Maxi Dress');
            descriptionPoints.push('Neckline: Square neckline');
            descriptionPoints.push('Length: Full length (Maxi)');
            descriptionPoints.push('Fit: Regular fit');
        }
        
        let html = `
            <style>
                .color-scroll-popup {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    background: white;
                    border-top-left-radius: 16px;
                    border-top-right-radius: 16px;
                    box-shadow: 0 -2px 10px rgba(0,0,0,0.15);
                    z-index: 10000;
                    animation: slideUp 0.3s ease;
                    padding-bottom: 20px;
                }
                @keyframes slideUp {
                    from { transform: translateY(100%); }
                    to { transform: translateY(0); }
                }
                .color-scroll-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 16px;
                    border-bottom: 1px solid #f0f0f0;
                    font-weight: 600;
                    font-size: 16px;
                    position: sticky;
                    top: 0;
                    background: white;
                    z-index: 10;
                }
                .color-scroll-close {
                    background: none;
                    border: none;
                    font-size: 18px;
                    cursor: pointer;
                    padding: 4px 8px;
                }
                .color-scroll-container {
                    display: flex;
                    overflow-x: auto;
                    overflow-y: hidden;
                    padding: 16px;
                    gap: 12px;
                    scrollbar-width: thin;
                    scrollbar-color: #ff3f6c #f0f0f0;
                    -webkit-overflow-scrolling: touch;
                }
                .color-scroll-container::-webkit-scrollbar {
                    height: 4px;
                }
                .color-scroll-container::-webkit-scrollbar-track {
                    background: #f0f0f0;
                    border-radius: 10px;
                }
                .color-scroll-container::-webkit-scrollbar-thumb {
                    background: #ff3f6c;
                    border-radius: 10px;
                }
                .color-scroll-item {
                    flex: 0 0 auto;
                    width: 100px;
                    border: 1px solid #f0f0f0;
                    border-radius: 12px;
                    overflow: hidden;
                    cursor: pointer;
                    transition: all 0.2s;
                    background: white;
                }
                .color-scroll-item.selected {
                    border: 2px solid #ff3f6c;
                }
                .color-scroll-image {
                    width: 100px;
                    height: 120px;
                    overflow: hidden;
                }
                .color-scroll-image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .color-scroll-info {
                    padding: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    background: #fafafa;
                }
                .color-scroll-dot {
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    display: inline-block;
                }
                .color-scroll-name {
                    font-size: 12px;
                    font-weight: 500;
                    margin: 0 4px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    max-width: 40px;
                }
                .color-scroll-check {
                    color: #ff3f6c;
                    font-weight: bold;
                    font-size: 12px;
                }
                .pdp-color-count {
                    cursor: pointer;
                    color: #ff3f6c;
                    font-weight: 500;
                    text-decoration: underline;
                }
                .pdp-color-count:hover {
                    opacity: 0.8;
                }
                .pdp-size-error {
                    color: #ff3f6c;
                    font-size: 13px;
                    margin-top: 8px;
                    display: none;
                }
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                .size-error-shake {
                    animation: shake 0.5s ease;
                }
                @keyframes fadeInOut {
                    0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
                    10% { opacity: 1; transform: translateX(-50%) translateY(0); }
                    90% { opacity: 1; transform: translateX(-50%) translateY(0); }
                    100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
                }
            </style>
            
            <div class="pdp-header">
                <div class="pdp-header-left">
                    <span class="back-btn" onclick="goBack()">←</span>  <!-- ✅ Updated back button -->
                </div>
                <div class="pdp-header-right">
                    <button onclick="window.location.href='/search'">🔍</button>
                    <button onclick="window.location.href='/wishlist'">❤️</button>
                    <button onclick="window.location.href='/cart'">🛒</button>
                </div>
            </div>

            <div class="pdp-gallery" onclick="nextImage()">
                <img src="${currentImages[0]}" class="pdp-main-image" id="mainImage" onerror="this.src='https://via.placeholder.com/400x600?text=No+Image'">
                ${discountPercentage > 20 ? '<span class="pdp-best-seller">Best Seller</span>' : ''}
                <button class="pdp-wishlist" onclick="event.stopPropagation(); toggleWishlist(this)">♡</button>
                <button class="pdp-share" onclick="event.stopPropagation(); shareProduct()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 16.08C17.24 16.08 16.56 16.38 16.04 16.85L8.91 12.7C8.96 12.47 9 12.24 9 12C9 11.76 8.96 11.53 8.91 11.3L15.96 7.19C16.5 7.69 17.21 8 18 8C19.66 8 21 6.66 21 5C21 3.34 19.66 2 18 2C16.34 2 15 3.34 15 5C15 5.24 15.04 5.47 15.09 5.7L8.04 9.81C7.5 9.31 6.79 9 6 9C4.34 9 3 10.34 3 12C3 13.66 4.34 15 6 15C6.79 15 7.5 14.69 8.04 14.19L15.16 18.35C15.11 18.56 15.08 18.78 15.08 19C15.08 20.61 16.39 21.92 18 21.92C19.61 21.92 20.92 20.61 20.92 19C20.92 17.39 19.61 16.08 18 16.08Z" fill="currentColor"/>
                    </svg>
                </button>                
                <span class="pdp-image-counter" id="currentImage">1/${currentImages.length}</span>
                
            </div>

            <div class="pdp-info">
                <div class="pdp-brand-row">
                    <span class="pdp-brand">${brand}</span>
                    <div class="pdp-header-circles">
                        ${allColors.slice(0, 4).map(c => `
                            <span class="pdp-color-circle" style="background: ${c.color}; ${c.color.toLowerCase() === '#ffffff' ? 'border:1px solid #ddd' : ''}" 
                                  onclick="selectColor(this, '${c.color}', '${c.image}', '${c.name}')"
                                  title="${c.name}"></span>
                        `).join('')}
                        ${allColors.length > 4 ? `<span class="pdp-color-more" onclick="showColorPopup()">+${allColors.length - 4}</span>` : ''}
                    </div>
                </div>
                
                <div class="pdp-name-row">
                    <span class="pdp-title">${name}</span>
                    <span class="pdp-color-count" onclick="showColorPopup()">${allColors.length} colors</span>
                </div>
                
                <div class="pdp-rating">
                    <span class="pdp-stars">${starsHtml}</span>
                    <span class="pdp-review-count">${rating} (${reviewCount} reviews)</span>
                </div>
                <div class="pdp-price">
                    <span class="pdp-current-price" id="currentPrice">₹${displayPrice.toLocaleString('en-IN')}</span>
                    ${originalPrice > displayPrice ? `<span class="pdp-original-price">₹${originalPrice.toLocaleString('en-IN')}</span>` : ''}
                    ${discountPercentage > 0 ? `<span class="pdp-discount">${discountPercentage}% Off</span>` : ''}
                </div>
            </div>
        `;
        
        html += `
            <div class="pdp-size">
                <div class="pdp-size-header">
                    <h3>${allSizes[0]?.type || 'Size'}</h3>  
                    ${allSizes[0]?.type === 'Size' ? '<span class="pdp-size-chart" onclick="showSizeChart()">Size Chart ▾</span>' : ''}
                </div>
                <div class="pdp-size-options">
        `;
        
        const uniqueSizes = [...new Map(allSizes.map(s => [s.value, s])).values()];
        uniqueSizes.forEach(s => {
            const isInStock = s.stock > 0;
            html += `
                <button class="pdp-size-btn ${isInStock ? '' : 'disabled'}" 
                        data-variant-id="${s.id || ''}"
                        data-price="${s.price}"
                        onclick="selectVariant(this, '${s.price}', '${s.id || ''}', '${s.type || ''}')"
                        ${isInStock ? '' : 'disabled'}>
                    ${s.value}
                </button>
            `;
        });
        
        html += `
                </div>
                <div class="pdp-size-error" style="color: #ff3f6c; font-size: 13px; margin-top: 8px; display: none;">Please select a size</div>
            </div>

            <div class="pdp-actions">
                <button class="pdp-add-to-cart" onclick="addToCartFromProduct()">Add to Cart</button>
                <button class="pdp-buy-now" onclick="buyNow()">Buy at ₹<span id="buyPrice">${displayPrice.toLocaleString('en-IN')}</span></button>
            </div>
        `;
        
        if (descriptionPoints.length > 0) {
            html += `
                <div class="pdp-details">
                    <h3>Product Details</h3>
                    <ul class="pdp-details-list">
            `;
            
            descriptionPoints.forEach(point => {
                html += `<li><span>•</span> <span>${point}</span></li>`;
            });
            
            html += `</ul></div>`;
        }
        
        html += `
            <div class="pdp-delivery">
                <h3>Delivery Details</h3>
                <div class="pdp-pincode">
                    <input type="text" id="pincode" placeholder="Enter pincode" maxlength="6" value="${localStorage.getItem('lastPincode') || ''}">
                    <button onclick="checkPincode()">Check</button>
                </div>
                <div class="pdp-delivery-info" id="deliveryInfo"></div>
                <div class="pdp-return">↩️ 7 Days Return & Exchange</div>
                <div class="pdp-cod">💳 Cash on Delivery is available</div>
            </div>

            <div class="pdp-offers">
                <h3>Offers and Discounts</h3>
                <div id="offersContainer"></div>
            </div>

            <div class="pdp-ratings">
                <h3>Ratings and Reviews</h3>
                <div class="pdp-rating-summary">
                    <span class="pdp-avg-rating">4.5</span>
                    <span class="pdp-stars">${starsHtml}</span>
                    <span class="pdp-total-ratings">33 Ratings</span>
                </div>
        `;
        
        const allReviewImages = allReviews.flatMap(r => r.images || []);
        if (allReviewImages.length > 0) {
            html += `
                <div class="pdp-photos">
                    ${allReviewImages.slice(0, 5).map(img => `
                        <div class="pdp-photo"><img src="${img}"></div>
                    `).join('')}
                </div>
            `;
        }
        
        html += `
                <div id="currentReview"></div>
                <div class="pdp-review-nav">
                    <button onclick="prevReview()">‹</button>
                    <div class="pdp-review-dots">
                        ${allReviews.map((_, i) => `<span class="pdp-review-dot ${i === 0 ? 'active' : ''}" onclick="changeReview(${i})"></span>`).join('')}
                    </div>
                    <button onclick="nextReview()">›</button>
                </div>
            </div>

            <!-- ✅ Only Similar Styles section -->
            <div class="pdp-similar">
                <h3>Similar Styles</h3>
                <div class="pdp-similar-grid" id="similarGrid"></div>
            </div>
        `;
        
        container.innerHTML = html;
        
        window.productVariants = allSizes;
        window.displayPrice = displayPrice;
        window.originalPrice = originalPrice;
        
        renderOffers();
        renderCurrentReview();
        fetchSimilarProducts();  // ✅ Only one function now
        
        const lastPincode = localStorage.getItem('lastPincode');
        if (lastPincode) {
            setTimeout(() => {
                document.getElementById('pincode').value = lastPincode;
                checkPincode();
            }, 500);
        }
    }
    
    async function fetchSimilarProducts() {
    const similarSection = document.querySelector('.pdp-similar');
    const grid = document.getElementById('similarGrid');
    if (!grid || !similarSection) return;
    
    try {
        const categoryId = currentProduct?.category?.id;
        if (!categoryId) {
            similarSection.style.display = 'none';  // 🔥 POORI SECTION HI HATA DO
            return;
        }
        
        const res = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${categoryId}/products`);
        const data = await res.json();
        
        if (data.success && data.data?.products) {
            const otherProducts = data.data.products.filter(p => p.id != currentProduct.id);
            
            if (otherProducts.length > 0) {
                similarSection.style.display = 'block';  // 🔥 PRODUCTS HAIN TO DIKHAO
                grid.innerHTML = otherProducts.map(p => `
                    <div class="pdp-similar-card" onclick="window.location.href='/product/${p.slug}'">
                        <img src="${p.image_url || ''}" class="pdp-similar-image" onerror="this.style.display='none'">
                        <div class="pdp-similar-brand">${p.brand || 'Brand'}</div>
                        <div class="pdp-similar-name">${p.name}</div>
                        <div class="pdp-similar-price">
                            <span class="pdp-similar-current">₹${parseFloat(p.final_price || p.price).toLocaleString('en-IN')}</span>
                            ${p.price > p.final_price ? `<span class="pdp-similar-original">₹${parseFloat(p.price).toLocaleString('en-IN')}</span>` : ''}
                        </div>
                    </div>
                `).join('');
            } else {
                similarSection.style.display = 'none';  // 🔥 PRODUCTS NAHI TO POORI SECTION HATAO
            }
        } else {
            similarSection.style.display = 'none';  // 🔥 API FAIL TO BHI HATAO
        }
        
    } catch (error) {
        console.error('Error fetching similar products:', error);
        similarSection.style.display = 'none';  // 🔥 ERROR ME BHI HATAO
    }
}
    
    
    window.buyNow = function() {
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        
        if (!token || !user.id) {
            sessionStorage.setItem('redirect_after_login', '/checkout/shipping');
            sessionStorage.setItem('login_message', 'Please login to continue checkout');
            window.location.href = '/login';
            return;
        }
        
        if (!selectedSize && allSizes.length > 0) {
            const sizeError = document.querySelector('.pdp-size-error');
            if (sizeError) {
                sizeError.style.display = 'block';
            } else {
                const sizeSection = document.querySelector('.pdp-size');
                if (sizeSection) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'pdp-size-error';
                    errorDiv.style.cssText = 'color: #ff3f6c; font-size: 13px; margin-top: 8px; display: block;';
                    errorDiv.textContent = 'Please select a size';
                    sizeSection.appendChild(errorDiv);
                    
                    setTimeout(() => {
                        errorDiv.style.display = 'none';
                    }, 3000);
                }
            }
            
            document.querySelector('.pdp-size-options')?.classList.add('size-error-shake');
            setTimeout(() => {
                document.querySelector('.pdp-size-options')?.classList.remove('size-error-shake');
            }, 500);
            
            return;
        }
        
        addToCartFromProduct();
        setTimeout(() => {
            window.location.href = '/checkout/shipping';
        }, 500);
    };
    
    function showError(message) {
        const container = document.getElementById('product-container');
        container.innerHTML = `
            <div class="error-container">
                <h2>${message}</h2>
                <p>Please try again or browse other products.</p>
                <a href="/landing" class="btn-home">Go to Homepage</a>
            </div>
        `;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
        fetchProduct();
    });
})();