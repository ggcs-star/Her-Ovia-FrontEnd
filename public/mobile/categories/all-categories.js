class AllCategoriesPage {
    constructor() {
        this.allCategories = [];
        this.isLoggedIn = !!localStorage.getItem('token');
        this.userCategories = [];
        this.isDragging = false;
        this.appSettings = null;
        this.init();
         window.addEventListener('resize', () => {
            this.renderHeader();
            this.renderWebSidebar(); 
        });
    }
    async init() {
        this.showSkeletonLoader();  
        this.showSidebarSkeleton();
        await this.fetchAppSettings(); 
        await this.fetchCategories();
        if (this.isLoggedIn) { 
        await this.fetchUserCategoryOrder();
    }
        this.renderHeader();
        this.renderCategories();
        this.renderWebSidebar();
        this.renderBottomNav();
        this.createPopup();
    }
    showSkeletonLoader() {
    const container = document.getElementById('all-categories-grid');
    if (!container) return;

    let skeletons = '';

    for (let i = 0; i < 6; i++) {
        skeletons += `
            <div class="skeleton-card">
                <div class="category-info">
                    <div class="skeleton-text"></div>
                </div>

                <div class="skeleton-image"></div>
            </div>
        `;
    }

    container.innerHTML = skeletons;
}
showSidebarSkeleton() {

    const sidebar = document.getElementById('categoriesWebSidebarList');

    if (!sidebar) return;

    if (window.innerWidth < 1024) return;

    let skeleton = '';

    for (let i = 0; i < 6; i++) {
        skeleton += `
            <li>
                <div style="
                    height:14px;
                    width:80%;
                    background:#e0e0e0;
                    border-radius:6px;
                    margin-bottom:12px;
                    position:relative;
                    overflow:hidden;
                ">
                    <div style="
                        position:absolute;
                        top:0;
                        left:-100px;
                        height:100%;
                        width:100px;
                        background:linear-gradient(
                            90deg,
                            transparent,
                            rgba(255,255,255,0.6),
                            transparent
                        );
                        animation:skeleton-loading 1.2s infinite;
                    "></div>
                </div>
            </li>
        `;
    }

    sidebar.innerHTML = skeleton;

}
    
    async fetchCategories() {
        try {
            const response = await fetch('https://retailadmin.ggconsultancy.services/api/categories');
            const data = await response.json();
            if (data.success) {
                this.allCategories = data.data;
                console.log('Categories loaded:', this.allCategories);
            }
        } catch (error) {
            console.error('Error fetching categories:', error);
            this.allCategories = [
                { id: 10, name: "Jewellery", image_url: null, children: [
                    { id: 11, name: "Necklace", image_url: null }
                ]},
                { id: 1, name: "Electronics", image_url: null, children: [] },
                { id: 12, name: "Men's Shaving & Face Care", image_url: null, children: [] },
                { id: 14, name: "Western Wear", image_url: null, children: [] },
                { id: 4, name: "T-Shirts", image_url: null, children: [] },
                { id: 7, name: "Books", image_url: null, children: [] },
                { id: 8, name: "Home & Furniture", image_url: null, children: [] },
                { id: 9, name: "Beauty & Personal Care", image_url: null, children: [] }
            ];
        }
    }
    async fetchUserCategoryOrder() {
        try {
            const response = await fetch('https://retailadmin.ggconsultancy.services/api/categories/order', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success && data.data.length > 0) {
                this.userCategories = data.data;
            }
        } catch (error) {
            console.error('Error fetching user categories:', error);
        }
    }
    renderHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;
    
    const isDesktop = window.innerWidth >= 1025;
    
    if (isDesktop) {
        const categoriesHtml = this.allCategories.slice(0, 5).map(cat => 
            `<a href="/category/${cat.id}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`
        ).join('');
        
        header.innerHTML = `
            <div class="web-header">
                <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
                <div class="main-header">
                    <div class="logo-area">
                        <a href="/" class="logo">${this.appSettings?.app_name || 'RAPID RETAIL'}</a>
                        <nav class="nav-menu" id="navMenu">
                            ${categoriesHtml}
                        </nav>
                    </div>
                    <div class="search-area">
                        <div class="search-box">
                            <input type="text" placeholder="Search for products, brands...">
                            <button>Search</button>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="${this.isLoggedIn ? '/profile' : '/login'}" class="action-link">Profile</a>
                        <a href="/wishlist" class="action-link">Wishlist</a>
                        <a href="/cart" class="action-link">Cart</a>
                    </div>
                </div>
            </div>
            <div class="all-categories-popup" id="allCategoriesPopup" style="display:none; position:absolute; top:100%; left:0; width:100%; background:white; box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:1000; border-top:1px solid #f0f0f0;"></div>
        `;
        
        // 🔥 ADD THIS LINE
        this.setupAllCategoriesPopup();
        
    } else {
        // Mobile header (same as before)
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    <div class="logo-search-container">
                      <div class="header-logo">
                            <a href="/">
                                <img src="${this.appSettings?.header_logo || this.appSettings?.app_logo || '/images/logo.jpg'}" alt="RAPID RETAIL" class="site-logo" 
                                    onerror="this.src='https://via.placeholder.com/100x35?text=RAPID'">
                            </a>
                        </div>
                        <div class="search-wrapper">
                            <input type="text" placeholder="Search for Category, Product ..." onclick="window.location.href='/search'">
                            <button class="search-icon-btn" onclick="window.location.href='/search'" style="background:none; border:none; cursor:pointer; padding:0; display:flex; align-items:center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="10" cy="10" r="7"/>
                                    <line x1="21" y1="21" x2="15" y2="15"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="header-icons">
                        <button class="header-icon-btn" onclick="window.location.href='/wishlist'">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}
async fetchAppSettings() {
    try {
        const response = await fetch('https://retailadmin.ggconsultancy.services/api/app-settings');
        const data = await response.json();
        if (data.success) {
            this.appSettings = data.data;
        }
    } catch (error) {
        console.error('Error fetching app settings:', error);
    }
}
setupAllCategoriesPopup() {
    const navItems = document.querySelectorAll('.nav-item');
    const popup = document.getElementById('allCategoriesPopup');
    
    if (!navItems.length || !popup) return;
    
    let hideTimeout = null;
    
    const showPopup = () => {
        if (hideTimeout) clearTimeout(hideTimeout);
        this.renderAllCategoriesPopup();
        popup.style.display = 'block';
    };
    
    const hidePopup = () => {
        hideTimeout = setTimeout(() => {
            popup.style.display = 'none';
        }, 200);
    };
    
    navItems.forEach(item => {
        item.addEventListener('mouseenter', showPopup);
        item.addEventListener('mouseleave', hidePopup);
    });
    
    popup.addEventListener('mouseenter', () => {
        if (hideTimeout) clearTimeout(hideTimeout);
        popup.style.display = 'block';
    });
    
    popup.addEventListener('mouseleave', hidePopup);
}
renderAllCategoriesPopup() {
    const popup = document.getElementById('allCategoriesPopup');
    if (!popup) return;
    
    if (!this.allCategories || this.allCategories.length === 0) {
        popup.innerHTML = '<div style="padding:40px; text-align:center;">Loading categories...</div>';
        return;
    }
    
    // Filter categories with subcategories
    const categoriesWithSub = this.allCategories.filter(cat => 
        cat.children && cat.children.length > 0
    );
    
    // Split into 5 columns
    const columnSize = Math.ceil(categoriesWithSub.length / 5);
    const columns = [];
    
    for (let i = 0; i < 5; i++) {
        columns.push(categoriesWithSub.slice(i * columnSize, (i + 1) * columnSize));
    }
    
    let html = `<div style="max-width:1200px; margin:0 auto; padding:30px; display:grid; grid-template-columns:repeat(5,1fr); gap:25px;">`;
    
    columns.forEach(col => {
        if (col.length > 0) {
            html += `<div>`;
            col.forEach(cat => {
                html += `
                    <div style="margin-bottom:20px;">
                        <h3 style="font-size:14px; font-weight:700; color:#282c3f; margin-bottom:12px; border-bottom:2px solid #ff3f6c; padding-bottom:6px; display:inline-block;">${cat.name}</h3>
                        <ul style="list-style:none; padding:0; margin-top:12px;">
                `;
                
                if (cat.children && cat.children.length > 0) {
                    cat.children.slice(0, 6).forEach(sub => {
                        html += `<li style="margin-bottom:8px;"><a href="/category/${sub.id}" style="text-decoration:none; color:#696b79; font-size:13px;">${sub.name}</a></li>`;
                    });
                    if (cat.children.length > 6) {
                        html += `<li style="margin-top:5px;"><a href="/category/${cat.id}" style="color:#ff3f6c; font-size:11px; font-weight:600; text-decoration:none;">+${cat.children.length - 6} more →</a></li>`;
                    }
                }
                
                html += `</ul></div>`;
            });
            html += `</div>`;
        }
    });
    
    html += `</div>`;
    popup.innerHTML = html;
}
    renderBottomNav() {
    const nav = document.getElementById('mobile-bottom-nav');
    if (!nav) return;
    
    // Get current page from URL path
    const currentPath = window.location.pathname;
    let activePage = '';
    
    if (currentPath === '/' || currentPath === '') activePage = 'landing';
    else if (currentPath === '/trends') activePage = 'trends';
    else if (currentPath === '/categories') activePage = 'all-categories';
    else if (currentPath === '/cart') activePage = 'cart';
    else if (currentPath === '/profile' || currentPath.includes('/profile')) activePage = 'profile';
    else if (currentPath === '/wishlist') activePage = 'wishlist';
    else if (currentPath === '/orders') activePage = 'orders';

    nav.innerHTML = `
        <a href="/" class="nav-item-figma ${activePage === 'landing' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span>Home</span>
        </a>
        <a href="/trends" class="nav-item-figma ${activePage === 'trends' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                    <line x1="7" y1="2" x2="7" y2="22"/>
                    <line x1="17" y1="2" x2="17" y2="22"/>
                    <line x1="2" y1="12" x2="22" y2="12"/>
                    <line x1="2" y1="7" x2="7" y2="7"/>
                    <line x1="2" y1="17" x2="7" y2="17"/>
                    <line x1="17" y1="17" x2="22" y2="17"/>
                    <line x1="17" y1="7" x2="22" y2="7"/>
                </svg>
            </div>
            <span>Trends</span>
        </a>
        <a href="/categories" class="nav-item-figma ${activePage === 'all-categories' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="13" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="13" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Categories</span>
        </a>
        <a href="/cart" class="nav-item-figma ${activePage === 'cart' ? 'active' : ''}">
            <div class="nav-icon-box">

                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">

                    <path d="M1 1H5L7.68 14.39
                            C7.77144 14.8504 8.02191 15.264
                            8.38755 15.5583
                            C8.75318 15.8526 9.2107 16.009
                            9.68 16
                            H19.4
                            C19.8693 16.009 20.3268 15.8526
                            20.6925 15.5583
                            C21.0581 15.264 21.3086 14.8504
                            21.4 14.39
                            L23 6H6"/>

                    <circle cx="9" cy="21" r="1.5"/>
                    <circle cx="20" cy="21" r="1.5"/>
                </svg>

                <!-- COUNT BADGE -->
                <span id="cart-count-badge" class="cart-count-badge">
                    0
                </span>

            </div>

            <span>Cart</span>
        </a>
        <a href="/profile" class="nav-item-figma ${activePage === 'profile' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Profile</span>
        </a>
    `;
    updateCartCountBadge();
}
    renderCategories() {
        const container = document.getElementById('all-categories-grid');
        if (!container) return;
        
        let editButtonHtml = '';
        if (this.isLoggedIn) {
            editButtonHtml = `
                <div class="categories-header">
                    <button class="edit-categories-btn" onclick="window.allCategoriesPage.toggleEditMode()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34" stroke-width="2"/>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2" stroke-width="2"/>
                        </svg>
                        Filter
                    </button>
                </div>
            `;
        }
        
        const style = document.createElement('style');
        style.textContent = `
            .page-content { padding-bottom: 80px; }
            .all-categories-grid .category-card:last-child { margin-bottom: 10px; }
            .categories-header {
                grid-column: 1 / -1;  /* Poori width lega */
                display: flex;
                justify-content: flex-end;
                padding: 8px 0;
                margin-bottom: 8px;
            }
            .edit-categories-btn {
                background: none;
                border: none;
                color: #ff3f6c;
                font-size: 14px;
                font-weight: 500;
                padding: 4px 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 4px;
            }
            .edit-categories-btn svg {
                width: 16px;
                height: 16px;
                stroke: #ff3f6c;
            }
            .edit-categories-btn.done {
                color: #28a745;
            }
            .edit-categories-btn.done svg {
                stroke: #28a745;
            }
        `;
        document.head.appendChild(style);
        
        const fallbackImages = [
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1598033121397-5ecc08fe7f1f?q=80&w=200&auto=format&fit=crop'
        ];

        const colors = [
    "linear-gradient(135deg, #FBE7A1, #F9D976)",
    "linear-gradient(135deg, #F8C8DC, #F4A6C1)",
    "linear-gradient(135deg, #D6C1E7, #C3A6E8)",
    "linear-gradient(135deg, #FAD7B5, #F6B98C)",
    "linear-gradient(135deg, #C8E6C9, #A5D6A7)",
    "linear-gradient(135deg, #C5CAE9, #9FA8DA)"
];
        const categoriesToShow = this.userCategories.length > 0 ? this.userCategories : this.allCategories;
        
      container.innerHTML = editButtonHtml + categoriesToShow.map((cat, index) => {

    const imageUrl = cat.image_url || fallbackImages[index % fallbackImages.length];
    const bgColor = colors[index % colors.length];

    return `
        <div class="category-card" 
            style="background: ${bgColor}"
            data-id="${cat.id}"
            onclick="showCategoryPopupById(${cat.id})">

            <div class="category-info">
                <h3>${cat.name}</h3>
            </div>

            <div class="category-image-box">
                <img src="${imageUrl}">
            </div>

        </div>
        `;
    }).join('');
        const layout = document.getElementById('categoriesLayoutWeb');
        if (layout) layout.style.display = 'flex';
    }
    renderWebSidebar() {
    const sidebar = document.getElementById('categoriesWebSidebarList');
    if (!sidebar) return;
    
    if (window.innerWidth < 1024) return;
    
    const categoriesToShow = this.userCategories.length > 0 ? this.userCategories : this.allCategories;
    
    sidebar.innerHTML = categoriesToShow.map(cat => `
        <li>
            <a href="/category/${cat.id}" class="category-sidebar-link" data-id="${cat.id}">
                ${cat.name}
            </a>
        </li>
    `).join('');
}            
    createPopup() {
        if (!document.getElementById('popup-overlay')) {
            const popupHTML = `
                <div class="popup-overlay" id="popup-overlay" onclick="hideCategoryPopup()">
                    <div class="popup-content" onclick="event.stopPropagation()">
                        <div class="popup-header">
                            <h2 id="popup-title">Category</h2>
                            <span class="popup-close" onclick="hideCategoryPopup()">×</span>
                        </div>
                        <div class="popup-body" id="popup-body"></div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', popupHTML);
        }
    }
    
    toggleEditMode() {
        const btn = document.querySelector('.edit-categories-btn');
        const grid = document.getElementById('all-categories-grid');

        if (btn.classList.contains('done')) {
            btn.classList.remove('done');
            btn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34" stroke-width="2"/>
                    <polygon points="18 2 22 6 12 16 8 16 8 12 18 2" stroke-width="2"/>
                </svg>
                Edit
            `;

            if (this.sortable) {
                this.sortable.destroy();
            }
            this.saveCategoryOrder();
        } else {
            btn.classList.add('done');
            btn.innerHTML = `
                
                Save
            `;

            this.sortable = new Sortable(grid, {
                animation: 200,
                ghostClass: "dragging",
                draggable: ".category-card"
            });
        }
    }
     saveCategoryOrder() {
        const ids = [];
        document.querySelectorAll(".category-card").forEach(item => {
            ids.push(item.dataset.id);
        });

        fetch('https://retailadmin.ggconsultancy.services/api/categories/order', {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("token"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ categories: ids })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                console.log('Order saved successfully');
                showToast('Category order saved', 'success');
            }
        })
        .catch(err => {
            console.error('Error saving order:', err);
            showToast('Could not save order', 'error');
        });
    }
