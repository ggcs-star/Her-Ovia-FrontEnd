const API_BASE_URL = window.API_BASE_URL || '';

// ========== HELPER FUNCTIONS ==========
function getCart() {
    try {
        const cart = JSON.parse(localStorage.getItem('cart'));
        return Array.isArray(cart) ? cart : [];
    } catch (error) {
        console.warn('Invalid cart data found. Resetting cart.');
        localStorage.removeItem('cart');
        return [];
    }
}

function saveCart(cart) {
    const safeCart = Array.isArray(cart) ? cart : [];

    try {
        localStorage.setItem('cart', JSON.stringify(safeCart));
    } catch (error) {
        console.error('Unable to save cart:', error);
        showToast('Unable to update cart', 'error');
        return false;
    }

    updateCartCountBadge();
    return true;
}

function updateCartCountBadge() {
    let cart = getCart();
    const totalItems = cart.length;
    
    const cartPageCount = document.getElementById('cart-count');
    if (cartPageCount) cartPageCount.innerText = totalItems;
    
    const webBadge = document.getElementById('web-cart-count-badge');
    if (webBadge) {
        webBadge.innerText = totalItems;
        webBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
    
    const mobileBadge = document.querySelector('.cart-badge');
    if (mobileBadge) {
        mobileBadge.innerText = totalItems;
        mobileBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `cart-toast ${type}`;
    toast.textContent = message;

    toast.style.position = 'fixed';
    toast.style.zIndex = '2147483647';

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}

function closePopup() {
    const popup = document.querySelector('.popup-overlay');
    if (!popup) return;
    popup.classList.remove('active');
    setTimeout(() => popup.remove(), 250);
    document.body.style.overflow = '';
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'flex';
}

function getEmptyCartHTML() {
    return `
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h3>Your bag is empty</h3>
            <p>Looks like you haven't added anything to your bag yet</p>
            <a href="/" class="shop-now-btn">SHOP NOW</a>
        </div>
    `;
}

function getDeliveryDate() {
    const date = new Date();
    date.setDate(date.getDate() + 5);
    return date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });
}

function getPriceInfo(item) {
    let price = Number(item.price) || Number(item.product_price) || 0;
    let mrp = Number(item.mrp) || Number(item.originalPrice) || price;
    
    if ((price === 0 || isNaN(price)) && item.availableVariants?.length) {
        const matchedVariant = item.availableVariants.find(v => v.value === item.variantValue);
        if (matchedVariant) {
            price = Number(matchedVariant.price) || 0;
            mrp = Number(matchedVariant.originalPrice) || price;
        }
    }
    
    if (price === 0 || isNaN(price)) {
        price = 999;
        mrp = 1999;
    }
    
    return { price, mrp, discountPercent: mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0 };
}

// ========== CART RENDERING ==========
const CART_CACHE_DURATION = 1 * 60 * 1000;
const cartCategoryCache = new Map();
const cartCategoryInFlight = new Map();

function readCartCategoryCache(categoryId) {
    try {
        const raw = localStorage.getItem(`cart_category_products_${categoryId}`);
        if (!raw) return null;

        const entry = JSON.parse(raw);
        if (!entry || !Array.isArray(entry.products)) return null;

        return {
            products: entry.products,
            timestamp: Number(entry.timestamp) || 0
        };
    } catch (error) {
        console.warn('Cart category cache read failed:', error);
        return null;
    }
}

function writeCartCategoryCache(categoryId, products) {
    const entry = {
        products: Array.isArray(products) ? products : [],
        timestamp: Date.now()
    };

    cartCategoryCache.set(String(categoryId), entry);

    try {
        localStorage.setItem(
            `cart_category_products_${categoryId}`,
            JSON.stringify(entry)
        );
    } catch (error) {
        console.warn('Cart category cache write failed:', error);
    }

    return entry;
}

async function fetchCategoryProductsForCart(categoryId, forceRefresh = false) {
    if (!categoryId) return null;

    const key = String(categoryId);
    const memoryCache = cartCategoryCache.get(key);
    const localCache = memoryCache || readCartCategoryCache(categoryId);

    if (!forceRefresh && localCache?.products?.length) {
        cartCategoryCache.set(key, localCache);

        if (Date.now() - localCache.timestamp < CART_CACHE_DURATION) {
            return localCache.products;
        }
    }

    if (cartCategoryInFlight.has(key)) {
        return cartCategoryInFlight.get(key);
    }

    const request = fetch(`${API_BASE_URL}/categories/${encodeURIComponent(categoryId)}/products`, {
        headers: { 'Accept': 'application/json' },
        cache: 'no-store'
    })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(data => {
            if (!data?.success || !Array.isArray(data.data?.products)) {
                throw new Error('Invalid category products response');
            }

            writeCartCategoryCache(categoryId, data.data.products);
            return data.data.products;
        })
        .finally(() => {
            cartCategoryInFlight.delete(key);
        });

    cartCategoryInFlight.set(key, request);
    return request;
}

