const API_BASE_URL = window.API_BASE_URL || 'https://retailadmin.ggconsultancy.services/api';

document.addEventListener('DOMContentLoaded', function() {
    initializeProfile();
    updateCartBadge();
    setupEventListeners();
});

// Add storage event listener to handle multiple tabs
window.addEventListener('storage', function(e) {
    if (e.key === 'token' || e.key === 'user') {
        initializeProfile();
    }
});

function initializeProfile() {
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || 'null');
    
    // Clear any cached profile data
    const container = document.getElementById('profile-container');
    if (container) {
        container.innerHTML = ''; // Clear container first
    }
    
    if (token && user && user.id) {
        // Validate token with server
        validateAndLoadUserProfile();
    } else {
        // Clear any stale data
        clearAuthData();
        renderGuestProfile();
    }
}

function clearAuthData() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    // Clear any session storage related to auth
    sessionStorage.removeItem('login_timestamp');
    sessionStorage.removeItem('redirect_after_login');
}

async function validateAndLoadUserProfile() {
    const token = localStorage.getItem('token');
    const container = document.getElementById('profile-container');
    
    if (!container) return;
    
    container.innerHTML = '<div class="loading-spinner">Loading profile...</div>';
    
    try {
        const response = await fetch(`${API_BASE_URL}/user/profile`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Cache-Control': 'no-cache' // Prevent caching
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success && data.data) {
            // Update stored user data
            localStorage.setItem('user', JSON.stringify(data.data));
            renderProfile(data.data);
            loadUserStats();
        } else {
            // Token is invalid
            clearAuthData();
            renderGuestProfile();
            showToast('Session expired. Please login again.', 'error');
        }
    } catch (error) {
        console.error('Profile validation error:', error);
        // Network error - try to use cached data temporarily
        const cachedUser = JSON.parse(localStorage.getItem('user') || 'null');
        if (cachedUser) {
            renderProfile(cachedUser);
            showToast('Using cached data. Check your connection.', 'warning');
        } else {
            renderGuestProfile();
        }
    }
}

function renderGuestProfile() {
    const container = document.getElementById('profile-container');
    if (!container) return;
    
    // Clear container first
    container.innerHTML = '';
    
    const html = `
        <div class="profile-menu" style="margin-top: 20px;">
            <div class="menu-card">
                <h3>My Account</h3>
                <div class="menu-item" onclick="window.location.href='/login'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5Z"/>
                        <path d="M4 20c0-3.314 3.582-6 8-6s8 2.686 8 6" stroke-linecap="round"/>
                    </svg>
                    <span>Sign In</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="window.location.href='/register'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    <span>Create Account</span>
                    <span class="menu-arrow">›</span>
                </div>
            </div>
            
            <div class="menu-card">
                <h3>Customer Care</h3>
                <div class="menu-item" onclick="window.location.href='/help/how-to-return'">
                    <span>How To Return</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="window.location.href='/help/terms'">
                    <span>Terms & Conditions</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="window.location.href='/help/privacy'">
                    <span>Privacy Policy</span>
                    <span class="menu-arrow">›</span>
                </div>
            </div>
        </div>
        
        <div class="promo-banner" onclick="window.location.href='/summer-sale'">
            <h4>🔥 Summer Sale Live!</h4>
            <p>Min 50% Off on Top Brands</p>
            <span class="shop-now">Shop Now →</span>
        </div>
    `;
    
    container.innerHTML = html;
}

function loadUserProfile() {
    // This is now handled by validateAndLoadUserProfile
    validateAndLoadUserProfile();
}

