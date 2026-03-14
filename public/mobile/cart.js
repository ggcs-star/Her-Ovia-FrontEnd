document.addEventListener('DOMContentLoaded', function() {
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

    const token = localStorage.getItem('token');
    if (!token) {
        console.log('Guest user - cart in localStorage');
    }
});

function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log('📦 Cart from localStorage:', cart.length);

    fetchBrandsForCartItems(cart).then(updatedCart => {
        renderCart(updatedCart);
    });

    setTimeout(() => {
        if (typeof loadAvailableCoupons === 'function') {
            loadAvailableCoupons();
        }
    }, 100);
}

window.goBack = function() {
    window.history.back();
};

async function fetchBrandsForCartItems(cart) {
    if (!cart || cart.length === 0) return cart;
    
    const updatedCart = [...cart];
    
    for (let i = 0; i < updatedCart.length; i++) {
        const item = updatedCart[i];
        
        if (item.brand && item.brand !== 'RAPID RETAIL' && item.brand !== 'H&M') continue;
        
        if (item.categoryId) {
            try {
                const res = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${item.categoryId}/products`);
                const data = await res.json();
                
                if (data.success && data.data?.products) {
                    const productInCategory = data.data.products.find(p => p.id == item.id);
                    if (productInCategory?.brand) {
                        updatedCart[i].brand = productInCategory.brand;
                    }
                }
            } catch (error) {
                console.error('Error fetching brand:', error);
            }
        }
        
        if (!item.mrp || item.mrp === 0) {
            if (item.availableVariants && item.availableVariants.length > 0) {
                const matchedVariant = item.availableVariants.find(v => v.value === item.variantValue);
                if (matchedVariant && matchedVariant.originalPrice) {
                    updatedCart[i].mrp = matchedVariant.originalPrice;
                    updatedCart[i].originalPrice = matchedVariant.originalPrice;
                }
            }
        }
    }
    
    return updatedCart;
}

function renderCart(items) {
    console.log('🎨 renderCart called with items:', items);
    
    const container = document.getElementById('cart-items');
    const countEl = document.getElementById('cart-count');
    const couponSection = document.querySelector('.coupon-section');
    const orderSummary = document.querySelector('.order-summary-card');
    const stickyBar = document.querySelector('.sticky-bottom-bar');
    
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
        item.price = parseFloat(item.price) || 0;
        
        if (!item.mrp || item.mrp === 0) {
            if (item.availableVariants && item.availableVariants.length > 0) {
                const matchedVariant = item.availableVariants.find(v => v.value === item.variantValue);
                if (matchedVariant && matchedVariant.originalPrice) {
                    item.mrp = matchedVariant.originalPrice;
                    item.originalPrice = matchedVariant.originalPrice;
                }
            }
            
            if (!item.mrp || item.mrp === 0) {
                if (item.originalPrice) {
                    item.mrp = item.originalPrice;
                } else {
                    item.mrp = item.price;
                }
            }
        }
        
        return item;
    });

    container.innerHTML = fixedItems.map((item, index) => {
        const price = Number(item.price) || 0;
        const mrp = Number(item.mrp) || Number(item.originalPrice) || price;
        const qty = Number(item.quantity) || 1;
        const itemTotal = price * qty;
        
        return getCartItemHTML({
            ...item,
            originalPrice: mrp,
            price: price,
            mrp: mrp
        }, index, qty, price, itemTotal);
    }).join('');

    updatePriceDetails(fixedItems);
    if (countEl) countEl.innerText = fixedItems.length;
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

function getCartItemHTML(item, index, qty, price, itemTotal) {
    let variantType = item.variantType || 'Size';
    let variantValue = item.variantValue || item.size || '';
    let availableVariants = item.availableVariants || [];
    
    const mrp = Number(item.mrp) || Number(item.originalPrice) || price;
    const finalPrice = Number(item.price) || 0;
    const discountPerItem = mrp - finalPrice;
    const discountPercent = mrp > finalPrice ? Math.round((discountPerItem / mrp) * 100) : 0;
    
    const deliveryDate = new Date();
    deliveryDate.setDate(deliveryDate.getDate() + 5);
    const formattedDate = deliveryDate.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });

    return `
        <div class="cart-item" data-index="${index}" data-product-id="${item.id}">
            <div class="cart-item-main">
                <img src="${item.image || 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c'}" 
                     alt="${item.name}" 
                     class="cart-item-img"
                     onclick="window.location.href='/products/${item.slug}'"
                     onerror="this.src='https://images.unsplash.com/photo-1503342217505-b0a15ec3261c'">
                
                <div class="cart-item-info">
                    <div class="cart-item-brand">${item.brand || ''}</div>
                    <div class="cart-item-name">${item.name}</div>
                    
                    <div class="cart-item-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-count">4.5 | 33</span>
                    </div>
                    
                    <div class="cart-item-price-section">
                        <span class="current-price">₹${finalPrice.toFixed(2)}</span>
                        ${mrp > finalPrice ? `
                            <span class="original-price">₹${mrp.toFixed(2)}</span>
                            <span class="discount-badge">${discountPercent}% Off</span>
                        ` : ''}
                    </div>
                                        
                  <div class="cart-item-selectors">
                    <div class="selector-box" onclick="openSizePopup(${index}, '${variantType}', '${variantValue}')">
                        <span class="selector-label">${variantType}:</span>
                        <span class="selector-value">${variantValue}</span>
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    
                    <div class="selector-box" onclick="openQtyPopup(${index}, ${qty})">
                        <span class="selector-label">Qty:</span>
                        <span class="selector-value">${qty}</span>
                        <span class="dropdown-arrow">▼</span>
                    </div>
                </div>

                    <div class="delivery-info">
                        <span class="info-icon">🚚</span>
                        <span class="info-text">Delivery by <span class="delivery-date">${formattedDate}</span></span>
                    </div>
                    
                    <div class="return-info">
                        <span class="info-icon">🔄</span>
                        <span class="info-text">7 Days Return & Exchange</span>
                    </div>
                </div>
            </div>
            
            <div class="cart-item-actions">
                <button class="action-btn" onclick="removeItem(${index})">Remove</button>
                <button class="action-btn" onclick="moveToWishlist(${index})">Move to Wishlist</button>
            </div>
        </div>
    `;
}

function openSizePopup(index, variantType, currentValue) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'none';
    
    const availableVariants = cart[index].availableVariants || [];
    
    let optionsHtml = '<div class="popup-options-grid">';
    availableVariants.forEach(v => {
        const selected = v.value === currentValue ? 'selected' : '';
        optionsHtml += `<div class="popup-option ${selected}" onclick="selectSizeFromPopup(${index}, '${v.value}', ${v.price || 0}, ${v.originalPrice || 0})">${v.value}</div>`;
    });
    optionsHtml += '</div>';
    
    const popupHTML = `
        <div class="popup-overlay" onclick="closePopup()">
            <div class="popup-content" onclick="event.stopPropagation()">
                <div class="popup-header">
                    <h3>Select ${variantType}</h3>
                    <button class="popup-close" onclick="closePopup()">✕</button>
                </div>
                ${optionsHtml}
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    document.body.style.overflow = 'hidden';
}

function selectSizeFromPopup(index, value, price, originalPrice) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    cart[index].variantValue = value;
    if (price) cart[index].price = price;
    if (originalPrice) {
        cart[index].mrp = originalPrice;
        cart[index].originalPrice = originalPrice;
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    closePopup();
    loadCart();
}

function openQtyPopup(index, currentQty) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'none';
    
    const popupHTML = `
        <div class="popup-overlay" onclick="closePopup()">
            <div class="popup-content">
                <div class="popup-header">
                    <h3>Select Quantity</h3>
                    <button class="popup-close" onclick="closePopup()">✕</button>
                </div>
                <div class="popup-qty-container">
                    <div class="popup-qty-controls">
                        <button class="popup-qty-btn" onclick="updateQtyFromPopup(${index}, ${currentQty - 1})" ${currentQty <= 1 ? 'disabled' : ''}>−</button>
                        <span class="popup-qty-value" id="popup-qty-${index}">${currentQty}</span>
                        <button class="popup-qty-btn" onclick="updateQtyFromPopup(${index}, ${currentQty + 1})">+</button>
                    </div>
                    <button class="popup-done-btn" onclick="closePopup()">DONE</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    document.body.style.overflow = 'hidden';
}

function updateQtyFromPopup(index, newQty) {
    if (newQty < 1) return;
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    cart[index].quantity = newQty;
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    document.getElementById(`popup-qty-${index}`).innerText = newQty;
    
    const minusBtn = document.querySelector(`.popup-qty-controls button:first-child`);
    if (minusBtn) {
        if (newQty <= 1) {
            minusBtn.setAttribute('disabled', 'disabled');
        } else {
            minusBtn.removeAttribute('disabled');
        }
    }
    
    loadCart();
}

function selectQtyFromPopup(index, qty) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    cart[index].quantity = qty;
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    closePopup();
    loadCart();
}

function closePopup() {
    const popup = document.querySelector('.popup-overlay');
    if (popup) popup.remove();
    document.body.style.overflow = '';
    
    const checkoutBar = document.querySelector('.sticky-bottom-bar');
    if (checkoutBar) checkoutBar.style.display = 'flex';
}

function changeQtyDropdown(index, newQty) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    cart[index].quantity = parseInt(newQty);
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    loadCart();
    updateCartCountBadge();
}

function updatePriceDetails(items) {
    let totalMrp = 0;
    let totalFinalPrice = 0;
    let totalProductDiscount = 0;
    let itemCount = items.length;
    
    items.forEach((item) => {
        const mrp = Number(item.mrp) || Number(item.originalPrice) || Number(item.price) || 0;
        const finalPrice = Number(item.price) || 0;
        const qty = Number(item.quantity) || 1;
        
        const itemMrp = mrp * qty;
        const itemFinal = finalPrice * qty;
        const itemDiscount = itemMrp - itemFinal;
        
        totalMrp += itemMrp;
        totalFinalPrice += itemFinal;
        totalProductDiscount += itemDiscount;
    });
    
    const finalTotal = totalFinalPrice;
    
    const itemCountEl = document.getElementById('item-count');
    const totalMrpEl = document.getElementById('total-mrp');
    const totalDiscountEl = document.getElementById('total-discount');
    const shippingEl = document.getElementById('shipping-charge');
    const finalTotalEl = document.getElementById('final-total');
    const bottomTotalEl = document.getElementById('bottom-total');
    const savingsMsg = document.querySelector('.savings-message');
    const savingsAmountEl = document.getElementById('savings-amount');
    
    if (itemCountEl) itemCountEl.innerText = itemCount;
    if (totalMrpEl) totalMrpEl.innerText = `₹${totalMrp.toFixed(2)}`;
    if (totalDiscountEl) totalDiscountEl.innerText = `- ₹${totalProductDiscount.toFixed(2)}`;
    if (shippingEl) shippingEl.innerText = `₹0.00`;
    if (finalTotalEl) finalTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    if (bottomTotalEl) bottomTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    
    if (savingsMsg && savingsAmountEl) {
        if (totalProductDiscount > 0) {
            savingsAmountEl.innerText = `₹${totalProductDiscount.toFixed(2)}`;
            savingsMsg.style.display = 'flex';
        } else {
            savingsMsg.style.display = 'none';
        }
    }

    const appliedCode = localStorage.getItem('applied_coupon');
    const couponDiscount = localStorage.getItem('coupon_discount');
    
    // 🔥 AGAR CART EMPTY HAI TO COUPON MAT DIKHAO
    if (itemCount === 0) {
        localStorage.removeItem('applied_coupon');
        localStorage.removeItem('coupon_discount');
    } else if (appliedCode && couponDiscount) {
        updateTotalsWithCoupon({ discount: parseFloat(couponDiscount) });
    }
}

window.addToBag = function(product) {
    console.log('🛒 addToBag called with product:', product);
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const activeBtn = document.querySelector('.variant-btn.active');
    let selectedVariant = null;
    
    if (product.variants && product.variants.length > 0) {
        if (activeBtn) {
            selectedVariant = product.variants.find(v => v.id == activeBtn.dataset.variantId);
        }
        
        if (!selectedVariant) {
            selectedVariant = product.variants[0];
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

    let imageUrl = '';
    if (product.gallery_images && product.gallery_images.length > 0) {
        imageUrl = product.gallery_images[0];
    } else if (product.image_url) {
        imageUrl = product.image_url;
    } else {
        imageUrl = 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c';
    }

    const cartItem = {
        id: product.id,
        name: product.name,
        brand: product.brand || '',
        price: finalPrice,
        mrp: originalPrice,
        originalPrice: originalPrice,
        image: imageUrl,
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
        i => i.id === cartItem.id && i.variantValue === cartItem.variantValue
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

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `cart-toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function changeVariant(index, variantType, newValue) {
    console.log('Changing variant:', { index, variantType, newValue });
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    const select = event.target;
    const selectedOption = select.options[select.selectedIndex];
    const newPrice = parseFloat(selectedOption.dataset.price);
    const newOriginal = parseFloat(selectedOption.dataset.original);
    
    console.log('Selected option data:', {
        newPrice,
        newOriginal,
        dataset: selectedOption.dataset
    });
    
    cart[index].variantValue = newValue;
    
    if (newPrice && !isNaN(newPrice)) {
        cart[index].price = newPrice;
    }
    if (newOriginal && !isNaN(newOriginal)) {
        cart[index].mrp = newOriginal;
        cart[index].originalPrice = newOriginal;
    }
    
    if (cart[index].availableVariants && cart[index].availableVariants.length > 0) {
        const matchedVariant = cart[index].availableVariants.find(v => v.value === newValue);
        if (matchedVariant) {
            matchedVariant.price = newPrice;
            matchedVariant.originalPrice = newOriginal;
        }
    }
    
    console.log('Updated cart item:', cart[index]);
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    loadCart();
}

function changeQty(index, delta) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (!cart[index]) return;
    
    cart[index].quantity += delta;
    
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    loadCart();
    updateCartCountBadge();
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    const removedItem = cart[index];
    
    // Sirf EK item remove karo
    cart.splice(index, 1);
    
    localStorage.setItem('cart', JSON.stringify(cart));

    if (cart.length === 0) {
        localStorage.removeItem('applied_coupon');
        localStorage.removeItem('coupon_discount');
    }

    const token = localStorage.getItem('token');
    if (token && removedItem?.cart_item_id) {
        fetch(`https://retailadmin.ggconsultancy.services/api/cart/remove/${removedItem.cart_item_id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        }).catch(err => console.warn('Server remove failed:', err));
    }
    loadCart();
    updateCartCountBadge();
}
function moveToWishlist(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    
    const item = cart[index];
    
    cart.splice(index, 1);
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    if (!wishlist.some(w => w.id === item.id)) {
        wishlist.push(item);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
    }
    
    loadCart();
    updateCartCountBadge();
}

function updateCartCountBadge() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    const total = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
    
    document.querySelectorAll('.cart-badge, #cart-count').forEach(el => {
        if (el) el.innerText = total;
    });
}

function loadAvailableCoupons() {
    const couponsList = document.getElementById('coupons-list');
    if (!couponsList) return;
    
    couponsList.innerHTML = '<div class="loading-coupons">Loading coupons...</div>';
    
    fetch('https://retailadmin.ggconsultancy.services/api/coupons', {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
    })
    .then(response => {
        if (response.success && response.data && response.data.length > 0) {
            window.allCoupons = response.data;
            renderCouponsList(response.data);
        } else {
            couponsList.innerHTML = '<div class="no-coupons">No coupons available</div>';
        }
    })
    .catch(err => {
        console.error('Error loading coupons:', err);
        couponsList.innerHTML = '<div class="no-coupons">Failed to load coupons</div>';
    });
}

function applyCoupon(couponCode = null) {
    const code = couponCode || document.getElementById('coupon-code-input')?.value;
    
    if (!code) {
        showToast('Please enter a coupon code', 'error');
        return;
    }
    const selectedCoupon = window.allCoupons?.find(c => c.code === code);
    if (selectedCoupon?.coupon_type === 'BANK') {
        showBankOfferPopup(selectedCoupon);
        return;
    }
    
    const cartTotal = parseFloat(document.getElementById('final-total')?.innerText.replace('₹', '') || 0);
    
    fetch('https://retailadmin.ggconsultancy.services/api/coupons/apply', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            coupon_code: code.toUpperCase(),
            cart_total: cartTotal
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
    .catch(err => {
        console.error('Error:', err);
        showToast('Error applying coupon', 'error');
    });
}

function showBankOfferPopup(couponCode) {
    const coupon = window.allCoupons?.find(c => c.code === couponCode);
    if (!coupon) return;
    
    const popup = document.createElement('div');
    popup.className = 'bank-offer-popup';
    popup.innerHTML = `
        <div class="bank-offer-overlay" onclick="closeBankOfferPopup()"></div>
        <div class="bank-offer-content">
            <div class="bank-offer-icon">🏦</div>
            <h3>Bank Offer</h3>
            <div class="bank-offer-code">${coupon.code}</div>
            <p class="bank-offer-message">This offer can only be applied during checkout with online payment</p>
            <div class="bank-offer-details">
                <div class="bank-offer-save">Save: ₹${parseFloat(coupon.value).toFixed(2)}</div>
                <div class="bank-offer-min">Min. Purchase: ₹${coupon.min_order_amount || 1000}</div>
            </div>
            <div class="bank-offer-buttons">
                <button class="bank-offer-checkout-btn" onclick="window.location.href='/checkout/shipping'">Proceed to Checkout</button>
                <button class="bank-offer-close-btn" onclick="closeBankOfferPopup()">Later</button>
            </div>
        </div>
    `;
    document.body.appendChild(popup);
}

function closeBankOfferPopup() {
    const popup = document.querySelector('.bank-offer-popup');
    if (popup) {
        popup.remove();
    }
}

function goToCheckout() {
    window.location.href = '/checkout/shipping';
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
    
    setTimeout(() => {
        closeCouponSuccessPopup();
    }, 3000);
}

function closeCouponSuccessPopup() {
    const popup = document.querySelector('.coupon-success-popup');
    if (popup) {
        popup.remove();
    }
}

function removeCoupon() {
    fetch('https://retailadmin.ggconsultancy.services/api/coupons/remove', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
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

function renderCouponsList(coupons) {
    const couponsList = document.getElementById('coupons-list');
    if (!couponsList) return;
    
    const finalTotalEl = document.getElementById('final-total');
    const cartTotal = parseFloat(finalTotalEl?.innerText.replace('₹', '') || 0);
    
    if (cartTotal === 0) {
        couponsList.innerHTML = '<div class="no-coupons">Add items to see applicable coupons</div>';
        return;
    }
    
    const applicableCoupons = coupons.filter(coupon => {
        const minOrder = coupon.min_order_amount ? parseFloat(coupon.min_order_amount) : 0;
        return cartTotal >= minOrder;
    });
    
    if (applicableCoupons.length === 0) {
        couponsList.innerHTML = '<div class="no-coupons">No applicable coupons for this order</div>';
        return;
    }
    
    const bankOffers = applicableCoupons.filter(coupon => coupon.coupon_type === 'BANK');
    const normalCoupons = applicableCoupons.filter(coupon => coupon.coupon_type !== 'BANK');
    
    let html = '';
    
    if (bankOffers.length > 0) {
        html += `<div class="coupon-section-divider"><span class="section-badge">🏦 Bank Offers</span></div>`;
        bankOffers.forEach(coupon => {
            html += getCouponCardHTML(coupon, cartTotal);
        });
    }
    
    if (normalCoupons.length > 0) {
        html += `<div class="coupon-section-divider"><span class="section-badge">🎫 Coupons & Offers</span></div>`;
        normalCoupons.forEach(coupon => {
            html += getCouponCardHTML(coupon, cartTotal);
        });
    }
    
    couponsList.innerHTML = html;
}

function getCouponCardHTML(coupon, cartTotal) {
    const minOrder = coupon.min_order_amount ? parseFloat(coupon.min_order_amount) : 0;
    const couponValue = parseFloat(coupon.value);
    const maxDiscount = coupon.max_discount ? parseFloat(coupon.max_discount) : null;
    
    let savings = 0;
    if (coupon.discount_type === 'PERCENT') {
        savings = (cartTotal * couponValue) / 100;
        if (maxDiscount) {
            savings = Math.min(savings, maxDiscount);
        }
    } else {
        savings = couponValue;
    }
    
    const isBank = coupon.coupon_type === 'BANK';
    const cardClass = isBank ? 'bank-offer' : 'normal-offer';
    const badgeClass = isBank ? 'bank-badge' : 'normal-badge';
    const badgeText = isBank ? '🏦 Bank Offer' : '🎫 Special Offer';
    
    let applyButton;
    if (isBank) {
        applyButton = `<button class="coupon-apply-btn bank-offer-btn" onclick="showBankOfferPopup('${coupon.code}'); event.stopPropagation();">Apply at Checkout</button>`;
    } else {
        applyButton = `<button class="coupon-apply-btn" onclick="applyCoupon('${coupon.code}'); event.stopPropagation();">Apply</button>`;
    }
    
    return `
        <div class="coupon-card ${cardClass}" data-code="${coupon.code}">
            <div class="coupon-header">
                <span class="coupon-badge ${badgeClass}">${badgeText}</span>
                <span class="coupon-code">${coupon.code}</span>
            </div>
            <div class="coupon-desc">${coupon.name || coupon.description || 'Special discount'}</div>
            <div class="coupon-savings">💰 You save: ₹${savings.toFixed(2)}</div>
            ${minOrder > 0 ? `<div class="coupon-min">Min. purchase: ₹${minOrder}</div>` : ''}
            <div class="coupon-footer">
                ${applyButton}
                <button class="coupon-tnc-btn" onclick="showCouponTerms('${coupon.code}'); event.stopPropagation();">View T & C</button>
            </div>
        </div>
    `;
}

window.showCouponTerms = function(code) {
    sessionStorage.setItem('view_coupon_code', code);
    window.location.href = '/coupon-terms';
}

function selectCoupon(element) {
    const couponCode = element.dataset.code;
    const input = document.getElementById('coupon-code-input');
    if (input) {
        input.value = couponCode;
    }
    
    document.querySelectorAll('.coupon-card').forEach(c => c.classList.remove('selected'));
    element.classList.add('selected');
    
    applyCoupon(couponCode);
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
    
    const finalTotal = totalMrp - productDiscount - couponData.discount;
    
    const finalTotalEl = document.getElementById('final-total');
    if (finalTotalEl) finalTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    
    const bottomTotalEl = document.getElementById('bottom-total');
    if (bottomTotalEl) bottomTotalEl.innerText = `₹${finalTotal.toFixed(2)}`;
    
    const savingsMsg = document.querySelector('.savings-message');
    const savingsAmount = document.getElementById('savings-amount');
    if (savingsMsg && savingsAmount) {
        savingsAmount.innerText = `₹${(productDiscount + couponData.discount).toFixed(2)}`;
        savingsMsg.style.display = 'flex';
    }
}

function initCouponSection() {
    const viewCouponsBtn = document.querySelector('.view-coupons-link');
    const couponsWrapper = document.querySelector('.applicable-coupons');
    
    if (viewCouponsBtn && couponsWrapper) {
        couponsWrapper.style.display = 'none';
        
        viewCouponsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (couponsWrapper.style.display === 'none') {
                couponsWrapper.style.display = 'block';
                loadAvailableCoupons();
                viewCouponsBtn.textContent = 'Hide Coupons';
            } else {
                couponsWrapper.style.display = 'none';
                viewCouponsBtn.textContent = 'View Coupons';
            }
        });
    }
    
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
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') applyCoupon();
        });
    }
}

const originalLoadCart = loadCart;
loadCart = function() {
    originalLoadCart();
    
    const appliedCode = localStorage.getItem('applied_coupon');
    const couponDiscount = localStorage.getItem('coupon_discount');
    
    if (appliedCode && couponDiscount) {
        showAppliedCoupon(appliedCode, parseFloat(couponDiscount));
        
        const totalMrp = parseFloat(document.getElementById('total-mrp')?.innerText.replace('₹', '') || 0);
        const finalTotal = totalMrp - parseFloat(couponDiscount);
        
        document.getElementById('final-total').innerText = `₹${finalTotal.toFixed(2)}`;
        document.getElementById('bottom-total').innerText = `₹${finalTotal.toFixed(2)}`;
    }
}

function proceedToCheckout() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        showEmptyCartPopup();
        return;
    }
    
    const token = localStorage.getItem('token');
    
    if (!token) {
        sessionStorage.setItem('guest_checkout_cart', JSON.stringify(cart));
        sessionStorage.setItem('redirect_after_login', '/checkout/shipping');
        window.location.href = '/login';
        return;
    }

    window.location.href = '/checkout/shipping';
}

function showEmptyCartPopup() {
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
}

function closeEmptyCartPopup() {
    const popup = document.querySelector('.empty-cart-popup');
    if (popup) {
        popup.remove();
    }
}

function handleLoginSuccess(userData, token) {
    localStorage.setItem('token', token);
    localStorage.setItem('user', JSON.stringify(userData));

    const guestCart = JSON.parse(localStorage.getItem('cart')) || [];
    if (guestCart.length > 0) {
        mergeCartWithUserCart(guestCart);
    }

    const redirect = sessionStorage.getItem('redirect_after_login');
    
    if (redirect) {
        sessionStorage.removeItem('redirect_after_login');
        sessionStorage.removeItem('login_message');
        window.location.href = redirect;
    } else {
        window.location.href = '/';
    }
}
function syncCartWithServer() {
    const token = localStorage.getItem('token');
    if (!token) return;
    
    const localCart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (localCart.length === 0) {
        // Cart empty hai toh server cart bhi empty karo
        fetch('https://retailadmin.ggconsultancy.services/api/cart/clear', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(() => console.log('Server cart cleared'))
        .catch(err => console.warn('Could not clear server cart:', err));
        
        return;
    }
    
    // Server cart ko local cart se sync karo
    const items = localCart.map(item => ({
        product_id: Number(item.id),
        variant_id: Number(item.variantId),
        quantity: Number(item.quantity) || 1
    }));
    
    fetch('https://retailadmin.ggconsultancy.services/api/cart/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ items })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            console.log('Cart synced with server');
            localStorage.setItem('cart_synced', '1');
        }
    })
    .catch(err => console.warn('Could not sync cart:', err));
}
