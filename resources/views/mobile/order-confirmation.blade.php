<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/order-confirmation.css') }}">
</head>
<body>
    <div class="confirmation-container">
        <div class="success-icon">🎉</div>
        
        <h1>Order Confirmed!</h1>
        
        <div class="order-number">
            Order #: {{ $orderId }}
        </div>
        
        <div class="success-message">
            Thank you for shopping with RAPID RETAIL!<br>
            Your order has been placed successfully.
        </div>
        
        <div class="order-details" id="order-details">
            <div class="loading-spinner">Loading order details...</div>
        </div>
        
        <a href="/" class="continue-btn">Continue Shopping</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = '{{ $orderId }}';
            const token = localStorage.getItem('token');
            
            if (!token) {
                window.location.href = '/user/login';
                return;
            }
            
            fetch(`https://retailadmin.ggconsultancy.services/api/orders/${orderId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    renderOrderDetails(response.data);
                } else {
                    document.getElementById('order-details').innerHTML = 
                        '<div class="error-message">Could not load order details</div>';
                }
            })
            .catch(() => {
                document.getElementById('order-details').innerHTML = 
                    '<div class="error-message">Network error. Please check your connection.</div>';
            });
        });
        
        function renderOrderDetails(order) {
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <div class="detail-row">
                        <span>${item.product_name} x ${item.quantity}</span>
                        <span>₹${item.price}</span>
                    </div>
                `;
            });
            
            document.getElementById('order-details').innerHTML = `
                <h3>Order Summary</h3>
                ${itemsHtml}
                <div class="detail-row" style="font-weight: bold;">
                    <span>Total Amount</span>
                    <span>₹${order.total}</span>
                </div>
                <div class="detail-row">
                    <span>Payment Status</span>
                    <span style="color: #4CAF50;">${order.payment_status}</span>
                </div>
                <div class="detail-row">
                    <span>Order Date</span>
                    <span>${new Date(order.created_at).toLocaleDateString()}</span>
                </div>
            `;
        }
    </script>
    
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    <script src="{{ asset('mobile/script.js') }}"></script>
</body>
</html>