async function enrichCartBrands(cart, forceRefresh = false) {
    if (!Array.isArray(cart) || !cart.length) return cart;

    const result = cart.map(item => ({ ...item }));
    const categoryIds = [...new Set(
        result
            .filter(item => {
                const hasBrand = item.brand &&
                    item.brand !== 'RAPID RETAIL' &&
                    item.brand !== 'H&M';
                return !hasBrand && item.categoryId;
            })
            .map(item => String(item.categoryId))
    )];

    if (!categoryIds.length) return result;

    const categoryResults = await Promise.allSettled(
        categoryIds.map(categoryId =>
            fetchCategoryProductsForCart(categoryId, forceRefresh)
        )
    );

    const productsByCategory = new Map();

    categoryResults.forEach((result, index) => {
        if (result.status === 'fulfilled' && Array.isArray(result.value)) {
            productsByCategory.set(categoryIds[index], result.value);
        }
    });

    let changed = false;

    result.forEach(item => {
        const products = productsByCategory.get(String(item.categoryId));
        if (!products) return;

        const product = products.find(p => p.id == item.id);
        if (product?.brand && product.brand !== item.brand) {
            item.brand = product.brand;
            changed = true;
        }

        if ((!item.mrp || item.mrp === 0) && item.availableVariants?.length) {
            const matchedVariant = item.availableVariants.find(
                v => v.value === item.variantValue
            );

            if (matchedVariant?.originalPrice) {
                item.mrp = matchedVariant.originalPrice;
                item.originalPrice = matchedVariant.originalPrice;
                changed = true;
            }
        }
    });

    if (changed) {
        localStorage.setItem('cart', JSON.stringify(result));
        updateCartCountBadge();
    }

    return result;
}

function refreshCartDataInBackground(cart) {
    enrichCartBrands(cart, true)
        .then(updatedCart => {
            if (!Array.isArray(updatedCart)) return;

            const currentCart = getCart();
            if (JSON.stringify(currentCart) !== JSON.stringify(updatedCart)) {
                renderCart(updatedCart);
            }
        })
        .catch(error => {
            console.warn('Background cart refresh failed:', error);
        });
}

