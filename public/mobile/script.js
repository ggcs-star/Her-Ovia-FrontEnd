const S3_BASE_URL = 'https://inventorydata-s3-bucket.s3.amazonaws.com/';

const FALLBACK_IMAGES = [
    'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=300&h=400&fit=crop',
    'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=300&h=400&fit=crop',
    'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=300&h=400&fit=crop',
    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=300&h=400&fit=crop',
    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=300&h=400&fit=crop',
    'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=300&h=400&fit=crop'
];

const APP_CONFIG = {
    ENDPOINTS: {
        CATEGORIES: 'https://retailadmin.ggconsultancy.services/api/categories',
        CATEGORY_DETAIL: (id) => `https://retailadmin.ggconsultancy.services/api/categories/${id}`,
        PRODUCTS_BY_CAT: (id) => `https://retailadmin.ggconsultancy.services/api/products?category_id=${id}`,
        TOP_SELLING: 'https://retailadmin.ggconsultancy.services/api/products/top-selling',
        ALL_PRODUCTS: 'https://retailadmin.ggconsultancy.services/api/products',
        PRODUCT_DETAIL: (slug) => `https://retailadmin.ggconsultancy.services/api/products/${slug}`
    },
    FALLBACK_IMAGE: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop',
    HERO_SLIDES: [
        { img: 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070', title: 'THE SS25<br>PREVIEW', desc: 'Experience the new era of high-fashion curation. Defined by craft and silhouette.' },
        { img: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070', title: 'FUTURE<br>CLASSICS', desc: 'Precision engineered lifestyle products. Minimalist aesthetics meets peak performance.' },
        { img: 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070', title: 'EDITORIAL<br>CURATION', desc: 'Curated by world-class stylists. Hand-picked pieces from the most coveted brands.' }
    ]
};

class RapidRetailsEngine {
    resolveImage(path) {
        if (!path) {
            const randomIndex = Math.floor(Math.random() * FALLBACK_IMAGES.length);
            return FALLBACK_IMAGES[randomIndex];
        }
        if (path.startsWith('http://') || path.startsWith('https://')) {
            return path;
        }
        return S3_BASE_URL + path;
    }

    constructor() {
        this.page = document.body.dataset.page || 'landing';
        this.cartCount = 0;
        this.slideIdx = 0;
        this.slideTimer = null;
        this.allCategories = [];
        this.mobileMenuOpen = false;
    }

    async init() {
            if (window.innerWidth <= 768) {
        const modal = document.getElementById('category-modal');
        if (modal) {
            modal.classList.remove('active');
        }
        document.body.style.overflow = '';
    }

        this.renderGlobalUI();
        this.setupCoreEvents();
        await this.loadCategoryMenu();
        this.setupMobileMenu();
        // this.setupCategoryDropdowns();
        this.setupNavItemClick();
        this.setupModalClose();

        switch (this.page) {
            case 'landing': await this.initLanding(); break;
            case 'all-categories': await this.initAllCategories(); break;
            case 'category-detail': await this.initCategoryDetail(); break;
            case 'all-products': await this.initAllProducts(); break;
            case 'product-detail': await this.initProductDetail(); break;
        }
    }

    renderGlobalUI() {
        const header = document.getElementById('site-header');
        if (header) {
            header.innerHTML = `
                <div class="header-top desktop-only">
                    GLOBAL FREE EXPRESS SHIPPING ON ALL ORDERS
                </div>
                <div class="offer-strip desktop-only">
                    10% INSTANT DISCOUNT* ON ALL CARDS <span>CLICK TO KNOW MORE ></span>
                </div>
                <div class="header-main">
                    <a href="/" class="brand-logo">AJIO STYLE</a>
                    <nav class="nav-menu desktop-only" id="desktop-nav-menu"></nav>
                    <div class="search-container desktop-only">
                        <input type="text" placeholder="Search AJIO">
                        <span class="search-icon">🔍</span>
                    </div>
                    <div class="header-actions">
                        <div class="mobile-menu-toggle mobile-only" id="menuToggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <a href="#" class="action-item desktop-only">
                            <span class="action-icon">👤</span>
                            <span class="action-text">SIGN IN / JOIN</span>
                        </a>
                        <span class="auth-separator desktop-only">|</span>
                        <a href="#" class="action-item desktop-only">
                            <span class="action-icon">❓</span>
                            <span class="action-text">CUSTOMER CARE</span>
                        </a>
                        <span class="auth-separator desktop-only">|</span>
                        <a href="#" class="action-item desktop-only">
                            <span class="action-icon">✨</span>
                            <span class="action-text">AJIOLUXE</span>
                        </a>
                        <a href="#" class="action-item">
                            <span class="action-icon">❤️</span>
                        </a>
                        <a href="#" class="action-item cart-wrap">
                            <span class="action-icon">🛒</span>
                            <span class="cart-badge">${this.cartCount}</span>
                        </a>
                    </div>
                </div>
                <div class="mobile-search mobile-only">
                    <input type="text" placeholder="Search AJIO">
                </div>
                <div class="category-menu desktop-only">
                    <div class="category-grid-menu" id="desktop-category-menu"></div>
                </div>
                <div class="mobile-category-menu" id="mobileCategoryMenu">
                    <div class="mobile-menu-header">
                        <h3>SHOP BY CATEGORY</h3>
                        <span class="mobile-menu-close" id="menuClose">&times;</span>
                    </div>
                    <div class="mobile-menu-items" id="mobileCategoryItems"></div>
                </div>
            `;
        }

        const footer = document.getElementById('site-footer');
        if (footer) {
            footer.innerHTML = `
                <div class="ajio-footer-links">
                    <div class="container">
                        <div class="ajio-footer-grid">
                            <div class="ajio-footer-col">
                                <h4>AJIO</h4>
                                <ul>
                                    <li>Who We Are</li>
                                    <li>Terms & Conditions</li>
                                    <li>We Respect Your Privacy</li>
                                    <li>Fees & Payments</li>
                                    <li>Returns & Refunds Policy</li>
                                    <li>Promotions Terms & Conditions</li>
                                    <li>Blog</li>
                                </ul>
                            </div>
                            <div class="ajio-footer-col">
                                <h4>HELP</h4>
                                <ul>
                                    <li>Track Your Order</li>
                                    <li>Frequently Asked Questions</li>
                                    <li>Returns</li>
                                    <li>Cancellations</li>
                                    <li>Payments</li>
                                    <li>Customer Care</li>
                                    <li>How Do I Redeem My Coupon</li>
                                </ul>
                            </div>
                            <div class="ajio-footer-col">
                                <h4>SHOP BY</h4>
                                <ul>
                                    <li>All</li>
                                    <li>Men</li>
                                    <li>Women</li>
                                    <li>Kids</li>
                                    <li>Indie</li>
                                    <li>Stores</li>
                                    <li>New Arrivals</li>
                                    <li>Brand Directory</li>
                                    <li>Home</li>
                                    <li>Collections</li>
                                </ul>
                            </div>
                            <div class="ajio-footer-col">
                                <h4>FOLLOW US</h4>
                                <ul>
                                    <li>Facebook</li>
                                    <li>Instagram - AJIOLife</li>
                                    <li>Instagram - AJIO LUXE</li>
                                    <li>Twitter</li>
                                    <li>Pinterest</li>
                                </ul>
                                <div class="ajio-payment-methods">
                                    <span>Net Banking</span>
                                    <span>Verified by VISA</span>
                                    <span>CASH ON DELIVERY</span>
                                    <span>Money</span>
                                </div>
                                <div class="ajio-security">
                                    <span>SSL 256 BIT ENCRYPTION</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container" style="border-top:1px solid #222; margin-top:60px; padding-top:30px; font-size:11px; color:#444">
                    <span>&copy; 2025 AJIO STYLE. ALL RIGHTS RESERVED.</span>
                </div>
            `;
        }

        const bottomNav = document.getElementById('mobile-bottom-nav');
        if (bottomNav) {
            bottomNav.innerHTML = `
                <a href="/" class="nav-item ${this.page === 'landing' ? 'active' : ''}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                    <span>Home</span>
                </a>
                <a href="/categories" class="nav-item ${this.page === 'all-categories' ? 'active' : ''}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Categories</span>
                </a>
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path></svg>
                    <span>Bag</span>
                </a>
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l9.78-9.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span>Favs</span>
                </a>
            `;
        }
    }

    setupCoreEvents() {
        document.addEventListener('click', (e) => {
            const prodCard = e.target.closest('.product-card');
            if (prodCard && prodCard.dataset.slug) {
                this.navigate(`/products/${prodCard.dataset.slug}`);
                return;
            }

            const catCard = e.target.closest('.category-card');
            if (catCard) {
                if (catCard.classList.contains('view-all-card')) {
                    this.navigate('/categories');
                } else if (catCard.dataset.id) {
                    this.navigate(`/category/${catCard.dataset.id}`);
                }
            }
        });
    }

    navigate(path) {
        window.location.href = path;
    }

    async callAPI(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const result = await response.json();
                return result;
            } else {
                console.warn('Non-JSON response received from:', url);
                return { success: false, data: [] };
            }
        } catch (error) {
            console.error('API Call Failed:', url, error);
            return { success: false, data: [] };
        }
    }

    renderLoading(container, count, html) {
        if (!container) return;
        container.innerHTML = Array(count).fill(0).map(() => html).join('');
    }

    async initLanding() {
        this.startHeroSlider();
        const catContainer = document.getElementById('category-grid');
        const prodContainer = document.getElementById('top-selling-grid');

        if (catContainer) {
            this.renderLoading(catContainer, 6, '<div class="category-card skeleton" style="height:250px"></div>');
        }
        if (prodContainer) {
            this.renderLoading(prodContainer, 4, '<div class="product-card skeleton" style="height:350px"></div>');
        }

        const [catsResponse, prodsResponse] = await Promise.all([
            this.callAPI(APP_CONFIG.ENDPOINTS.CATEGORIES),
            this.callAPI(APP_CONFIG.ENDPOINTS.TOP_SELLING)
        ]);

        let cats = [];
        if (catsResponse && catsResponse.success && catsResponse.data) {
            cats = catsResponse.data || [];
            if (!Array.isArray(cats)) cats = [];
        }

        let prods = [];
        if (prodsResponse && prodsResponse.success && prodsResponse.data) {
            if (prodsResponse.data.products && Array.isArray(prodsResponse.data.products)) {
                prods = prodsResponse.data.products;
            } else if (Array.isArray(prodsResponse.data)) {
                prods = prodsResponse.data;
            }
        }

        if (catContainer && cats.length > 0) {
            const sliced = cats.slice(0, 5);
            catContainer.innerHTML = sliced.map(c => `
                <div class="category-card" data-id="${c.id}">
                    <div class="cat-img-wrap"><img src="${this.resolveImage(c.image_url)}" loading="lazy" onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'"></div>
                    <div class="cat-overlay"><h3>${c.name}</h3></div>
                </div>
            `).join('');
            catContainer.innerHTML += `
                <div class="category-card view-all-card">
                    <span>&rarr;</span>
                    <h3>VIEW ALL</h3>
                </div>
            `;
        } else if (catContainer) {
            catContainer.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#999;padding:50px;">No categories available</p>';
        }

        if (prodContainer) {
            if (prods.length > 0) {
                prodContainer.innerHTML = prods.map(p => this.genProductCard(p)).join('');
            } else {
                prodContainer.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#999;padding:50px;">No top selling products available</p>';
            }
        }
    }

    async initAllCategories() {
        const grid = document.getElementById('full-category-grid');
        const shopForEl = document.getElementById('filter-shop-for');
        const categoryEl = document.getElementById('filter-categories');

        if (!grid) return;

        this.renderLoading(
            grid,
            8,
            '<div class="category-card skeleton" style="height:250px"></div>'
        );

        const response = await this.callAPI(APP_CONFIG.ENDPOINTS.CATEGORIES);
        const categories = response?.data || [];

        if (shopForEl) {
            shopForEl.innerHTML = categories.map(cat => `
                <li class="filter-option">
                    <input type="checkbox" class="filter-shop-for" data-id="${cat.id}">
                    <label>${cat.name}</label>
                </li>
            `).join('');
        }

        if (categoryEl) {
            categoryEl.innerHTML = categories.flatMap(cat =>
                (cat.children || []).map(child => `
                    <li class="filter-option" style="display:none">
                        <input type="checkbox" class="filter-category" data-parent="${cat.id}">
                        <label>${child.name}</label>
                    </li>
                `)
            ).join('');
        }

        grid.innerHTML = categories.map(cat => `
            <div class="category-card" data-id="${cat.id}">
                <div class="cat-img-wrap">
                    <img src="${this.resolveImage(cat.image_url)}" onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
                </div>
                <div class="cat-overlay"><h3>${cat.name}</h3></div>
            </div>
        `).join('');

        const countEl = document.getElementById('product-count');
        if (countEl) {
            countEl.innerText = categories.length;
        }
        this.allCategories = categories;

        const renderCategoryGrid = (list) => {
            grid.innerHTML = list.map(cat => `
                <div class="category-card" data-id="${cat.id}">
                    <div class="cat-img-wrap">
                        <img src="${this.resolveImage(cat.image_url)}" onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'">
                    </div>
                    <div class="cat-overlay"><h3>${cat.name}</h3></div>
                </div>
            `).join('');

            if (countEl) countEl.innerText = list.length;
        };

        renderCategoryGrid(this.allCategories);
        renderBreadcrumb({});
    }

    startHeroSlider() {
        const slider = document.getElementById('hero-slider');
        const dots = document.getElementById('slider-dots');
        if (!slider) return;

        slider.innerHTML = APP_CONFIG.HERO_SLIDES.map((s, i) => `
            <div class="slide ${i === 0 ? 'active' : ''}">
                <img src="${s.img}" class="slide-img">
                <div class="slide-content">
                    <h1>${s.title}</h1>
                    <p>${s.desc}</p>
                </div>
            </div>
        `).join('');

        if (dots) {
            dots.innerHTML = APP_CONFIG.HERO_SLIDES.map((_, i) => `<div class="dot ${i === 0 ? 'active' : ''}" data-idx="${i}"></div>`).join('');
        }

        if (this.slideTimer) clearInterval(this.slideTimer);
        this.slideTimer = setInterval(() => {
            const next = (this.slideIdx + 1) % APP_CONFIG.HERO_SLIDES.length;
            this.changeSlide(next);
        }, 6000);
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

    genProductCard(p) {
        const brand = p.brand || p.brand_name || 'AJIO EXCLUSIVES';
        const name = p.name || 'Product';
        const price = p.final_price || p.price;
        const mrp = p.mrp || null;
        const discount = p.discount ? (typeof p.discount === 'object' ? p.discount.value : p.discount) : null;
        const image = this.resolveImage(p.image_url);

        if (!price) {
            return `
                <div class="product-card" data-slug="${p.slug || ''}">
                    <div class="ajio-offer-badge">NEW</div>
                    <div class="p-img-wrap">
                        <img src="${image}" loading="lazy" onerror="this.src='${this.resolveImage()}'">
                    </div>
                    <div class="p-info">
                        <div class="p-brand">${brand}</div>
                        <div class="p-name">${name}</div>
                        <div class="p-price-row">
                            <span class="p-price">Price Coming Soon</span>
                        </div>
                    </div>
                </div>
            `;
        }

        return `
            <div class="product-card" data-slug="${p.slug || ''}">
                <div class="ajio-offer-badge">${discount ? discount + '% OFF' : 'NEW'}</div>
                <div class="p-img-wrap">
                    <img src="${image}" loading="lazy" onerror="this.src='${this.resolveImage()}'">
                </div>
                <div class="p-info">
                    <div class="p-brand">${brand}</div>
                    <div class="p-name">${name}</div>
                    <div class="p-price-row">
                        <span class="p-price">₹${price.toLocaleString()}</span>
                        ${mrp && mrp > price ? `<span class="p-mrp">₹${mrp.toLocaleString()}</span>` : ''}
                    </div>
                    <div class="ajio-instant-discount">10% INSTANT DISCOUNT* ON CARDS</div>
                </div>
            </div>
        `;
    }

    async initCategoryDetail() {
        const id = document.body.dataset.categoryId;
        const grid = document.getElementById('category-products-grid');
        const hero = document.getElementById('category-hero');

        if (!id) return;

        const [catResponse, prodsResponse] = await Promise.all([
            this.callAPI(APP_CONFIG.ENDPOINTS.CATEGORY_DETAIL(id)),
            this.callAPI(APP_CONFIG.ENDPOINTS.PRODUCTS_BY_CAT(id))
        ]);

        const cat = catResponse?.data || catResponse;
        let prods = prodsResponse?.data || prodsResponse?.products || prodsResponse || [];
        if (!Array.isArray(prods)) prods = [];

        if (cat) {
            const titleEl = document.getElementById('category-title');
            if (titleEl) titleEl.innerText = cat.name;
            if (hero) {
                hero.style.backgroundImage = `url(${this.resolveImage(cat.image_url)})`;
                hero.innerHTML = `<h1>${cat.name}</h1>`;
            }
        }

        if (grid) {
            grid.innerHTML = prods.length
                ? prods.map(p => this.genProductCard(p)).join('')
                : `<p style="grid-column:1/-1;text-align:center;color:#999">No products found</p>`;

            const countEl = document.getElementById('product-count');
            if (countEl) countEl.innerText = prods.length;
        }
    }
setupNavItemClick() {
    // Mobile par kuch mat karo
    if (window.innerWidth <= 768) return;
    
    const navItems = document.querySelectorAll('.nav-menu .nav-item'); 
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const categoryName = item.getAttribute('data-category') || item.textContent.trim();
            this.openCategoryPopup(categoryName);
        });
    });
}
openCategoryPopup(selectedCategoryName = 'MEN') {

    // 🚫 MOBILE = NEVER OPEN MODAL
    if (window.innerWidth <= 768) return;

    const modal = document.getElementById('category-modal');
    const modalBody = document.getElementById('modal-popup-body');
    if (!modal || !modalBody) return;

    modal.classList.add('active');
}


    renderSubCategoriesGrid(category) {
        const right = document.getElementById('modal-sub-cats');
        if (!right || !category) return;
        
        const children = category.children || [];
        
        if (children.length === 0) {
            right.innerHTML = '<p class="no-subcats">No subcategories available</p>';
            return;
        }
        
        const groupedChildren = this.groupSubcategories(children);
        
        let html = '';
        for (const [group, items] of Object.entries(groupedChildren)) {
            html += `
                <div class="subcat-group">
                    <h4 class="subcat-group-title">${group}</h4>
                    <div class="subcat-grid">
                        ${items.map(child => `
                            <div class="modal-sub-item">
                                <a href="/category/${child.id}" onclick="event.preventDefault(); window.app.navigate('/category/${child.id}')">
                                    ${child.name}
                                </a>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        right.innerHTML = html;
    }

    groupSubcategories(children) {
        const groups = {};
        
        children.forEach(child => {
            const firstLetter = child.name.charAt(0).toUpperCase();
            if (!groups[firstLetter]) {
                groups[firstLetter] = [];
            }
            groups[firstLetter].push(child);
        });
        
        return groups;
    }

    renderSubCategoriesInPopup(category) {
        const right = document.getElementById('modal-sub-cats');
        if (!right || !category) return;

        const children = category.children || [];

        if (children.length === 0) {
            right.innerHTML = '<p style="grid-column:1/-1; text-align:center; padding:40px;">No subcategories available</p>';
            return;
        }

        right.innerHTML = children.map(child => `
            <div class="modal-sub-item">
                <a href="/category/${child.id}" onclick="event.preventDefault(); window.app.navigate('/category/${child.id}')" 
                   style="text-decoration:none; color:#282c3f; display:block;">
                    <strong>${child.name}</strong>
                </a>
            </div>
        `).join('');
    }

    setupModalClose() {
        const modal = document.getElementById('category-modal');
        const closeBtn = document.getElementById('close-category-modal');

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.classList.remove('active');
            });
        }

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    }

    async initAllProducts() {}

    async initProductDetail() {
        const parts = window.location.pathname.split('/');
        const slug = parts[parts.length - 1];
        const main = document.getElementById('product-detail-container');
        if (!main) return;

        const response = await this.callAPI(APP_CONFIG.ENDPOINTS.PRODUCT_DETAIL(slug));
        const p = response?.data || response;

        if (p) {
            main.innerHTML = `
                <div class="product-detail-layout">
                    <div class="detail-gallery">
                        <img src="${p.image_url || this.resolveImage()}" onerror="this.src='${this.resolveImage()}'">
                    </div>
                    <div class="detail-info">
                        <div class="detail-brand">${p.brand_name || 'AJIO EXCLUSIVES'}</div>
                        <h1 class="detail-name">${p.name}</h1>
                        <div class="detail-price-row">
                            <span class="detail-price">₹${p.price ? p.price.toLocaleString() : 'N/A'}</span>
                            ${p.mrp > p.price ? `<span class="detail-mrp">₹${p.mrp.toLocaleString()}</span>` : ''}
                        </div>
                        <div class="ajio-instant-discount" style="margin:20px 0; padding:15px; background:#e6f3ff;">10% INSTANT DISCOUNT* ON AU CREDIT CARDS</div>
                        <div class="desktop-only" style="margin-top:30px">
                            <button class="btn-luxury" style="width:100%; background:black; color:white; padding: 18px">ADD TO BAG</button>
                        </div>
                    </div>
                </div>
            `;

            const mobileCTA = document.getElementById('mobile-sticky-cta');
            if (mobileCTA) {
                mobileCTA.style.display = 'flex';
                mobileCTA.innerHTML = `
                    <div style="flex:1">
                        <div style="font-weight:900; font-size:16px">₹${p.price ? p.price.toLocaleString() : 'N/A'}</div>
                        <div style="font-size:10px; color:var(--accent); font-weight:700">10% OFF ON CARDS</div>
                    </div>
                    <button class="btn-luxury" style="flex:1; background:black; color:white; padding: 12px">ADD TO BAG</button>
                `;
            }
        }
    }

    async loadCategoryMenu() {
        try {
            const response = await this.callAPI(APP_CONFIG.ENDPOINTS.CATEGORIES);
            let categories = [];

            if (response && response.success && response.data) {
                categories = response.data;
            }

            const navMenu = document.getElementById('desktop-nav-menu');
            if (navMenu) {
                const mainCategories = categories.slice(0, 5).map(c => c.name);
                const defaultCategories = ['MEN', 'WOMEN', 'KIDS', 'BEAUTY', 'HOME & KITCHEN'];
                const displayCategories = mainCategories.length ? mainCategories : defaultCategories;

                navMenu.innerHTML = displayCategories.map(name => `
                    <a href="#" class="nav-item" data-category="${name}">${name}</a>
                `).join('');
            }

            const desktopMenu = document.getElementById('desktop-category-menu');
            if (desktopMenu) {
                desktopMenu.innerHTML = '';
            }
            
            const mobileMenu = document.getElementById('mobileCategoryItems');
            if (mobileMenu) {
                mobileMenu.innerHTML = categories.map(cat => `
                    <div class="mobile-menu-category">
                        <h4><a href="/category/${cat.id}" style="color:#282c3f; text-decoration:none;">${cat.name}</a></h4>
                        <ul>
                            ${(cat.children || []).map(child => `
                                <li><a href="/category/${child.id}">${child.name}</a></li>
                            `).join('')}
                        </ul>
                    </div>
                `).join('');
            }

            this.allCategories = categories;

            if (navMenu) {
                navMenu.querySelectorAll('.nav-item').forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        const categoryName = e.target.getAttribute('data-category') || e.target.textContent.trim();
                        this.openCategoryPopup(categoryName);
                    });
                });
            }

        } catch (error) {
            console.error('Error loading category menu:', error);
            const navMenu = document.getElementById('desktop-nav-menu');
            if (navMenu) {
                navMenu.innerHTML = `
                    <a href="#" class="nav-item" data-category="MEN">MEN</a>
                    <a href="#" class="nav-item" data-category="WOMEN">WOMEN</a>
                    <a href="#" class="nav-item" data-category="KIDS">KIDS</a>
                    <a href="#" class="nav-item" data-category="BEAUTY">BEAUTY</a>
                    <a href="#" class="nav-item" data-category="HOME & KITCHEN">HOME & KITCHEN</a>
                `;
                navMenu.querySelectorAll('.nav-item').forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        const categoryName = e.target.getAttribute('data-category') || e.target.textContent.trim();
                        this.openCategoryPopup(categoryName);
                    });
                });
            }
        }
    }


    setupMobileMenu() {
        const menuToggle = document.getElementById('menuToggle');
        const menuClose = document.getElementById('menuClose');
        const mobileMenu = document.getElementById('mobileCategoryMenu');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                this.mobileMenuOpen = true;
            });
        }
        
        if (menuClose) {
            menuClose.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                this.mobileMenuOpen = false;
            });
        }
        
        document.querySelectorAll('.mobile-menu-category h4 a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const categoryName = e.target.textContent.trim();
                this.openCategoryPopup(categoryName);
                mobileMenu.classList.remove('active');
            });
        });
        
        document.addEventListener('click', (e) => {
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    this.mobileMenuOpen = false;
                }
            }
        });
    }
}

