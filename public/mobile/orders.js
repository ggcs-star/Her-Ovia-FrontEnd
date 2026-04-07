const API_BASE_URL = window.API_BASE_URL;
const token = localStorage.getItem('token');

document.addEventListener('DOMContentLoaded', function() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    if (!token || !user.id) {
        sessionStorage.setItem('redirect_after_login', '/orders');
        window.location.href = '/user/login';
        return;
    }
    loadAllOrders();
    setInterval(loadAllOrders, 30000);
});

async function loadAllOrders() {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    try {
        const response = await fetch(`${API_BASE_URL}/orders?per_page=100&_=${Date.now()}`, {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json",
                "Cache-Control": "no-cache"
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.data) {
            renderOrders(data.data.data);
        } else {
            showEmptyState();
        }
        
    } catch (error) {
        console.error("Error:", error);
        showEmptyState();
    }
}
function renderOrders(orders) {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    if (!orders || orders.length === 0) {
        showEmptyState();
        return;
    }
    
    let html = '';
    orders.forEach(order => {
        const date = new Date(order.created_at).toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
        
        const orderStatus = order.status || 'pending';
        const paymentStatus = order.payment_status || 'pending';
        
        const items = order.items || [];
        const firstItem = items[0] || {};
        const itemCount = items.length;
        const moreItems = itemCount - 1;
        
        let image = firstItem.image || '';
        
        const imageHtml = image ? 
            `<img src="${image}" alt="${firstItem.product_name || 'Product'}" 
                  style="width:80px;height:80px;object-fit:cover;border-radius:8px;"
                  onerror="this.style.display='none'; this.parentNode.innerHTML+='<div style=\\'width:80px;height:80px;background:#f0f0f0;border-radius:8px;\\'></div>';">` : 
            '<div style="width:80px;height:80px;background:#f0f0f0;border-radius:8px;"></div>';
    
        const price = firstItem.price ? parseFloat(firstItem.price) : 0;
        const itemQuantity = firstItem.quantity ? parseInt(firstItem.quantity) : 1;

        html += `
            <div class="order-card" onclick="viewOrderDetails('${order.id}')">
                <div class="order-header">
                    <div class="order-id">#${order.order_number || order.id}</div>
                    <div class="order-status ${orderStatus}">
                        ${orderStatus === 'pending' ? '⏳ Pending' : ''}
                        ${orderStatus === 'confirmed' ? '✅ Confirmed' : ''}
                        ${orderStatus === 'processing' ? '⚙️ Processing' : ''}
                        ${orderStatus === 'shipped' ? '🚚 Shipped' : ''}
                        ${orderStatus === 'delivered' ? '📦 Delivered' : ''}
                        ${orderStatus === 'cancelled' ? '❌ Cancelled' : ''}
                    </div>
                </div>
                
                <div class="order-date">
                    <span>📅</span> Placed on ${date}
                </div>
                
                <div class="order-item-preview">
                    ${imageHtml}
                    <div class="preview-details">
                        <div class="preview-name">${firstItem.product_name || 'Product'}</div>
                        <div class="preview-price">₹${price.toFixed(2)} x ${itemQuantity}</div>
                        ${moreItems > 0 ? `<div class="more-items">+${moreItems} more</div>` : ''}
                    </div>
                </div>
                
                <div class="order-footer">
                    <div class="order-total">
                        <span>Total:</span>
                        <span class="total-amount">₹${parseFloat(order.total).toFixed(2)}</span>
                    </div>
                    <button class="view-details-btn">View Details →</button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}
function showEmptyState() {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    container.innerHTML = `
        <div class="empty-orders">
            <div class="empty-icon">📦</div>
            <h3>No orders yet</h3>
            <p>Looks like you haven't placed any orders</p>
            <a href="/" class="shop-now-btn">START SHOPPING</a>
        </div>
    `;
}

function viewOrderDetails(orderId) {
    window.location.href = `/order-confirmation/${orderId}`;
}