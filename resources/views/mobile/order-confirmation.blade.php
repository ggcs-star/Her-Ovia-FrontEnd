<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Order Details | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .order-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 100vh;
            padding: 0 20px 30px;
        }

        .order-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px 0 30px;
        }

        .order-header-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 28px;
            padding: 28px 24px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 30px -10px rgba(0,0,0,0.3);
        }

        .order-header-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .order-header-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
        }

        .order-id-large {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .order-date-large {
            font-size: 15px;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
        }

        .order-total-large {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .payment-method-tag {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .tracker-card {
            background: white;
            border-radius: 28px;
            padding: 28px 24px;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
        }

        .tracker-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tracker-title span {
            width: 32px;
            height: 32px;
            background: #ff3f6c;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .tracker-steps {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tracker-step {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 8px 0;
        }

        .tracker-step-icon {
            width: 44px;
            height: 44px;
            background: #f8fafc;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #64748b;
            flex-shrink: 0;
        }

        .tracker-step.completed .tracker-step-icon {
            background: #10b981;
            color: white;
        }

        .tracker-step.active .tracker-step-icon {
            background: #ff3f6c;
            color: white;
            box-shadow: 0 8px 15px -5px rgba(255,63,108,0.4);
        }

        .tracker-step-content {
            flex: 1;
            padding-top: 4px;
        }

        .tracker-step-label {
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .tracker-step-time {
            font-size: 13px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tracker-connector {
            margin-left: 22px;
            width: 2px;
            height: 30px;
            background: #e2e8f0;
        }

        .items-card {
            background: white;
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: #fff1f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ff3f6c;
        }

        .section-title {
            font-weight: 700;
            font-size: 18px;
            color: #0f172a;
        }

        .item-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .item-card {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 20px;
        }

        .item-image {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            object-fit: cover;
            background: white;
            border: 1px solid #f1f5f9;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .item-variant {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .item-pricing {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .item-price {
            font-weight: 700;
            font-size: 18px;
            color: #ff3f6c;
        }

        .item-quantity {
            color: #64748b;
            font-size: 14px;
            background: white;
            padding: 4px 12px;
            border-radius: 30px;
        }

        .price-card {
            background: #f8fafc;
            border-radius: 28px;
            padding: 24px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            font-size: 15px;
        }

        .price-row:not(:last-child) {
            border-bottom: 1px dashed #e2e8f0;
        }

        .price-label {
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .price-value {
            font-weight: 600;
            color: #0f172a;
        }

        .price-total {
            font-weight: 800;
            font-size: 20px;
            color: #ff3f6c;
            padding-top: 8px;
            margin-top: 8px;
            border-top: 2px solid #e2e8f0;
        }

        .savings-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 20px;
            border-radius: 40px;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            box-shadow: 0 10px 20px -10px #10b981;
        }

        .address-card {
            background: white;
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
        }

        .address-box {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f1f5f9;
        }

        .address-recipient {
            font-weight: 700;
            font-size: 18px;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .address-phone {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .address-full {
            font-size: 15px;
            line-height: 1.7;
            color: #334155;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 18px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #ff3f6c;
            color: white;
            box-shadow: 0 15px 25px -10px #ff3f6c;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 30px -10px #ff3f6c;
        }

        .btn-secondary {
            background: white;
            color: #0f172a;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .loading-pulse {
            text-align: center;
            padding: 60px 0;
        }

        .loading-pulse::after {
            content: '';
            display: block;
            width: 44px;
            height: 44px;
            margin: 0 auto;
            border: 4px solid #f1f5f9;
            border-top-color: #ff3f6c;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-state {
            text-align: center;
            padding: 60px 20px;
            color: #ef4444;
            font-size: 16px;
            background: #fef2f2;
            border-radius: 28px;
            font-weight: 500;
        }

        .coupon-badge {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 40px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #0369a1;
        }
        /* Responsive buttons */
        @media (max-width: 480px) {
            .action-buttons {
                flex-direction: column;
                gap: 10px;
                margin-bottom: 80px;
            }
            
            .action-btn {
                width: 100%;
            }
        }
    </style>
</head>
    
   <body class="order-confirmation-page">
    <header class="site-header" id="site-header"></header>
    
    <div class="order-container">
        <div id="order-content" class="order-content"></div>
    </div>
    
    <footer class="site-footer" id="site-footer"></footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

    <script src="{{ asset('mobile/script.js') }}"></script>
    <script>
        const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';
        const token = localStorage.getItem('token');
        const orderId = '{{ $orderId }}';

        if (!token) {
            window.location.href = '/user/login';
        }

        document.getElementById('order-content').innerHTML = '<div class="loading-pulse"></div>';

        fetch(`${API_BASE_URL}/orders/${orderId}`, {
            headers: { 
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.data) {
                const order = res.data;
                
                if (order.shipping_address_id) {
                    fetch(`https://retailadmin.ggconsultancy.services/api/user/addresses/${order.shipping_address_id}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(addrRes => addrRes.json())
                    .then(addrData => {
                        if (addrData.success) {
                            order.shipping_address = addrData.data;
                        }
                        renderOrderDetails(order);
                    })
                    .catch(() => {
                        renderOrderDetails(order);
                    });
                } else {
                    renderOrderDetails(order);
                }
            } else {
                const lastOrder = JSON.parse(localStorage.getItem('last_order') || '{}');
                if (lastOrder.id == orderId) {
                    renderOrderDetails(lastOrder);
                } else {
                    document.getElementById('order-content').innerHTML = '<div class="error-state">⚠️ Order not found</div>';
                }
            }
        })
        .catch(err => {
            console.error('Error:', err);
            const lastOrder = JSON.parse(localStorage.getItem('last_order') || '{}');
            if (lastOrder.id == orderId) {
                renderOrderDetails(lastOrder);
            } else {
                document.getElementById('order-content').innerHTML = '<div class="error-state">⚠️ Network error</div>';
            }
        });
        setInterval(() => {
    fetch(`${API_BASE_URL}/orders/${orderId}`, {
        headers: { 
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success && res.data) {
            renderOrderDetails(res.data);
        }
    })
    .catch(err => console.error('Auto-refresh error:', err));
}, 10000);

        function renderOrderDetails(order) {
            const statusMap = {
                'pending': 'Order Placed',
                'confirmed': 'Confirmed',
                'processing': 'Processing',
                'shipped': 'Shipped',
                'delivered': 'Delivered',
                'cancelled': 'Cancelled'
            };

            const statusIcons = {
                'pending': '⏳',
                'confirmed': '✅',
                'processing': '⚙️',
                'shipped': '🚚',
                'delivered': '📦',
                'cancelled': '❌'
            };

            const statusColor = {
                'pending': '#f97316',
                'confirmed': '#3b82f6',
                'processing': '#8b5cf6',
                'shipped': '#ec4899',
                'delivered': '#10b981',
                'cancelled': '#ef4444'
            };

            const orderDate = new Date(order.created_at).toLocaleDateString('en-IN', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            const orderTime = new Date(order.created_at).toLocaleTimeString('en-IN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            let fullName = order.shipping_address?.full_name || order.shipping_address?.name || 'Customer';
            let phone = order.shipping_address?.phone || '';
            let addressLine1 = order.shipping_address?.address_line1 || order.shipping_address?.address_line_1 || '';
            let addressLine2 = order.shipping_address?.address_line2 || order.shipping_address?.address_line_2 || '';
            let city = order.shipping_address?.city || '';
            let state = order.shipping_address?.state || '';
            let pincode = order.shipping_address?.pincode || order.shipping_address?.postal_code || '';

            const steps = [
                { key: 'pending', label: 'Order Placed', icon: '📝', time: order.created_at },
                { key: 'confirmed', label: 'Confirmed', icon: '✅', time: order.confirmed_at },
                { key: 'processing', label: 'Processing', icon: '⚙️', time: order.processing_at },
                { key: 'shipped', label: 'Shipped', icon: '🚚', time: order.shipped_at },
                { key: 'delivered', label: 'Delivered', icon: '📦', time: order.delivered_at }
            ];

            const currentStatusIndex = steps.findIndex(s => s.key === order.status);
            
            let stepsHtml = '';
            steps.forEach((step, index) => {
                const isCompleted = index <= currentStatusIndex && order.status !== 'cancelled';
                const isActive = index === currentStatusIndex && order.status !== 'cancelled';
                const stepTime = step.time ? new Date(step.time).toLocaleString('en-IN', {
                    hour: '2-digit',
                    minute: '2-digit',
                    day: 'numeric',
                    month: 'short'
                }) : '';

                stepsHtml += `
                    <div style="display: flex; align-items: flex-start; gap: 12px; position: relative; padding: 8px 0;">
                        ${index < steps.length - 1 && order.status !== 'cancelled' ? `
                            <div style="position: absolute; left: 15px; top: 35px; width: 2px; height: 35px; background: ${isCompleted ? '#10b981' : '#e2e8f0'};"></div>
                        ` : ''}
                        
                        <div style="width: 32px; height: 32px; border-radius: 32px; background: ${isCompleted ? '#10b981' : isActive ? '#ff3f6c' : '#f1f5f9'}; display: flex; align-items: center; justify-content: center; color: ${isCompleted || isActive ? 'white' : '#94a3b8'}; font-size: 14px; z-index: 1;">
                            ${step.icon}
                        </div>
                        
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 15px; color: #0f172a;">${step.label}</div>
                            ${stepTime ? `<div style="font-size: 12px; color: #64748b; margin-top: 2px;">${stepTime}</div>` : ''}
                        </div>
                    </div>
                `;
            });

            if (order.status === 'cancelled') {
                stepsHtml = `
                    <div style="display: flex; align-items: flex-start; gap: 12px; padding: 8px 0;">
                        <div style="width: 32px; height: 32px; border-radius: 32px; background: #ef4444; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; z-index: 1;">❌</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 15px; color: #0f172a;">Cancelled</div>
                            ${order.cancelled_at ? `<div style="font-size: 12px; color: #64748b; margin-top: 2px;">📅 ${new Date(order.cancelled_at).toLocaleString('en-IN', { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short' })}</div>` : ''}
                        </div>
                    </div>
                `;
            }

            const itemsHtml = order.items?.map(item => {
                let img = item.image || '';
                if (img && !img.startsWith('http')) {
                    img = `https://inventorydata-s3-bucket.s3.amazonaws.com/${img}`;
                }
                
                const variantText = item.variant ? 
                    `${item.variant.variant?.name || ''}: ${item.variant.value?.value || ''}` : '';
                
                return `
                    <div style="display: flex; gap: 16px; padding: 16px; background: #f8fafc; border-radius: 16px; margin-bottom: 12px;">
                        <img src="${img || 'https://via.placeholder.com/80'}" 
                             style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; background: white; border: 1px solid #f1f5f9;"
                             onerror="this.src='https://via.placeholder.com/80'">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 16px; color: #0f172a; margin-bottom: 4px;">${item.product_name || 'Product'}</div>
                            ${variantText ? `<div style="font-size: 14px; color: #64748b; margin-bottom: 8px;">${variantText}</div>` : ''}
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-weight: 700; font-size: 18px; color: #ff3f6c;">₹${parseFloat(item.price || 0).toFixed(2)}</span>
                                <span style="color: #64748b; font-size: 14px; background: white; padding: 4px 12px; border-radius: 20px; border: 1px solid #f1f5f9;">Qty: ${item.quantity || 1}</span>
                            </div>
                        </div>
                    </div>
                `;
            }).join('') || '<div style="padding: 20px; text-align: center; color: #64748b;">No items found</div>';

            const subtotal = parseFloat(order.subtotal || 0);
            const shipping = parseFloat(order.shipping || 0);
            const discount = parseFloat(order.discount || 0);
            const platformFee = parseFloat(order.platform_fee || 0);
            const tax = parseFloat(order.tax || 0);
            const total = parseFloat(order.total || 0);
            const totalSavings = discount;

            const paymentMethod = order.payment_method || 'cod';
            const paymentMethodText = paymentMethod === 'cod' ? 'Cash on Delivery' : 'Online Payment';
            const paymentIcon = paymentMethod === 'cod' ? '💵' : '💳';

            const html = `
                <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 24px; padding: 24px; color: white; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <div style="font-size: 16px; font-weight: 600; letter-spacing: 0.5px;">#${order.order_number || order.id}</div>
                        <div style="background: rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 40px; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                            <span>${paymentIcon}</span> ${paymentMethodText}
                        </div>
                    </div>
                    
                    <div style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <span>📅</span> ${orderDate} • ${orderTime}
                    </div>
                    
                    <div style="font-size: 36px; font-weight: 700; margin-bottom: 4px; letter-spacing: -1px;">
                        ₹${total.toFixed(2)}
                    </div>
                </div>

                <div style="background: white; border-radius: 24px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <div style="font-weight: 600; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #ff3f6c; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">📍</span>
                            Order Tracker
                        </div>
                        <div style="background: ${statusColor[order.status]}20; color: ${statusColor[order.status]}; padding: 6px 14px; border-radius: 30px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            ${statusIcons[order.status]} ${statusMap[order.status] || order.status}
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column;">
                        ${stepsHtml}
                    </div>
                </div>

                <div style="background: white; border-radius: 24px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #fff1f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #ff3f6c;">🛍️</div>
                        <div style="font-weight: 700; font-size: 18px; color: #0f172a;">Items (${order.items?.length || 0})</div>
                    </div>
                    <div>
                        ${itemsHtml}
                    </div>
                </div>

                <div style="background: white; border-radius: 24px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #fff1f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #ff3f6c;">💰</div>
                        <div style="font-weight: 700; font-size: 18px; color: #0f172a;">Payment Details</div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <span style="color: #64748b;">Subtotal</span>
                            <span style="font-weight: 600; color: #0f172a;">₹${subtotal.toFixed(2)}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <span style="color: #64748b;">Shipping</span>
                            <span style="font-weight: 600; color: #0f172a;">${shipping > 0 ? '₹' + shipping.toFixed(2) : 'Free'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <span style="color: #64748b;">Platform Fee</span>
                            <span style="font-weight: 600; color: #0f172a;">₹${platformFee.toFixed(2)}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <span style="color: #64748b;">Tax (GST)</span>
                            <span style="font-weight: 600; color: #0f172a;">₹${tax.toFixed(2)}</span>
                        </div>
                        ${discount > 0 ? `
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9; color: #10b981;">
                            <span>Discount</span>
                            <span style="font-weight: 600;">-₹${discount.toFixed(2)}</span>
                        </div>
                        ` : ''}
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; margin-top: 4px; border-top: 2px solid #1e293b;">
                            <span style="font-weight: 700; color: #0f172a;">Total Amount</span>
                            <span style="font-weight: 800; font-size: 20px; color: #ff3f6c;">₹${total.toFixed(2)}</span>
                        </div>
                    </div>
                    
                    ${totalSavings > 0 ? `
                    <div style="text-align: center; margin-top: 20px;">
                        <span style="background: #10b981; color: white; padding: 10px 18px; border-radius: 40px; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <span>💰</span> You saved ₹${totalSavings.toFixed(2)}
                        </span>
                    </div>
                    ` : ''}
                </div>

              

                ${order.coupon_code ? `
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 16px; padding: 16px; display: flex; align-items: center; gap: 12px; color: #0369a1; margin-bottom: 16px;">
                    <span style="font-size: 22px;">🏷️</span>
                    <span style="font-weight: 600;">Coupon Applied: ${order.coupon_code}</span>
                </div>
                ` : ''}

                <div style="display: flex; gap: 12px; margin: 20px 0 30px;">
                    <button onclick="window.location.href='/orders'" 
                            style="flex: 1; padding: 16px; border-radius: 40px; font-weight: 700; font-size: 16px; text-align: center; cursor: pointer; border: none; background: #ff3f6c; color: white; box-shadow: 0 8px 20px -5px #ff3f6c;">
                        View All Orders
                    </button>
                    <button onclick="window.location.href='/'" 
                            style="flex: 1; padding: 16px; border-radius: 40px; font-weight: 700; font-size: 16px; text-align: center; cursor: pointer; border: 1px solid #e2e8f0; background: white; color: #0f172a;">
                        Continue Shopping
                    </button>
                </div>
            `;

            document.getElementById('order-content').innerHTML = html;
        }
    </script>
</body>
</html>