function renderBreadcrumb({ category = null, subcategory = null }) {
    const el = document.getElementById('breadcrumb');
    if (!el) return;

    let html = `<a href="/">Home</a>`;

    if (category) {
        html += `<span class="separator">/</span>
                 <a href="/categories">${category}</a>`;
    }

    if (subcategory) {
        html += `<span class="separator">/</span>
                 <span class="current">${subcategory}</span>`;
    } else {
        html += `<span class="separator">/</span>
                 <span class="current">All Departments</span>`;
    }

    el.innerHTML = html;
}

document.addEventListener('change', (e) => {
    if (!e.target.classList.contains('filter-shop-for')) return;

    const checkedIds = Array.from(
        document.querySelectorAll('.filter-shop-for:checked')
    ).map(cb => cb.dataset.id);

    document.querySelectorAll('.filter-category').forEach(cb => {
        cb.closest('li').style.display = 'none';
    });

    checkedIds.forEach(id => {
        document.querySelectorAll(
            `.filter-category[data-parent="${id}"]`
        ).forEach(cb => {
            cb.closest('li').style.display = 'flex';
        });
    });

    const filtered = checkedIds.length === 0
        ? window.app.allCategories
        : window.app.allCategories.filter(c => checkedIds.includes(String(c.id)));

    const grid = document.getElementById('full-category-grid');
    if (grid) {
        grid.innerHTML = filtered.map(cat => `
            <div class="category-card" data-id="${cat.id}">
                <div class="cat-img-wrap">
                    <img src="${window.app.resolveImage(cat.image_url)}" onerror="this.src='${window.app.resolveImage()}'">
                </div>
                <div class="cat-overlay"><h3>${cat.name}</h3></div>
            </div>
        `).join('');
    }

    const countEl = document.getElementById('product-count');
    if (countEl) countEl.innerText = filtered.length;
});

