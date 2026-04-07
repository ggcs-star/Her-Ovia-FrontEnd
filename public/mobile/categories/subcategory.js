const API_BASE_URL = window.API_BASE_URL;
class SubCategoryPage {
    constructor() {
        this.categoryId = this.getCategoryIdFromUrl();
        this.categoryData = null;
        this.allCategories = [];
        this.checkForSingleCategory()
        this.init();
    }
    getCategoryIdFromUrl() {
        const matches = window.location.pathname.match(/\/subcategory\/(\d+)/);
        return matches ? matches[1] : null;
    }
    async init() {
        await this.fetchAllCategories();
        this.renderHeader();
        this.renderSubcategories();
        this.renderBottomNav();
    }
    async fetchAllCategories() {
        try {
            const response = await fetch(`${API_BASE_URL}/categories`);
            const data = await response.json();
            if (data.success) {
                this.allCategories = data.data;
                this.categoryData = this.allCategories.find(cat => cat.id == this.categoryId);
            }
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }
    checkForSingleCategory() {
    const pathParts = window.location.pathname.split('/');
    if (pathParts[1] === 'category' && pathParts[2]) {
        this.loadSingleCategory(pathParts[2]);
    }
}

    async loadSingleCategory(categoryId) {
        const container = document.getElementById('all-categories-grid');
        if (!container) return;
        
        container.innerHTML = '<div style="text-align:center;padding:50px;">Loading products...</div>';
        
        try {
            const response = await fetch(`${API_BASE_URL}/categories/${categoryId}/products`);
            const data = await response.json();
            
            if (data.success && data.data.products) {
                this.renderCategoryProducts(data.data.products, data.data.category?.name);
            } else {
                container.innerHTML = '<div style="text-align:center;padding:50px;">No products found</div>';
            }
        } catch (error) {
            console.error('Error loading category products:', error);
            container.innerHTML = '<div style="text-align:center;padding:50px;">Error loading products</div>';
        }
    }

    renderCategoryProducts(products, categoryName) {
        const container = document.getElementById('all-categories-grid');
        if (!container) return;
        
        document.title = `${categoryName || 'Products'} | RAPID RETAIL`;
        
        if (products.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:50px;">No products found</div>';
            return;
        }
        
        container.innerHTML = products.map(product => {
            const price = product.final_price || product.price || '0';
            const originalPrice = product.mrp || product.price || price;
            
            return `
                <div class="category-card" onclick="window.location.href='/products/${product.slug}'">
                    <div class="category-image">
                        <img src="${product.image_url || 'https://via.placeholder.com/200'}" 
                            onerror="this.src='https://via.placeholder.com/200'">
                    </div>
                    <div class="category-info">
                        <h3>${product.name}</h3>
                        <p style="color:#ff3f6c; font-weight:600; margin-top:5px;">₹${price}</p>
                        ${originalPrice > price ? `<small style="text-decoration:line-through;color:#999;">₹${originalPrice}</small>` : ''}
                    </div>
                </div>
            `;
        }).join('');
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
                    </div>
                </div>
            </div>
        `;
    }
    renderBottomNav() {
    const nav = document.getElementById('mobile-bottom-nav');
    if (!nav) return;
    
    const currentPath = window.location.pathname;
    
    nav.innerHTML = `
        <a href="/" class="nav-item-figma ${currentPath === '/' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span>Home</span>
        </a>
        <a href="/trends" class="nav-item-figma ${currentPath.includes('/trends') ? 'active' : ''}">
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
        <a href="/categories" class="nav-item-figma ${currentPath.includes('/categories') ? 'active' : ''}">
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
        <a href="/profile" class="nav-item-figma ${currentPath.includes('/profile') ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Profile</span>
        </a>
        <a href="/cart" class="nav-item-figma ${currentPath.includes('/cart') ? 'active' : ''}">
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
    renderSubcategories() {
        const container = document.getElementById('subcategory-grid');
        const titleEl = document.getElementById('category-title');
        if (!container || !this.categoryData) return;
        titleEl.textContent = this.categoryData.name;
        if (!this.categoryData.children || !this.categoryData.children.length) {
            container.innerHTML = `<div class="no-subcategories">No subcategories found</div>`;
            return;
        }
        const fallbackImage = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
        
        console.log('Children data:', this.categoryData.children);
        
        container.innerHTML = this.categoryData.children.map(child => {
            console.log('Creating card for child:', child.id, child.name);
            
            const link = `/products?subcategory=${child.id}`;
            console.log('Link for', child.name, ':', link);
            
            return `
                <div class="subcategory-card" onclick="window.location.href='${link}'">
                    <div class="subcategory-image">
                        <img src="${child.image_url || fallbackImage}" onerror="this.src='${fallbackImage}'" alt="${child.name}">
                    </div>
                    <div class="subcategory-info">
                        <h3>${child.name}</h3>
                        <p>Shop Now →</p>
                    </div>
                </div>
            `;
        }).join('');
    }
    }


document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('/subcategory/')) {
        new SubCategoryPage();
    }
});