async function loadUserStats() {
    const token = localStorage.getItem('token');
    if (!token) return;
    
    try {
        const [ordersRes, wishlistRes, couponsRes] = await Promise.all([
            fetch(`${API_BASE_URL}/orders`, {
                headers: { 
                    'Authorization': `Bearer ${token}`,
                    'Cache-Control': 'no-cache'
                }
            }),
            fetch(`${API_BASE_URL}/wishlist`, {
                headers: { 
                    'Authorization': `Bearer ${token}`,
                    'Cache-Control': 'no-cache'
                }
            }),
            fetch(`${API_BASE_URL}/coupons`, {
                headers: { 
                    'Authorization': `Bearer ${token}`,
                    'Cache-Control': 'no-cache'
                }
            })
        ]);
        
        const ordersData = await ordersRes.json();
        const wishlistData = await wishlistRes.json();
        const couponsData = await couponsRes.json();
        
        updateStats({
            orders: ordersData.data?.length || 0,
            wishlist: wishlistData.data?.length || 0,
            coupons: couponsData.data?.length || 0
        });
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

function updateStats(stats) {
    const statsContainer = document.querySelector('.profile-stats');
    if (!statsContainer) return;
    
    statsContainer.innerHTML = `
        <div class="stat-item" onclick="window.location.href='/orders'">
            <span class="stat-value">${stats.orders}</span>
            <span class="stat-label">Orders</span>
        </div>
        <div class="stat-item" onclick="window.location.href='/wishlist'">
            <span class="stat-value">${stats.wishlist}</span>
            <span class="stat-label">Wishlist</span>
        </div>
        <div class="stat-item" onclick="window.location.href='/coupons'">
            <span class="stat-value">${stats.coupons}</span>
            <span class="stat-label">Coupons</span>
        </div>
    `;
}

function renderProfile(user) {
    const container = document.getElementById('profile-container');
    if (!container) return;
    
    // Clear container first
    container.innerHTML = '';
    
    const initials = user.name ? user.name.split(' ').map(n => n[0]).join('').toUpperCase() : 'U';
    
    const html = `
        <div class="profile-header">
            <div class="profile-avatar" onclick="triggerImageUpload()" style="cursor: pointer; position: relative;">
                ${user.profile_image ? 
                    `<img src="${user.profile_image}" alt="${user.name}">` : 
                    `<div class="avatar-initials">${initials}</div>`
                }
                <button class="edit-avatar-btn" onclick="event.stopPropagation(); triggerImageUpload()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                        <line x1="12" y1="9" x2="12" y2="17"/>
                        <line x1="9" y1="12" x2="15" y2="12"/>
                    </svg>
                </button>
            </div>
            <div class="profile-info">
                <h2 class="profile-name">${user.name || 'User'}</h2>
                <p class="profile-email">${user.email || ''}</p>
                <p class="profile-phone">${user.phone || user.mobile || ''}</p>
                <div class="profile-actions">
                    <button class="edit-profile-btn ${!user.profile_image ? 'centered' : ''}" onclick="openEditProfile()">Edit Profile</button>
                    ${user.profile_image ? `
                        <button class="remove-image-btn" onclick="removeProfileImage()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Remove Photo
                        </button>
                    ` : ''}
                </div>
            </div>
        </div>
        
        <div class="profile-stats"></div>
        <div class="profile-menu">
            <div class="menu-card">
                <h3>My Orders</h3>
<div class="menu-item" data-link="/orders">                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span>My Orders</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span>Return Creation Demo</span>
                    <span class="menu-arrow">›</span>
                </div>
            </div>
            
            <div class="menu-card">
                <h3>Customer Care</h3>
                <div class="menu-item" onclick="return false;">
                    <span>How To Return</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>How Do I Redeem My Coupon?</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Terms & Conditions</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Promotions Terms & Conditions</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Returns & Refunds Policy</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>We Respect Your Privacy</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Fees & Payments</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Who We Are</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <span>Join Our Team</span>
                    <span class="menu-arrow">›</span>
                </div>
            </div>
            
            <div class="menu-card">
                <h3>Wallet & Rewards</h3>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Invite Friends & Earn</span>
                    <span class="badge-promo">₹100 SuperCash</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="M12 8v8"/>
                        <path d="M8 12h8"/>
                    </svg>
                    <span>Add Gift Card</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="2" y="6" width="20" height="14" rx="2" ry="2"/>
                        <circle cx="16" cy="14" r="2"/>
                        <path d="M22 10h-4a4 4 0 0 0-8 0H2"/>
                    </svg>
                    <span>Rapid Wallet</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    <span>Saved Cards</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8 21 12 17 16 21"/>
                    </svg>
                    <span>My Rewards</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Address</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item" onclick="return false;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span>Notifications</span>
                    <span class="menu-arrow">›</span>
                </div>
                <div class="menu-item logout-btn" onclick="handleLogout()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </div>
            </div>
        </div>
        
        <div class="promo-banner" onclick="window.location.href='/summer-sale'">
            <h4>🔥 Summer Sale Live!</h4>
            <p>Min 50% Off on Top Brands</p>
            <span class="shop-now">Shop Now →</span>
        </div>
        
        <div class="version-info">
            Version 9.29.1 Build 3630
        </div>
    `;
    
    container.innerHTML = html;
}

function triggerImageUpload() {
    // Create file input dynamically if it doesn't exist
    let fileInput = document.getElementById('avatarUpload');
    if (!fileInput) {
        fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.id = 'avatarUpload';
        fileInput.accept = 'image/jpeg,image/jpg,image/png,image/webp';
        fileInput.style.display = 'none';
        fileInput.addEventListener('change', handleImageUpload);
        document.body.appendChild(fileInput);
    }
    fileInput.click();
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        showToast('File size must be less than 2MB', 'error');
        return;
    }

    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        showToast('Only JPG, PNG, WEBP allowed', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('profile_image', file);

    fetch(`${API_BASE_URL}/user/profile/image`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            // Update user data in localStorage
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            user.profile_image = response.data?.profile_image || response.data?.image;
            localStorage.setItem('user', JSON.stringify(user));
            
            // Refresh profile
            validateAndLoadUserProfile();
            showToast('Profile picture updated!', 'success');
        } else {
            showToast(response.message || 'Upload failed', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Network error', 'error');
    });
}

function removeProfileImage() {
    const removeBtn = document.querySelector('.remove-image-btn');
    if (removeBtn) {
        removeBtn.disabled = true;
        removeBtn.innerHTML = 'Removing...';
    }
    
    fetch(`${API_BASE_URL}/user/profile/image`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            user.profile_image = null;
            localStorage.setItem('user', JSON.stringify(user));
            
            validateAndLoadUserProfile();
            showToast('Profile picture removed successfully', 'success');
        } else {
            showToast(response.message || 'Failed to remove picture', 'error');
        }
    })
    .catch(error => {
        console.error('Remove error:', error);
        showToast('Failed to remove picture', 'error');
    })
    .finally(() => {
        if (removeBtn) {
            removeBtn.disabled = false;
        }
    });
}