document.querySelector('.more-link')?.addEventListener('click', async (e) => {
    e.preventDefault();

    const modal = document.getElementById('category-modal');
    const left = document.getElementById('modal-parent-cats');
    const right = document.getElementById('modal-sub-cats');

    modal.classList.add('active');

    const res = await window.app.callAPI(APP_CONFIG.ENDPOINTS.CATEGORIES);
    const categories = res?.data || [];

    left.innerHTML = categories.map(c => `
        <div class="modal-parent" data-id="${c.id}">${c.name}</div>
    `).join('');

    const renderSub = (cat) => {
        right.innerHTML = (cat.children || []).map(s => `
            <label class="modal-sub"><input type="checkbox"> ${s.name}</label>
        `).join('');
    };

    if (categories.length > 0) {
        renderSub(categories[0]);
    }

    left.onclick = (e) => {
        const el = e.target.closest('.modal-parent');
        if (!el) return;
        document.querySelectorAll('.modal-parent').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        renderSub(categories.find(c => c.id == el.dataset.id));
    };
});

document.addEventListener('click', (e) => {
    if (e.target.id === 'close-category-modal' || e.target.id === 'category-modal') {
        document.getElementById('category-modal').classList.remove('active');
    }
});

function updateSubCategories() {
    const checkedParents = Array.from(
        document.querySelectorAll('.filter-shop-for:checked')
    ).map(cb => cb.dataset.id);

    document.querySelectorAll('.filter-category').forEach(cb => {
        cb.closest('li').style.display = 'none';
    });

    checkedParents.forEach(parentId => {
        document.querySelectorAll(
            `.filter-category[data-parent="${parentId}"]`
        ).forEach(cb => {
            cb.closest('li').style.display = 'flex';
        });
    });
}
// ===== CATEGORY MODAL CLOSE FIX (MOBILE + DESKTOP) =====
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('category-modal');
    const closeBtn = document.getElementById('close-category-modal');

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            modal.classList.remove('active');
            document.body.style.overflow = ''; // unlock scroll
        });
    }

    // Close when clicking on dark overlay
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

window.app = new RapidRetailsEngine();
document.addEventListener('DOMContentLoaded', () => window.app.init());