class AllCategoriesPage {
    constructor() {
        this.allCategories = [];
        this.init();
    }
    async init() {
        await this.fetchCategories();
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
    renderHeader() {
        const header = document.getElementById('site-header');
        if (!header) return;
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    <div class="mobile-search-figma">
                        <span class="search-icon-figma">🔍</span>
                        <input type="text" placeholder="Search for Category, Product ...">
                    </div>
                    <div class="header-icons-figma">
                        <button class="header-icon-btn">❤️</button>
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
            <a href="/" class="nav-item-figma">
                <div class="nav-icon-box">🏠</div>
                <span>Home</span>
            </a>
            <a href="/categories" class="nav-item-figma active">
                <div class="nav-icon-box">🔲</div>
                <span>Categories</span>
            </a>
            <a href="/profile" class="nav-item-figma">
                <div class="nav-icon-box">👤</div>
                <span>Profile</span>
            </a>
            <a href="/cart" class="nav-item-figma">
                <div class="nav-icon-box">🛒</div>
                <span>Cart</span>
            </a>
        `;
    }
    renderCategories() {
        const container = document.getElementById('all-categories-grid');
        if (!container) return;
        
        const fallbackImages = [
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1598033121397-5ecc08fe7f1f?q=80&w=200&auto=format&fit=crop'
        ];

        container.innerHTML = this.allCategories.map((cat, index) => {
            const imageUrl = cat.image_url || fallbackImages[index % fallbackImages.length];
            return `
                <div class="category-card" onclick='showCategoryPopup(${JSON.stringify(cat).replace(/'/g, "\\'")})'>
                    <div class="category-image">
                        <img src="${imageUrl}" onerror="this.src='${fallbackImages[0]}'" alt="${cat.name}">
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
        new AllCategoriesPage();
    }
});