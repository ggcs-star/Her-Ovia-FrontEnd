(() => {
    'use strict';

    const API_BASE_URL = window.API_BASE_URL || '';
    const token = localStorage.getItem('token');
    const orderId = String(window.ORDER_CONFIRMATION_ID || '').trim();

    const CACHE_TTL = 1 * 60 * 1000;
    const cache = new Map();
    const inFlight = new Map();
    let refreshInterval = null;
    let lastRenderedFingerprint = '';

    if (!token) {
        window.location.replace('/user/login');
        return;
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[char]));
    }

    function safeSlug(value) {
        return String(value ?? '')
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function safeImageUrl(value) {
        const raw = String(value ?? '').trim();
        if (!raw) return 'https://via.placeholder.com/88x88?text=Item';

        if (/^https?:\/\//i.test(raw)) return raw;

        if (/^(data|javascript|vbscript|blob):/i.test(raw)) {
            return 'https://via.placeholder.com/88x88?text=Item';
        }

        return `https://her-ovia.s3.us-east-1.amazonaws.com/${raw.replace(/^\/+/, '')}`;
    }

    function formatMoney(amount) {
        const value = Number(amount);
        return `₹${Number.isFinite(value) ? value.toFixed(2) : '0.00'}`;
    }

    function formatLongDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        if (Number.isNaN(d.getTime())) return '';
        return d.toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }

    function formatTime(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        if (Number.isNaN(d.getTime())) return '';
        return d.toLocaleTimeString('en-IN', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function formatShortDateTime(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        if (Number.isNaN(d.getTime())) return '';
        return d.toLocaleString('en-IN', {
            day: 'numeric',
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getCached(key) {
        const entry = cache.get(key);
        if (!entry) return null;
        if (Date.now() - entry.time > CACHE_TTL) {
            cache.delete(key);
            return null;
        }
        return entry.data;
    }

    function setCached(key, data) {
        cache.set(key, { time: Date.now(), data });
        return data;
    }

    async function fetchJsonOnce(url, requestKey, options = {}) {
        if (inFlight.has(requestKey)) return inFlight.get(requestKey);

        const promise = (async () => {
            const controller = new AbortController();
            const timeout = setTimeout(() => controller.abort(), options.timeout || 15000);

            try {
                const headers = {
                    Accept: 'application/json',
                    Authorization: `Bearer ${token}`,
                    'Cache-Control': 'no-cache'
                };

                const response = await fetch(url, {
                    ...options,
                    headers: { ...headers, ...(options.headers || {}) },
                    signal: options.signal || controller.signal,
                    cache: 'no-store'
                });

                let json = null;
                try {
                    json = await response.json();
                } catch {
                    throw new Error('Invalid server response');
                }

                if (!response.ok) {
                    const error = new Error(
                        typeof json?.message === 'string' ? json.message : `Request failed (${response.status})`
                    );
                    error.status = response.status;
                    error.data = json;
                    throw error;
                }

                return json;
            } finally {
                clearTimeout(timeout);
                inFlight.delete(requestKey);
            }
        })();

        inFlight.set(requestKey, promise);
        return promise;
    }

    // ============================================================
    // ORDER STATUS / RENDER
    // ============================================================
    const statusMap = {
        pending: { label: 'Order Placed', icon: '📦', color: '#f59e0b', bg: '#fffbeb' },
        confirmed: { label: 'Confirmed', icon: '✅', color: '#3b82f6', bg: '#eff6ff' },
        processing: { label: 'Processing', icon: '⚙️', color: '#8b5cf6', bg: '#f5f3ff' },
        shipped: { label: 'Shipped', icon: '🚚', color: '#ec489a', bg: '#fdf2f8' },
        delivered: { label: 'Delivered', icon: '📦', color: '#10b981', bg: '#ecfdf5' },
        cancelled: { label: 'Cancelled', icon: '❌', color: '#ef4444', bg: '#fef2f2' }
    };

    const stepsConfig = [
        { key: 'pending', label: 'Order Placed', icon: '📦' },
        { key: 'confirmed', label: 'Confirmed', icon: '✓' },
        { key: 'processing', label: 'Processing', icon: '⚙️' },
        { key: 'shipped', label: 'Shipped', icon: '🚚' },
        { key: 'delivered', label: 'Delivered', icon: '🏠' }
    ];

    function orderFingerprint(order) {
        try {
            return JSON.stringify(order);
        } catch {
            return `${order?.id || ''}:${order?.status || ''}:${order?.updated_at || ''}`;
        }
    }

    function renderOrderDetails(order) {
        const root = document.getElementById('order-root');
        if (!root) return;

        window.currentOrder = order || null;

        if (!order) {
            root.innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Order data unavailable</div>';
            return;
        }

        const fingerprint = orderFingerprint(order);
        if (fingerprint === lastRenderedFingerprint) return;
        lastRenderedFingerprint = fingerprint;

        const statusKey = String(order.status || 'pending').toLowerCase();
        const statusInfo = statusMap[statusKey] || statusMap.pending;
        const isCancelled = statusKey === 'cancelled';

        const subtotal = Math.max(0, Number(order.subtotal) || 0);
        const shipping = Math.max(0, Number(order.shipping) || 0);
        const discount = Math.max(0, Number(order.discount) || 0);
        const platformFee = Math.max(0, Number(order.platform_fee) || 0);
        const tax = Math.max(0, Number(order.tax) || 0);
        const serverTotal = Number(order.total);
        const calculatedTotal = subtotal + shipping + tax + platformFee - discount;
        const total = Number.isFinite(serverTotal) ? Math.max(0, serverTotal) : Math.max(0, calculatedTotal);
        const totalSavings = discount;

        let paymentText = 'Cash on Delivery';
        let paymentIcon = '💵';

        if (String(order.payment_status || '').toLowerCase() === 'paid') {
            paymentText = 'Online Payment';
            paymentIcon = '💳';
        } else if (String(order.payment_method || '').toLowerCase() === 'cod') {
            paymentText = 'Cash on Delivery';
            paymentIcon = '💵';
        }

        const addr = order.shipping_address && typeof order.shipping_address === 'object'
            ? order.shipping_address
            : {};

        const fullName = String(addr.full_name || addr.name || 'Customer');
        const phone = String(addr.phone || '');
        const addressLine1 = String(addr.address_line1 || addr.address_line_1 || '');
        const addressLine2 = String(addr.address_line2 || addr.address_line_2 || '');
        const city = String(addr.city || '');
        const state = String(addr.state || '');
        const pincode = String(addr.pincode || addr.postal_code || '');
        const hasAddress = Boolean(fullName && (addressLine1 || city));

        let trackerHtml = '';

        if (!isCancelled) {
            const currentIdx = stepsConfig.findIndex(step => step.key === statusKey);
            const safeIndex = currentIdx >= 0 ? currentIdx : 0;

            trackerHtml = '<div class="step-list">';

            stepsConfig.forEach((step, idx) => {
                const isCompleted = idx <= safeIndex;
                const isActive = idx === safeIndex;

                let statusDate = '';
                if (step.key === 'pending') statusDate = formatShortDateTime(order.created_at);
                if (step.key === 'confirmed') statusDate = formatShortDateTime(order.confirmed_at);
                if (step.key === 'processing') statusDate = formatShortDateTime(order.processing_at);
                if (step.key === 'shipped') statusDate = formatShortDateTime(order.shipped_at);
                if (step.key === 'delivered') statusDate = formatShortDateTime(order.delivered_at);

                trackerHtml += `
                    <div class="step-item-wrapper">
                        <div class="step-icon-box">
                            <div class="step-dot ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}">
                                ${step.icon}
                            </div>
                            ${idx < stepsConfig.length - 1
                                ? `<div class="step-connector-line ${isCompleted ? 'completed' : ''}"></div>`
                                : ''}
                        </div>
                        <div class="step-content-box">
                            <div class="step-label-text">${escapeHtml(step.label)}</div>
                            ${statusDate ? `<div class="step-date">${escapeHtml(statusDate)}</div>` : ''}
                        </div>
                    </div>
                `;
            });

            trackerHtml += '</div>';
        } else {
            trackerHtml = `
                <div style="text-align:center; padding:20px;">
                    <div style="background:#fef2f2; border-radius:12px; padding:16px; color:#dc2626;">
                        ❌ Order Cancelled
                        ${order.cancelled_at
                            ? `<div style="font-size:12px; margin-top:8px;">on ${escapeHtml(formatShortDateTime(order.cancelled_at))}</div>`
                            : ''}
                    </div>
                </div>
            `;
        }

        const items = Array.isArray(order.items) ? order.items : [];
        let itemsHtml = '';

        if (items.length) {
            items.forEach(item => {
                const imgUrl = safeImageUrl(
                    item?.variant?.image_url ||
                    item?.product?.image_url ||
                    item?.image ||
                    ''
                );

                const variantName = String(item?.variant?.variant?.name || '');
                const variantValue = String(item?.variant?.value?.value || '');
                const variantText = variantName || variantValue
                    ? `${variantName}: ${variantValue}`
                    : '';

                const itemPrice = Math.max(0, Number(item?.price) || 0);
                const qtyValue = Number.parseInt(item?.quantity, 10);
                const qty = Number.isFinite(qtyValue) && qtyValue > 0 ? qtyValue : 1;

                itemsHtml += `
                    <div class="product-item">
                        <img class="product-img"
                             src="${escapeHtml(imgUrl)}"
                             alt="${escapeHtml(item?.product_name || 'Product')}"
                             loading="lazy"
                             decoding="async">
                        <div class="product-info">
                            <div class="product-name">${escapeHtml(item?.product_name || 'Product')}</div>
                            ${variantText ? `<div class="product-variant">${escapeHtml(variantText)}</div>` : ''}
                            <div class="price-quantity">
                                <span class="price-current">${formatMoney(itemPrice)}</span>
                                <span class="quantity-badge">Qty: ${qty}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            itemsHtml = '<div style="text-align:center; padding:28px; color:var(--hero-text-muted);">No items available</div>';
        }

        const priceRows = `
            <div class="price-detail-row"><span>Subtotal</span><span>${formatMoney(subtotal)}</span></div>
            <div class="price-detail-row"><span>Shipping</span><span>${shipping > 0 ? formatMoney(shipping) : 'Free'}</span></div>
            <div class="price-detail-row"><span>Platform Fee</span><span>${formatMoney(platformFee)}</span></div>
            <div class="price-detail-row"><span>Tax (GST)</span><span>${formatMoney(tax)}</span></div>
            ${discount > 0 ? `<div class="price-detail-row" style="color:#10b981;"><span>Discount</span><span>-${formatMoney(discount)}</span></div>` : ''}
            <div class="price-detail-row total"><span>Total Amount</span><span>${formatMoney(total)}</span></div>
        `;

        const couponHtml = order.coupon_code
            ? `<div class="coupon-block"><span style="font-size:18px;">🏷️</span><span style="font-weight:600;">Coupon: ${escapeHtml(order.coupon_code)}</span></div>`
            : '';

        const savingsHtml = totalSavings > 0
            ? `<div style="text-align:center;"><div class="savings-block">💰 You saved ${formatMoney(totalSavings)}</div></div>`
            : '';

        const addressHtml = hasAddress
            ? `
                <div class="address-display">
                    <div style="font-weight:700; margin-bottom:5px;">${escapeHtml(fullName)}</div>
                    ${phone ? `<div style="font-size:12px; color:var(--hero-text-muted); margin-bottom:8px;">📞 ${escapeHtml(phone)}</div>` : ''}
                    <div style="font-size:13px; line-height:1.5; color:var(--hero-text);">
                        ${escapeHtml(addressLine1)}${addressLine2 ? ', ' + escapeHtml(addressLine2) : ''}<br>
                        ${escapeHtml(city)}${state ? ', ' + escapeHtml(state) : ''}${pincode ? ' - ' + escapeHtml(pincode) : ''}
                    </div>
                </div>
            `
            : '';

        const mainColumnHtml = `
            <div class="hero-card">
                <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:10px; margin-bottom:12px;">
                    <div class="order-id">#${escapeHtml(order.order_number || order.id || '')}</div>
                    <div class="payment-badge">${paymentIcon} ${escapeHtml(paymentText)}</div>
                </div>
                <div style="font-size:12px; color:var(--hero-text-muted); margin-bottom:14px;">
                    📅 ${escapeHtml(formatLongDate(order.created_at))} • ${escapeHtml(formatTime(order.created_at))}
                </div>
                <div class="order-total">${formatMoney(total)}</div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">📍</div>
                        <div class="card-title">Order Tracker</div>
                    </div>
                    <div class="status-badge-sm" style="background:${statusInfo.bg}; color:${statusInfo.color};">
                        ${statusInfo.icon} ${escapeHtml(statusInfo.label)}
                    </div>
                </div>
                <div class="card-body">${trackerHtml}</div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">🛍️</div>
                        <div class="card-title">Order Items (${items.length})</div>
                    </div>
                </div>
                <div class="card-body">${itemsHtml}</div>
            </div>
        `;

        const sidebarHtml = `
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">💰</div>
                        <div class="card-title">Payment Summary</div>
                    </div>
                </div>
                <div class="card-body">
                    ${priceRows}
                    ${couponHtml}
                    ${savingsHtml}
                </div>
            </div>

            ${hasAddress ? `
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🏠</div>
                            <div class="card-title">Delivery Address</div>
                        </div>
                    </div>
                    <div class="card-body">${addressHtml}</div>
                </div>
            ` : ''}

            <div class="card" style="border:none; background:transparent; box-shadow:none;">
                <div class="action-buttons-group">
                    <button class="btn btn-primary" id="viewOrdersDesktop">📋 View All Orders</button>
                    <button class="btn btn-secondary" id="continueShopDesktop">✨ Continue Shopping</button>
                </div>
            </div>
        `;

        root.innerHTML = `
            <div class="order-main">${mainColumnHtml}</div>
            <div class="order-sidebar">${sidebarHtml}</div>
        `;

        root.querySelector('#viewOrdersDesktop')?.addEventListener(
            'click',
            () => { window.location.href = '/orders'; }
        );

        root.querySelector('#continueShopDesktop')?.addEventListener(
            'click',
            () => { window.location.href = '/'; }
        );

        root.querySelectorAll('.product-img').forEach(img => {
            img.addEventListener('error', () => {
                if (img.dataset.fallbackApplied === '1') return;
                img.dataset.fallbackApplied = '1';
                img.src = 'https://via.placeholder.com/88x88?text=Product';
            }, { once: true });
        });
    }

    // ============================================================
    // FETCH ORDER
    // ============================================================
    async function fetchOrderData() {
        const root = document.getElementById('order-root');

        if (!root) return;

        if (!orderId) {
            root.innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Invalid Order ID</div>';
            return;
        }

        const url = `${API_BASE_URL}/orders/${encodeURIComponent(orderId)}`;

        try {
            const json = await fetchJsonOnce(url, `order:${orderId}`);

            let order = null;

            if (json?.success && json.data) {
                order = json.data;
            } else {
                throw new Error('Order not found');
            }

            if (order.shipping_address_id && !order.shipping_address) {
                const addressKey = `address:${order.shipping_address_id}`;
                const cachedAddress = getCached(addressKey);

                if (cachedAddress) {
                    order.shipping_address = cachedAddress;
                } else {
                    try {
                        const addressJson = await fetchJsonOnce(
                            `${API_BASE_URL}/user/addresses/${encodeURIComponent(order.shipping_address_id)}`,
                            addressKey
                        );

                        if (addressJson?.success && addressJson.data) {
                            order.shipping_address = setCached(addressKey, addressJson.data);
                        }
                    } catch {
                        // Address is optional for rendering.
                    }
                }
            }

            renderOrderDetails(order);

            try {
                localStorage.setItem('last_order_cached', JSON.stringify(order));
            } catch {
                // Storage can fail in private/restricted browser contexts.
            }
        } catch (error) {
            console.warn('Order fetch failed');

            try {
                const cachedRaw = localStorage.getItem('last_order_cached');
                if (cachedRaw) {
                    const cachedOrder = JSON.parse(cachedRaw);
                    if (cachedOrder?.id == orderId) {
                        renderOrderDetails(cachedOrder);
                        return;
                    }
                }
            } catch {
                // Ignore invalid local cache.
            }

            root.innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Failed to load order. Check connection.</div>';
        }
    }

    function startAutoRefresh() {
        if (refreshInterval) clearInterval(refreshInterval);

        refreshInterval = window.setInterval(() => {
            fetchOrderData();
        }, 5000);
    }

    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    }

    // ============================================================
    // INIT
    // ============================================================
    document.body.classList.add('order-confirmation-page');

    fetchOrderData();
    startAutoRefresh();


    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            fetchOrderData();
            startAutoRefresh();
        }
    });

    window.addEventListener('beforeunload', stopAutoRefresh);

    window.goBack = function goBack() {
        window.location.replace('/orders');
    };

    window.showLoginPopup = window.showLoginPopup || function showLoginPopup() {
        window.location.href = '/user/login';
    };
})();