function openEditProfile() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    const modal = document.createElement('div');
    modal.className = 'edit-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    modal.innerHTML = `
        <div class="edit-modal-content" style="
            background: white;
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        ">
            <h3 style="margin-bottom: 20px; color: #282c3f;">Edit Profile</h3>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Full Name <span style="color: #ff3f6c;">*</span></label>
                <input type="text" id="edit-name" value="${user.name || ''}" 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                <div id="name-error" style="color: #ff3f6c; font-size: 12px; margin-top: 5px; display: none;"></div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email Address <span style="color: #ff3f6c;">*</span></label>
                <input type="email" id="edit-email" value="${user.email || ''}" readonly
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: #f5f5f5;">
                <div style="color: #999; font-size: 11px; margin-top: 5px;">Email cannot be changed</div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Phone Number <span style="color: #ff3f6c;">*</span></label>
                <input type="tel" id="edit-phone" value="${user.phone || user.mobile || ''}" 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                <div id="phone-error" style="color: #ff3f6c; font-size: 12px; margin-top: 5px; display: none;"></div>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button onclick="closeEditModal()" 
                        style="flex: 1; padding: 14px; background: #f5f5f5; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Cancel
                </button>
                <button onclick="validateAndSaveProfile()" 
                        style="flex: 1; padding: 14px; background: #ff3f6c; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Save Changes
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