openFilterModal() {
    alert('Filter modal - coming soon');
}
}
function showCategoryPopupById(categoryId) {
    const cat = window.allCategoriesPage.allCategories.find(c => c.id == categoryId);
    if (cat) showCategoryPopup(cat);
}
function showCategoryPopup(cat) {
    const popup = document.getElementById('popup-overlay');
    const title = document.getElementById('popup-title');
    const body = document.getElementById('popup-body');
    
    if (!popup || !title || !body) return;
    
    title.textContent = cat.name;
    
    if (cat.children && cat.children.length > 0) {
        const fallbackImage = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
        
        body.innerHTML = cat.children.map(child => `
            <div class="subcategory-card" onclick="window.location.href='/products?subcategory=${child.id}'">
                <div class="subcategory-image">
                    <img src="${child.image_url || fallbackImage}" onerror="this.src='${fallbackImage}'" alt="${child.name}">
                </div>
                <div class="subcategory-name">${child.name}</div>
            </div>
        `).join('');
    } else {
        body.innerHTML = `<div class="popup-empty">No subcategories</div>`;
    }
    
    popup.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function hideCategoryPopup() {
    const popup = document.getElementById('popup-overlay');
    if (popup) {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page === 'all-categories') {
        window.allCategoriesPage = new AllCategoriesPage();  // YEH CHANGE KARO
    }
});
function updateCartCountBadge() {

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let totalItems = cart.length;

    const badge = document.getElementById('cart-count-badge');

    if (!badge) return;
    badge.style.display = 'flex';
    badge.textContent = totalItems;
}
