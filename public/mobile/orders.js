const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';

document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!token || !user.id) {
        sessionStorage.setItem('redirect_after_login', '/orders');
        window.location.href = '/user/login';
        return;
    }
    
    loadOrders();
});

function loadOrders() {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    const recentOrders = JSON.parse(localStorage.getItem('recent_orders') || '[]');
    
    fetch(`${API_BASE_URL}/orders`, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.success && response.data && response.data.length > 0) {
            renderOrders(response.data);
            localStorage.setItem('recent_orders', JSON.stringify(response.data.slice(0, 10)));
        } else if (recentOrders.length > 0) {
            renderOrders(recentOrders);
            showToast('Showing saved orders', 'info');
        } else {
            showEmptyState();
        }
    })
    .catch(() => {
        if (recentOrders.length > 0) {
            renderOrders(recentOrders);
            showToast('Showing saved orders', 'info');
        } else {
            showEmptyState();
        }
    });
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
        const date = new Date(order.created_at || order.date || Date.now()).toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
        
        const status = order.payment_status || order.status || 'Pending';
        const statusClass = status.toLowerCase();
        
        const items = order.items || [];
        const firstItem = items[0] || {};
        const itemCount = items.length;
        const moreItems = itemCount - 1;
        
        html += `
            <div class="order-card" onclick="viewOrderDetails('${order.id}')">
                <div class="order-header">
                    <div class="order-id">#${order.id}</div>
                    <div class="order-status ${statusClass}">${status}</div>
                </div>
                
                <div class="order-date">
                    <span>📅</span> Placed on ${date}
                </div>
                
                <div class="order-item-preview">
                    <img src="${firstItem.image || 'https://via.placeholder.com/60'}" 
                         alt="${firstItem.product_name || 'Product'}"
                         onerror="this.src='https://via.placeholder.com/60'">
                    <div class="preview-details">
                        <div class="preview-name">${firstItem.product_name || firstItem.name || 'Product'}</div>
                        <div class="preview-price">₹${(firstItem.price || 0).toFixed(2)} x ${firstItem.quantity || 1}</div>
                        ${moreItems > 0 ? `<div class="more-items">+${moreItems} more item${moreItems > 1 ? 's' : ''}</div>` : ''}
                    </div>
                </div>
                
                <div class="order-footer">
                    <div class="order-total">
                        <span>Total:</span>
                        <span class="total-amount">₹${(
                            order.total || 
                            order.total_amount || 
                            order.grand_total || 
                            items.reduce((sum,i)=>sum + (i.price * (i.quantity || 1)),0)
                        ).toFixed(2)}</span>
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