function getCartItemHTML(item, index, qty, price, itemTotal, isWeb) {
    let variantType = item.variantType || item.type || 'Size';
    let variantValue = item.variantValue || item.size || '';
    
    if (!variantValue && item.availableVariants && item.availableVariants.length > 0) {
        const matched = item.availableVariants.find(v => v.id == item.variantId);
        variantValue = matched?.value || item.availableVariants[0]?.value || '';
    }
    
    const hasVariant = variantValue && variantValue !== '' && variantValue !== 'Standard';
    const allVariants = item.availableVariants || [];
    const availableVariants = allVariants.filter(function(v) {
        const stock = Number(v.quantity ?? v.stock ?? 0);
        return stock > 0;
    });
    const { mrp, discountPercent } = getPriceInfo(item);
    const formattedDate = getDeliveryDate();

    let variantDisplayHtml = '';
    if (hasVariant) {
        variantDisplayHtml = '<div class="cart-item-variant">' +
            '<span class="variant-label">' + variantType + ':</span>' +
            '<span class="variant-value">' + variantValue + '</span>' +
            '</div>';
    }

    let selectorsHtml = '';
    
    if (isWeb) {
        if (availableVariants.length > 1) {
            let variantsHtml = '';
            availableVariants.forEach(function(v) {
                const selClass = v.value === variantValue ? 'selected' : '';
                variantsHtml += '<div class="dropdown-option ' + selClass + '" ' +
                    'data-value="' + v.value + '" data-variant-id="' + v.id + '" data-price="' + (v.price || 0) + '" data-original="' + (v.originalPrice || 0) + '">' +
                    v.value + '</div>';
            });
            
            selectorsHtml = '<div class="selector-wrapper">' +
                '<div class="selector-trigger" onclick="toggleVariantDropdown(' + index + ')">' +
                '<span class="selector-label">' + variantType + ':</span>' +
                '<span class="selector-value">' + (variantValue || 'Select') + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>' +
                '<div class="selector-dropdown" id="variant-dropdown-' + index + '">' +
                '<div class="dropdown-options">' + variantsHtml + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="selector-wrapper">' +
                '<div class="qty-control">' +
                '<button class="qty-btn qty-minus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', -1)">−</button>' +
                '<input type="number" class="qty-input" id="qty-input-' + index + '" value="' + qty + '" min="1" max="99" onchange="updateWebQtyFromInput(' + index + ')">' +
                '<button class="qty-btn qty-plus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', 1)">+</button>' +
                '</div>' +
                '</div>';
        } else if (hasVariant) {
            selectorsHtml = '<div class="selector-wrapper">' +
                '<div class="selector-trigger" style="cursor:default;">' +
                '<span class="selector-label">' + variantType + ':</span>' +
                '<span class="selector-value">' + variantValue + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>' +
                '</div>' +
                '<div class="selector-wrapper">' +
                '<div class="qty-control">' +
                '<button class="qty-btn qty-minus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', -1)">−</button>' +
                '<input type="number" class="qty-input" id="qty-input-' + index + '" value="' + qty + '" min="1" max="99" onchange="updateWebQtyFromInput(' + index + ')">' +
                '<button class="qty-btn qty-plus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', 1)">+</button>' +
                '</div>' +
                '</div>';
        } else {
            selectorsHtml = '<div class="selector-wrapper">' +
                '<div class="qty-control">' +
                '<button class="qty-btn qty-minus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', -1)">−</button>' +
                '<input type="number" class="qty-input" id="qty-input-' + index + '" value="' + qty + '" min="1" max="99" onchange="updateWebQtyFromInput(' + index + ')">' +
                '<button class="qty-btn qty-plus-btn" data-index="' + index + '" onclick="updateWebQty(' + index + ', 1)">+</button>' +
                '</div>' +
                '</div>';
        }
    } else {
        if (availableVariants.length > 1) {
            selectorsHtml = '<div class="selector-box" onclick="openSizePopup(' + index + ', \'' + variantType + '\', \'' + (variantValue || '') + '\')">' +
                '<span class="selector-label">' + variantType + ':</span>' +
                '<span class="selector-value">' + (variantValue || 'Select') + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>' +
                '<div class="selector-box" onclick="openQtyPopup(' + index + ', ' + qty + ')">' +
                '<span class="selector-label">Qty:</span>' +
                '<span class="selector-value">' + qty + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>';
        } else if (hasVariant) {
            selectorsHtml = '<div class="selector-box" style="cursor:default;background:#f8f8f8;">' +
                '<span class="selector-label">' + variantType + ':</span>' +
                '<span class="selector-value" style="font-weight:600;">' + variantValue + '</span>' +
                '</div>' +
                '<div class="selector-box" onclick="openQtyPopup(' + index + ', ' + qty + ')">' +
                '<span class="selector-label">Qty:</span>' +
                '<span class="selector-value">' + qty + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>';
        } else {
            selectorsHtml = '<div class="selector-box" onclick="openQtyPopup(' + index + ', ' + qty + ')">' +
                '<span class="selector-label">Qty:</span>' +
                '<span class="selector-value">' + qty + '</span>' +
                '<span class="dropdown-arrow">▼</span>' +
                '</div>';
        }
    }

    return '<div class="cart-item" data-index="' + index + '" data-product-id="' + item.id + '">' +
        '<div class="cart-item-main">' +
        '<img src="' + (item.image || 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c') + '" ' +
        'alt="' + (item.name || '') + '" class="cart-item-img" ' +
        'onclick="window.location.href=\'/product/' + (item.slug || item.id) + '\'" ' +
        'onerror="this.src=\'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c\'">' +
        '<div class="cart-item-info">' +
        '<div class="cart-item-brand">' + (item.brand || '') + '</div>' +
        '<div class="cart-item-name">' + (item.name || '') + '</div>' +
        variantDisplayHtml +
        '<div class="cart-item-rating">' +
        '<span class="stars">★★★★☆</span>' +
        '<span class="rating-count">4.5 | 33</span>' +
        '</div>' +
        '<div class="cart-item-price-section">' +
        '<span class="current-price">₹' + price.toFixed(2) + '</span>' +
        (mrp > price ? '<span class="original-price">₹' + mrp.toFixed(2) + '</span><span class="discount-badge">' + discountPercent + '% Off</span>' : '') +
        '</div>' +
        '<div class="cart-item-selectors">' + selectorsHtml + '</div>' +
        '<div class="delivery-info">' +
        '<span class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><rect x="2" y="5" width="16" height="12" rx="2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/><path d="M18 9h4v6h-4"/></svg></span>' +
        '<span class="info-text">Delivery by <span class="delivery-date">' + formattedDate + '</span></span>' +
        '</div>' +
        '<div class="return-info">' +
        '<span class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" stroke-linecap="round" stroke-linejoin="round"/></svg></span>' +
        '<span class="info-text">7 Days Return & Exchange</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="cart-item-actions">' +
        '<button class="action-btn" onclick="removeItem(' + index + ')">Remove</button>' +
        '<button class="action-btn" onclick="moveToWishlist(' + index + ')">Move to Wishlist</button>' +
        '</div>' +
        '</div>';
}