function validateProfileData(name, phone) {
    const errors = [];
    
    if (!name || name.trim() === '') {
        errors.push({ field: 'name', message: 'Name is required' });
    } else if (name.length < 3) {
        errors.push({ field: 'name', message: 'Name must be at least 3 characters' });
    } else if (name.length > 50) {
        errors.push({ field: 'name', message: 'Name must be less than 50 characters' });
    }
    
    const phoneRegex = /^[6-9]\d{9}$/;
    if (!phone) {
        errors.push({ field: 'phone', message: 'Phone number is required' });
    } else if (!phoneRegex.test(phone)) {
        errors.push({ field: 'phone', message: 'Enter a valid 10-digit Indian mobile number' });
    }
    
    return errors;
}

function validateAndSaveProfile() {
    const nameInput = document.getElementById('edit-name');
    const phoneInput = document.getElementById('edit-phone');
    
    const name = nameInput?.value.trim() || '';
    const phone = phoneInput?.value.trim() || '';
    
    document.getElementById('name-error').style.display = 'none';
    document.getElementById('phone-error').style.display = 'none';
    nameInput.style.borderColor = '#ddd';
    phoneInput.style.borderColor = '#ddd';
    
    const errors = validateProfileData(name, phone);
    
    if (errors.length > 0) {
        errors.forEach(error => {
            if (error.field === 'name') {
                document.getElementById('name-error').textContent = error.message;
                document.getElementById('name-error').style.display = 'block';
                nameInput.style.borderColor = '#ff3f6c';
            } else if (error.field === 'phone') {
                document.getElementById('phone-error').textContent = error.message;
                document.getElementById('phone-error').style.display = 'block';
                phoneInput.style.borderColor = '#ff3f6c';
            }
        });
        return;
    }
    
    const data = { name, mobile: phone };
    closeEditModal();
    
    fetch(`${API_BASE_URL}/user/profile`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            localStorage.setItem('user', JSON.stringify(response.data));
            validateAndLoadUserProfile();
            showToast('Profile updated successfully!', 'success');
        } else {
            showToast(response.message || 'Failed to update profile', 'error');
        }
    })
    .catch(() => {
        showToast('Network error. Please try again.', 'error');
    });
}

function closeEditModal() {
    const modal = document.querySelector('.edit-modal');
    if (modal) modal.remove();
}

function handleLogout() {
    // Show loading state
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.style.opacity = '0.5';
        logoutBtn.style.pointerEvents = 'none';
    }
    
    fetch(`${API_BASE_URL}/logout`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .finally(() => {
        // Clear ALL auth data
        clearAuthData();
        
        // Clear any other app data
        localStorage.removeItem('cart');
        localStorage.removeItem('cart_synced');
        localStorage.removeItem('wishlist');
        sessionStorage.clear();
        
        // Force reload to clear all memory
        window.location.href = '/';
    });
}

function updateCartBadge() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const count = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'block' : 'none';
    }
}

function showToast(message, type) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    
    const toast = document.createElement('div');
    toast.className = `toast-message ${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: ${type === 'error' ? '#ff3f6c' : type === 'warning' ? '#ffa500' : '#333'};
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 10000;
        animation: slideUp 0.3s ease;
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, 3000);
}

function setupEventListeners() {
    // Remove any existing file input and create new one
    const oldInput = document.getElementById('avatarUpload');
    if (oldInput) oldInput.remove();
    
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.id = 'avatarUpload';
    fileInput.accept = 'image/jpeg,image/jpg,image/png,image/webp';
    fileInput.style.display = 'none';
    fileInput.addEventListener('change', handleImageUpload);
    document.body.appendChild(fileInput);
    
    window.addEventListener('storage', function(e) {
        if (e.key === 'cart') {
            updateCartBadge();
        }
        if (e.key === 'token' || e.key === 'user') {
            initializeProfile();
        }
    });
    document.addEventListener('click', function(e) {
    const item = e.target.closest('.menu-item');
    if (item && item.dataset.link) {
        e.preventDefault();
        window.location.href = item.dataset.link;
    }
});
}