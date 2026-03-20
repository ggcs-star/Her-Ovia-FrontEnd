const S3_BASE_URL = 'https://inventorydata-s3-bucket.s3.amazonaws.com/';

const APP_CONFIG = {
    ENDPOINTS: {
        CATEGORIES: 'https://retailadmin.ggconsultancy.services/api/categories',
        CATEGORY_PRODUCTS: (id) => `https://retailadmin.ggconsultancy.services/api/categories/${id}/products`, 
        TOP_SELLING: 'https://retailadmin.ggconsultancy.services/api/products/top-selling',
        BANNERS: 'https://retailadmin.ggconsultancy.services/api/banners',
    },
    FALLBACK_IMAGE: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop',
};

class RapidRetailsEngine {
    constructor() {
        this.page = document.body.dataset.page || 'landing';
        this.slideIdx = 0;
        this.slideTimer = null;
        this.allCategories = [];
        this.allBanners = [];
        this.userCategories = [];
        this.isLoggedIn = !!localStorage.getItem('token');
    }

    async init() {
    // Pehle categories load karo
    if (this.page === 'landing') {
        await this.initLanding();
    }
    
    this.renderHeader();
    this.renderBottomNav();
    this.initSearchRedirect();
    
    // Resize handler
    let lastWidth = window.innerWidth;
    setInterval(() => {
        if (lastWidth !== window.innerWidth) {
            lastWidth = window.innerWidth;
            this.renderHeader();
        }
    }, 100);
}
   renderHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    const isDesktop = window.innerWidth >= 1025;
    