function updatePriceDetails(items) {
    let totalMrp = 0, totalFinalPrice = 0, itemCount = 0;
    
    items.forEach(item => {
        const { price, mrp } = getPriceInfo(item);
        const qty = Number(item.quantity) || 1;
        itemCount += qty;
        totalMrp += mrp * qty;
        totalFinalPrice += price * qty;
    });
    
    const totalProductDiscount = totalMrp - totalFinalPrice;
    
    const elements = {
        itemCount: document.getElementById('item-count'),
        totalMrp: document.getElementById('total-mrp'),
        totalDiscount: document.getElementById('total-discount'),
        finalTotal: document.getElementById('final-total-web'),
        bottomTotal: document.getElementById('bottom-total'),
        savingsAmount: document.getElementById('savings-amount'),
        savingsMsg: document.querySelector('.savings-message')
    };
    
    if (elements.itemCount) elements.itemCount.innerText = itemCount;
    if (elements.totalMrp) elements.totalMrp.innerText = `₹${totalMrp.toFixed(2)}`;
    if (elements.totalDiscount) elements.totalDiscount.innerText = `- ₹${totalProductDiscount.toFixed(2)}`;
    if (elements.finalTotal) elements.finalTotal.innerText = `₹${totalFinalPrice.toFixed(2)}`;
    if (elements.bottomTotal) elements.bottomTotal.innerText = `₹${totalFinalPrice.toFixed(2)}`;
    
    if (elements.savingsMsg && elements.savingsAmount) {
        if (totalProductDiscount > 0) {
            elements.savingsAmount.innerText = `₹${totalProductDiscount.toFixed(2)}`;
            elements.savingsMsg.style.display = 'flex';
        } else {
            elements.savingsMsg.style.display = 'none';
        }
    }
}

function renderCart(items) {
    const container = document.getElementById('cart-items');
    const countEl = document.getElementById('cart-count');
    const couponSection = document.querySelector('.coupon-section');
    const orderSummary = document.querySelector('.order-summary-card');
    const stickyBar = document.querySelector('.sticky-bottom-bar');
    const isWeb = window.innerWidth >= 1025;
    
    if (!container) return;

    if (items.length === 0) {
        container.innerHTML = getEmptyCartHTML();
        updatePriceDetails([]);
        if (countEl) countEl.innerText = '0';
        if (couponSection) couponSection.style.display = 'none';
        if (orderSummary) orderSummary.style.display = 'none';
        if (stickyBar) stickyBar.style.display = 'none';
        return;
    }
    
    if (couponSection) couponSection.style.display = 'block';
    if (orderSummary) orderSummary.style.display = 'block';
    if (stickyBar) stickyBar.style.display = 'flex';

    const fixedItems = items.map(item => {
        const { price, mrp } = getPriceInfo(item);
        return { ...item, price, mrp, originalPrice: mrp };
    });

    container.innerHTML = fixedItems.map((item, index) => {
        const price = Number(item.price) || 0;
        const qty = Number(item.quantity) || 1;
        const itemTotal = price * qty;
        return getCartItemHTML({ ...item, originalPrice: item.mrp, mrp: item.mrp }, index, qty, price, itemTotal, isWeb);
    }).join('');

    updatePriceDetails(fixedItems);
    if (countEl) countEl.innerText = fixedItems.reduce((sum, item) => sum + (item.quantity || 1), 0);
    updateCartCountBadge();
    fixedItems.forEach((item, index) => {
        updateQtyButtonState(index);
    });
}

function loadCart() {
    const cart = getCart();

    // console.log('📦 Cart from localStorage:', cart.length);
    renderCart(cart);

    refreshCartDataInBackground(cart);
}

