window.S3_BASE_URL = 'https://inventorydata-s3-bucket.s3.amazonaws.com/';
window.API_BASE_URL = window.API_BASE_URL;
const APP_CONFIG = {
    ENDPOINTS: {
        CATEGORIES: `${API_BASE_URL}/categories`,
        CATEGORY_PRODUCTS: (id) => `${API_BASE_URL}/categories/${id}/products`,
        TOP_SELLING: `${API_BASE_URL}/products/top-selling`,
        BANNERS: `${API_BASE_URL}/banners`,
        APP_SETTINGS: `${API_BASE_URL}/app-settings`,
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
    await this.fetchAppSettings();
    if (this.page === 'landing') {
        await this.initLanding();
    }
    
    this.renderHeader();
    this.renderBottomNav();
    this.initSearchRedirect();
    
    let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (this.page === 'landing') {
                    this.renderPromotionalBanners();  
                    this.renderHeroSlider();
                    this.renderStyleSpotlight();
                    this.renderBrandsGrid();
                }
                this.renderHeader();
            }, 250);
        });
    
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
        if (!this.allCategories || this.allCategories.length === 0) {
            fetch(APP_CONFIG.ENDPOINTS.CATEGORIES)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.allCategories = data.data;
                        this.renderHeader(); // Re-render
                    }
                });
            return;
        }
    
        const topCategories = this.allCategories.slice(0, 5);
        
        const categoriesHtml = topCategories.map((cat, index) => 
            `<a href="/category/${cat.id}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`
        ).join('');
        
        header.innerHTML = `
            <div class="web-header">
                <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
                <div class="main-header">
                    <div class="logo-area">
                        <a href="/" class="logo">
                            <img src="" alt="Logo" id="site-logo" class="site-logo"
                            onerror="this.src='https://placehold.co/120x40?text=LOGO'">
                        </a>
                        <nav class="nav-menu" id="navMenu">
                            ${categoriesHtml}
                        </nav>
                    </div>
                   <div class="search-area">
                        <div class="search-box" style="position:relative;">
                            <input type="text" id="web-search-input" placeholder="Search for products, brands..." autocomplete="off">
                            <div id="web-search-suggestions" class="web-search-suggestions" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="header-actions">

                <a href="${this.isLoggedIn ? '/profile' : '/login'}" class="action-link">
                    <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Profile
                </a>

                <a href="/wishlist" class="action-link">
                    <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M12 21s-6-4.35-9-8.5C-1 6.5 4 2 8 5c2 1.5 4 3.5 4 3.5S14 6.5 16 5c4-3 9 1.5 5 7.5C18 16.65 12 21 12 21z"
                            stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Wishlist
                </a>

                <a href="/cart" class="action-link cart-link">
                <span class="cart-icon-wrapper">
                    <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                        <circle cx="9" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                        <circle cx="18" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                        <path d="M2 2h3l3 12h11l2-8H6"
                            stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span id="web-cart-count-badge">0</span>
                </span>
                Cart
            </a>
            </div>
                </div>
            </div>
            <div class="all-categories-popup" id="allCategoriesPopup" style="display:none; position:absolute; top:100%; left:0; width:100%; background:white; box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:1000; border-top:1px solid #f0f0f0;"></div>
        `;
        
        this.setupAllCategoriesPopup();
        this.initWebSearchDropdown();
       this.applyAppSettings();

setTimeout(() => {
    updateCartCountBadge();
}, 0);

        
    } else {
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
                            <img src="" alt="Logo" class="site-logo" id="site-logo"                                    
                            onerror="this.src='https://placehold.co/100x35?text=RAPID'">
                            </a>
                        </div>
                        <div class="search-wrapper">
                            <input id="landing-search" type="text" placeholder="Search for Category, Product ...">
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
    this.applyAppSettings();
}

