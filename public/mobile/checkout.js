const API_BASE_URL = window.API_BASE_URL;
let PAYMENT_IN_PROGRESS = false;
let PAYMENT_COMPLETED = false;

document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token || !user.id) {
        sessionStorage.setItem('redirect_after_login', '/checkout/shipping');
        window.location.href = '/user/login';
        return;
    }

    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    if (cartItems.length === 0) {
        alert('Your cart is empty. Please add items to continue.');
        window.location.href = '/';
        return;
    }
    
    syncCartWithServer().then(() => {
        loadCheckoutSummary();
        loadUserAddresses();
    });
});

async function syncCartWithServer() {

    const token = localStorage.getItem('token');
    const localCart = JSON.parse(localStorage.getItem('cart')) || [];

    try {

        const res = await fetch(`${API_BASE_URL}/cart`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();
        const serverItems = data?.data?.items || [];

        for (const item of serverItems) {
            await fetch(`${API_BASE_URL}/cart/remove/${item.id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
        }

        if (localCart.length > 0) {

            const items = localCart.map(item => ({
            product_id: item.id,
            variant_id: item.variantId,
            quantity: item.quantity,
            price: item.price,
            image: item.image || ''
        }))

            await fetch(`${API_BASE_URL}/cart/add`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ items })
            });
        }

        return true;

    } catch (error) {
        console.warn('Cart sync failed', error);
        return true;
    }
}

function loadCheckoutSummary() {
    const summaryContainer = document.getElementById('checkout-summary');
    if (!summaryContainer) return;
    
    summaryContainer.innerHTML = '<div class="loading-spinner">Loading summary...</div>';
    
    let url = `${API_BASE_URL}/checkout/summary`;
    const couponCode = localStorage.getItem('applied_coupon');
    if (couponCode) {
        url += `?coupon_code=${encodeURIComponent(couponCode)}`;
    }
    
    fetch(url, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            renderCheckoutSummary(response.data.cart);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function renderCheckoutSummary(cart) {
    const summaryContainer = document.getElementById('checkout-summary');
    if (!summaryContainer) return;

    const subtotal = parseFloat(cart.subtotal) || 0;
    const tax = parseFloat(cart.tax) || 0;
    const shipping = parseFloat(cart.shipping) || 0;
    const discount = parseFloat(cart.discount) || 0;
    const platformFee = parseFloat(cart.platform_fee) || 0;
    const total = parseFloat(cart.total) || 0;
    const itemsCount = cart.items_count || 0;

    let html = `
        <div class="order-details">
            <h3 class="price-details-title">Price Details (${itemsCount} Items)</h3>

            <div class="detail-row">
                <span>Product Price</span>
                <span>₹${subtotal.toFixed(2)}</span>
            </div>
    `;

    if (discount > 0) {
        html += `
            <div class="detail-row discount">
                <span>Product Discounts</span>
                <span>-₹${discount.toFixed(2)}</span>
            </div>
        `;
    }

    if (tax > 0) {
        html += `
            <div class="detail-row">
                <span>Tax (GST)</span>
                <span>₹${tax.toFixed(2)}</span>
            </div>
        `;
    }

    if (shipping > 0) {
        html += `
            <div class="detail-row">
                <span>Delivery Fee</span>
                <span>₹${shipping.toFixed(2)}</span>
            </div>
        `;
    } else {
        html += `
            <div class="detail-row">
                <span>Delivery Fee</span>
                <span class="free">FREE</span>
            </div>
        `;
    }
    
    if (platformFee > 0) {
        html += `
            <div class="detail-row">
                <span>Platform Fee</span>
                <span>₹${platformFee.toFixed(2)}</span>
            </div>
        `;
    }

    html += `
        <div class="detail-row final-total">
            <span>Final Total</span>
            <span>₹${total.toFixed(2)}</span>
        </div>
    `;

    if (discount > 0) {
        html += `
            <div class="total-savings">
                <span>🎉 Yay! Your total discount is ₹${discount.toFixed(2)}</span>
            </div>
        `;
    }

    summaryContainer.innerHTML = html;
    summaryContainer.dataset.total = total;
}
function loadUserAddresses() {
    const addressContainer = document.getElementById('shipping-addresses');
    if (!addressContainer) return;
    
    addressContainer.innerHTML = '<div class="loading-spinner">Loading addresses...</div>';
    
    fetch(`${API_BASE_URL}/user/addresses`, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            renderAddresses(response.data);
        } else {
            addressContainer.innerHTML = `
                <div class="error-message">
                    <p>Could not load addresses</p>
                    <button onclick="loadUserAddresses()" class="retry-btn">Try Again</button>
                </div>
            `;
        }
    })
    .catch(() => {
        addressContainer.innerHTML = `
            <div class="error-message">
                <p>Network error. Please check your connection.</p>
                <button onclick="loadUserAddresses()" class="retry-btn">Try Again</button>
            </div>
        `;
    });
}

function renderAddresses(responseData) {
    const addressContainer = document.getElementById('shipping-addresses');
    if (!addressContainer) return;
    
    let addresses = [];
    if (responseData && responseData.addresses) {
        addresses = responseData.addresses;
    } else if (Array.isArray(responseData)) {
        addresses = responseData;
    }
    
    const validAddresses = addresses.filter(addr => addr.id && addr.full_name);
    
    if (validAddresses.length === 0) {
        addressContainer.innerHTML = `
            <div class="no-addresses">
                <p>No saved addresses found</p>
                
            </div>
        `;
        return;
    }
    
    let html = '';
    validAddresses.forEach(address => {
        const isDefault = address.is_default === true;
        const defaultClass = isDefault ? 'default' : '';
        
        html += `
            <div class="address-card ${defaultClass}" data-address-id="${address.id}">
                <div class="address-radio" onclick="event.stopPropagation(); selectAddress(${address.id})">
                    <input type="radio" name="shipping_address" value="${address.id}" ${isDefault ? 'checked' : ''}>
                </div>
                <div class="address-details" onclick="selectAddress(${address.id})">
                    <div class="address-name">${escapeHtml(address.full_name) || ''}</div>
                    <div class="address-phone">${escapeHtml(address.phone) || ''}</div>
                    <div class="address-text">
                        ${escapeHtml(address.address_line_1) || ''}${address.address_line_2 ? ', ' + escapeHtml(address.address_line_2) : ''}, 
                        ${escapeHtml(address.city) || ''}, ${escapeHtml(address.state) || ''} - ${escapeHtml(address.postal_code) || ''}
                    </div>
                </div>
                <div class="address-actions" onclick="event.stopPropagation()">
                <button class="remove-address-btn" onclick="showConfirmModal(${address.id})" aria-label="Remove address">                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-linecap="round"/>
                            <line x1="10" y1="11" x2="10" y2="17"/>
                            <line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    });
    
    addressContainer.innerHTML = html;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
async function removeAddress(addressId) {
    const token = localStorage.getItem('token');
    const btn = document.querySelector(`.remove-address-btn[onclick*="${addressId}"]`);
    const originalText = btn ? btn.innerText : 'Remove';
    if (btn) {
        btn.innerText = 'Removing...';
        btn.disabled = true;
    }
    
    try {
        const response = await fetch(`${API_BASE_URL}/user/addresses/${addressId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showToast('Address removed successfully', 'success');
            loadUserAddresses();
        } else {
            showToast(data.message || 'Failed to remove address', 'error');
            if (btn) {
                btn.innerText = originalText;
                btn.disabled = false;
            }
        }
    } catch (error) {
        console.error('Error removing address:', error);
        showToast('Server error, please try again', 'error');
        if (btn) {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    }
}
function showAddAddressForm() {
    document.getElementById('shipping-section').style.display = 'none';
    document.getElementById('add-address-form').style.display = 'block';
}

function hideAddAddressForm() {
    document.getElementById('shipping-section').style.display = 'block';
    document.getElementById('add-address-form').style.display = 'none';
    clearValidationErrors();
}

function clearValidationErrors() {
    document.querySelectorAll('.error-text').forEach(el => el.remove());
    document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
}

function validateAddressForm(formData) {
    let errors = [];
    
    if (!formData.full_name || formData.full_name.trim() === '') {
        errors.push({ field: 'full_name', message: 'Please enter your full name' });
    } else if (formData.full_name.length < 3) {
        errors.push({ field: 'full_name', message: 'Name must be at least 3 characters' });
    }
    
    const phoneRegex = /^[6-9]\d{9}$/;
    if (!formData.phone) {
        errors.push({ field: 'phone', message: 'Please enter your phone number' });
    } else if (!phoneRegex.test(formData.phone)) {
        errors.push({ field: 'phone', message: 'Please enter a valid 10-digit mobile number' });
    }
    
    if (!formData.address_line_1 || formData.address_line_1.trim() === '') {
        errors.push({ field: 'address_line_1', message: 'Please enter your address' });
    }
    
    if (!formData.city || formData.city.trim() === '') {
        errors.push({ field: 'city', message: 'Please enter your city' });
    }
    
    if (!formData.state || formData.state.trim() === '') {
        errors.push({ field: 'state', message: 'Please enter your state' });
    }
    
    const pincodeRegex = /^\d{6}$/;
    if (!formData.postal_code) {
        errors.push({ field: 'postal_code', message: 'Please enter your postal code' });
    } else if (!pincodeRegex.test(formData.postal_code)) {
        errors.push({ field: 'postal_code', message: 'Please enter a valid 6-digit pincode' });
    }
    
    return errors;
}

function showValidationErrors(errors) {
    clearValidationErrors();
    
    errors.forEach(error => {
        const input = document.querySelector(`[name="${error.field}"]`);
        if (input) {
            input.classList.add('input-error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-text';
            errorDiv.textContent = error.message;
            input.parentNode.appendChild(errorDiv);
        }
    });
    
    const firstError = document.querySelector('.input-error');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function saveNewAddress(event) {
    event.preventDefault();
    
    const form = document.getElementById('addressForm');
    const formData = {
        type: 'shipping',
        full_name: form.querySelector('[name="full_name"]').value.trim(),
        phone: form.querySelector('[name="phone"]').value.trim(),
        address_line_1: form.querySelector('[name="address_line_1"]').value.trim(),
        address_line_2: form.querySelector('[name="address_line_2"]').value.trim() || '',
        city: form.querySelector('[name="city"]').value.trim(),
        state: form.querySelector('[name="state"]').value.trim(),
        postal_code: form.querySelector('[name="postal_code"]').value.trim(),
        country: form.querySelector('[name="country"]').value.trim() || 'India',
        is_default: form.querySelector('[name="is_default"]')?.checked || false
    };
    
    const errors = validateAddressForm(formData);
    if (errors.length > 0) {
        showValidationErrors(errors);
        return;
    }
    
    const saveBtn = form.querySelector('button[type="submit"]');
    const originalText = saveBtn.innerText;
    saveBtn.innerText = 'Saving...';
    saveBtn.disabled = true;
    
    fetch(`${API_BASE_URL}/user/addresses`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            form.reset();
            hideAddAddressForm();
            loadUserAddresses();
            showToast('Address added successfully', 'success');
        } else {
            showToast(response.message || 'Could not save address', 'error');
        }
    })
    .catch(() => {
        showToast('Network error. Please try again.', 'error');
    })
    .finally(() => {
        saveBtn.innerText = originalText;
        saveBtn.disabled = false;
    });
}

function selectAddress(addressId) {
    document.querySelectorAll('input[name="shipping_address"]').forEach(radio => {
        if (radio.value == addressId) {
            radio.checked = true;
        }
    });
    
    const token = localStorage.getItem('token');
    
    fetch(`${API_BASE_URL}/user/addresses/${addressId}/set-default`, {
        method: 'PUT',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            loadUserAddresses();
        } else {
            console.error('Set default failed:', data.message);
        }
    })
    .catch(err => {
        console.error('Error setting default:', err);
        // Don't show toast, just log error
    });
}
function placeOrder() {
    const shippingAddress = document.querySelector(
        'input[name="shipping_address"]:checked'
    )?.value;

    if (!shippingAddress) {
        showToast('Please select a delivery address', 'error');
        return;
    }

    const placeOrderBtn = document.querySelector('.place-order-btn');
    if (placeOrderBtn) {
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerText = 'Placing Order...';
    }

    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    fetch(`${API_BASE_URL}/checkout/place-order`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            shipping_address_id: Number(shippingAddress),
            billing_address_id: Number(shippingAddress),
            payment_method_id: 1,
            coupon_code: localStorage.getItem('applied_coupon') || null,
        })
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            const orderData = {
                id: response.data.order.id,
                total: response.data.order.total,
                payment_status: response.data.order.payment_status || 'Paid',
                created_at: new Date().toISOString(),
                items: cartItems.map(item => ({
                    product_name: item.name,
                    price: item.price,
                    quantity: item.quantity,
                    image: item.image,
                    product_id: item.id,
                    variant_id: item.variantId
                }))
            };
            
            const recentOrders = JSON.parse(localStorage.getItem('recent_orders') || '[]');
            recentOrders.unshift(orderData);
            if (recentOrders.length > 10) recentOrders.pop();
            localStorage.setItem('recent_orders', JSON.stringify(recentOrders));
            localStorage.setItem('last_order', JSON.stringify(orderData));
            localStorage.removeItem('cart');
            localStorage.removeItem('cart_synced');
            localStorage.removeItem('applied_coupon');
            localStorage.removeItem('coupon_discount');

            showToast('Order placed successfully', 'success');
            
            setTimeout(() => {
                window.location.replace(`/order-confirmation/${response.data.order.id}`);
            }, 1200);

        } else {
            PAYMENT_IN_PROGRESS = false;
            if (placeOrderBtn) {
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerText = 'PLACE ORDER';
            }
            showToast(response.message || 'Could not place order', 'error');
        }
    })
    .catch(err => {
        PAYMENT_IN_PROGRESS = false;
        if (placeOrderBtn) {
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerText = 'PLACE ORDER';
        }
        showToast('Network error. Please try again.', 'error');
    });
}

function getSelectedPaymentMethod() {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    
    if (paymentRadios.length > 0) {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (!selected) return null;
        return selected.value === 'cod' ? 1 : 2;
    }
    
    return 1;
}

function handleCheckout() {
    if (PAYMENT_IN_PROGRESS || PAYMENT_COMPLETED) {
        showToast('Please wait, your order is being processed', 'info');
        return;
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        showToast('Your cart is empty', 'info');
        return;
    }

    const selectedPaymentMethod = getSelectedPaymentMethod();

    if (selectedPaymentMethod === 1) {
        placeOrder();
    } else if (selectedPaymentMethod === 2) {
        startRazorpayPayment();
    } else {
        showToast('Please select a payment method', 'error');
    }
}

async function startRazorpayPayment() {
    if (PAYMENT_IN_PROGRESS || PAYMENT_COMPLETED) {
        showToast('Please wait, your order is being processed', 'info');
        return;
    }

    const shippingAddress = document.querySelector(
        'input[name="shipping_address"]:checked'
    )?.value;

    if (!shippingAddress) {
        showToast('Please select a delivery address', 'error');
        return;
    }

    PAYMENT_IN_PROGRESS = true;

    fetch(`${API_BASE_URL}/checkout/razorpay/create-order`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            shipping_address_id: Number(shippingAddress),
            billing_address_id: Number(shippingAddress),
            payment_method_id: 2,
            coupon_code: localStorage.getItem('applied_coupon') || null
        })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            PAYMENT_IN_PROGRESS = false;
            throw new Error(data.message || 'Could not start payment');
        }
        openRazorpay(data.data);
    })
    .catch(err => {
        PAYMENT_IN_PROGRESS = false;
        showToast(err.message, 'error');
    });
}

function openRazorpay(data) {
    const options = {
        key: window.RAZORPAY_KEY_ID,
        amount: Math.round(data.amount * 100),
        currency: data.currency,
        order_id: data.razorpay_order_id,
        name: 'RAPID RETAIL',
        description: 'Order Payment',

        handler: function (response) {
            PAYMENT_COMPLETED = true;

            const btn = document.querySelector('.place-order-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerText = 'Processing...';
            }

            verifyRazorpayPayment(response);
        }
    };

    const rzp = new Razorpay(options);
    rzp.open();
}

function verifyRazorpayPayment(response) {
    fetch(`${API_BASE_URL}/checkout/razorpay/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify(response)
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            PAYMENT_COMPLETED = true;

            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            
            const orderData = {
                id: res.data.order_id,
                total: res.data.amount,
                payment_status: 'Paid',
                created_at: new Date().toISOString(),
                items: cartItems.map(item => ({
                    product_name: item.name,
                    price: item.price,
                    quantity: item.quantity,
                    image: item.image,
                    product_id: item.id   
                }))
            };
            
            const recentOrders = JSON.parse(localStorage.getItem('recent_orders') || '[]');
            recentOrders.unshift(orderData);
            if (recentOrders.length > 10) recentOrders.pop();
            localStorage.setItem('recent_orders', JSON.stringify(recentOrders));
            localStorage.setItem('last_order', JSON.stringify(orderData));

            localStorage.removeItem('cart');
            localStorage.removeItem('cart_synced');
            localStorage.removeItem('applied_coupon');
            localStorage.removeItem('coupon_discount');

             window.location.replace(`/order-confirmation/${res.data.order_id}`);
            return;
        }

        PAYMENT_IN_PROGRESS = false;
        showToast(res.message || 'Payment could not be verified', 'error');
    })
    .catch(() => {
        PAYMENT_IN_PROGRESS = false;
        showToast('Network error during verification', 'error');
    });
}

function showToast(message, type) {
    const existingToast = document.querySelector('.toast-message');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = `toast-message ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function applyCoupon() {
    const input = document.getElementById('coupon-code-input');
    const code = input?.value.trim().toUpperCase();
    
    if (!code) {
        showToast('Please enter a coupon code', 'error');
        return;
    }
    
    localStorage.setItem('applied_coupon', code);
    loadCheckoutSummary();
    input.value = '';
}

function removeCoupon() {
    localStorage.removeItem('applied_coupon');
    localStorage.removeItem('coupon_discount');
    loadCheckoutSummary();
    showToast('Coupon removed', 'info');
}
let pendingAddressId = null;

function showConfirmModal(addressId) {
    pendingAddressId = addressId;
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        pendingAddressId = null;
    }
}

function confirmRemoveAddress() {
    if (pendingAddressId) {
        removeAddress(pendingAddressId);
        closeConfirmModal();
    }
}