    if (isDesktop) {
        const categoriesHtml = this.allCategories.slice(0, 5).map((cat, index) => 
            `<a href="/category/${cat.id}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`
        ).join('');
        
        header.innerHTML = `
            <div class="web-header">
                <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
                <div class="main-header">
                    <div class="logo-area">
                        <a href="/" class="logo">RAPID RETAIL</a>
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
                        <a href="/login" class="action-link">Profile</a>
                        <a href="/wishlist" class="action-link">Wishlist</a>
                        <a href="/cart" class="action-link">Cart</a>
                    </div>
                </div>
            </div>
            <div class="all-categories-popup" id="allCategoriesPopup" style="display:none; position:absolute; top:100%; left:0; width:100%; background:white; box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:1000; border-top:1px solid #f0f0f0;"></div>
        `;
        
        this.setupAllCategoriesPopup();
        
    } else {
        // Mobile Header - same rahega
        const isCartPage = document.body.classList.contains('cart-page');
        const isCheckoutPage = document.body.classList.contains('checkout-page');
        const isProfilePage = document.body.classList.contains('profile-page');
        const isOrdersPage = document.body.classList.contains('orders-page');
        const isWishlistPage = document.body.classList.contains('wishlist-page'); 
        const isOrderConfirmationPage = document.body.classList.contains('order-confirmation-page'); 

        const showBackButton = isCartPage || isCheckoutPage || isProfilePage || isOrdersPage || isWishlistPage || isOrderConfirmationPage;
        
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    ${showBackButton ? '<button class="back-btn-header" onclick="goBack()">←</button>' : ''}
                    <div class="logo-search-container">
                        <div class="header-logo">
                            <a href="/">
                                <img src="/images/logo.jpg" alt="RAPID RETAIL" class="site-logo" 
                                    onerror="this.src='https://via.placeholder.com/100x35?text=RAPID'">
                            </a>
                        </div>
                        <div class="search-wrapper">
                            <input id="landing-search" type="text" placeholder="Search for Category, Product ...">
                            <span class="search-icon" onclick="window.location.href='/search'">🔍</span>
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

    initSearchRedirect() {
    const searchInput = document.getElementById("landing-search");
    if (!searchInput) return;
    searchInput.addEventListener("focus", () => {
        window.location.href = "/search";
    });
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
        <a href="/profile" class="nav-item-figma ${this.page === 'profile' ? 'active' : ''}">
            <div class="nav-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Profile</span>
        </a>
        
    `;
}

    async initLanding() {
        const [catsRes, bannersRes, topSellingRes] = await Promise.all([
            fetch(APP_CONFIG.ENDPOINTS.CATEGORIES).then(r => r.json()),
            fetch(APP_CONFIG.ENDPOINTS.BANNERS).then(r => r.json()),
            fetch(APP_CONFIG.ENDPOINTS.TOP_SELLING).then(r => r.json())
        ]);

        if (catsRes.success) this.allCategories = catsRes.data;
        if (bannersRes.success) this.allBanners = bannersRes.data;
        if (this.isLoggedIn) {
        await this.fetchUserCategoryOrder();
    }
        await this.renderHeroSlider();
        await this.renderCategoryPills();
        await this.renderTrending(topSellingRes);
        await this.renderPromotionalBanners();
        await this.renderStyleSpotlight();
        await this.renderBrandsMarquee();
        await this.renderBrandsGrid();
        await this.renderDynamicCategorySections();
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
            console.log('User categories loaded:', this.userCategories);
        }
    } catch (error) {
        console.error('Error fetching user categories:', error);
    }
}
    async renderHeroSlider() {
        const slider = document.getElementById('hero-slider');
        const dots = document.getElementById('slider-dots');
        if (!slider) return;

        const heroBanners = this.allBanners.filter(b => b.position === 'hero' || b.page === 'home');
        
        if (heroBanners.length > 0) {
            slider.innerHTML = heroBanners.map((b, i) => {
                const hasText = b.title || b.subtitle;
                return `
                    <div class="slide ${i === 0 ? 'active' : ''}">
                        <img src="${this.resolveImage(b.image)}" class="slide-img-figma">
                        <div class="slide-content-figma" style="${!hasText ? 'background: transparent;' : ''}">
                            ${hasText ? `
                                <h1>${b.title || ''}</h1>
                                <p>${b.subtitle || ''}</p>
                            ` : ''}
                            <button class="shop-now-btn" style="${!hasText ? 'position: absolute; bottom: 50px;' : ''}" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'Shop Now'}</button>
                        </div>
                    </div>
                `;
            }).join('');

            if (dots) {
                dots.innerHTML = heroBanners.map((_, i) => `<div class="dot ${i === 0 ? 'active' : ''}" data-idx="${i}"></div>`).join('');
            }
            this.startSlider(heroBanners.length);
        }
    }

    startSlider(count) {
        if (this.slideTimer) clearInterval(this.slideTimer);
        this.slideTimer = setInterval(() => {
            const next = (this.slideIdx + 1) % count;
            this.changeSlide(next);
        }, 5000);
    }

    changeSlide(idx) {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        if (!slides.length) return;
        slides[this.slideIdx].classList.remove('active');
        if (dots.length) dots[this.slideIdx].classList.remove('active');
        this.slideIdx = idx;
        slides[this.slideIdx].classList.add('active');
        if (dots.length) dots[this.slideIdx].classList.add('active');
    }
    
    async renderCategoryPills() {

        const container = document.getElementById('categories-pills');
        if (!container) return;

        const categoriesToShow =
            (this.isLoggedIn && this.userCategories.length > 0)
            ? this.userCategories
            : this.allCategories;

        if (!categoriesToShow.length) return;

        container.innerHTML = categoriesToShow.map(cat => `
            <div class="pill-item"
            onclick="window.app.showCategoryPopupById(${cat.id})">

                <div class="pill-img-wrap">
                    <img src="${this.resolveImage(cat.image_url)}"
                    onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
                </div>

                <span>${cat.name}</span>

            </div>
        `).join('');
    }

    startTrendingAutoScroll(container) {
        let scrollAmount = 0;
        const step = 1;
        const interval = 30;
        
        setInterval(() => {
            if (container.scrollLeft >= (container.scrollWidth - container.clientWidth)) {
                container.scrollLeft = 0;
                scrollAmount = 0;
            } else {
                container.scrollLeft += step;
                scrollAmount += step;
            }
        }, interval);
    }
async renderPromotionalBanners() {
    const banners = this.allBanners.filter(b => b.position === 'mid');
    const container1 = document.getElementById('mid-banner-1-container');
    const container2 = document.getElementById('mid-banner-2-container');

    console.log("Mid Banners:", banners); 

    
    if (banners.length > 0 && container1) {
        const b = banners[0]; 
        container1.innerHTML = `
            <div class="spring-bloom-banner" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex: 1;">
                        <span class="banner-tag-script">${b.subtitle || 'Special Offer'}</span>
                        <h3 style="font-size: 28px; margin: 10px 0;">${b.title || 'HOLI OFFER'}</h3>
                        <p style="font-size: 16px; margin-bottom: 15px;">${b.subtitle || 'Gold Jewellary'}</p>
                        <button class="code-btn-figma" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'SHOP NOW'}</button>
                    </div>
                    <div style="width: 120px; height: 120px;">
                        <img src="${this.resolveImage(b.mobile_image || b.image)}" 
                             style="width: 100%; height: 100%; object-fit: contain;"
                             onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
                    </div>
                </div>
            </div>
        `;
    }

    // Dusra mid banner agar ho to
    if (banners.length > 1 && container2) {
        const b = banners[1];
        container2.innerHTML = `
            <div class="home-upgrade-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 100px; height: 100px;">
                        <img src="${this.resolveImage(b.mobile_image || b.image)}" 
                             style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <h3>${b.title || 'Special Offer'}</h3>
                        <p>${b.subtitle || ''}</p>
                        <span class="price-tag-figma">${b.button_text || 'Shop Now'}</span>
                    </div>
                </div>
            </div>
        `;
    }
}
showCategoryPopup(category) {
    // Create popup if not exists
    let popup = document.getElementById('category-popup-overlay');
    if (!popup) {
        const popupHTML = `
            <div class="category-popup-overlay" id="category-popup-overlay" onclick="window.app.hideCategoryPopup()">
                <div class="category-popup-content" onclick="event.stopPropagation()">
                    <div class="category-popup-header">
                        <h2 id="category-popup-title">Category</h2>
                        <span class="category-popup-close" onclick="window.app.hideCategoryPopup()">×</span>
                    </div>
                    <div class="category-popup-body" id="category-popup-body"></div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', popupHTML);
    }
    
    popup = document.getElementById('category-popup-overlay');
    const title = document.getElementById('category-popup-title');
    const body = document.getElementById('category-popup-body');
    
    if (!popup || !title || !body) return;
    
    title.textContent = category.name;
    
    if (category.children && category.children.length > 0) {
        const fallbackImage = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
        
        // ✅ YAHAN LINK CHANGE KARO - /products?subcategory=${child.id}
        body.innerHTML = category.children.map(child => `
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
showCategoryPopupById(categoryId) {

    const category = this.allCategories.find(c => c.id == categoryId);

    if (category) {
        this.showCategoryPopup(category);
    }

}
hideCategoryPopup() {
    const popup = document.getElementById('category-popup-overlay');
    if (popup) {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }
}
async renderTrending(res) {
    const container = document.getElementById('trending-slider');
    if (!container) return;

    let items = [];
    if (res.success && res.data) {
        items = Array.isArray(res.data) ? res.data : (res.data.products || []);
    }

    // PERFECT DATA
    const perfectItems = [
        {
            id: 1,
            name: "WÜWEN SMAI ONE",
            slug: "wuwen-smai-one",
            description: "Trending now",
            image_url: "https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop"
        },
        {
            id: 2,
            name: "SMARTPHONE PRO",
            slug: "smartphone-pro",
            description: "Latest technology",
            image_url: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=200&auto=format&fit=crop"
        },
        {
            id: 3,
            name: "WIRELESS BUDS",
            slug: "wireless-buds",
            description: "Premium sound",
            image_url: "https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=200&auto=format&fit=crop"
        },
        {
            id: 4,
            name: "VOUVIEN COTTON T-SHIRT",
            slug: "vouvier-cotton-tshirt",
            description: "Comfort wear",
            image_url: "https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=200&auto=format&fit=crop"
        },
        {
            id: 5,
            name: "FUEL THE HUSTLE",
            slug: "fuel-the-hustle",
            description: "Snack smarter",
            image_url: "https://images.unsplash.com/photo-1546435770-a3e426bf472b?q=80&w=200&auto=format&fit=crop"
        }
    ];

    const displayItems = (items && items.length > 0) ? items.slice(0, 5) : perfectItems;

    container.innerHTML = displayItems.map(item => {
        const name = item.name || item.main || '';
        const slug = item.slug || `product-${item.id}`;
        
        // SPECIAL CASE 1: "WÜWEN SMAI ONE" - do alag lines me
        if (name.includes("WÜWEN") || name.includes("WUWEN")) {
            return `
                <div class="trending-card" onclick="window.location.href='/product/${slug}'">
                    <div class="trending-card-content">
                        <div class="trending-main" style="font-size: 20px; margin-bottom: 2px;">WÜWEN</div>
                        <div class="trending-main" style="font-size: 18px; margin-bottom: 4px;">SMAI ONE</div>
                        <div class="trending-sub">${item.description || "Trending now"}</div>
                        <span class="shop-now-link">SHOP NOW</span>
                    </div>
                    <div class="trending-img-wrap">
                        <img src="${this.resolveImage(item.image_url)}" alt="WÜWEN">
                    </div>
                </div>
            `;
        }
        
        // SPECIAL CASE 2: "VOUVIEN COTTON T-SHIRT" - do lines
        else if (name.includes("VOUVIEN")) {
            return `
                <div class="trending-card" onclick="window.location.href='/product/${slug}'">
                    <div class="trending-card-content">
                        <div class="trending-main" style="font-size: 20px; margin-bottom: 2px;">VOUVIEN</div>
                        <div class="trending-main" style="font-size: 18px; margin-bottom: 4px;">COTTON T-SHIRT</div>
                        <div class="trending-sub">${item.description || "Comfort wear"}</div>
                        <span class="shop-now-link">SHOP NOW</span>
                    </div>
                    <div class="trending-img-wrap">
                        <img src="${this.resolveImage(item.image_url)}" alt="VOUVIEN">
                    </div>
                </div>
            `;
        }
        
        else {
            return `
                <div class="trending-card" onclick="window.location.href='/product/${slug}'">
                    <div class="trending-card-content">
                        <div class="trending-main">${name}</div>
                        <div class="trending-sub">${item.description || "Trending now"}</div>
                        <span class="shop-now-link">SHOP NOW</span>
                    </div>
                    <div class="trending-img-wrap">
                        <img src="${this.resolveImage(item.image_url)}" alt="${name}">
                    </div>
                </div>
            `;
        }
    }).join('');

    this.setupAutoScroll(container);
}

setupAutoScroll(container) {
    if (this.autoScrollTimer) {
        clearInterval(this.autoScrollTimer);
    }
    
    const slider = container;
    let isPaused = false;
    const scrollSpeed = 1;
    const intervalTime = 30;
    
    slider.addEventListener('mouseenter', () => { 
        isPaused = true; 
        slider.classList.remove('scrolling');
    });
    
    slider.addEventListener('mouseleave', () => { 
        isPaused = false; 
    });
    
    slider.addEventListener('touchstart', () => { 
        isPaused = true; 
        slider.classList.remove('scrolling');
    });
    
    slider.addEventListener('touchend', () => { 
        isPaused = false; 
    });
    
    slider.addEventListener('scroll', () => {
        slider.classList.add('scrolling');
        
        if (this.scrollTimeout) {
            clearTimeout(this.scrollTimeout);
        }
        
        this.scrollTimeout = setTimeout(() => {
            slider.classList.remove('scrolling');
        }, 500);
        
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        if (slider.scrollLeft >= maxScroll - 5) {
            setTimeout(() => {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            }, 100);
        }
    });
    
    this.autoScrollTimer = setInterval(() => {
        if (isPaused) return;
        
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        
        if (slider.scrollLeft >= maxScroll - 5) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollLeft += scrollSpeed;
        }
    }, intervalTime);
}

async renderStyleSpotlight() {
    const container = document.getElementById('style-spotlight-grid');
    if (!container) return;

    const res = await fetch(APP_CONFIG.ENDPOINTS.TOP_SELLING).then(r => r.json());
    
    let items = [];
    if (res.success && res.data) {
        items = Array.isArray(res.data) ? res.data : (res.data.products || []);
    }

    const fallbackItems = [
        {
            brand: "FashionHub",
            name: "Women's Cotton T-Shirt",
            rating: "4.5",
            current: "1260",
            old: "1638",
            image_url: "https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop"
        },
        {
            brand: "TechPro",
            name: "Smartphone Pro",
            rating: "4.8",
            current: "49800",
            old: "64740",
            image_url: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=200&auto=format&fit=crop"
        },
        {
            brand: "AudioMax",
            name: "Wireless Buds",
            rating: "4.6",
            current: "4999",
            old: "7999",
            image_url: "https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=200&auto=format&fit=crop"
        },
        {
            brand: "SportLife",
            name: "Running Shoes",
            rating: "4.7",
            current: "3500",
            old: "5000",
            image_url: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=200&auto=format&fit=crop"
        },
        {
            brand: "WatchWorld",
            name: "Smart Watch",
            rating: "4.4",
            current: "2999",
            old: "4500",
            image_url: "https://images.unsplash.com/photo-1546868871-7041f2a55e12?q=80&w=200&auto=format&fit=crop"
        }
    ];

    const displayItems = items.length > 0 ? items.slice(0, 10) : fallbackItems;

    container.innerHTML = displayItems.map(item => {
        const brand = item.brand || 'Premium Brand';
        const name = item.name || 'Fashion Item';
        const rating = item.rating || (4 + Math.random()).toFixed(1);
        const current = item.current || item.final_price || item.price || '999';
        const old = item.old || item.mrp || (Math.round(parseInt(current) * 1.3));
        
        return `
            <div class="spotlight-item" onclick="window.location.href='/product/${item.slug || '#'}'">
                <div class="spotlight-img-wrap">
                    <img src="${this.resolveImage(item.image_url)}" onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
                    <div class="spotlight-rating">${rating}</div>
                </div>
                <div class="spotlight-info">
                    <h4>${brand}</h4>
                    <div class="product-name">${name}</div>
                    <div class="spotlight-price">
                        <span class="current">₹${current}</span>
                        <span class="old">₹${old}</span>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

    async renderBrandsMarquee() {
        const container = document.getElementById('brands-marquee-container');
        if (!container || !this.allCategories.length) return;

        const names = this.allCategories.map(c => c.name.toUpperCase());
        const marqueeText = names.map(name => `<span>${name} ON SALE</span>`).join('');
        
        container.innerHTML = `
            <div class="brands-marquee">
                <div class="marquee-content">
                    ${marqueeText}${marqueeText}${marqueeText}${marqueeText}
                </div>
            </div>
        `;
    }

async renderBrandsGrid() {
    const container = document.getElementById('brands-grid');
    if (!container) return;

    // Agar categories hain to unse names lo, nahi to fallback use karo
    let brandNames = [];
    
    if (this.allCategories && this.allCategories.length > 0) {
        // Categories ke names ko uppercase mein le lo
        brandNames = this.allCategories.map(c => c.name.toUpperCase());
    } else {
        // Fallback brand names
        brandNames = [
            "JEWELLERY",
            "ELECTRONICS", 
            "MEN'S SHAVING",
            "WESTERN WEAR",
            "BEAUTY",
            "SPORTS"
        ];
    }

    // Limit to 6 brands
    const displayBrands = brandNames.slice(0, 6);

    container.innerHTML = displayBrands.map((brand, index) => `
        <div class="brand-card-figma" onclick="window.location.href='/category/${brand.toLowerCase().replace(/\s+/g, '-')}'">
            <h4>${brand}</h4>
            <p>Up to 50% Off</p>
        </div>
    `).join('');

    console.log("Brands Grid rendered:", displayBrands);
}

    async renderDynamicCategorySections() {
    const container = document.getElementById('dynamic-category-sections');
    if (!container || !this.allCategories.length) return;

    container.innerHTML = '';
    
    let subcategoriesShown = 0;
    const MAX_SUBCATEGORIES = 4;
    const MAX_PRODUCTS = 5;

    // Saari categories loop karo
    for (let i = 0; i < this.allCategories.length && subcategoriesShown < MAX_SUBCATEGORIES; i++) {
        const category = this.allCategories[i];
        
        // Agar category ke paas subcategories hain
        if (category.children && category.children.length > 0) {
            
            // Har subcategory ke liye loop
            for (let j = 0; j < category.children.length && subcategoriesShown < MAX_SUBCATEGORIES; j++) {
                const subcategory = category.children[j];
                
                try {
                    // Subcategory ke products fetch karo
                    const res = await fetch(APP_CONFIG.ENDPOINTS.CATEGORY_PRODUCTS(subcategory.id));
                    const data = await res.json();
                    
                    if (data.success && data.data && data.data.products && data.data.products.length > 0) {
                        // Sirf 5 products lo
                        const products = data.data.products.slice(0, MAX_PRODUCTS);
                        
                        const sectionHtml = `
                            <section class="section-container">
                                <div class="container">
                                    <div class="section-header">
                                        <h2 class="section-title">${subcategory.name}</h2>
                                        <a href="/products?subcategory=${subcategory.id}" class="view-all-link">View All →</a>
                                    </div>
                                    <div class="horizontal-scroll">
                                        ${products.map(p => this.genProductCard(p)).join('')}
                                    </div>
                                </div>
                            </section>
                        `;
                        container.innerHTML += sectionHtml;
                        subcategoriesShown++;
                    }
                } catch (error) {
                    console.error('Error fetching subcategory products:', error);
                }
            }
        }
    }
    
    console.log(`✅ Displayed ${subcategoriesShown} subcategories with ${MAX_PRODUCTS} products each`);
}

    genCircularItem(p) {
        return `
            <div class="circular-item" onclick="window.location.href='/product/${p.slug}'">
                <div class="circular-img-wrap">
                    <img src="${this.resolveImage(p.image_url)}">
                </div>
                <h4>${p.name}</h4>
                <p>₹${p.final_price || p.price}</p>
            </div>
        `;
    }

    genProductCard(p) {
    return `
        <div class="product-card-horizontal" onclick="window.location.href='/product/${p.slug}'">
            <div class="product-image-wrapper">
                <img src="${this.resolveImage(p.image_url)}" alt="${p.name}">
                <div class="product-rating">⭐ ${p.rating || '4.5'}</div>
            </div>
            <div class="product-info">
                <h4>${p.name}</h4>
                <div class="product-price">
                    <span class="current">₹${p.final_price || p.price}</span>
                    ${p.mrp ? `<span class="old">₹${p.mrp}</span>` : ''}
                </div>
            </div>
        </div>
    `;
}

    resolveImage(path) {
    if (!path) return APP_CONFIG.FALLBACK_IMAGE;
    if (path.startsWith('http')) return path;  
    
    
    if (!path.includes('amazonaws.com')) {
        return S3_BASE_URL + path;
    }
    return path;
}

    setupCoreEvents() {}
    updateAuthUI() {}
    async initAllCategories() {}
    async initCategoryDetail() {}
    async initProductDetail() {}
}

window.goBack = function() {
    const currentPath = window.location.pathname;
    const token = localStorage.getItem('token');
    
    // 🔥 CHECKOUT PAGE SE BACK - DIRECT CART
    if (currentPath.includes('/checkout')) {
        window.location.href = '/cart';
        return;
    }
    
    // 🔥 CART PAGE SE BACK - PRODUCT PAGE PE JANA
    if (currentPath === '/cart') {
        const lastProduct = sessionStorage.getItem('last_product_page');
        if (lastProduct) {
            window.location.href = lastProduct;
            sessionStorage.removeItem('last_product_page');
        } else {
            window.location.href = '/';
        }
        return;
    }
    
    // 🔥 ORDER CONFIRMATION
    if (currentPath.includes('/order-confirmation')) { 
        window.location.href = '/orders';
        return;
    }
    
    // 🔥 PROFILE
    if (currentPath === '/profile' || currentPath.includes('/profile')) {
        window.location.href = '/';
        return;
    }
    
    // 🔥 ORDERS
    if (currentPath === '/orders' || currentPath.includes('/orders')) {
        window.location.href = '/profile';
        return;
    }
    
    // 🔥 LOGIN/REGISTER
    if (currentPath === '/login' || currentPath === '/register') {
        if (token) {
            window.location.href = '/';
        } else {
            window.history.back();
        }
        return;
    }
    
    // DEFAULT
    window.history.back();
};


window.app = new RapidRetailsEngine();
document.addEventListener('DOMContentLoaded', () => window.app.init());

// Hide loader when page ready
window.addEventListener("load", function () {
    const loader = document.getElementById("app-loader");
    if (loader) {
        loader.style.opacity = "0";
        setTimeout(() => {
            loader.style.display = "none";
        }, 300);
    }
});