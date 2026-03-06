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
            const response = await fetch('https://retailadmin.ggconsultancy.services/api/categories');
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
    // Check URL pattern /category/123
    const pathParts = window.location.pathname.split('/');
    if (pathParts[1] === 'category' && pathParts[2]) {
        this.loadSingleCategory(pathParts[2]);
    }
}

    async loadSingleCategory(categoryId) {
        const container = document.getElementById('all-categories-grid');
        if (!container) return;
        
        // Show loading
        container.innerHTML = '<div style="text-align:center;padding:50px;">Loading products...</div>';
        
        try {
            // Fetch products for this category
            const response = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${categoryId}/products`);
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
        
        // Update page title
        document.title = `${categoryName || 'Products'} | RAPID RETAIL`;
        
        if (products.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:50px;">No products found</div>';
            return;
        }
        
        // Render products in grid (same style as categories)
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
            <a href="/categories" class="nav-item-figma">
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
            
            // ✅ DEBUG LINK - CONSOLE MEIN PRINT HOGA
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