function removeItem(index) {
    let cart = getCart();
    cart.splice(index, 1);
    saveCart(cart);
    
    if (cart.length === 0) {
        localStorage.removeItem('applied_coupon');
        localStorage.removeItem('coupon_discount');
    }
    
    const token = localStorage.getItem('token');
    const serverCartItemId = window.cartItemIds?.[index];
    if (token && serverCartItemId) {
        fetch(`${API_BASE_URL}/cart/remove/${serverCartItemId}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        }).catch(err => console.warn('Server remove failed:', err));
    }
    loadCart();
}

function moveToWishlist(index) {
    let cart = getCart();
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const item = cart[index];
    cart.splice(index, 1);
    saveCart(cart);
    
    if (!wishlist.some(w => w.id === item.id)) {
        wishlist.push(item);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
    }
    loadCart();
}
function getVariantStock(item) {
    const variants = item.availableVariants || [];

    const selectedVariant = variants.find(v =>
        String(v.id) === String(item.variantId) ||
        String(v.value) === String(item.variantValue) ||
        String(v.variant_value) === String(item.variantValue)
    );

    if (selectedVariant) {
        return Number(
            selectedVariant.quantity ??
            selectedVariant.stock ??
            item.quantity_available ??
            item.stock ??
            99
        );
    }

    return Number(item.quantity_available ?? item.stock ?? 99);
}
function updateQtyButtonState(index) {
    const cart = getCart();
    const item = cart[index];

    if (!item) return;

    const input = document.getElementById(`qty-input-${index}`);
    if (!input) return;

    const plusBtn = document.querySelector(
        `.qty-plus-btn[data-index="${index}"]`
    );

    const minusBtn = document.querySelector(
        `.qty-minus-btn[data-index="${index}"]`
    );

    const currentQty = Number(input.value) || 1;

    const selectedVariant = (item.availableVariants || []).find(
        v => String(v.id) === String(item.variantId)
    );

    const stock = getVariantStock(item);

    if (plusBtn) {
    if (stock > 0 && currentQty >= stock) {
        plusBtn.disabled = false;
        plusBtn.setAttribute('aria-disabled', 'true');
        plusBtn.style.pointerEvents = 'auto';
        plusBtn.style.opacity = '0.4';
        plusBtn.style.cursor = 'not-allowed';

        plusBtn.onclick = function () {
            showToast(
                `Maximum available quantity reached. Only ${stock} items are in stock.`,
                'error'
            );
        };
    } else {
        plusBtn.disabled = false;
        plusBtn.removeAttribute('aria-disabled');
        plusBtn.style.pointerEvents = 'auto';
        plusBtn.style.opacity = '1';
        plusBtn.style.cursor = 'pointer';

        plusBtn.onclick = function () {
            updateWebQty(index, 1);
        };
    }
}
    if (minusBtn) {
        if (currentQty <= 1) {
            minusBtn.disabled = true;
            minusBtn.style.pointerEvents = 'none';
            minusBtn.style.opacity = '0.4';
            minusBtn.style.cursor = 'not-allowed';
        } else {
            minusBtn.disabled = false;
            minusBtn.style.pointerEvents = 'auto';
            minusBtn.style.opacity = '1';
            minusBtn.style.cursor = 'pointer';
        }
    }
}
function updateWebQty(index, delta) {
    const input = document.getElementById(`qty-input-${index}`);
    if (!input) return;

    let cart = getCart();
    if (!cart[index]) return;

    const item = cart[index];

    let currentQty = parseInt(input.value) || 1;
    let newQty = currentQty + delta;

    const stock = getVariantStock(item);

    newQty = Math.max(1, newQty);

    if (newQty > stock) {
        newQty = stock;
        showToast(`Only ${stock} items available`, 'error');
    }

    newQty = Math.min(99, newQty);

    input.value = newQty;
    item.quantity = newQty;

    saveCart(cart);
    updatePriceDetails(cart);
    updateQtyButtonState(index);
}

function updateWebQtyFromInput(index) {
    const input = document.getElementById(`qty-input-${index}`);
    if (!input) return;

    let cart = getCart();
    if (!cart[index]) return;

    const item = cart[index];

    let newQty = Math.max(1, parseInt(input.value) || 1);

    const stock = getVariantStock(item);

    if (newQty > stock) {
        newQty = stock;
        showToast(`Only ${stock} items available`, 'error');
    }

    newQty = Math.min(99, newQty);

    input.value = newQty;
    item.quantity = newQty;

    saveCart(cart);
    updatePriceDetails(cart);
    updateQtyButtonState(index);
}

function toggleVariantDropdown(index) {
    const dropdown = document.getElementById(`variant-dropdown-${index}`);
    const trigger = dropdown?.previousElementSibling;
    if (!dropdown) return;
    
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        trigger?.classList.remove('open');
    } else {
        document.querySelectorAll('.selector-dropdown').forEach(d => d.classList.remove('show'));
        document.querySelectorAll('.selector-trigger').forEach(t => t.classList.remove('open'));
        dropdown.classList.add('show');
        trigger?.classList.add('open');
        
        dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
            opt.onclick = (e) => {
                e.stopPropagation();
                const value = opt.dataset.value;
                const price = parseFloat(opt.dataset.price);
                const originalPrice = parseFloat(opt.dataset.original);
                const variantId = opt.dataset.variantId;
                
                let cart = getCart();
                if (cart[index]) {
                    cart[index].variantValue = value;
                    if (price && !isNaN(price)) cart[index].price = price;
                    if (variantId) {
                        cart[index].variantId = variantId;
                    }
                    if (originalPrice && !isNaN(originalPrice)) {
                        cart[index].mrp = originalPrice;
                        cart[index].originalPrice = originalPrice;
                    }
                    const selectedVariant = (cart[index].availableVariants || []).find(
                            v => String(v.id) === String(variantId)
                        );

                        const stock = Number(
                            selectedVariant?.quantity ??
                            selectedVariant?.stock ??
                            cart[index].quantity_available ??
                            cart[index].stock ??
                            99
                        );

                        if (cart[index].quantity > stock) {
                            cart[index].quantity = stock;
                            showToast(`Only ${stock} items available`, 'error');
                        }
                    saveCart(cart);
                    
                    dropdown.classList.remove('show');
                    trigger?.classList.remove('open');
                    if (trigger) {
                        const valueSpan = trigger.querySelector('.selector-value');
                        if (valueSpan) valueSpan.innerText = value;
                    }
                    loadCart();
                }
            };
        });
    }
}

function openSizePopup(index, variantType, currentValue) {
    let cart = getCart();
    if (!cart[index]) return;
    
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'none';
    
    const availableVariants = cart[index].availableVariants || [];
    
    let optionsHtml = '<div class="popup-options-grid">';
    availableVariants.forEach(function(v) {
        const isSelected = v.value === currentValue ? 'selected' : '';
        optionsHtml += '<div class="popup-option ' + isSelected + '" ' +
            'onclick="selectSizeFromPopup(' + index + ', \'' + v.value + '\', ' + (Number(v.price) || 0) + ', ' + (Number(v.originalPrice) || 0) + ', ' + (v.id || 0) + ')">' +
            v.value +
            '</div>';
    });
    optionsHtml += '</div>';
    
    const popupHTML = `
        <div class="popup-overlay" onclick="closePopup()">
            <div class="popup-content" onclick="event.stopPropagation()">
                <div class="popup-header"><h3>Select ${variantType}</h3><button class="popup-close" onclick="closePopup()">✕</button></div>
                ${optionsHtml}
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    setTimeout(() => document.querySelector('.popup-overlay')?.classList.add('active'), 10);
    document.body.style.overflow = 'hidden';
}

function selectSizeFromPopup(index, value, price, originalPrice, variantId) {
    let cart = getCart();
    if (!cart[index]) return;
    
    cart[index].variantValue = value;
    cart[index].size = value;
    
    if (variantId && variantId !== 0) {
        cart[index].variantId = variantId;
    } else if (cart[index].availableVariants && cart[index].availableVariants.length > 0) {
        const matchedVariant = cart[index].availableVariants.find(function(v) {
            return v.value === value;
        });
        if (matchedVariant) {
            cart[index].variantId = matchedVariant.id || cart[index].variantId;
        }
    }
    
    if (price && !isNaN(price)) cart[index].price = price;
    if (originalPrice && !isNaN(originalPrice)) {
        cart[index].mrp = originalPrice;
        cart[index].originalPrice = originalPrice;
    }
    
    saveCart(cart);
    closePopup();
    loadCart();
}

function openQtyPopup(index, currentQty) {
    let cart = getCart();
    if (!cart[index]) return;
    
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'none';
    
    const popupHTML = `
        <div class="popup-overlay" id="qty-popup-overlay" onclick="closeQtyPopup()">
            <div class="popup-content" onclick="event.stopPropagation()">
                <div class="popup-header"><h3>Select Quantity</h3><button class="popup-close" onclick="closeQtyPopup()">✕</button></div>
                <div class="popup-qty-container">
                    <div class="popup-qty-controls">
                        <button class="popup-qty-btn" onclick="updateTempQty(${index}, -1)" ${currentQty <= 1 ? 'disabled' : ''}>−</button>
                        <input type="number" class="popup-qty-input" id="popup-qty-input-${index}" value="${currentQty}" min="1" max="99" onchange="updateTempQtyFromInput(${index})">
                        <button class="popup-qty-btn" onclick="updateTempQty(${index}, 1)">+</button>
                    </div>
                    <div class="popup-buttons">
                        <button class="popup-cancel-btn" onclick="closeQtyPopup()">CANCEL</button>
                        <button class="popup-done-btn" onclick="applyQtyChange(${index})">DONE</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    const popup = document.querySelector('.popup-overlay');
    setTimeout(() => popup?.classList.add('active'), 10);
    document.body.style.overflow = 'hidden';
    if (popup) popup.dataset.tempQty = currentQty;
}

function updateTempQty(index, delta) {
    const input = document.getElementById(`popup-qty-input-${index}`);
    if (!input) return;

    const cart = getCart();
    if (!cart[index]) return;

    const item = cart[index];

    let newQty = (parseInt(input.value) || 1) + delta;
    newQty = Math.max(1, newQty);

    const selectedVariant = (item.availableVariants || []).find(
        v => String(v.id) === String(item.variantId)
    );

    const stock = Number(
        selectedVariant?.quantity ??
        selectedVariant?.stock ??
        item.quantity_available ??
        item.stock ??
        99
    );

    if (newQty > stock) {
        newQty = stock;
        showToast(`Only ${stock} items available`, 'error');
    }

    newQty = Math.min(99, newQty);

    input.value = newQty;

    const popup = document.querySelector('.popup-overlay');
    if (popup) popup.dataset.tempQty = newQty;
}

function updateTempQtyFromInput(index) {
    const input = document.getElementById(`popup-qty-input-${index}`);
    if (!input) return;

    const cart = getCart();
    if (!cart[index]) return;

    const item = cart[index];

    let newQty = Math.max(1, parseInt(input.value) || 1);

    const selectedVariant = (item.availableVariants || []).find(
        v => String(v.id) === String(item.variantId)
    );

    const stock = Number(
        selectedVariant?.quantity ??
        selectedVariant?.stock ??
        item.quantity_available ??
        item.stock ??
        99
    );

    if (newQty > stock) {
        newQty = stock;
        showToast(`Only ${stock} items available`, 'error');
    }

    newQty = Math.min(99, newQty);

    input.value = newQty;

    const popup = document.querySelector('.popup-overlay');
    if (popup) popup.dataset.tempQty = newQty;
}

function applyQtyChange(index) {
    const popup = document.querySelector('.popup-overlay');
    const newQty = popup ? parseInt(popup.dataset.tempQty) : null;
    if (newQty && newQty > 0) {
        let cart = getCart();
        if (cart[index]) {
            cart[index].quantity = newQty;
            saveCart(cart);
            loadCart();
        }
    }
    closeQtyPopup();
}

function closeQtyPopup() {
    const popup = document.querySelector('.popup-overlay');
    if (!popup) return;
    popup.classList.remove('active');
    setTimeout(() => popup.remove(), 250);
    document.body.style.overflow = '';
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'flex';
}

function initCouponSection() {

    const applyBtn = document.getElementById('apply-coupon-btn');
    if (applyBtn) {
        applyBtn.addEventListener('click', () => applyCoupon());
    }

    const removeBtn = document.getElementById('remove-coupon-btn');
    if (removeBtn) {
        removeBtn.addEventListener('click', removeCoupon);
    }

    const input = document.getElementById('coupon-code-input');
    if (input) {
        input.addEventListener('keypress', function(e){
            if(e.key === 'Enter'){
                applyCoupon();
            }
        });
    }
}

function applyCoupon(couponCode = null) {
    const code = couponCode || document.getElementById('coupon-code-input')?.value;
    if (!code) { showToast('Please enter a coupon code', 'error'); return; }

    
    const cartTotal = parseFloat(document.getElementById('final-total-web')?.innerText.replace('₹', '').replace(',', '') || 0);
  const cart = getCart();

if (!cart.length) {
    showToast('Cart is empty', 'error');
    return;
}

const firstItem = cart[0];  
console.log(firstItem);
console.log("First Item:", firstItem);

console.log({
    coupon_code: code.toUpperCase(),
    cart_total: cartTotal,
    product_id: firstItem.id,
    category_id: firstItem.categoryId,
    subcategory_id: firstItem.subcategoryId
});
    fetch(`${API_BASE_URL}/coupons/apply`, {
        method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
body: JSON.stringify({
    coupon_code: code.toUpperCase(),
    cart_total: cartTotal,
    product_id: firstItem.id,
    category_id: firstItem.categoryId,
    subcategory_id: firstItem.subcategoryId || null  
})
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            localStorage.setItem('applied_coupon', response.data.coupon_code);
            localStorage.setItem('coupon_discount', response.data.discount);
            showAppliedCoupon(response.data.coupon_code, response.data.discount);
            updateTotalsWithCoupon(response.data);
            showCouponSuccessPopup(response.data.coupon_code, response.data.discount);
        } else {
            showToast(response.message || 'Failed to apply coupon', 'error');
        }
    })
    .catch(err => { console.error('Error:', err); showToast('Error applying coupon', 'error'); });
}

function showAppliedCoupon(code, discount) {
    const appliedDiv = document.querySelector('.applied-coupon');
    const couponBox = document.querySelector('.coupon-box');
    const appliedCodeSpan = document.getElementById('applied-coupon-code');
    if (appliedDiv && appliedCodeSpan) {
        appliedCodeSpan.innerText = `${code} • -₹${discount.toFixed(2)}`;
        appliedDiv.style.display = 'flex';
        if (couponBox) couponBox.style.display = 'none';
    }
}

function updateTotalsWithCoupon(couponData) {
    const totalMrp = parseFloat(document.getElementById('total-mrp')?.innerText.replace('₹', '') || 0);
    const productDiscount = parseFloat(document.getElementById('total-discount')?.innerText.replace('- ₹', '') || 0);
    
    const couponRow = document.querySelector('.coupon-discount');
    const couponDiscountSpan = document.getElementById('coupon-discount');
    if (couponRow && couponDiscountSpan) {
        couponRow.style.display = 'flex';
        couponDiscountSpan.innerText = `- ₹${couponData.discount.toFixed(2)}`;
    }
    
    const finalTotal = Math.max(totalMrp - productDiscount - (couponData?.discount || 0), 0);
    const finalTotalEl = document.getElementById('final-total-web');
    const bottomTotalEl = document.getElementById('bottom-total');
    if (finalTotalEl) finalTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    if (bottomTotalEl) bottomTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    
    const savingsMsg = document.querySelector('.savings-message');
    const savingsAmount = document.getElementById('savings-amount');
    if (savingsMsg && savingsAmount) {
        savingsAmount.innerText = `₹${(productDiscount + couponData.discount).toFixed(2)}`;
        savingsMsg.style.display = 'flex';
    }
}

function removeCoupon() {
    fetch(`${API_BASE_URL}/coupons/remove`, { method: 'POST', headers: { 'Accept': 'application/json' } })
    .then(() => {
        localStorage.removeItem('applied_coupon');
        localStorage.removeItem('coupon_discount');
        document.querySelector('.applied-coupon').style.display = 'none';
        document.querySelector('.coupon-box').style.display = 'flex';
        document.querySelector('.coupon-discount').style.display = 'none';
        document.getElementById('coupon-code-input').value = '';
        document.querySelectorAll('input[name="coupon"]').forEach(r => r.checked = false);
        loadCart();
        showToast('Coupon removed', 'info');
    });
}

function showCouponSuccessPopup(code, discount) {
    const popup = document.createElement('div');
    popup.className = 'coupon-success-popup';
    popup.innerHTML = `
        <div class="coupon-success-overlay" onclick="closeCouponSuccessPopup()"></div>
        <div class="coupon-success-content">
            <div class="coupon-success-icon">🎉</div>
            <h3>Coupon Applied!</h3>
            <div class="coupon-success-code">${code}</div>
            <div class="coupon-success-discount">You saved: ₹${discount.toFixed(2)}</div>
            <p class="coupon-success-message">Discount has been applied to your order</p>
            <button class="coupon-success-btn" onclick="closeCouponSuccessPopup()">OK, Great!</button>
        </div>
    `;
    document.body.appendChild(popup);
    setTimeout(() => closeCouponSuccessPopup(), 3000);
}

function closeCouponSuccessPopup() {
    document.querySelector('.coupon-success-popup')?.remove();
}
function proceedToCheckout() {
    let cart = getCart();
    if (cart.length === 0) {
        const popup = document.createElement('div');
        popup.className = 'empty-cart-popup';
        popup.innerHTML = `
            <div class="empty-cart-overlay" onclick="closeEmptyCartPopup()"></div>
            <div class="empty-cart-popup-content">
                <div class="empty-cart-popup-icon">🛒</div>
                <h3>Your cart is empty!</h3>
                <p>Looks like you haven't added anything to your bag yet</p>
                <div class="empty-cart-popup-buttons">
                    <button class="empty-cart-shop-btn" onclick="window.location.href='/'">SHOP NOW</button>
                    <button class="empty-cart-close-btn" onclick="closeEmptyCartPopup()">CLOSE</button>
                </div>
            </div>
        `;
        document.body.appendChild(popup);
        return;
    }
    
        const token = localStorage.getItem('token');
    if (!token) {
        sessionStorage.setItem('guest_checkout_cart', JSON.stringify(cart));
        sessionStorage.setItem('redirect_after_login', '/checkout/shipping');
        if (typeof showLoginPopup === 'function') {
            showLoginPopup();
        } else {
            window.location.href = '/login';
        }
        return;
    }
    window.location.href = '/checkout/shipping';
}


function closeEmptyCartPopup() {
    document.querySelector('.empty-cart-popup')?.remove();
}

document.addEventListener('DOMContentLoaded', function() {
    const buyNowOriginalCart = sessionStorage.getItem('buy_now_original_cart');
    if (buyNowOriginalCart && window.location.pathname === '/cart') {
        console.log('Restoring original cart after Buy Now');
        localStorage.setItem('cart', buyNowOriginalCart);
        sessionStorage.removeItem('buy_now_original_cart');
        location.reload();
        return;
    }
    
    if (document.getElementById('cart-items')) {
        loadCart();
        initCouponSection();
        
        const showPopup = sessionStorage.getItem('show_coupon_popup');
        const popupCode = sessionStorage.getItem('popup_code');
        const popupDiscount = sessionStorage.getItem('popup_discount');
        
        if (showPopup === 'true' && popupCode && popupDiscount) {
            setTimeout(() => {
                showCouponSuccessPopup(popupCode, parseFloat(popupDiscount));
                sessionStorage.removeItem('show_coupon_popup');
                sessionStorage.removeItem('popup_code');
                sessionStorage.removeItem('popup_discount');
            }, 1000);
        }
    }
    
    updateCartCountBadge();
});

if (document.body.classList.contains('cart-page')) {
    window.goBack = function() {
        const lastProduct = sessionStorage.getItem('last_product_page');
        if (lastProduct && !lastProduct.includes('/checkout') && !lastProduct.includes('/cart')) {
            window.location.href = lastProduct;
            sessionStorage.removeItem('last_product_page');
        } else {
            window.location.href = '/';
        }
    };
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.selector-wrapper')) {
        document.querySelectorAll('.selector-dropdown').forEach(d => d.classList.remove('show'));
        document.querySelectorAll('.selector-trigger').forEach(t => t.classList.remove('open'));
    }
});
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        if (document.getElementById('cart-items')) {
            const cart = getCart();
            if (cart.length > 0) {
                renderCart(cart);
            }
        }
    }, 300);
});