initWebSearchDropdown() {
    setTimeout(() => {
        const input = document.getElementById("web-search-input");
        if (!input) {
            console.log("Web search input not found");
            return;
        }
        
        console.log("Web search input found");
        
        let suggestionsBox = document.getElementById("web-search-suggestions");
        if (!suggestionsBox) {
            const parent = input.parentElement;
            const div = document.createElement("div");
            div.id = "web-search-suggestions";
            div.className = "web-search-suggestions";
            div.style.display = "none";
            parent.appendChild(div);
            suggestionsBox = div;
        }
        
        let timer;
        
        input.addEventListener("input", async (e) => {

    clearTimeout(timer);

    const q = e.target.value.trim();

    /* empty input */
    if (q.length === 0) {
        suggestionsBox.style.display = "none";
        suggestionsBox.innerHTML = "";
        return;
    }

    try {

        /* ⭐ First letter pe instant suggestion */
        if (q.length === 1) {

            const res = await fetch(
                `${API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`
            );

            const data = await res.json();

            if (!data.success) return;

            const products = data.data.products || [];

            let html = "";

            products.forEach(p => {
                html += `
                <div class="web-suggestion-item"
                     onclick="window.location.href='/product/${p.slug}'">
                     ${p.name}
                </div>
                `;
            });

            if (html === "") {
                html = `
                <div class="web-suggestion-item">
                    No results found for "${q}"
                </div>`;
            }

            suggestionsBox.innerHTML = html;
            suggestionsBox.style.display = "block";

            return;
        }

        /* ⭐ baaki typing pe smooth delay */

        timer = setTimeout(async () => {

            try {

                const res = await fetch(
                    `${API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`
                );

                const data = await res.json();

                if (!data.success) return;

                const products = data.data.products || [];

                let html = "";

                products.forEach(p => {
                    html += `
                    <div class="web-suggestion-item"
                         onclick="window.location.href='/product/${p.slug}'">
                         ${p.name}
                    </div>
                    `;
                });

                if (html === "") {
                    html = `
                    <div class="web-suggestion-item">
                        No results found for "${q}"
                    </div>`;
                }

                suggestionsBox.innerHTML = html;
                suggestionsBox.style.display = "block";

            } catch (err) {
                console.log(err);
            }

        }, 200);

    } catch (err) {
        console.log(err);
    }

});
        
        document.addEventListener("click", (e) => {
            if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });
        
    }, 500);
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
    
    const categoriesWithSub = this.allCategories.filter(cat => 
        cat.children && cat.children.length > 0
    );
    
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
    const mobileSearchInput = document.getElementById("landing-search");
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener("focus", () => {
            window.location.href = "/search";
        });
    }
}
renderBottomNav() {
    const nav = document.getElementById('mobile-bottom-nav');
    if (!nav) return;
    
    const currentPath = window.location.pathname;
    let activePage = this.page;
    
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
        <!--
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
        --!>
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
            <div class="nav-icon-box" style="position: relative;">

                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>

                    <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                    <circle cx="20" cy="21" r="1.5" fill="currentColor"/>
                </svg>

                <span id="cart-count-badge"
                    style="
                        position: absolute;
                        top: -6px;
                        right: -10px;
                        background: red;
                        color: white;
                        font-size: 11px;
                        padding: 2px 6px;
                        border-radius: 50%;
                        display: none;
                    ">
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

    async initLanding() {
    const [catsRes, bannersRes, topSellingRes] = await Promise.all([
        fetch(APP_CONFIG.ENDPOINTS.CATEGORIES).then(r => r.json()),
        fetch(APP_CONFIG.ENDPOINTS.BANNERS).then(r => r.json()),
        fetch(APP_CONFIG.ENDPOINTS.TOP_SELLING).then(r => r.json())
    ]);

    if (catsRes.success) this.allCategories = catsRes.data;
    if (bannersRes.success) {
        this.allBanners = bannersRes.data;
    }
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
    
    const skeleton = document.getElementById('skeleton-loader');
    const realContent = document.getElementById('real-content');
    if (skeleton) skeleton.style.display = 'none';
    if (realContent) realContent.style.display = 'block';
    window.addEventListener('resize', () => {
    clearTimeout(this.styleResizeTimer);
    this.styleResizeTimer = setTimeout(() => {
        if (this.page === 'landing') {
            this.renderStyleSpotlight();
        }
    }, 200);
});
}
    async fetchUserCategoryOrder() {
    try {
        const response = await fetch(`${API_BASE_URL}/categories/order`, {
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

    let heroBanners = this.allBanners.filter(b => b.position === 'hero');
    
    if (heroBanners.length === 0 && this.allBanners.length > 0) {
        heroBanners = this.allBanners;
    }
    
    if (heroBanners.length === 0) return;
    
    const isMobile = window.innerWidth < 768;
    
    slider.innerHTML = heroBanners.map((b, i) => {
        const hasText = b.title || b.subtitle;
        let bannerImage;
        
        if (isMobile) {
            bannerImage = b.mobile_image || b.image;
        } else {
            bannerImage = b.image || b.mobile_image;
        }
        
        return `
            <div class="slide ${i === 0 ? 'active' : ''}">
                <img src="${this.resolveImage(bannerImage)}" class="slide-img-figma" alt="${b.title || 'Banner'}">
                ${hasText ? `
                    <div class="slide-content-figma">
                        <h1>${b.title || ''}</h1>
                        <p>${b.subtitle || ''}</p>
                        <button class="shop-now-btn" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'Shop Now'}</button>
                    </div>
                ` : ''}
            </div>
        `;
    }).join('');

    if (dots) {
        dots.innerHTML = heroBanners.map((_, i) => `<div class="dot ${i === 0 ? 'active' : ''}" data-idx="${i}"></div>`).join('');
        document.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', (e) => {
                const idx = parseInt(e.target.dataset.idx);
                this.changeSlide(idx);
            });
        });
    }
    
    this.startSlider(heroBanners.length);
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
    async fetchAppSettings() {
        try {

            const response = await fetch(
                APP_CONFIG.ENDPOINTS.APP_SETTINGS
            );

            const data = await response.json();

            if (data.success) {

                this.appSettings = data.data;

                console.log(
                    "App Settings Loaded:",
                    this.appSettings
                );

                this.applyAppSettings();

            }

        } catch (error) {

            console.error(
                "Error loading app settings:",
                error
            );

        }
    }
    applyAppSettings() {

    if (!this.appSettings) return;

    const headerLogo = document.getElementById('site-logo');

    if (headerLogo && this.appSettings.header_logo) {

        headerLogo.src = this.appSettings.header_logo;

        headerLogo.onerror = function () {
            this.src = 'https://placehold.co/120x40?text=LOGO';
        };
    }

    if (this.appSettings.app_name) {
        document.title = this.appSettings.app_name;
    }

}
async renderCategoryPills() {
    const container = document.getElementById('categories-pills');
    if (!container) return;

    const categoriesToShow =
        (this.isLoggedIn && this.userCategories.length > 0)
        ? this.userCategories
        : this.allCategories;

    if (!categoriesToShow.length) return;

    let categoriesHtml = `
        <div class="pill-item" onclick="window.location.href='/categories'">
            <div class="pill-img-wrap all-categories-pill">
                <img src="https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?w=100&h=100&fit=crop" 
     style="width:100%; height:100%; object-fit:cover; border-radius:50%;"
     onerror="this.src='https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=100&h=100&fit=crop'">
            </div>
            <span>All Categories</span>
        </div>
    `;
    
    categoriesHtml += categoriesToShow.map(cat => `
        <div class="pill-item"
        onclick="window.app.showCategoryPopupById(${cat.id})">
            <div class="pill-img-wrap">
                <img src="${this.resolveImage(cat.image_url)}"
                onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
            </div>
            <span>${cat.name}</span>
        </div>
    `).join('');
    
    container.innerHTML = categoriesHtml;
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

    const isMobile = window.innerWidth < 768;

    if (banners.length > 0 && container1) {
        const b = banners[0];
        
        let bannerImage;
        if (isMobile) {
            bannerImage = b.mobile_image || b.image;
        } else {
            bannerImage = b.image || b.mobile_image;
        }
        
        const hasText = b.title || b.subtitle || b.button_text;
        
        container1.innerHTML = `
            <div class="spring-bloom-banner">
                <img src="${this.resolveImage(bannerImage)}" alt="${b.title || 'Banner'}">
                ${hasText ? `
                    <div>
                        <span class="banner-tag-script">${b.subtitle || 'Special Offer'}</span>
                        <h3>${b.title || 'HOLI OFFER'}</h3>
                        <p>${b.subtitle || ''}</p>
                        <button class="code-btn-figma" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'SHOP NOW'}</button>
                    </div>
                ` : ''}
            </div>
        `;
    }

    if (banners.length > 1 && container2) {
        const b = banners[1];
        
        // ✅ Same for second banner
        let bannerImage;
        if (isMobile) {
            bannerImage = b.mobile_image || b.image;
        } else {
            bannerImage = b.image || b.mobile_image;
        }
        
        const hasText = b.title || b.subtitle || b.button_text;
        
        container2.innerHTML = `
            <div class="home-upgrade-banner" style="background: transparent;">
                <img src="${this.resolveImage(bannerImage)}" style="width:100%; height:auto; display:block;">
                ${hasText ? `
                    <div>
                        <h3>${b.title || 'Special Offer'}</h3>
                        <p>${b.subtitle || ''}</p>
                        <span class="price-tag-figma" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'Shop Now'}</span>
                    </div>
                ` : ''}
            </div>
        `;
    }
}
showCategoryPopup(category) {
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

    const gradients = [
            { bg: "linear-gradient(135deg, #F0F5FF, #E0ECFF)", border: "#C0D4FF" },
            { bg: "linear-gradient(135deg, #FFF8F0, #FFE8D9)", border: "#FFD9B5" },
            { bg: "linear-gradient(135deg, #FFF0F5, #FFE0EC)", border: "#FFC0D0" },
            { bg: "linear-gradient(135deg, #F0FFF0, #E0FFE0)", border: "#C0FFC0" },
            { bg: "linear-gradient(135deg, #FFF5E6, #FFE8CC)", border: "#FFD9A3" },
            { bg: "linear-gradient(135deg, #F5F0FF, #E8E0FF)", border: "#D9C0FF" },
            { bg: "linear-gradient(135deg, #FFF0E6, #FFE0CC)", border: "#FFC99E" },
            { bg: "linear-gradient(135deg, #E6F0FF, #CCE0FF)", border: "#99B8FF" }
        ];

    const displayItems = (items && items.length > 0) ? items.slice(0, 5) : perfectItems;

    container.innerHTML = displayItems.map((item, idx) => {
        const gradientIndex = idx % gradients.length;
        const bgGradient = gradients[gradientIndex];
        
        const name = item.name || item.main || '';
        const slug = item.slug || `product-${item.id}`;
        
        if (name.includes("WÜWEN") || name.includes("WUWEN")) {
            return `
                <div class="trending-card" style="background: ${bgGradient.bg} !important; border: 1px solid ${bgGradient.border} !important;" onclick="window.location.href='/product/${slug}'">
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
        
        else if (name.includes("VOUVIEN")) {
            return `
                <div class="trending-card" style="background: ${bgGradient.bg} !important; border: 1px solid ${bgGradient.border} !important;" onclick="window.location.href='/product/${slug}'">
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
                <div class="trending-card" style="background: ${bgGradient.bg} !important; border: 1px solid ${bgGradient.border} !important;" onclick="window.location.href='/product/${slug}'">
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
    let resetting = false;
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
        if (resetting) return;
        
        slider.classList.add('scrolling');
        
        if (this.scrollTimeout) {
            clearTimeout(this.scrollTimeout);
        }
        
        this.scrollTimeout = setTimeout(() => {
            slider.classList.remove('scrolling');
        }, 500);
        
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        if (slider.scrollLeft >= maxScroll - 5) {
            resetting = true;
            setTimeout(() => {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
                setTimeout(() => {
                    resetting = false;
                }, 500);
            }, 100);
        }
    });
    
    this.autoScrollTimer = setInterval(() => {
        if (isPaused || resetting) return;
        
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        
        if (slider.scrollLeft >= maxScroll - 5) {
            resetting = true;
            slider.scrollTo({ left: 0, behavior: 'smooth' });
            setTimeout(() => {
                resetting = false;
            }, 500);
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
    
    let displayItems = [];
    if (items.length > 0) {
        if (window.innerWidth >= 1025) {
            displayItems = items.slice(0, 8);
        } else {
            displayItems = items;
        }
    } else {
        displayItems = fallbackItems;
        if (window.innerWidth >= 1025) {
            displayItems = displayItems.slice(0, 8);
        }
    }

    const itemsHtml = displayItems.map(item => {
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

    const sectionHeader = `
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="section-title" style="font-size: 24px; font-weight: 700; color: #000; margin: 0;">Style Spotlight</h2>
            <a href="/products?type=top-selling" class="view-all-link">View All →</a>
        </div>
    `;

    container.innerHTML = sectionHeader + `<div class="spotlight-grid">${itemsHtml}</div>`;
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

    let brandNames = [];
    
    if (this.allCategories && this.allCategories.length > 0) {
        brandNames = this.allCategories.map(c => c.name.toUpperCase());
    } else {
        brandNames = [
            "JEWELLERY",
            "ELECTRONICS", 
            "MEN'S SHAVING",
            "WESTERN WEAR",
            "BEAUTY",
            "SPORTS"
        ];
    }

    const isDesktop = window.innerWidth >= 1025;
    const maxBrands = isDesktop ? 4 : 6;
    const displayBrands = brandNames.slice(0, maxBrands);

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
    
    let categoriesArray = [];

    for (let i = 0; i < this.allCategories.length && subcategoriesShown < MAX_SUBCATEGORIES; i++) {
        const category = this.allCategories[i];
        
        if (category.children && category.children.length > 0) {
            
            for (let j = 0; j < category.children.length && subcategoriesShown < MAX_SUBCATEGORIES; j++) {
                const subcategory = category.children[j];
                
                try {
                    const res = await fetch(APP_CONFIG.ENDPOINTS.CATEGORY_PRODUCTS(subcategory.id));
                    const data = await res.json();
                    
                    if (data.success && data.data && data.data.products && data.data.products.length > 0) {
                        const products = data.data.products.slice(0, MAX_PRODUCTS);
                        
                        const sectionHtml = `
    <section class="section-container style-category-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">${subcategory.name}</h2>
                <a href="/products?subcategory=${subcategory.id}" class="view-all-link">View All →</a>
            </div>
            <div class="style-category-grid">
                ${products.map(p => `
                    <div class="style-category-card" onclick="window.location.href='/product/${p.slug}'">
                        <div class="style-category-img">
                            <img src="${this.resolveImage(p.image_url)}" alt="${p.name}">
                        </div>
                        <div class="style-category-info">
                            <h4>${p.name}</h4>
                            <p>${p.brand || 'Premium Collection'}</p>
                            <div class="style-category-price">
                                <span class="current">₹${p.final_price || p.price}</span>
                                ${p.mrp ? `<span class="old">₹${p.mrp}</span>` : ''}
                            </div>
                            <button class="explore-btn" onclick="event.stopPropagation(); window.location.href='/product/${p.slug}'">EXPLORE →</button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    </section>
`;
                        
                        categoriesArray.push({
                            name: subcategory.name,
                            html: sectionHtml
                        });
                        subcategoriesShown++;
                    }
                } catch (error) {
                    console.error('Error fetching subcategory products:', error);
                }
            }
        }
    }
    
    let finalHtml = '';
    for (let i = 0; i < categoriesArray.length; i++) {
        if (categoriesArray[i].name === 'Full Bridal Sets') {
            finalHtml += `<div id="brands-marquee-container"></div>`;
        }
        
        finalHtml += categoriesArray[i].html;
        
        if (categoriesArray[i].name === 'Long Haar Necklace') {
            finalHtml += `
                <section class="section-container">
                    <div class="container">
                        <div class="section-header centered">
                            <h2 class="section-title">Shop by Brands</h2>
                        </div>
                        <div id="brands-grid" class="brands-grid-figma"></div>
                    </div>
                </section>
            `;
        }
    }
    
    container.innerHTML = finalHtml;
    
    await this.renderBrandsGrid();
    await this.renderBrandsMarquee();
    
    console.log(`✅ Displayed ${categoriesArray.length} subcategories`);
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
    
    if (currentPath.includes('/checkout')) {
        window.location.href = '/cart';
        return;
    }

if (currentPath === '/cart') {
    const lastProduct = sessionStorage.getItem('last_product_page');
    if (lastProduct && !lastProduct.includes('/checkout')) {
        window.location.href = lastProduct;
        sessionStorage.removeItem('last_product_page');
    } else {
        window.location.href = '/';
    }
    return;
}

    if (currentPath.includes('/order-confirmation')) { 
        window.location.href = '/orders';
        return;
    }
    
    if (currentPath === '/profile' || currentPath.includes('/profile')) {
        window.location.href = '/';
        return;
    }
    
    if (currentPath === '/orders' || currentPath.includes('/orders')) {
        window.location.href = '/profile';
        return;
    }
    
    if (currentPath === '/login' || currentPath === '/register') {
        if (token) {
            window.location.href = '/';
        } else {
            window.history.back();
        }
        return;
    }
    
    window.history.back();
};


window.app = new RapidRetailsEngine();
document.addEventListener('DOMContentLoaded', () => window.app.init());

window.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("app-loader");
    if (loader) {
        loader.style.display = "none";
    }
})
function updateCartCountBadge() {

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalItems = cart.length;

    const mobileBadge = document.getElementById('cart-count-badge');
    if (mobileBadge) {
        mobileBadge.style.display = 'flex';
        mobileBadge.textContent = totalItems;
        if (totalItems === 0) {
            mobileBadge.style.display = 'flex';  
        }
    }
    const webBadge = document.getElementById('web-cart-count-badge');
    if (webBadge) {
        webBadge.style.display = 'flex';
        webBadge.textContent = totalItems;
        if (totalItems === 0) {
            webBadge.style.display = 'flex'; 
        }
    }
}
async function fetchFooterSettings() {
    try {
        const response = await fetch(`${API_BASE_URL}/app-settings`);
        const data = await response.json();
        if (data.success) {
            const appName = data.data.app_name;
            const footerAppName = document.getElementById('footerAppName');
            const footerAppNameBottom = document.getElementById('footerAppNameBottom');
            if (footerAppName) footerAppName.textContent = appName;
            if (footerAppNameBottom) footerAppNameBottom.textContent = appName;
        }
    } catch (error) {
        console.error('Error fetching app settings:', error);
    }
}

async function fetchCategoriesForFooter() {
    try {
        const response = await fetch(`${API_BASE_URL}/categories`)
        const data = await response.json();
        if (data.success && data.data.length > 0) {
            const categories = data.data.slice(0, 6);
            const listContainer = document.getElementById('footerCategoriesList');
            if (listContainer) {
                listContainer.innerHTML = categories.map(cat => `
                    <li><a href="/category/${cat.id}">${cat.name}</a></li>
                `).join('');
            }
        }
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
}

const footerYear = document.getElementById('footerYear');

if (footerYear) {
    footerYear.textContent = new Date().getFullYear();
}
document.addEventListener('DOMContentLoaded', function() {
    fetchFooterSettings();
    fetchCategoriesForFooter();
});
document.addEventListener("click", (e) => {

    const box =
        document.querySelector(".search-box");

    const suggestions =
        document.getElementById(
            "web-search-suggestions"
        );

    if (!box || !suggestions) return;

    if (!box.contains(e.target)) {

        suggestions.style.display = "none";

    }

});