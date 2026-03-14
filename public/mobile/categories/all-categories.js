class AllCategoriesPage {
    constructor() {
        this.allCategories = [];
        this.isLoggedIn = !!localStorage.getItem('token');
        this.userCategories = [];
        this.isDragging = false;
        this.init();
        
    }
    async init() {
        await this.fetchCategories();
        if (this.isLoggedIn) { 
        await this.fetchUserCategoryOrder();
    }
        this.renderHeader();
        this.renderCategories();
        this.renderBottomNav();
        this.createPopup();
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
        
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    <div class="logo-search-container">
                        <div class="header-logo">
                            <a href="/">
                                <img src="/images/logo.jpg" alt="RAPID RETAIL" class="site-logo" 
                                    onerror="this.src='https://via.placeholder.com/100x35?text=RAPID'">
                            </a>
                        </div>
                        <div class="search-wrapper">
                            <input type="text" placeholder="Search for Category, Product ..." onclick="window.location.href='/search'">
                            <span class="search-icon">🔍</span>
                        </div>
                    </div>
                    <div class="header-icons">
                        <button class="header-icon-btn" onclick="window.location.href='/wishlist'">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        <button class="header-icon-btn">🔔</button>
                    </div>
                </div>
            </div>
        `;
    }
    renderBottomNav() {
        const nav = document.getElementById('mobile-bottom-nav');
        if (!nav) return;

        nav.innerHTML = `
            <a href="/" class="nav-item-figma ${this.page === 'landing' ? 'active' : ''}">
                <div class="nav-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span>Home</span>
            </a>
            <a href="/trends" class="nav-item-figma ${this.page === 'trends' ? 'active' : ''}">
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
            <a href="/categories" class="nav-item-figma ${this.page === 'all-categories' ? 'active' : ''}">
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
            <a href="/profile" class="nav-item-figma ${this.page === 'profile' ? 'active' : ''}">
                <div class="nav-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <span>Profile</span>
            </a>
            <a href="/cart" class="nav-item-figma ${this.page === 'cart' ? 'active' : ''}">
                <div class="nav-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                        <circle cx="20" cy="21" r="1.5" fill="currentColor"/>
                    </svg>
                </div>
                <span>Cart</span>
            </a>
        `;
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

        const categoriesToShow = this.userCategories.length > 0 ? this.userCategories : this.allCategories;
        
        container.innerHTML = editButtonHtml + categoriesToShow.map((cat, index) => {
            const imageUrl = cat.image_url || fallbackImages[index % fallbackImages.length];
            return `
                <div class="category-card" data-id="${cat.id}"
                onclick="showCategoryPopupById(${cat.id})">

                <div class="category-image">
                <img src="${imageUrl}">
                </div>

                <div class="category-info">
                <h3>${cat.name}</h3>
                </div>

                </div>
                `;
                    }).join('');
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