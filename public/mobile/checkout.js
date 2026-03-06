const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';
let PAYMENT_IN_PROGRESS = false;
let PAYMENT_COMPLETED = false;

async function syncCartWithDatabase(force = false) {
    const token = localStorage.getItem('token');
    if (!token) return false;

    if (!force && localStorage.getItem('cart_synced') === '1') {
        console.log('Cart already synced, skipping');
        return true;
    }

    const localCart = JSON.parse(localStorage.getItem('cart')) || [];
    if (localCart.length === 0) return true;

    const items = [];

    for (const item of localCart) {
        if (!item.variantId) {
            showToast('Please select product size before checkout', 'error');
            return false;
        }

        items.push({
            product_id: Number(item.id),
            variant_id: Number(item.variantId),
            quantity: Number(item.quantity) || 1
        });
    }

    console.log('Syncing items to DB:', items);

    try {
        const response = await fetch(`${API_BASE_URL}/cart/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ items })
        });

        const data = await response.json();
        console.log('Cart sync response:', data);

        if (data.success) {
            localStorage.setItem('cart_synced', '1');
            return true;
        }

        showToast(data.message || 'Could not add to cart. Please try again.', 'error');
        return false;

    } catch (error) {
        console.error('Cart sync error:', error);
        showToast('Network error. Please check your connection.', 'error');
        return false;
    }
}

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

    loadCheckoutSummary();
    loadUserAddresses();
});

function loadCheckoutSummary() {
    const summaryContainer = document.getElementById('checkout-summary');
    if (!summaryContainer) return;
    
    summaryContainer.innerHTML = '<div class="loading-spinner">Loading summary...</div>';
    
    // ✅ LocalStorage se data calculate karo
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    let totalMrp = 0;
    let totalProductDiscount = 0;
    
    cartItems.forEach(item => {
        const mrp = parseFloat(item.mrp) || parseFloat(item.originalPrice) || parseFloat(item.price) || 0;
        const price = parseFloat(item.price) || 0;
        const qty = parseInt(item.quantity) || 1;
        
        totalMrp += mrp * qty;
        totalProductDiscount += (mrp - price) * qty;
    });
    
    const couponDiscount = parseFloat(localStorage.getItem('coupon_discount')) || 0;
    const couponCode = localStorage.getItem('applied_coupon') || '';
    
    console.log('Checkout Summary:', {
        totalMrp,
        totalProductDiscount,
        couponDiscount,
        couponCode
    });
    
    // ✅ Direct localStorage se render karo (API ke bina)
    renderCheckoutSummary({
        cart: {
            subtotal: totalMrp,
            discount: totalProductDiscount,
            coupon_discount: couponDiscount,
            coupon_code: couponCode,
            total: totalMrp - totalProductDiscount - couponDiscount
        }
    });
    
    // API call optional hai - agar chaho to background me kar lo
    fetch(`${API_BASE_URL}/checkout/summary`, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            // Update with API data if needed
        }
    })
    .catch(() => {});
}

function renderFallbackSummary(subtotal) {
    const summaryContainer = document.getElementById('checkout-summary');
    if (!summaryContainer) return;
    
    const couponDiscount = parseFloat(localStorage.getItem('coupon_discount')) || 0;
    const couponCode = localStorage.getItem('applied_coupon') || '';
    
    const deliveryFee = 50;
    const platformFee = 29;
    const total = subtotal - couponDiscount + deliveryFee + platformFee;
    
    let html = `
        <div class="order-details">
            <div class="detail-row">
                <span>Bag total</span>
                <span>₹${subtotal.toFixed(2)}</span>
            </div>
    `;
    
    if (couponDiscount > 0) {
        html += `
            <div class="detail-row coupon-discount">
                <span>Coupon discount (${couponCode})</span>
                <span>-₹${couponDiscount.toFixed(2)}</span>
            </div>
        `;
    }
    
    html += `
        <div class="fee-details">
            <div class="detail-row">
                <span>Convenience Fee</span>
                <span></span>
            </div>
            <div class="detail-row sub-item">
                <span>Delivery Fee</span>
                <span>₹${deliveryFee.toFixed(2)}</span>
            </div>
            <div class="detail-row sub-item">
                <span>Platform Fee</span>
                <span>₹${platformFee.toFixed(2)}</span>
            </div>
        </div>
        <div class="detail-row total">
            <span>Order Total</span>
            <span>₹${total.toFixed(2)}</span>
        </div>
    `;
    
    summaryContainer.innerHTML = html;
}

function renderCheckoutSummary(data) {
    const summaryContainer = document.getElementById('checkout-summary');
    if (!summaryContainer) return;

    const cart = data.cart || {};

    // ✅ LocalStorage se values lo
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    let totalMrp = 0;
    let totalProductDiscount = 0;
    
    cartItems.forEach(item => {
        const mrp = parseFloat(item.mrp) || parseFloat(item.originalPrice) || parseFloat(item.price) || 0;
        const price = parseFloat(item.price) || 0;
        const qty = parseInt(item.quantity) || 1;
        
        totalMrp += mrp * qty;
        totalProductDiscount += (mrp - price) * qty;
    });
    
    const couponDiscount = parseFloat(localStorage.getItem('coupon_discount')) || 0;
    const couponCode = localStorage.getItem('applied_coupon') || '';
    
    // ✅ Calculate final total
    const deliveryFee = 50;
    const platformFee = 29;
    const orderTotal = totalMrp - totalProductDiscount - couponDiscount;
    const finalTotal = orderTotal + deliveryFee + platformFee;

    const itemCount = cartItems.length;

    let html = `
        <div class="order-details">
            <h3 class="price-details-title">Price Details (${itemCount} Items)</h3>

            <div class="detail-row">
                <span>Product Price</span>
                <span>₹${totalMrp.toFixed(2)}</span>
            </div>
    `;

    if (totalProductDiscount > 0) {
        html += `
            <div class="detail-row discount">
                <span>Product Discounts</span>
                <span>-₹${totalProductDiscount.toFixed(2)}</span>
            </div>
        `;
    }

    if (couponDiscount > 0) {
        html += `
            <div class="detail-row coupon-discount">
                <span>Coupon Discount (${couponCode})</span>
                <span>-₹${couponDiscount.toFixed(2)}</span>
            </div>
        `;
    }

    html += `
        <div class="detail-row order-total">
            <span>Order Total</span>
            <span>₹${orderTotal.toFixed(2)}</span>
        </div>
        
        <div class="fee-details">
            <div class="detail-row">
                <span>Delivery Fee</span>
                <span>₹${deliveryFee.toFixed(2)}</span>
            </div>
            <div class="detail-row">
                <span>Platform Fee</span>
                <span>₹${platformFee.toFixed(2)}</span>
            </div>
        </div>
        
        <div class="detail-row final-total">
            <span>Final Total</span>
            <span>₹${finalTotal.toFixed(2)}</span>
        </div>
    `;

    const totalDiscount = totalProductDiscount + couponDiscount;
    if (totalDiscount > 0) {
        html += `
            <div class="total-savings">
                <span>🎉 Yay! Your total discount is ₹${totalDiscount.toFixed(2)}</span>
            </div>
        `;
    }

    summaryContainer.innerHTML = html;
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
                <button onclick="showAddAddressForm()" class="add-address-btn">+ Add New Address</button>
            </div>
        `;
        return;
    }
    
    let html = '';
    validAddresses.forEach(address => {
        const isDefault = address.is_default ? 'default' : '';
        html += `
            <div class="address-card ${isDefault}" onclick="selectAddress(${address.id})">
                <div class="address-radio">
                    <input type="radio" name="shipping_address" value="${address.id}" ${isDefault ? 'checked' : ''}>
                </div>
                <div class="address-details">
                    <div class="address-name">${address.full_name || ''}</div>
                    <div class="address-phone">${address.phone || ''}</div>
                    <div class="address-text">
                        ${address.address_line_1 || ''}${address.address_line_2 ? ', ' + address.address_line_2 : ''}, 
                        ${address.city || ''}, ${address.state || ''} - ${address.postal_code || ''}
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '<button onclick="showAddAddressForm()" class="add-address-btn">+ Add New Address</button>';
    addressContainer.innerHTML = html;
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
}

function placeOrder() {
    const shippingAddress = document.querySelector(
        'input[name="shipping_address"]:checked'
    )?.value;

    if (!shippingAddress) {
        showToast('Please select a delivery address', 'error');
        return;
    }

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
            coupon_code: localStorage.getItem('applied_coupon') || null
        })
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            localStorage.removeItem('cart');
            localStorage.removeItem('cart_synced');
            localStorage.removeItem('applied_coupon');
            localStorage.removeItem('coupon_discount');

            showToast('Order placed successfully', 'success');
            setTimeout(() => {
                window.location.href = `/order-confirmation/${response.data.order.id}`;
            }, 1200);
        } else {
            showToast(response.message || 'Could not place order', 'error');
        }
    })
    .catch(() => showToast('Network error. Please try again.', 'error'));
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

    const synced = await syncCartWithDatabase(true);
    if (!synced) {
        showToast('Could not sync cart. Please try again.', 'error');
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

            localStorage.removeItem('cart');
            localStorage.removeItem('cart_synced');
            localStorage.removeItem('applied_coupon');
            localStorage.removeItem('coupon_discount');

            window.location.href = `/order-confirmation/${res.data.order_id}`;
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