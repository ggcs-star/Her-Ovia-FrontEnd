<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>Order Details | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Main Layout - Desktop First with Max Width */
        .order-app {
            min-height: 100vh;
            background: #f1f5f9;
        }

        /* Desktop Centered Container */
        .order-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 32px;
        }

        /* Responsive Grid Layout */
        .order-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        /* Desktop Layout - 2 Columns */
        @media (min-width: 1024px) {
            .order-grid {
                grid-template-columns: 1fr 380px;
                gap: 28px;
                align-items: start;
            }
            
            .order-main {
                grid-column: 1;
            }
            
            .order-sidebar {
                grid-column: 2;
                position: sticky;
                top: 24px;
            }
        }

        /* Tablet Layout */
        @media (min-width: 768px) and (max-width: 1023px) {
            .order-container {
                padding: 20px 24px;
            }
            .order-grid {
                gap: 20px;
            }
        }

        /* Mobile Layout */
        @media (max-width: 767px) {
            .order-container {
                padding: 16px;
            }
            .order-grid {
                gap: 16px;
            }
        }

        /* Card Styles - Universal */
        .card {
            background: white;
            border-radius: 24px;
            border: 1px solid #e9eef3;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        @media (min-width: 1024px) {
            .card {
                border-radius: 28px;
            }
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 640px) {
            .card-header {
                padding: 16px 18px;
            }
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-icon {
            width: 44px;
            height: 44px;
            background: #eff6ff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #2563eb;
        }

        @media (max-width: 640px) {
            .card-icon {
                width: 38px;
                height: 38px;
                font-size: 18px;
            }
        }

        .card-title {
            font-weight: 700;
            font-size: 18px;
            color: #0f172a;
        }

        @media (max-width: 640px) {
            .card-title {
                font-size: 16px;
            }
        }

        .card-body {
            padding: 24px;
        }

        @media (max-width: 640px) {
            .card-body {
                padding: 18px;
            }
        }

        /* Hero Header */
        .hero-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafdff 100%);
            border: 1px solid #e9eef3;
            border-radius: 28px;
            padding: 28px 28px;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .hero-card {
                padding: 20px 20px;
                border-radius: 24px;
            }
        }

        @media (max-width: 480px) {
            .hero-card {
                padding: 18px 16px;
            }
        }

        .order-id {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        @media (max-width: 640px) {
            .order-id {
                font-size: 18px;
            }
        }

        .payment-badge {
            background: #f8fafc;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            color: #334155;
        }

        .order-total {
            font-size: 42px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -1px;
        }

        @media (max-width: 768px) {
            .order-total {
                font-size: 36px;
            }
        }

        @media (max-width: 480px) {
            .order-total {
                font-size: 32px;
            }
        }

        /* Tracker Steps */
        .step-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .step-item-wrapper {
            display: flex;
            position: relative;
        }

        .step-icon-box {
            width: 48px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-dot {
            width: 36px;
            height: 36px;
            border-radius: 36px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            z-index: 2;
        }

        @media (max-width: 640px) {
            .step-dot {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
            .step-icon-box {
                width: 44px;
            }
        }

        .step-dot.completed {
            background: #10b981;
            color: white;
        }

        .step-dot.active {
            background: #2563eb;
            color: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .step-connector-line {
            width: 2px;
            background: #e2e8f0;
            flex: 1;
            margin: 4px 0;
            min-height: 32px;
        }

        .step-content-box {
            flex: 1;
            padding-bottom: 24px;
            padding-left: 12px;
        }

        .step-label-text {
            font-weight: 700;
            font-size: 15px;
            color: #0f172a;
        }

        .step-date {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Items */
        .product-item {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #fafcff;
            border-radius: 20px;
            margin-bottom: 12px;
            border: 1px solid #eff3f8;
        }

        @media (max-width: 560px) {
            .product-item {
                gap: 12px;
                padding: 12px;
            }
        }

        .product-img {
            width: 88px;
            height: 88px;
            border-radius: 16px;
            object-fit: cover;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        @media (max-width: 560px) {
            .product-img {
                width: 72px;
                height: 72px;
            }
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 700;
            font-size: 15px;
            line-height: 1.4;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .product-variant {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .price-quantity {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 16px;
            margin-top: 6px;
        }

        .price-current {
            font-weight: 800;
            font-size: 18px;
            color: #2563eb;
        }

        .quantity-badge {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Price Rows */
        .price-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .price-detail-row {
                padding: 10px 0;
                font-size: 13px;
            }
        }

        .price-detail-row.total {
            border-top: 2px solid #eef2f8;
            border-bottom: none;
            margin-top: 8px;
            padding-top: 16px;
            font-weight: 800;
            font-size: 18px;
        }

        /* Address */
        .address-display {
            background: #fafcff;
            border-radius: 20px;
            padding: 18px;
            border: 1px solid #eff3f8;
        }

        /* Action Buttons */
        .action-buttons-group {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        @media (max-width: 640px) {
            .btn {
                padding: 12px 16px;
                font-size: 13px;
            }
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-secondary {
            background: white;
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        @media (max-width: 560px) {
            .action-buttons-group {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
            }
        }

        /* Status Badge */
        .status-badge-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Coupon & Savings */
        .coupon-block {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 16px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
        }

        .savings-block {
            background: #e6f7ec;
            border-radius: 40px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 13px;
            color: #0a6b3f;
            margin-top: 16px;
        }

        /* Loading & Error */
        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .spinner {
            width: 48px;
            height: 48px;
            border: 3px solid #e2e8f0;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-box {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 28px;
        }

        /* Desktop fine-tuning */
        @media (min-width: 1280px) {
            .order-container {
                padding: 32px 40px;
            }
        }
    </style>
</head>
<body>
    <div class="order-app">
        <div class="order-container">
            <div id="order-root" class="order-grid">
                <div class="loader-container" style="grid-column:1/-1">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ======================== CONFIGURATION ========================
        const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';
        const token = localStorage.getItem('token');
        const orderId = '{{ $orderId }}';

        if (!token) {
            window.location.href = '/user/login';
        }

        // Utility functions
        function formatMoney(amount) {
            return `₹${Number(amount || 0).toFixed(2)}`;
        }

        function formatLongDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        function formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
        }

        function formatShortDateTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleString('en-IN', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
        }

        const statusMap = {
            pending: { label: 'Order Placed', icon: '⏳', color: '#f59e0b', bg: '#fffbeb' },
            confirmed: { label: 'Confirmed', icon: '✅', color: '#3b82f6', bg: '#eff6ff' },
            processing: { label: 'Processing', icon: '⚙️', color: '#8b5cf6', bg: '#f5f3ff' },
            shipped: { label: 'Shipped', icon: '🚚', color: '#ec489a', bg: '#fdf2f8' },
            delivered: { label: 'Delivered', icon: '📦', color: '#10b981', bg: '#ecfdf5' },
            cancelled: { label: 'Cancelled', icon: '❌', color: '#ef4444', bg: '#fef2f2' }
        };

        const stepsConfig = [
            { key: 'pending', label: 'Order Placed', icon: '📦', timeKey: 'created_at' },
            { key: 'confirmed', label: 'Confirmed', icon: '✅', timeKey: 'confirmed_at' },
            { key: 'processing', label: 'Processing', icon: '⚙️', timeKey: 'processing_at' },
            { key: 'shipped', label: 'Shipped', icon: '🚚', timeKey: 'shipped_at' },
            { key: 'delivered', label: 'Delivered', icon: '🏠', timeKey: 'delivered_at' }
        ];

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Render with Desktop + Mobile Grid (2 columns on desktop)
        function renderOrderDetails(order) {
            if (!order) {
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Order data unavailable</div>';
                return;
            }

            const statusKey = order.status || 'pending';
            const statusInfo = statusMap[statusKey] || statusMap.pending;
            const isCancelled = statusKey === 'cancelled';

            // Financials
            const subtotal = parseFloat(order.subtotal) || 0;
            const shipping = parseFloat(order.shipping) || 0;
            const discount = parseFloat(order.discount) || 0;
            const platformFee = parseFloat(order.platform_fee) || 0;
            const tax = parseFloat(order.tax) || 0;
            const total = parseFloat(order.total) || (subtotal + shipping + tax + platformFee - discount);
            const totalSavings = discount;

            // Payment
            const paymentMethod = order.payment_method || 'cod';
            const paymentText = paymentMethod === 'cod' ? 'Cash on Delivery' : (paymentMethod === 'online' ? 'Online Payment' : 'Digital Payment');
            const paymentIcon = paymentMethod === 'cod' ? '💵' : '💳';

            // Address
            const addr = order.shipping_address || {};
            const fullName = addr.full_name || addr.name || 'Customer';
            const phone = addr.phone || '';
            const addressLine1 = addr.address_line1 || addr.address_line_1 || '';
            const addressLine2 = addr.address_line2 || addr.address_line_2 || '';
            const city = addr.city || '';
            const state = addr.state || '';
            const pincode = addr.pincode || addr.postal_code || '';
            const hasAddress = fullName && (addressLine1 || city);

            // Build Tracker Steps
            let trackerHtml = '';
            if (!isCancelled) {
                const currentIdx = stepsConfig.findIndex(s => s.key === statusKey);
                trackerHtml = `<div class="step-list">`;
                stepsConfig.forEach((step, idx) => {
                    const isCompleted = idx <= currentIdx;
                    const isActive = idx === currentIdx;
                    let stepTime = '';
                    if (step.timeKey && order[step.timeKey]) {
                        stepTime = formatShortDateTime(order[step.timeKey]);
                    } else if (step.key === 'pending' && order.created_at) {
                        stepTime = formatShortDateTime(order.created_at);
                    }

                    trackerHtml += `
                        <div class="step-item-wrapper">
                            <div class="step-icon-box">
                                <div class="step-dot ${isCompleted ? 'completed' : (isActive ? 'active' : '')}">
                                    ${step.icon}
                                </div>
                                ${idx < stepsConfig.length - 1 ? `<div class="step-connector-line"></div>` : ''}
                            </div>
                            <div class="step-content-box">
                                <div class="step-label-text">${step.label}</div>
                                ${stepTime ? `<div class="step-date">🕒 ${stepTime}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
                trackerHtml += `</div>`;
            } else {
                const cancelTime = order.cancelled_at ? formatShortDateTime(order.cancelled_at) : '';
                trackerHtml = `
                    <div class="step-item-wrapper">
                        <div class="step-icon-box">
                            <div class="step-dot" style="background:#ef4444; color:white;">❌</div>
                        </div>
                        <div class="step-content-box">
                            <div class="step-label-text">Order Cancelled</div>
                            ${cancelTime ? `<div class="step-date">📅 ${cancelTime}</div>` : ''}
                        </div>
                    </div>
                `;
            }

            // Items HTML
            let itemsHtml = '';
            if (order.items && order.items.length) {
                order.items.forEach(item => {
                    let imgUrl = item.image || '';
                    if (imgUrl && !imgUrl.startsWith('http')) {
                        imgUrl = `https://inventorydata-s3-bucket.s3.amazonaws.com/${imgUrl}`;
                    }
                    const variantText = item.variant ? 
                        `${item.variant.variant?.name || ''}: ${item.variant.value?.value || ''}` : '';
                    const itemPrice = parseFloat(item.price) || 0;
                    const qty = parseInt(item.quantity) || 1;

                    itemsHtml += `
                        <div class="product-item">
                            <img class="product-img" src="${imgUrl || 'https://via.placeholder.com/88x88?text=Item'}" 
                                 onerror="this.src='https://via.placeholder.com/88x88?text=Product'">
                            <div class="product-info">
                                <div class="product-name">${escapeHtml(item.product_name || 'Product')}</div>
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
                itemsHtml = `<div style="text-align:center; padding:32px; color:#64748b;">No items available</div>`;
            }

            // Price breakdown
            const priceRows = `
                <div class="price-detail-row"><span>Subtotal</span><span>${formatMoney(subtotal)}</span></div>
                <div class="price-detail-row"><span>Shipping</span><span>${shipping > 0 ? formatMoney(shipping) : 'Free'}</span></div>
                <div class="price-detail-row"><span>Platform Fee</span><span>${formatMoney(platformFee)}</span></div>
                <div class="price-detail-row"><span>Tax (GST)</span><span>${formatMoney(tax)}</span></div>
                ${discount > 0 ? `<div class="price-detail-row" style="color:#10b981;"><span>Discount</span><span>-${formatMoney(discount)}</span></div>` : ''}
                <div class="price-detail-row total"><span>Total Amount</span><span style="color:#2563eb;">${formatMoney(total)}</span></div>
            `;

            const couponHtml = order.coupon_code ? `
                <div class="coupon-block">
                    <span style="font-size:20px;">🏷️</span>
                    <span style="font-weight:600;">Coupon: ${escapeHtml(order.coupon_code)}</span>
                </div>
            ` : '';

            const savingsHtml = totalSavings > 0 ? `
                <div style="text-align:center;">
                    <div class="savings-block">💰 You saved ${formatMoney(totalSavings)}</div>
                </div>
            ` : '';

            const addressHtml = hasAddress ? `
                <div class="address-display">
                    <div style="font-weight:700; margin-bottom:6px;">${escapeHtml(fullName)}</div>
                    ${phone ? `<div style="font-size:13px; color:#5e6f8d; margin-bottom:10px;">📞 ${escapeHtml(phone)}</div>` : ''}
                    <div style="font-size:14px; line-height:1.5; color:#334155;">
                        ${escapeHtml(addressLine1)}${addressLine2 ? ', ' + escapeHtml(addressLine2) : ''}<br>
                        ${escapeHtml(city)}${state ? ', ' + escapeHtml(state) : ''} ${pincode ? ' - ' + escapeHtml(pincode) : ''}
                    </div>
                </div>
            ` : '';

            // MAIN LEFT COLUMN (Order Main)
            const mainColumnHtml = `
                <!-- Hero Card -->
                <div class="hero-card" style="margin-bottom:0;">
                    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:14px;">
                        <div class="order-id">#${order.order_number || order.id}</div>
                        <div class="payment-badge">${paymentIcon} ${paymentText}</div>
                    </div>
                    <div style="font-size:13px; color:#64748b; margin-bottom:18px;">📅 ${formatLongDate(order.created_at)} • ${formatTime(order.created_at)}</div>
                    <div class="order-total">${formatMoney(total)}</div>
                </div>

                <!-- Tracker Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">📍</div>
                            <div class="card-title">Order Tracker</div>
                        </div>
                        <div class="status-badge-sm" style="background:${statusInfo.bg}; color:${statusInfo.color};">
                            ${statusInfo.icon} ${statusInfo.label}
                        </div>
                    </div>
                    <div class="card-body">
                        ${trackerHtml}
                    </div>
                </div>

                <!-- Items Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🛍️</div>
                            <div class="card-title">Order Items (${order.items?.length || 0})</div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${itemsHtml}
                    </div>
                </div>
            `;

            // RIGHT SIDEBAR (Payment + Address + Actions)
            const sidebarHtml = `
                <!-- Payment Details -->
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
                <!-- Shipping Address -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🏠</div>
                            <div class="card-title">Delivery Address</div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${addressHtml}
                    </div>
                </div>
                ` : ''}

                <!-- Action Buttons -->
                <div class="card" style="border: none; background: transparent; box-shadow: none;">
                    <div class="action-buttons-group">
                        <button class="btn btn-primary" id="viewOrdersDesktop">📋 View All Orders</button>
                        <button class="btn btn-secondary" id="continueShopDesktop">✨ Continue Shopping</button>
                    </div>
                </div>
            `;

            // Combine into Grid
            const finalGrid = `
                <div class="order-main">${mainColumnHtml}</div>
                <div class="order-sidebar">${sidebarHtml}</div>
            `;

            document.getElementById('order-root').innerHTML = finalGrid;

            // Bind events
            document.getElementById('viewOrdersDesktop')?.addEventListener('click', () => window.location.href = '/orders');
            document.getElementById('continueShopDesktop')?.addEventListener('click', () => window.location.href = '/');
        }

        // Fetch order with address enrichment
        async function fetchOrderData() {
            if (!orderId || orderId === '') {
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Invalid Order ID</div>';
                return;
            }

            try {
                const res = await fetch(`${API_BASE_URL}/orders/${orderId}`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const json = await res.json();
                let order = null;

                if (json.success && json.data) {
                    order = json.data;
                } else {
                    const lastRaw = localStorage.getItem('last_order');
                    if (lastRaw) {
                        const last = JSON.parse(lastRaw);
                        if (last.id == orderId) order = last;
                    }
                    if (!order) throw new Error('Order not found');
                }

                // Fetch address if needed
                if (order.shipping_address_id && !order.shipping_address) {
                    try {
                        const addrRes = await fetch(`${API_BASE_URL}/user/addresses/${order.shipping_address_id}`, {
                            headers: { 'Authorization': `Bearer ${token}` }
                        });
                        const addrJson = await addrRes.json();
                        if (addrJson.success && addrJson.data) {
                            order.shipping_address = addrJson.data;
                        }
                    } catch(e) { console.warn('Address fetch failed'); }
                }

                renderOrderDetails(order);
                localStorage.setItem('last_order_cached', JSON.stringify(order));
            } catch (err) {
                console.error(err);
                const cached = localStorage.getItem('last_order_cached');
                if (cached) {
                    try {
                        const cachedOrder = JSON.parse(cached);
                        if (cachedOrder.id == orderId) {
                            renderOrderDetails(cachedOrder);
                            return;
                        }
                    } catch(e) {}
                }
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Failed to load order. Check connection.</div>';
            }
        }

        // Auto refresh
        let refreshInterval;
        function startAutoRefresh() {
            if (refreshInterval) clearInterval(refreshInterval);
            refreshInterval = setInterval(() => fetchOrderData(), 12000);
        }

        fetchOrderData();
        startAutoRefresh();
    </script>
</body>
</html>