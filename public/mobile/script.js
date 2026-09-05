window.S3_BASE_URL = 'https://her-ovia.s3.us-east-1.amazonaws.com/';
window.API_BASE_URL = window.API_BASE_URL;

if (window.location.hostname !== 'localhost' && !window.location.hostname.includes('127.0.0.1')) {
    console.log = console.debug = console.info = console.warn = function() {};
}

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

class ApiClient {
    constructor(baseUrl) {
        this.baseUrl = String(baseUrl || '').replace(/\/+$/, '');
    }

    buildUrl(path) {
        if (/^https?:\/\//i.test(path)) return path;
        return `${this.baseUrl}/${String(path).replace(/^\/+/, '')}`;
    }

    async get(path, options = {}) {
        const response = await fetch(this.buildUrl(path), {
            method: 'GET',
            ...options,
            headers: {
                Accept: 'application/json',
                ...(options.headers || {}),
            },
        });

        let data;
        try {
            data = await response.json();
        } catch (_) {
            throw new Error(`Invalid JSON response (${response.status})`);
        }

        if (!response.ok) {
            const error = new Error(data?.message || `API request failed (${response.status})`);
            error.status = response.status;
            error.data = data;
            throw error;
        }

        return data;
    }

    async post(path, body, options = {}) {
        const response = await fetch(this.buildUrl(path), {
            method: 'POST',
            ...options,
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                ...(options.headers || {}),
            },
            body: JSON.stringify(body),
        });

        let data;
        try {
            data = await response.json();
        } catch (_) {
            throw new Error(`Invalid JSON response (${response.status})`);
        }

        if (!response.ok) {
            const error = new Error(data?.message || `API request failed (${response.status})`);
            error.status = response.status;
            error.data = data;
            throw error;
        }

        return data;
    }
}

class LandingService {
    constructor(api) {
        this.api = api;
        this.cacheKey = 'landing_all_data';
        this.settingsCacheKey = 'app_settings_cache';
        this.cacheTtl = 5 * 60 * 1000;
        this.settingsTtl = 1 * 60 * 1000;
        this.memoryCache = new Map();
        this.inFlight = new Map();
    }

    readCache(key) {
        const memory = this.memoryCache.get(key);
        if (memory && Date.now() - memory.timestamp < this.getTtl(key)) {
            return memory.data;
        }
        if (memory) this.memoryCache.delete(key);

        try {
            const raw = sessionStorage.getItem(key);
            if (!raw) return null;
            const parsed = JSON.parse(raw);
            if (!parsed?.timestamp || !('data' in parsed)) return null;

            const ttl = this.getTtl(key);
            if (Date.now() - parsed.timestamp >= ttl) {
                sessionStorage.removeItem(key);
                return null;
            }

            this.memoryCache.set(key, parsed);
            return parsed.data;
        } catch (_) {
            return null;
        }
    }

    getTtl(key) {
        if (key === this.settingsCacheKey) return this.settingsTtl;
        return this.cacheTtl;
    }

    writeCache(key, data) {
        const payload = { timestamp: Date.now(), data };
        this.memoryCache.set(key, payload);
        try {
            sessionStorage.setItem(key, JSON.stringify(payload));
        } catch (_) {}
    }

    normalizeProducts(response) {
        if (!response?.success || !response.data) return [];
        return Array.isArray(response.data)
            ? response.data
            : (response.data.products || []);
    }

    async getLandingData({ forceRefresh = false } = {}) {
        if (!forceRefresh) {
            const cached = this.readCache(this.cacheKey);
            if (cached) return cached;
        }

        const [categories, banners, topSelling] = await Promise.all([
            this.getCategories({ forceRefresh }),
            this.getBanners({ forceRefresh }),
            this.getTopSelling({ forceRefresh }),
        ]);

        const data = {
            categories: Array.isArray(categories) ? categories : [],
            banners: Array.isArray(banners) ? banners : [],
            products: Array.isArray(topSelling) ? topSelling : this.normalizeProducts(topSelling),
        };

        this.writeCache(this.cacheKey, data);
        return data;
    }

    async getCategories({ forceRefresh = false } = {}) {
        const cacheKey = 'categories_all';
        const cached = forceRefresh ? null : this.readCache(cacheKey);
        if (cached) return cached;

        if (!forceRefresh && this.inFlight.has(cacheKey)) {
            return this.inFlight.get(cacheKey);
        }

        const promise = this.api.get('/categories')
            .then(response => {
                const data = response?.success ? (response.data || []) : [];
                this.writeCache(cacheKey, data);
                return data;
            })
            .finally(() => {
                this.inFlight.delete(cacheKey);
            });

        this.inFlight.set(cacheKey, promise);
        return promise;
    }

    async getBanners({ forceRefresh = false } = {}) {
        const cacheKey = 'banners_all';
        const cached = forceRefresh ? null : this.readCache(cacheKey);
        if (cached) return cached;

        if (!forceRefresh && this.inFlight.has(cacheKey)) {
            return this.inFlight.get(cacheKey);
        }

        const promise = this.api.get('/banners')
            .then(response => {
                const data = response?.success ? (response.data || []) : [];
                this.writeCache(cacheKey, data);
                return data;
            })
            .finally(() => this.inFlight.delete(cacheKey));

        this.inFlight.set(cacheKey, promise);
        return promise;
    }

    async getTopSelling({ forceRefresh = false } = {}) {
        const cacheKey = 'top_selling_all';
        const cached = forceRefresh ? null : this.readCache(cacheKey);
        if (cached) return cached;

        if (!forceRefresh && this.inFlight.has(cacheKey)) {
            return this.inFlight.get(cacheKey);
        }

        const promise = this.api.get('/products/top-selling')
            .then(response => this.normalizeProducts(response))
            .then(products => {
                this.writeCache(cacheKey, products);
                return products;
            })
            .finally(() => this.inFlight.delete(cacheKey));

        this.inFlight.set(cacheKey, promise);
        return promise;
    }

    async getCategoryProducts(categoryId, { forceRefresh = false } = {}) {
        const cacheKey = `products_${categoryId}`;
        const cached = forceRefresh ? null : this.readCache(cacheKey);
        if (cached) return cached;

        const promiseKey = `category_products_${categoryId}`;
        if (!forceRefresh && this.inFlight.has(promiseKey)) {
            return this.inFlight.get(promiseKey);
        }

        const promise = this.api.get(`/categories/${encodeURIComponent(categoryId)}/products`)
            .then(response => {
                const products = response?.success ? (response?.data?.products || []) : [];
                this.writeCache(cacheKey, products);
                return products;
            })
            .finally(() => {
                this.inFlight.delete(promiseKey);
            });

        this.inFlight.set(promiseKey, promise);
        return promise;
    }

    async getAppSettings({ forceRefresh = false } = {}) {
        const cached = forceRefresh ? null : this.readCache(this.settingsCacheKey);
        if (cached) return cached;
        if (!forceRefresh && this.settingsPromise) return this.settingsPromise;

        this.settingsPromise = this.api.get('/app-settings')
            .then(response => {
                const data = response?.success ? (response.data || {}) : {};
                this.writeCache(this.settingsCacheKey, data);
                return data;
            })
            .finally(() => {
                this.settingsPromise = null;
            });

        return this.settingsPromise;
    }

    async getSearchSuggestions(query, signal) {
        return fetch(
            this.api.buildUrl(`/products/suggestions?q=${encodeURIComponent(query)}`),
            {
                signal,
                headers: { Accept: 'application/json' },
            }
        ).then(async response => {
            const data = await response.json().catch(() => null);
            if (!response.ok) {
                const error = new Error(data?.message || `Suggestion API failed (${response.status})`);
                error.status = response.status;
                throw error;
            }
            return data;
        });
    }

    getProduct(slug) {
        return this.api.get(`/products/${encodeURIComponent(slug)}`);
    }

    getUserCategoryOrder(token) {
        return this.api.get('/categories/order', {
            headers: { Authorization: `Bearer ${token}` },
        });
    }

    trackPageImpression(pageName) {
        return this.api.post('/page-impression', { page_name: pageName });
    }
}

const API = new ApiClient(window.API_BASE_URL || '');
const landingService = new LandingService(API);


class RapidRetailsEngine {
    constructor() {
        this.page = document.body.dataset.page || 'landing';
        this.slideIdx = 0;
        this.slideTimer = null;
        this.allCategories = [];
        this.allBanners = [];
        this.topSellingProducts = [];
        this.userCategories = [];
        this.isLoggedIn = !!localStorage.getItem('token');
        this.autoScrollTimer = null;
        this.scrollTimeout = null;
        this.styleResizeTimer = null;
        this.apiCache = new Map();
        this.initialized = false;
        this.settingsLoaded = false;
        this.categoriesLoaded = false;
        this.bannersLoaded = false;
        this.productsLoaded = false;
        this.loadCacheFromStorage();
    }

    loadCacheFromStorage() {
        try {
            const cached = sessionStorage.getItem('landing_cache');
            if (cached) {
                const parsed = JSON.parse(cached);
                if (Date.now() - parsed.timestamp < 300000) {
                    this.apiCache = new Map(Object.entries(parsed.data));
                }
            }
        } catch(e) {}
    }

    saveCacheToStorage() {
        try {
            const data = {
                timestamp: Date.now(),
                data: Object.fromEntries(this.apiCache)
            };
            sessionStorage.setItem('landing_cache', JSON.stringify(data));
        } catch(e) {}
    }

    async init() {
        // Rehydrate shared landing cache before first header paint when available.
        const cachedLanding = landingService.readCache(landingService.cacheKey);
        if (cachedLanding) {
            this.allCategories = cachedLanding.categories || [];
            this.allBanners = cachedLanding.banners || [];
            this.topSellingProducts = cachedLanding.products || [];
            this.categoriesLoaded = this.allCategories.length > 0;
            this.bannersLoaded = this.allBanners.length > 0;
            this.productsLoaded = this.topSellingProducts.length > 0;
        }

        // Critical UI first: never block header/navigation on API calls.
        this.renderHeader();
        this.renderBottomNav();
        this.initSearchRedirect();

        // Data loads independently in the background.
        this.fetchAppSettings().catch(() => {});

        if (this.page === 'landing') {
            this.initLanding().catch(error => {
                console.error('Landing initialization error:', error);
            });
        }

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (this.page === 'landing' && this.initialized) {
                    this.renderPromotionalBanners();
                    this.renderHeroSlider();
                    this.renderStyleSpotlight();
                }
                this.renderHeader();
            }, 250);
        });
    }

    getProductPrice(product) {
        return (product.product_price && product.product_price != "0.00")
            ? product.product_price
            : (product.final_price || product.price || 0);
    }

    getBannerImage(banner, isMobile) {
        return isMobile ? (banner.mobile_image || banner.image) : (banner.image || banner.mobile_image);
    }

    resolveImage(path) {
        if (!path) return APP_CONFIG.FALLBACK_IMAGE;
        if (path.startsWith('http')) return path;
        if (!path.includes('amazonaws.com')) return S3_BASE_URL + path;
        return path;
    }

    applyAppSettings() {
        if (!this.appSettings) return;
        const headerLogo = document.getElementById('site-logo');
        if (headerLogo && this.appSettings.header_logo) {
            headerLogo.src = this.appSettings.header_logo;
            headerLogo.onerror = function() {
                this.src = 'https://placehold.co/120x40?text=LOGO';
            };
        }
        if (this.appSettings.app_name) document.title = this.appSettings.app_name;
    }

    renderHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;
    const isDesktop = window.innerWidth >= 1025;
    if (isDesktop) {
        const hasCategories = Array.isArray(this.allCategories) && this.allCategories.length > 0;

       if (!hasCategories && !this.headerCategoriesPromise) {
            this.headerCategoriesPromise = landingService.getCategories()
                .then(categories => {
                    this.allCategories = Array.isArray(categories) ? categories : [];
                    this.categoriesLoaded = this.allCategories.length > 0;

                    if (this.allCategories.length > 0) {
                        this.renderHeader();
                    }
                })
                .catch(() => {})
                .finally(() => {
                    this.headerCategoriesPromise = null;
                });
        }

        const topCategories = hasCategories ? this.allCategories.slice(0, 5) : [];
        const categoriesHtml = topCategories.map(cat => {
            let url = `/collection/${cat.slug}`;
            if (cat.slug === "trending") url = "/top-selling";
            if (cat.slug === "bestsellers") url = "/best-selling";
            return `<a href="${url}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`;
        }).join('');
        
        header.innerHTML = `
            <div class="web-header">
                <div class="main-header">
                    <div class="logo-area">
                        <a href="/" class="logo">
                           <img
                                src="${this.appSettings?.header_logo || ''}"
                                alt=""
                                id="site-logo"
                                class="site-logo"
                                style="${this.appSettings?.header_logo ? 'display:block;' : 'display:none;'}"
                                onerror="this.style.display='none'"
                            >
                        </a>
                        <nav class="nav-menu" id="navMenu">${categoriesHtml}</nav>
                    </div>
                    <div class="search-area">
                        <div class="search-box" style="position:relative;">
                            <input type="text" id="web-search-input" placeholder="Search for " autocomplete="off">
                            <button class="search-icon-btn" aria-label="Search">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="10" cy="10" r="7"/>
                                    <line x1="21" y1="21" x2="15" y2="15"/>
                                </svg>
                            </button>
                            <div id="web-search-suggestions" class="web-search-suggestions" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="javascript:void(0)" class="action-link" onclick="if(!localStorage.getItem('token')){showLoginPopup();}else{window.location.href='/profile';}">
                            <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                                <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            Profile
                        </a>
                        <a href="/wishlist" class="action-link">
                            <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 21s-6-4.35-9-8.5C-1 6.5 4 2 8 5c2 1.5 4 3.5 4 3.5S14 6.5 16 5c4-3 9 1.5 5 7.5C18 16.65 12 21 12 21z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            Wishlist
                        </a>
                        <a href="/cart" class="action-link cart-link">
                            <span class="cart-icon-wrapper">
                                <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                    <circle cx="9" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="18" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                                    <path d="M2 2h3l3 12h11l2-8H6" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                <span id="web-cart-count-badge">0</span>
                            </span>
                            Cart
                        </a>
                    </div>
                </div>
            </div>
<div class="all-categories-popup" id="allCategoriesPopup" style="display:none; position:absolute; top:100%; left:0; width:100%; background:white; box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:9999; border-top:1px solid #f0f0f0; max-height:500px; overflow-y:auto;"></div>
        `;
        
        this.setupAllCategoriesPopup();
        this.initWebSearchDropdown();
        this.applyAppSettings();
        setTimeout(() => updateCartCountBadge(), 0);
    } else {
        const isCartPage = document.body.classList.contains('cart-page');
        const isCheckoutPage = document.body.classList.contains('checkout-page');
        const isProfilePage = document.body.classList.contains('profile-page');
        const isOrdersPage = document.body.classList.contains('orders-page');
        const isWishlistPage = document.body.classList.contains('wishlist-page');
        const isOrderConfirmationPage = document.body.classList.contains('order-confirmation-page');
        const isTermsPage = document.body.classList.contains('terms-page') || window.location.pathname === '/terms';
        const isReturnsPage = document.body.classList.contains('returns-page') || window.location.pathname === '/returns';
        const isPrivacyPage = document.body.classList.contains('privacy-page') || window.location.pathname === '/privacy-policy';
        const showBackButton = isCartPage || isCheckoutPage || isProfilePage || isOrdersPage || isWishlistPage || isOrderConfirmationPage || isTermsPage || isReturnsPage || isPrivacyPage;
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    ${showBackButton ? '<button class="back-btn-header" onclick="goBack()">←</button>' : ''}
                    <div class="logo-search-container">
                        <div class="header-logo">
                            <a href="/">
                                <img src="${this.appSettings?.header_logo || ''}" alt="Logo" class="site-logo" id="site-logo" onerror="this.style.display='none'">
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
        const input = document.getElementById("web-search-input");
        if (!input) return;

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
            let currentController = null;

            const escapeHtml = (value) => {
                const div = document.createElement("div");
                div.textContent = value ?? "";
                return div.innerHTML;
            };

            const fetchAndShowSuggestions = async (q) => {
                if (currentController) {
                    currentController.abort();
                }

                currentController = new AbortController();

                try {
                    const data = await landingService.getSearchSuggestions(
                        q,
                        currentController.signal
                    );

                    if (!data?.success || !data?.data) {
                        suggestionsBox.style.display = "none";
                        return;
                    }

                    const products = Array.isArray(data.data.products)
                        ? data.data.products
                        : [];

                    const categories = Array.isArray(data.data.categories)
                        ? data.data.categories
                        : [];

                    const subcategories = Array.isArray(data.data.subcategories)
                        ? data.data.subcategories
                        : [];

                    const brands = Array.isArray(data.data.brands)
                        ? data.data.brands
                        : [];

                    const suggestions = [
                        ...products.slice(0, 6).map(product => ({
                            name: product.name || product.product_name || "",
                            url: `/product/${encodeURIComponent(product.slug || product.id || "")}`
                        })),

                        ...categories.slice(0, 6).map(category => {
                            const slug = category.slug || slugify(category.name);

                            let url = `/collection/${encodeURIComponent(slug)}`;

                            if (slug === "trending") {
                                url = "/top-selling";
                            } else if (slug === "bestsellers") {
                                url = "/best-selling";
                            }

                            return {
                                name: category.name || "",
                                url
                            };
                        }),

                        ...subcategories.slice(0, 6).map(subcategory => {
                            const subSlug =
                                subcategory.slug || slugify(subcategory.name);

                            const parentSlug =
                                subcategory.parent?.slug ||
                                subcategory.parent_slug ||
                                (
                                    subcategory.parent?.name
                                        ? slugify(subcategory.parent.name)
                                        : ""
                                );

                            const url = parentSlug
                                ? `/collection/${encodeURIComponent(parentSlug)}/${encodeURIComponent(subSlug)}`
                                : `/collection/${encodeURIComponent(subSlug)}`;

                            return {
                                name: subcategory.name || "",
                                url
                            };
                        }),

                        ...brands.slice(0, 6).map(brand => {
                            const brandName =
                                typeof brand === "string"
                                    ? brand
                                    : brand.name || brand.brand || "";

                            return {
                                name: brandName,
                                url: `/products?search=${encodeURIComponent(brandName)}`
                            };
                        })
                    ].filter(item => item.name);

                    if (!suggestions.length) {
                        suggestionsBox.innerHTML = "";
                        suggestionsBox.style.display = "none";
                        return;
                    }

                    suggestionsBox.innerHTML = suggestions.map(item => `
                        <div
                            class="web-suggestion-item"
                            onclick="window.location.href='${item.url}'"
                        >
                            ${escapeHtml(item.name)}
                        </div>
                    `).join("");

                    suggestionsBox.style.display = "block";

                } catch (err) {
                    if (err.name !== "AbortError") {
                        console.log(err);
                    }

                    suggestionsBox.innerHTML = "";
                    suggestionsBox.style.display = "none";
                }
            };

            input.addEventListener("input", (e) => {
                clearTimeout(timer);

                const q = e.target.value.trim();

                if (q.length < 2) {
                    suggestionsBox.style.display = "none";
                    suggestionsBox.innerHTML = "";
                    return;
                }

                timer = setTimeout(() => {
                    fetchAndShowSuggestions(q);
                }, 100);
            });

            input.addEventListener("keydown", (e) => {
                if (e.key !== "Enter") return;

                e.preventDefault();

                const q = input.value.trim();

                if (!q) return;

                window.location.href =
                    `/products?search=${encodeURIComponent(q)}`;
            });

            document.addEventListener("click", (e) => {
                if (
                    !input.contains(e.target) &&
                    !suggestionsBox.contains(e.target)
                ) {
                    suggestionsBox.style.display = "none";
                }
            });

    }

    setupAllCategoriesPopup() {
    const navItems = document.querySelectorAll('.nav-item');
    const popup = document.getElementById('allCategoriesPopup');
    
    if (!navItems.length || !popup) {
        return;
    }
    
    let hideTimeout = null;
    
    const showPopup = () => {
        if (hideTimeout) clearTimeout(hideTimeout);
        this.renderAllCategoriesPopup();
        popup.style.display = 'block';
        popup.style.opacity = '1';
        popup.style.visibility = 'visible';
    };
    
    const hidePopup = () => {
        hideTimeout = setTimeout(() => {
            popup.style.display = 'none';
            popup.style.opacity = '0';
            popup.style.visibility = 'hidden';
        }, 300);
    };
    
    navItems.forEach(item => {
        item.addEventListener('mouseenter', showPopup);
        item.addEventListener('mouseleave', hidePopup);
    });
    
    popup.addEventListener('mouseenter', () => {
        if (hideTimeout) clearTimeout(hideTimeout);
        popup.style.display = 'block';
        popup.style.opacity = '1';
        popup.style.visibility = 'visible';
    });
    
    popup.addEventListener('mouseleave', hidePopup);
}
renderAllCategoriesPopup() {
    const popup = document.getElementById('allCategoriesPopup');
    if (!popup) return;
    
    if (!this.allCategories || this.allCategories.length === 0) {
        popup.innerHTML = '';
        return;
    }
    
    const categoriesWithSub = this.allCategories.filter(cat => cat.children && cat.children.length > 0);
    
    if (categoriesWithSub.length === 0) {
        let html = `<div style="max-width:1200px; margin:0 auto; padding:30px; display:grid; grid-template-columns:repeat(4,1fr); gap:20px;">`;
        this.allCategories.slice(0, 8).forEach(cat => {
            let slug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            let url = `/collection/${slug}`;
            if (slug === "trending") url = "/top-selling";
            if (slug === "bestsellers") url = "/best-selling";
            html += `<a href="${url}" style="text-decoration:none; color:#282c3f; font-size:14px; padding:10px 15px; border:1px solid #f0f0f0; border-radius:8px; text-align:center; transition:0.2s;" onmouseover="this.style.borderColor='#ff3f6c';" onmouseout="this.style.borderColor='#f0f0f0';">${cat.name}</a>`;
        });
        html += `</div>`;
        popup.innerHTML = html;
        return;
    }
    
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
                let mainSlug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                let mainUrl = `/collection/${mainSlug}`;
                if (mainSlug === "trending") mainUrl = "/top-selling";
                if (mainSlug === "bestsellers") mainUrl = "/best-selling";
                
                html += `<div style="margin-bottom:20px;">
                    <h3 style="font-size:14px; font-weight:700; color:#282c3f; margin-bottom:12px; border-bottom:2px solid #ff3f6c; padding-bottom:6px; display:inline-block;">
                        <a href="${mainUrl}" style="color:#282c3f; text-decoration:none;">${cat.name}</a>
                    </h3>
                    <ul style="list-style:none; padding:0; margin-top:12px;">`;
                    
                if (cat.children && cat.children.length > 0) {
                    cat.children.slice(0, 8).forEach(sub => {
                        let subSlug = sub.slug || sub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                        
                        let subUrl = `/collection/${mainSlug}/${subSlug}`;
                        
                        html += `<li style="margin-bottom:8px;">
                            <a href="${subUrl}" 
                               style="text-decoration:none; color:#696b79; font-size:13px; display:block; padding:4px 0; transition:color 0.2s;"
                               onmouseover="this.style.color='#ff3f6c'"
                               onmouseout="this.style.color='#696b79'">
                                ${sub.name}
                            </a>
                        </li>`;
                    });
                    
                    if (cat.children.length > 8) {
                        let slug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                        let productUrl = `/collection/${slug}`;
                        if (slug === "trending") productUrl = "/top-selling";
                        if (slug === "bestsellers") productUrl = "/best-selling";
                        html += `<li style="margin-top:5px;">
                            <a href="${productUrl}" 
                               style="color:#ff3f6c; font-size:11px; font-weight:600; text-decoration:none;">
                                +${cat.children.length - 8} more →
                            </a>
                        </li>`;
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

        if (!mobileSearchInput) return;

        let suggestionsContainer = null;
        let abortController = null;
        let debounceTimer = null;

        const escapeHtml = (value) => {
            const div = document.createElement("div");
            div.textContent = value ?? "";
            return div.innerHTML;
        };

        const getContainer = () => {
            if (!suggestionsContainer) {
                suggestionsContainer = document.createElement("div");

                suggestionsContainer.id = "mobile-search-suggestions";

                suggestionsContainer.style.cssText =
                    "position:absolute;top:100%;left:0;right:0;background:white;border-radius:0 0 12px 12px;box-shadow:0 8px 20px rgba(0,0,0,0.1);z-index:9999;max-height:300px;overflow-y:auto;display:none;border:1px solid #e0e0e0;border-top:none;";

                mobileSearchInput.parentNode.style.position = "relative";

                mobileSearchInput.parentNode.appendChild(
                    suggestionsContainer
                );
            }

            return suggestionsContainer;
        };

        const fetchSuggestions = async (query) => {

            if (abortController) {
                abortController.abort();
            }

            abortController = new AbortController();

            try {
                const data =
                    await landingService.getSearchSuggestions(
                        query,
                        abortController.signal
                    );

                const container = getContainer();

                if (!data?.success || !data?.data) {
                    container.style.display = "none";
                    return;
                }

                const products = Array.isArray(data.data.products)
                    ? data.data.products
                    : [];

                const categories = Array.isArray(data.data.categories)
                    ? data.data.categories
                    : [];

                const subcategories = Array.isArray(data.data.subcategories)
                    ? data.data.subcategories
                    : [];

                const brands = Array.isArray(data.data.brands)
                    ? data.data.brands
                    : [];

                let html = "";

                /*
                * PRODUCTS
                */
                products.slice(0, 6).forEach(product => {

                    const imageHtml = product.image_url
                        ? `
                            <img
                                src="${this.resolveImage(product.image_url)}"
                                style="width:40px;height:40px;object-fit:cover;border-radius:4px;"
                                onerror="this.style.display='none'"
                            >
                        `
                        : "";

                    html += `
                        <div
                            style="padding:12px 16px;cursor:pointer;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;gap:12px;"
                            onclick="window.location.href='/product/${encodeURIComponent(product.slug)}'"
                        >
                            ${imageHtml}

                            <div>
                                <div style="font-size:14px;font-weight:500;color:#333;">
                                    ${escapeHtml(product.name)}
                                </div>

                                <div style="font-size:12px;color:#666;">
                                    Product
                                </div>
                            </div>
                        </div>
                    `;
                });

                /*
                * CATEGORIES
                */
                categories.slice(0, 6).forEach(category => {

                    html += `
                        <div
                            style="padding:12px 16px;cursor:pointer;border-bottom:1px solid #f0f0f0;"
                            onclick="window.location.href='/collection/${encodeURIComponent(category.slug)}'"
                        >
                            <div style="font-size:14px;font-weight:500;color:#333;">
                                ${escapeHtml(category.name)}
                            </div>

                            <div style="font-size:12px;color:#666;">
                                Category
                            </div>
                        </div>
                    `;
                });

                /*
                * SUBCATEGORIES
                */
                subcategories.slice(0, 6).forEach(subcategory => {

                    const parentSlug =
                        subcategory.parent?.slug;

                    const url = parentSlug
                        ? `/collection/${encodeURIComponent(parentSlug)}/${encodeURIComponent(subcategory.slug)}`
                        : `/collection/${encodeURIComponent(subcategory.slug)}`;

                    html += `
                        <div
                            style="padding:12px 16px;cursor:pointer;border-bottom:1px solid #f0f0f0;"
                            onclick="window.location.href='${url}'"
                        >
                            <div style="font-size:14px;font-weight:500;color:#333;">
                                ${escapeHtml(subcategory.name)}
                            </div>

                            <div style="font-size:12px;color:#666;">
                                Subcategory
                            </div>
                        </div>
                    `;
                });

                /*
                * BRANDS
                */
                brands.slice(0, 6).forEach(brand => {

                    const brandName =
                        typeof brand === "string"
                            ? brand
                            : brand.name;

                    html += `
                        <div
                            style="padding:12px 16px;cursor:pointer;border-bottom:1px solid #f0f0f0;"
                            onclick="window.location.href='/products?search=${encodeURIComponent(brandName)}'"
                        >
                            <div style="font-size:14px;font-weight:500;color:#333;">
                                ${escapeHtml(brandName)}
                            </div>

                            <div style="font-size:12px;color:#666;">
                                Brand
                            </div>
                        </div>
                    `;
                });

                if (!html) {
                    container.innerHTML = `
                        <div style="padding:16px;color:#999;text-align:center;">
                            No results found
                        </div>
                    `;
                } else {
                    container.innerHTML = html;
                }

                container.style.display = "block";

            } catch (e) {
                if (e.name !== "AbortError") {
                    console.log(e);
                }
            }
        };

        mobileSearchInput.addEventListener("input", (e) => {

            const query = e.target.value.trim();

            const container = getContainer();

            clearTimeout(debounceTimer);

            if (query.length < 2) {
                container.style.display = "none";
                container.innerHTML = "";
                return;
            }

            debounceTimer = setTimeout(() => {
                fetchSuggestions(query);
            }, 100);
        });

        mobileSearchInput.addEventListener("keydown", (e) => {

            if (e.key !== "Enter") return;

            e.preventDefault();

            const query = mobileSearchInput.value.trim();

            if (query) {
                window.location.href =
                    `/products?search=${encodeURIComponent(query)}`;
            }
        });

        document.addEventListener("click", (e) => {

            const container =
                document.getElementById(
                    "mobile-search-suggestions"
                );

            if (
                container &&
                !mobileSearchInput.contains(e.target) &&
                !container.contains(e.target)
            ) {
                container.style.display = "none";
            }
        });
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
                        <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                        <circle cx="20" cy="21" r="1.5" fill="currentColor"/>
                    </svg>
                    <span id="cart-count-badge" style="position: absolute; top: -6px; right: -10px; background: red; color: white; font-size: 11px; padding: 2px 6px; border-radius: 50%; display: none;">0</span>
                </div>
                <span>Cart</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-figma ${activePage === 'profile' ? 'active' : ''}" onclick="if(!localStorage.getItem('token')){showLoginPopup();}else{window.location.href='/profile';}">
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
        const cached = landingService.readCache(landingService.cacheKey);

        if (cached) {
            this.allCategories = cached.categories || [];
            this.allBanners = cached.banners || [];
            this.topSellingProducts = cached.products || [];
            this.categoriesLoaded = true;
            this.bannersLoaded = true;
            this.productsLoaded = true;

            await this.renderAllSections();
            this.initialized = true;
            this.hideSkeleton();

            this.refreshLandingData();
            return;
        }

        try {
            const data = await landingService.getLandingData();

            this.allCategories = data.categories || [];
            this.allBanners = data.banners || [];
            this.topSellingProducts = data.products || [];
            this.categoriesLoaded = true;
            this.bannersLoaded = true;
            this.productsLoaded = true;

            if (this.isLoggedIn) {
                this.fetchUserCategoryOrder().catch(() => {});
            }

            await this.renderAllSections();
            this.initialized = true;
            this.hideSkeleton();

        } catch (error) {
            console.error('Landing data error:', error);
            this.hideSkeleton();
        }
    }

    async renderAllSections() {
        // Critical above-the-fold/primary sections.
        await Promise.all([
            this.renderHeroSlider(),
            this.renderTrending(),
            this.renderPromotionalBanners(),
            this.renderStyleSpotlight(),
            this.renderDynamicCollections(),
            this.renderFeaturedLook(),
            this.renderTwoCollections(),
            this.renderMidBanner()
        ]);

        // Secondary section must never block the first paint.
        const renderFeatured = () => {
            this.renderFeaturedCollections().catch(() => {});
        };

        if ('requestIdleCallback' in window) {
            window.requestIdleCallback(renderFeatured, { timeout: 1200 });
        } else {
            setTimeout(renderFeatured, 0);
        }
    }

    hideSkeleton() {
        const skeleton = document.getElementById('skeleton-loader');
        const realContent = document.getElementById('real-content');
        if (skeleton) skeleton.style.display = 'none';
        if (realContent) realContent.style.display = 'block';
    }

    async refreshLandingData() {
        setTimeout(async () => {
            try {
                const data = await landingService.getLandingData({ forceRefresh: true });

                const changed =
                    JSON.stringify(data.categories) !== JSON.stringify(this.allCategories) ||
                    JSON.stringify(data.banners) !== JSON.stringify(this.allBanners) ||
                    JSON.stringify(data.products) !== JSON.stringify(this.topSellingProducts);

                if (!changed) return;

                this.allCategories = data.categories || [];
                this.allBanners = data.banners || [];
                this.topSellingProducts = data.products || [];

                await this.renderAllSections();
            } catch (_) {}
        }, 3000);
    }

    async fetchUserCategoryOrder() {
        try {
            const token = localStorage.getItem('token');
            if (!token) return;

            const data = await landingService.getUserCategoryOrder(token);
            if (data?.success && Array.isArray(data.data) && data.data.length > 0) {
                this.userCategories = data.data;
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
            const bannerImage = this.getBannerImage(b, isMobile);
            return `<div class="slide ${i === 0 ? 'active' : ''}">
                <img src="${this.resolveImage(bannerImage)}" class="slide-img-figma" alt="${b.title || 'Banner'}" loading="${i === 0 ? 'eager' : 'lazy'}" fetchpriority="${i === 0 ? 'high' : 'auto'}">
                ${hasText ? `<div class="slide-content-figma">
                    <h1>${b.title || ''}</h1>
                    <p>${b.subtitle || ''}</p>
                    <button class="shop-now-btn" onclick="window.location.href='${b.button_link || '#'}'">${b.button_text || 'Shop Now'}</button>
                </div>` : ''}
            </div>`;
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
        }, 7000);
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
        if (this.settingsLoaded) return;

        try {
            this.appSettings = await landingService.getAppSettings();
            this.settingsLoaded = true;
            this.applyAppSettings();
        } catch (error) {
            console.error('Error loading app settings:', error);
        }
    }

    async renderPromotionalBanners() {
        const banners = this.allBanners.filter(b => b.position === 'mid');
        const container1 = document.getElementById('mid-banner-1-container');
        const container2 = document.getElementById('mid-banner-2-container');
        if (!banners.length) return;
        if (container2) container2.innerHTML = '';
        const isMobile = window.innerWidth < 768;
        const createBannerHTML = (b) => {
            const bannerImage = this.getBannerImage(b, isMobile);
            const hasText = b.title || b.subtitle || b.button_text;
            return `
                <div style="position: relative; border-radius: 16px; overflow: hidden; background: #f5f5f5; height: 100%;">
                    <img src="${this.resolveImage(bannerImage)}" style="width: 100%; height: auto; display: block;" loading="lazy">
                    ${hasText ? `
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 20px; color: white;">
                            ${b.title ? `<h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">${b.title}</h3>` : ''}
                            ${b.subtitle ? `<p style="font-size: 12px; margin-bottom: 8px;">${b.subtitle}</p>` : ''}
                            ${b.button_text ? `<button onclick="window.location.href='${b.button_link || '#'}'" style="background: #fff; color: #000; border: none; padding: 6px 16px; border-radius: 30px; font-size: 12px; font-weight: 600; cursor: pointer;">${b.button_text}</button>` : ''}
                        </div>
                    ` : ''}
                </div>
            `;
        };
        if (banners.length === 2) {
            const b1 = banners[0],
                b2 = banners[1];
            if (container1) {
                container1.innerHTML = `
                    <div style="display: flex; gap: 16px; width: 100%; margin: 20px 0;">
                        <div style="flex: 1; min-width: 0;">${createBannerHTML(b1)}</div>
                        <div style="flex: 1; min-width: 0;">${createBannerHTML(b2)}</div>
                    </div>
                `;
            }
        } else if (banners.length > 2) {
            if (container1) {
                let bannersHtml = `<div class="mid-banner-carousel" id="midBannerCarousel">
                    <div class="mid-banner-track" id="midBannerTrack" style="display: flex; gap: 12px; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; padding: 8px 0;">`;
                banners.forEach(b => {
                    bannersHtml += `<div class="mid-banner-slide" style="flex: 0 0 85%; scroll-snap-align: start; min-width: 85%;">${createBannerHTML(b)}</div>`;
                });
                bannersHtml += `</div></div>`;
                container1.innerHTML = bannersHtml;
                this.startMidBannerAutoScroll();
            }
        } else if (banners.length === 1) {
            const b = banners[0];
            if (container1) container1.innerHTML = createBannerHTML(b);
        }
    }

    startMidBannerAutoScroll() {
        const track = document.getElementById('midBannerTrack');
        if (!track) return;
        let autoScrollInterval;
        let isHovering = false;
        const slides = document.querySelectorAll('.mid-banner-slide');
        if (slides.length <= 1) return;

        function autoScroll() {
            if (isHovering) return;
            const maxScroll = track.scrollWidth - track.clientWidth;
            if (track.scrollLeft + 10 >= maxScroll) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: track.clientWidth * 0.8, behavior: 'smooth' });
            }
        }

        function startScroll() {
            if (autoScrollInterval) clearInterval(autoScrollInterval);
            autoScrollInterval = setInterval(autoScroll, 3000);
        }

        function stopScroll() {
            if (autoScrollInterval) clearInterval(autoScrollInterval);
        }
        track.addEventListener('mouseenter', () => { isHovering = true;
            stopScroll(); });
        track.addEventListener('mouseleave', () => { isHovering = false;
            startScroll(); });
        track.addEventListener('touchstart', () => { isHovering = true;
            stopScroll(); });
        track.addEventListener('touchend', () => { isHovering = false;
            startScroll(); });
        startScroll();
    }

    async renderTrending() {
        const container = document.getElementById('trending-slider');
        if (!container) return;
        let categories = this.allCategories || [];
        if (categories.length === 0) {
            return;
        }
        categories = categories.slice(0, 5);
        if (!categories.length) return;
        const gradients = [
            { bg: "linear-gradient(135deg, #F0F5FF, #E0ECFF)", border: "#C0D4FF" },
            { bg: "linear-gradient(135deg, #FFF8F0, #FFE8D9)", border: "#FFD9B5" },
            { bg: "linear-gradient(135deg, #FFF0F5, #FFE0EC)", border: "#FFC0D0" },
            { bg: "linear-gradient(135deg, #F0FFF0, #E0FFE0)", border: "#C0FFC0" },
            { bg: "linear-gradient(135deg, #FFF5E6, #FFE8CC)", border: "#FFD9A3" }
        ];
        container.innerHTML = categories.map((cat, idx) => {
            const bgGradient = gradients[idx % gradients.length];
            const imageUrl = this.resolveImage(cat.image_url) || 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
            return `<div class="trending-card" style="background: ${bgGradient.bg} !important; border: 1px solid ${bgGradient.border} !important;" onclick="redirectToSubcategory(${cat.id})">
                <div class="trending-card-content">
                    <div class="trending-main">${cat.name}</div>
                    <div class="trending-sub">Shop Collection</div>
                    <span class="shop-now-link">SHOP NOW</span>
                </div>
                <div class="trending-img-wrap">
                    <img src="${imageUrl}" alt="${cat.name}" loading="lazy" width="85" height="85" decoding="async">
                </div>
            </div>`;
        }).join('');
        this.setupAutoScroll(container);
    }

    setupAutoScroll(container) {
        if (this.autoScrollTimer) clearInterval(this.autoScrollTimer);
        const slider = container;
        let isPaused = false;
        let resetting = false;
        const scrollSpeed = 0.8;
        const intervalTime = 40;
        slider.addEventListener('mouseenter', () => { isPaused = true;
            slider.classList.remove('scrolling'); });
        slider.addEventListener('mouseleave', () => { isPaused = false; });
        slider.addEventListener('touchstart', () => { isPaused = true;
            slider.classList.remove('scrolling'); });
        slider.addEventListener('touchend', () => { isPaused = false; });
        slider.addEventListener('scroll', () => {
            if (resetting) return;
            slider.classList.add('scrolling');
            if (this.scrollTimeout) clearTimeout(this.scrollTimeout);
            this.scrollTimeout = setTimeout(() => slider.classList.remove('scrolling'), 500);
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 5) {
                resetting = true;
                setTimeout(() => {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                    setTimeout(() => resetting = false, 500);
                }, 100);
            }
        });
        this.autoScrollTimer = setInterval(() => {
            if (isPaused || resetting) return;
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 5) {
                resetting = true;
                slider.scrollTo({ left: 0, behavior: 'smooth' });
                setTimeout(() => resetting = false, 500);
            } else {
                slider.scrollLeft += scrollSpeed;
            }
        }, intervalTime);
    }

    async renderStyleSpotlight() {
        const container = document.getElementById('style-spotlight-grid');
        if (!container) return;
        let displayItems = this.topSellingProducts.slice(0, 8);
        if (!displayItems.length) {
            return;
        }
        const itemsHtml = displayItems.map(item => {
            const brand = item.brand || 'Premium Brand';
            const name = item.name || 'Fashion Item';
            const rating = item.rating || '4.5';
            const current = this.getProductPrice(item);
            const mainImage = this.resolveImage(item.image_url);
            const hoverImageUrl = item.hoverImage || mainImage;
            return `<div class="spotlight-card" onclick="window.location.href='/product/${item.slug || '#'}'">
                <div class="spotlight-card-img">
                    <img src="${mainImage}" 
                        alt="${brand} ${name}"
                        data-main="${mainImage}"
                        data-hover="${hoverImageUrl}"
                        onmouseenter="this.src=this.dataset.hover"
                        onmouseleave="this.src=this.dataset.main"
                        onerror="this.src='${APP_CONFIG.FALLBACK_IMAGE}'" 
                        loading="lazy" 
                        width="200" 
                        height="200" 
                        decoding="async">
                     <div class="rating-badge">★ <span>${rating}</span></div>
                </div>
                <div class="spotlight-card-info">
                    <div class="card-brand">${brand}</div>
                    <div class="card-title">${name.length > 35 ? name.substring(0, 35) + '...' : name}</div>
                    <div class="card-price">
                        <span class="current-price">₹${current}</span>
                    </div>
                    <button class="add-to-cart" onclick="event.stopPropagation(); window.location.href='/product/${item.slug}'" aria-label="Explore ${name}">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                            <circle cx="20" cy="21" r="1.5" fill="currentColor"/>
                        </svg>
                        Explore
                    </button>
                </div>
            </div>`;
        }).join('');
        container.innerHTML = `<div class="style-spotlight-section">
            <div class="spotlight-header">
                <h2>Style Spotlight</h2>
               <a href="/top-selling" class="spotlight-viewall">View All →</a>
            </div>
            <div class="spotlight-grid">${itemsHtml}</div>
        </div>`;
    }

    async loadSpotlightHoverImage(img) {
        if (!img) return;

        if (img.dataset.hoverLoaded === 'true') {
            if (img.dataset.hover) img.src = img.dataset.hover;
            return;
        }

        const slug = img.dataset.productSlug;
        if (!slug || img.dataset.hoverLoaded === 'loading') return;

        img.dataset.hoverLoaded = 'loading';

        try {
            const data = await landingService.getProduct(slug);
            const galleryImages = data?.success ? (data.data?.gallery_images || []) : [];
            const hoverImage = galleryImages[1] || galleryImages[0];

            if (hoverImage) {
                const resolved = this.resolveImage(hoverImage);
                img.dataset.hover = resolved;
                img.src = resolved;
            }

            img.dataset.hoverLoaded = 'true';
        } catch (_) {
            img.dataset.hoverLoaded = 'true';
        }
    }

    renderDynamicCollections() {
        const container = document.getElementById('dynamic-collections');
        if (!container) return;
        const categories = this.allCategories || [];
        if (categories.length === 0) {
            setTimeout(() => this.renderDynamicCollections(), 100);
            return;
        }
        const displayCategories = categories.slice(0, 3);
        const numbers = ['01', '02', '03'];
        const titles = ['THE TIMELESS EDIT', 'MODERN EASE', 'AFTER DARK'];
        const linkTexts = ['Explore the collection →', 'Explore co-ords →', 'Explore occasion wear →'];
        let html = '';
        displayCategories.forEach((cat, index) => {
            const isLarge = index === 0;
            const number = numbers[index] || `0${index + 1}`;
            const title = titles[index] || cat.name.toUpperCase();
            const slug = cat.slug || cat.name.toLowerCase().replace(/\s+/g, '-');
            const imageUrl = this.resolveImage(cat.image_url) || '';
            const linkText = linkTexts[index] || `Explore ${cat.name.toLowerCase()} →`;
            html += `
                <article class="herovia-collection-card ${isLarge ? 'large' : 'small'}" 
                         id="${slug}"
                         onclick="window.location.href='/collection/${slug}'">
                    <div class="herovia-collection-image" 
                         style="${imageUrl ? `background-image: url('${imageUrl}'); background-size: cover; background-position: center;` : 'background: linear-gradient(135deg, #ede8e2, #d5ccc4);'}">
                    </div>
                    <div class="herovia-collection-overlay">
                        <p>${number} · ${title}</p>
                        <h3>${cat.name}</h3>
                        <a href="/collection/${slug}">${linkText}</a>
                    </div>
                </article>
            `;
        });
        container.innerHTML = html;
    }

    async renderFeaturedCollections() {
        const container = document.getElementById('dynamic-featured-collections');
        if (!container) return;

        const categories = this.allCategories || [];

        if (!categories.length) {
            return;
        }

        // First 3 main categories
        const mainCategories = categories.slice(0, 3);

        const labels = ['EVERYDAY', 'WEDDING', 'FESTIVE'];

        const descs = [
            'Timeless pieces for your most beautiful day.',
            'Celebrate every moment with effortless elegance.',
            'Effortless style for the woman on the go.'
        ];

        try {
            const categoryProducts = await Promise.all(
                mainCategories.map(async (mainCategory) => {

                    // First subcategory
                    const firstSubCategory = mainCategory?.children?.[0];

                    if (!firstSubCategory) {
                        return {
                            category: mainCategory,
                            product: null
                        };
                    }

                    // If first subcategory has sub-subcategories,
                    // use first sub-subcategory.
                    const firstSubSubCategory = firstSubCategory?.children?.[0];

                    const targetCategory = firstSubSubCategory || firstSubCategory;

                    const products = await landingService.getCategoryProducts(
                        targetCategory.id
                    );

                    return {
                        category: mainCategory,
                        product: products?.[0] || null
                    };
                })
            );

            let html = `<div class="herovia-featured-cards-grid">`;

            categoryProducts.forEach(({ category, product }, index) => {

                if (!product) {
                    return;
                }

                const productName = product.name || 'Product';
                const productSlug = product.slug || product.id || '#';
                const productPrice = this.getProductPrice(product);

                const productImage =
                    product.gallery_images?.length
                        ? this.resolveImage(product.gallery_images[0])
                        : this.resolveImage(product.image_url);

                const label = labels[index] || 'TOP PICK';

                let desc = descs[index] || 'Premium quality product';

                if (product.short_description) {
                    desc = product.short_description;
                } else if (product.description) {
                    desc = product.description.length > 80
                        ? product.description.substring(0, 80) + '...'
                        : product.description;
                }

                html += `
                    <div class="herovia-featured-card"
                        onclick="window.location.href='/product/${productSlug}'">

                        <div class="herovia-featured-card-image"
                            style="${productImage
                                ? `background-image: url('${productImage}'); background-size: cover; background-position: center;`
                                : 'background: linear-gradient(135deg, #ede8e2, #d5ccc4);'}">

                            <span class="herovia-featured-card-tag">
                                ${label}
                            </span>

                        </div>

                        <div class="herovia-featured-card-content">

                            <h3>${productName}</h3>

                            <p>${desc}</p>

                            <div class="herovia-featured-card-bottom">

                                <span class="herovia-featured-card-price">
                                    ₹${productPrice}
                                </span>

                                <a href="/product/${productSlug}"
                                class="herovia-featured-card-link">
                                    Explore →
                                </a>

                            </div>

                        </div>
                    </div>
                `;
            });

            html += `</div>`;

            container.innerHTML = html;

        } catch (error) {
            console.error('Featured collections loading error:', error);
            container.innerHTML = '';
        }
    }

    renderFeaturedLook() {
        const container = document.getElementById('dynamic-featured');
        if (!container) return;
        
        const products = this.topSellingProducts || [];
        if (products.length === 0) {
            container.innerHTML = `
                <div class="herovia-featured-box">
                    <div class="herovia-featured-box-inner">
                        <div class="herovia-featured-box-image-wrapper">
                            <div class="herovia-featured-box-main">
                                <img src="/azure-poise-suit.png" alt="Azure Poise Suit" id="featured-main-image-fallback" loading="lazy">
                            </div>
                            <div class="herovia-featured-box-thumbs">
                                <div class="herovia-featured-box-thumb active" onclick="changeFeaturedImageFallback('/azure-poise-suit.png', this)">
                                    <img src="/azure-poise-suit.png" alt="View 1" loading="lazy">
                                </div>
                                <div class="herovia-featured-box-thumb" onclick="changeFeaturedImageFallback('/azure-poise-suit.png', this)">
                                    <img src="/azure-poise-suit.png" alt="View 2" loading="lazy">
                                </div>
                                <div class="herovia-featured-box-thumb" onclick="changeFeaturedImageFallback('/azure-poise-suit.png', this)">
                                    <img src="/azure-poise-suit.png" alt="View 3" loading="lazy">
                                </div>
                            </div>
                        </div>
                        <div class="herovia-featured-box-content">
                            <p class="herovia-featured-box-eyebrow">New arrival · The Everyday Edit</p>
                            <h2 class="herovia-featured-box-title">The Azure<br><em>Poise Suit.</em></h2>
                            <p class="herovia-featured-box-desc">A rich cobalt-blue kurta set designed for polished days and easy evenings. Delicate floral motifs, a softly scalloped neckline and a fluid matching dupatta bring quiet detail to its clean, confident silhouette.</p>
                            <ul class="herovia-featured-box-details">
                                <li>Three-piece suit set</li>
                                <li>Plain three-quarter sleeves</li>
                                <li>Straight-fit trousers</li>
                                <li>Lightweight matching dupatta</li>
                            </ul>
                            <div class="herovia-featured-box-action">
                                <span class="herovia-featured-box-price">₹4,999</span>
                                <a class="herovia-featured-box-btn" href="#contact">Enquire to order <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            window.changeFeaturedImageFallback = function(imageSrc, element) {
                const mainImg = document.getElementById('featured-main-image-fallback');
                if (mainImg) mainImg.src = imageSrc;
                document.querySelectorAll('.herovia-featured-box-thumb').forEach(el => el.classList.remove('active'));
                if (element) element.classList.add('active');
            };
            return;
        }
        
        const product = products[0];
        const name = product.name || 'Product';
        const brand = product.brand || 'Her-Ovia';
        let description = product.short_description || product.description || 'Premium quality product';
        if (description.length > 200) {
            description = description.substring(0, 200) + '...';
        }
        const price = this.getProductPrice(product);
        const slug = product.slug || '#';
        let detailsHtml = '';
        if (product.attributes && Array.isArray(product.attributes) && product.attributes.length > 0) {
            detailsHtml = product.attributes.slice(0, 4).map(d => `<li>${d}</li>`).join('');
        } else if (product.product_details && Array.isArray(product.product_details) && product.product_details.length > 0) {
            detailsHtml = product.product_details.slice(0, 4).map(d => `<li>${d}</li>`).join('');
        } else if (product.specifications && typeof product.specifications === 'object') {
            const keys = Object.keys(product.specifications).slice(0, 4);
            detailsHtml = keys.map(key => `<li>${key}: ${product.specifications[key]}</li>`).join('');
        } else {
            const catName = product.category?.name || '';
            if (catName) {
                detailsHtml = `<li>Category: ${catName}</li><li>Premium quality</li><li>Best seller</li>`;
            } else {
                detailsHtml = `<li>Premium quality</li><li>Best seller</li><li>Limited edition</li>`;
            }
        }
        const galleryImages = product.gallery_images || [];
        const mainImage = galleryImages.length > 0 
            ? this.resolveImage(galleryImages[0]) 
            : this.resolveImage(product.image_url) || 'https://placehold.co/600x800?text=HER-OVIA';
        const thumbnails = galleryImages.slice(1, 5).map(img => this.resolveImage(img));
        while (thumbnails.length < 3) { thumbnails.push(mainImage); }
        let thumbnailsHtml = thumbnails.map((thumb, idx) => `
            <div class="herovia-featured-box-thumb ${idx === 0 ? 'active' : ''}" 
                 onclick="changeFeaturedImage('${thumb}', this)">
                <img src="${thumb}" alt="${name} view ${idx + 2}" loading="lazy" onerror="this.src='https://placehold.co/150x180?text=HER-OVIA'">
            </div>
        `).join('');
        container.innerHTML = `
            <div class="herovia-featured-box">
                <div class="herovia-featured-box-inner">
                    <div class="herovia-featured-box-image-wrapper">
                        <div class="herovia-featured-box-main">
                            <img src="${mainImage}" alt="${name}" id="featured-main-image" loading="lazy" onerror="this.src='https://placehold.co/600x800?text=HER-OVIA'">
                        </div>
                        <div class="herovia-featured-box-thumbs">${thumbnailsHtml}</div>
                    </div>
                    <div class="herovia-featured-box-content">
                        <p class="herovia-featured-box-eyebrow">New arrival · The Everyday Edit</p>
                        <h2 class="herovia-featured-box-title">${name}<br><em>${brand}</em></h2>
                        <p class="herovia-featured-box-desc">${description}</p>
                        <ul class="herovia-featured-box-details">${detailsHtml}</ul>
                        <div class="herovia-featured-box-action">
                            <span class="herovia-featured-box-price">₹${price}</span>
                            <a class="herovia-featured-box-btn" href="/product/${slug}">Enquire to order <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        window.changeFeaturedImage = function(imageSrc, element) {
            const mainImage = document.getElementById('featured-main-image');
            if (mainImage) mainImage.src = imageSrc;
            document.querySelectorAll('.herovia-featured-box-thumb').forEach(el => el.classList.remove('active'));
            if (element) element.classList.add('active');
        };
    }

    renderTwoCollections() {
        const container = document.getElementById('dynamic-two-collections');
        if (!container) return;
        const categories = this.allCategories || [];
        if (categories.length === 0) {
            setTimeout(() => this.renderTwoCollections(), 200);
            return;
        }
        const displayCategories = categories.slice(0, 2);
        const titles = ['Modern Ease', 'Celebration Edit'];
        const numbers = ['01', '02'];
        const prices = ['₹4,799', '₹5,999'];
        const descs = [
            'A softly structured ivory tunic with wide-leg trousers, finished with rich botanical appliqué and delicate collar and cuff details.',
            'A luminous peach three-piece ensemble with an ornate jewel-toned neckline, flowing sharara and a weightless coordinated dupatta.'
        ];
        let html = '';
        displayCategories.forEach((cat, index) => {
            const subcategory = (cat.children && cat.children.length > 0) ? cat.children[0] : null;
            const subName = subcategory ? subcategory.name : cat.name;
            const subSlug = subcategory ? subcategory.slug : cat.slug;
            const imageUrl = this.resolveImage(subcategory?.image_url || cat.image_url) || '';
            html += `
                <article class="herovia-two-collection"
                    onclick="window.location.href='/collection/${subSlug || '#'}'">
                    <div class="herovia-two-collection-image">
                        <img src="${imageUrl || 'https://placehold.co/600x700?text=HER-OVIA'}"
                            alt="${subName}"
                            loading="lazy"
                            onerror="this.src='https://placehold.co/600x700?text=HER-OVIA'">
                        <span class="herovia-two-collection-badge">
                            ${cat.name.toUpperCase()}
                        </span>
                    </div>
                    <div class="herovia-two-collection-info">
                        <div>
                            <p>${titles[index] || 'Collection'} · ${numbers[index] || '0' + (index + 1)}</p>
                            <h3>${subName}</h3>
                        </div>
                        <strong>${prices[index] || '₹4,999'}</strong>
                    </div>
                    <p class="herovia-two-collection-desc">
                        ${descs[index] || 'Premium quality product from ' + cat.name}
                    </p>
                    <a href="/collection/${subSlug || '#'}">
                        Enquire to order <span aria-hidden="true">→</span>
                    </a>
                </article>
            `;
        });
        container.innerHTML = html;
    }

    renderMidBanner() {
        const container = document.getElementById('dynamic-mid-banner');
        if (!container) return;
        const midBanners = this.allBanners.filter(b => b.position === 'mid' || b.position === 'packaging');
        const bannersToShow = midBanners.slice(-3);
        if (bannersToShow.length === 0) {
            container.innerHTML = `
                <div class="herovia-packaging-inner">
                    <div class="herovia-packaging-image">
                        <img src="/her-ovia-packaging.png" alt="Her-Ovia packaging" loading="lazy">
                    </div>
                    <div class="herovia-packaging-copy">
                        <p class="herovia-eyebrow">The Her-Ovia experience</p>
                        <h2>Wrapped like the<br>luxury it holds.</h2>
                        <p>Every Her-Ovia piece is thoughtfully folded, protected in soft tissue and presented in our signature maroon-and-cream rigid gift box.</p>
                        <div class="herovia-packaging-specs">
                            <span>Signature rigid box</span>
                            <span>Tissue wrapped</span>
                            <span>Delivered with care</span>
                        </div>
                    </div>
                </div>
            `;
            return;
        }
        if (bannersToShow.length === 1) {
            const b = bannersToShow[0];
            const isMobile = window.innerWidth < 768;
            const bannerImage = this.getBannerImage(b, isMobile);
            const title = b.title || 'The Her-Ovia experience';
            const description = b.description || 'Every Her-Ovia piece is thoughtfully folded, protected in soft tissue.';
            container.innerHTML = `
                <div class="herovia-packaging-inner">
                    <div class="herovia-packaging-image">
                        <img src="${this.resolveImage(bannerImage)}" alt="${title}" loading="lazy" onerror="this.src='https://placehold.co/600x400?text=HER-OVIA'">
                    </div>
                    <div class="herovia-packaging-copy">
                        <p class="herovia-eyebrow">${b.position === 'mid' ? 'Featured' : 'The Her-Ovia experience'}</p>
                        <h2>${title}</h2>
                        <p>${description}</p>
                        <div class="herovia-packaging-specs">
                            <span>Signature rigid box</span>
                            <span>Tissue wrapped</span>
                            <span>Delivered with care</span>
                        </div>
                    </div>
                </div>
            `;
            return;
        }
        const bannerCount = bannersToShow.length;
        const gridClass = `banners-${bannerCount}`;
        let html = `<div class="herovia-mid-grid ${gridClass}">`;
        bannersToShow.forEach((b) => {
            const isMobile = window.innerWidth < 768;
            const bannerImage = this.getBannerImage(b, isMobile);
            const title = b.title || 'Her-Ovia';
            const description = b.description || 'Premium quality';
            const buttonText = b.button_text || 'Explore Now';
            const buttonLink = b.button_link || '#';
            html += `
                <div class="herovia-mid-card" onclick="window.location.href='${buttonLink}'">
                    <img src="${this.resolveImage(bannerImage)}" alt="${title}" loading="lazy" onerror="this.src='https://placehold.co/600x340?text=HER-OVIA'">
                    <div class="herovia-mid-overlay">
                        <h3>${title}</h3>
                        <p>${description}</p>
                        <span class="herovia-mid-btn">${buttonText}</span>
                    </div>
                </div>
            `;
        });
        html += `</div>`;
        container.innerHTML = html;
    }
}

function redirectToSubcategory(categoryId) {
    const categories = window.app?.allCategories || [];
    const category = categories.find(c => c.id == categoryId);

    if (!category) {
        window.location.href = `/products?category=${categoryId}`;
        return;
    }

    if (category.slug === 'trending') {
        window.location.href = '/top-selling';
        return;
    }

    if (category.slug === 'bestsellers') {
        window.location.href = '/best-selling';
        return;
    }

    if (category.children && category.children.length > 0) {
        window.location.href = `/collection/${category.slug}`;
    } else {
        window.location.href = `/products?category=${categoryId}`;
    }
}

window.goBack = function() {
    const currentPath = window.location.pathname;
    const token = localStorage.getItem('token');
    if (currentPath.includes('/checkout')) { window.location.href = '/cart'; return; }
    if (currentPath === '/cart') {
        const lastProduct = sessionStorage.getItem('last_product_page');
        if (lastProduct && !lastProduct.includes('/checkout')) {
            window.location.href = lastProduct;
            sessionStorage.removeItem('last_product_page');
        } else { window.location.href = '/'; }
        return;
    }
    if (currentPath.includes('/order-confirmation')) { window.location.href = '/orders'; return; }
    if (currentPath === '/profile' || currentPath.includes('/profile')) { window.location.href = '/'; return; }
    if (currentPath === '/orders' || currentPath.includes('/orders')) { window.location.href = '/profile'; return; }
    if (currentPath === '/login' || currentPath === '/register') { window.location.href = token ? '/' : '/'; return; }
    window.history.back();
};

function updateCartCountBadge() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalItems = cart.length;
    const updateBadge = (badgeId) => {
        const badge = document.getElementById(badgeId);
        if (badge) { badge.style.display = 'flex';
            badge.textContent = totalItems; }
    };
    updateBadge('cart-count-badge');
    updateBadge('web-cart-count-badge');
}

async function fetchFooterSettings() {
    try {
        const data = await landingService.getAppSettings();
        const appName = data?.app_name || '';
        const footerAppName = document.getElementById('footerAppName');
        const footerAppNameBottom = document.getElementById('footerAppNameBottom');

        if (footerAppName) footerAppName.textContent = appName;
        if (footerAppNameBottom) footerAppNameBottom.textContent = appName;
    } catch (error) {
        console.error('Error fetching app settings:', error);
    }
}

async function fetchCategoriesForFooter() {
    const listContainer = document.getElementById('footerCategoriesList');
    if (!listContainer) return;

    try {
        const categories = (await landingService.getCategories()).slice(0, 6);
        if (categories.length) {
            listContainer.innerHTML = categories
                .map(cat => `<li><a href="/category/${cat.id}">${cat.name}</a></li>`)
                .join('');
        }
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
}

const footerYear = document.getElementById('footerYear');
if (footerYear) footerYear.textContent = new Date().getFullYear();

document.addEventListener('DOMContentLoaded', function() {
    fetchFooterSettings();
    fetchCategoriesForFooter();
});

document.addEventListener("click", (e) => {
    const box = document.querySelector(".search-box");
    const suggestions = document.getElementById("web-search-suggestions");
    if (!box || !suggestions) return;
    if (!box.contains(e.target)) suggestions.style.display = "none";
});

window.app = new RapidRetailsEngine();
document.addEventListener('DOMContentLoaded', () => window.app.init());

window.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById("app-loader");
    if (loader) loader.style.display = "none";
});

(function() {
    const fallbackCategories = ['Co-ords set', 'Dresses', 'Kurta Sets'];
    let categories = fallbackCategories.slice();
    let index = 0;
    let intervalId = null;

    function startRotation(input) {
        if (intervalId) clearInterval(intervalId);
        if (!input || !categories.length) return;

        input.placeholder = 'Search for ' + categories[0];
        intervalId = setInterval(() => {
            index = (index + 1) % categories.length;
            input.placeholder = 'Search for ' + categories[index];
        }, 3000);
    }

    async function initPlaceholder() {
        try {
            const data = await landingService.getCategories();
            const names = data.map(cat => cat.name).filter(Boolean);

            if (names.length) {
                categories = names;
            }
        } catch (_) {}

        const input =
            document.getElementById('web-search-input') ||
            document.getElementById('landing-search');

        if (!input) return;

        startRotation(input);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPlaceholder, { once: true });
    } else {
        initPlaceholder();
    }
})();

async function trackPageImpression(pageName) {
    try {
        await landingService.trackPageImpression(pageName);
    } catch (e) {
        console.error('Impression Error:', e);
    }
}
window.addEventListener('beforeunload', function() {
    if (window.app && window.app.apiCache) {
        try {
            const data = {
                timestamp: Date.now(),
                data: Object.fromEntries(window.app.apiCache)
            };
            sessionStorage.setItem('landing_cache', JSON.stringify(data));
        } catch(e) {}
    }
});

window.addEventListener('popstate', function(e) {
    if (e.state && e.state.page === 'landing' && window.app) {
        try {
            const cached = sessionStorage.getItem('landing_cache');
            if (cached) {
                const parsed = JSON.parse(cached);
                if (Date.now() - parsed.timestamp < 300000) {
                    window.app.apiCache = new Map(Object.entries(parsed.data));
                    window.app.initLanding();
                }
            }
        } catch(e) {}
    }
});

if (window.location.pathname === '/' || window.location.pathname === '') {
    history.replaceState({ page: 'landing' }, '');
}

class ProductPage {
    constructor() {
        this.grid = document.getElementById('productsGrid');
        this.subStrip = document.getElementById('subStrip');
        this.categoryFilters = document.getElementById('desktopCategoryFilters');
        this.categoryTitle = document.getElementById('categoryFilterTitle');
        this.priceFilters = document.getElementById('desktopPriceFilters');
        this.brandFilters = document.getElementById('desktopBrandFilters');
        this.discountFilters = document.getElementById('desktopDiscountFilters');

        this.currentProducts = [];
        this.originalProducts = [];
        this.allCategories = [];
        this.mainCategoryData = null;
        this.currentSubId = null;
        this.priceSlider = null;
        this.maxPrice = null;
        this.productLoadToken = 0;
        this.initialized = false;
    }

    escape(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    slug(value) {
        return String(value ?? '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    categorySlug(category) {
        return category?.slug || this.slug(category?.name);
    }

    getPrice(product) {
        const value =
            product?.product_price && product.product_price !== '0.00'
                ? product.product_price
                : (product?.final_price ?? product?.price ?? 0);

        return Number.parseFloat(value) || 0;
    }

    getMrp(product) {
        return Number.parseFloat(
            product?.price || product?.product_price || 0
        ) || 0;
    }

    getDiscount(product) {
        const mrp = Number.parseFloat(product?.price || product?.product_price || 0);
        const finalPrice = Number.parseFloat(product?.final_price || 0);

        if (mrp > finalPrice && finalPrice > 0) {
            return Math.round(((mrp - finalPrice) / mrp) * 100);
        }

        return 0;
    }

    formatPrice(value) {
        return `₹${Number(value || 0).toLocaleString('en-IN')}`;
    }

    getFallbackImage() {
        return APP_CONFIG.FALLBACK_IMAGE;
    }

    async loadCategories() {
        try {
            this.allCategories = await landingService.getCategories();
            if (!Array.isArray(this.allCategories)) this.allCategories = [];
            return this.allCategories;
        } catch (error) {
            console.error('Category loading error:', error);
            this.allCategories = [];
            return [];
        }
    }

    findCategory(categories, categoryId) {
        for (const category of categories || []) {
            if (String(category.id) === String(categoryId)) return category;

            const found = this.findCategory(category.children, categoryId);
            if (found) return found;
        }

        return null;
    }

    findInitialCategory(categories) {
        const pathMatch = window.location.pathname.match(
            /\/collection\/([^/]+)(?:\/([^/]+))?/
        );

        let mainCategory = null;
        let targetSubId = null;
        let targetSubSubId = null;

        if (pathMatch?.[1]) {
            const mainSlug = pathMatch[1];
            const subSlug = pathMatch[2] || null;

            mainCategory = categories.find(
                category => this.categorySlug(category) === mainSlug
            );

            if (mainCategory) {
                if (subSlug) {
                    for (const sub of mainCategory.children || []) {
                        const subCategorySlug = this.categorySlug(sub);

                        if (subCategorySlug === subSlug) {
                            targetSubId = sub.id;
                            break;
                        }

                        for (const subSub of sub.children || []) {
                            if (this.categorySlug(subSub) === subSlug) {
                                targetSubSubId = subSub.id;
                                targetSubId = sub.id;
                                break;
                            }
                        }

                        if (targetSubId) break;
                    }
                }

                if (!targetSubId && mainCategory.children?.length) {
                    const firstSub = mainCategory.children[0];
                    targetSubId = firstSub.children?.length
                        ? firstSub.children[0].id
                        : firstSub.id;
                }
            }
        }

        if (!mainCategory && categories.length) {
            mainCategory = categories[0];
            const firstSub = mainCategory.children?.[0];

            if (firstSub) {
                targetSubId = firstSub.children?.length
                    ? firstSub.children[0].id
                    : firstSub.id;
            } else {
                targetSubId = mainCategory.id;
            }
        }

        if (targetSubSubId) targetSubId = targetSubSubId;

        return { mainCategory, targetSubId };
    }

    renderSubcategories(category) {
        if (!this.subStrip) return;

        const children = [];
        for (const child of category?.children || []) {
            children.push(child);
            for (const nested of child.children || []) {
                children.push(nested);
            }
        }

        if (!children.length) {
            this.subStrip.innerHTML = '';
            this.subStrip.style.display = 'none';
            return;
        }

        this.subStrip.innerHTML = children.map(item => {
            const image = this.escape(
                item.image_url || this.getFallbackImage()
            );
            const name = this.escape(item.name || '');
            const active = String(item.id) === String(this.currentSubId);

            return `
                <div class="sub-item ${active ? 'active' : ''}"
                     data-subid="${this.escape(item.id)}"
                     role="button"
                     tabindex="0">
                    <div class="sub-img">
                        <img src="${image}"
                             alt="${name}"
                             loading="lazy"
                             onerror="this.src='${this.getFallbackImage()}'">
                    </div>
                    <div class="sub-name">${name}</div>
                </div>
            `;
        }).join('');

        this.subStrip.style.display = 'flex';
    }

    renderCategoryFilters(category) {
        if (!this.categoryFilters || !this.categoryTitle) return;

        const children = category?.children || [];

        if (!children.length) {
            this.categoryFilters.innerHTML = '';
            this.categoryTitle.textContent = 'CATEGORY';
            return;
        }

        this.categoryTitle.textContent = category?.name || 'CATEGORY';

        this.categoryFilters.innerHTML = children.map(item => `
            <label class="filter-option">
                <input type="checkbox"
                    class="desktop-category-filter"
                    value="${this.escape(item.id)}">
                ${this.escape(item.name)}
            </label>
        `).join('');
    }

        renderPriceFilter(products) {
            if (!this.priceFilters) return;

            const prices = products.map(product => this.getPrice(product)).filter(Boolean);

            if (!prices.length) {
                this.priceFilters.innerHTML = '';
                this.priceSlider = null;
                this.maxPrice = null;
                return;
            }

            const max = Math.max(...prices) + 100;
            this.maxPrice = max;

            this.priceFilters.innerHTML = `
                <div class="price-slider-wrap">
                    <input type="range" id="priceRangeSlider" min="0" max="100" value="100">
                    <div class="price-labels">
                        <span>₹0</span>
                        <span>${this.formatPrice(max)}</span>
                    </div>
                </div>
            `;

            this.priceSlider = document.getElementById('priceRangeSlider');
            this.priceSlider?.addEventListener('input', event => {
                const percentage = Number(event.target.value) / 100;
                const currentMax = Math.round(percentage * max);

                const labels = this.priceSlider.parentElement.querySelector('.price-labels');
                if (labels) {
                    labels.innerHTML = `<span>₹0</span><span>${this.formatPrice(currentMax)}</span>`;
                }

                this.maxPrice = currentMax;
                this.applyAllFilters();
            });
        }

    renderBrandFilter(products) {
        if (!this.brandFilters) return;

        const brands = [...new Set(
            products.map(product => product.brand).filter(Boolean)
        )].sort((a, b) => String(a).localeCompare(String(b)));

        this.brandFilters.innerHTML = brands.map(brand => `
            <label class="filter-option">
                <input type="checkbox"
                       class="desktop-brand-filter"
                       value="${this.escape(brand)}">
                ${this.escape(brand)}
            </label>
        `).join('');
    }

    renderDiscountFilter(products) {
        if (!this.discountFilters) return;

        const discounts = [...new Set(
            products.map(product => this.getDiscount(product)).filter(value => value > 0)
        )].sort((a, b) => a - b);

        this.discountFilters.innerHTML = discounts.map(discount => `
            <label class="filter-option">
                <input type="checkbox"
                       class="desktop-discount-filter"
                       value="${discount}">
                ${discount}% & above
            </label>
        `).join('');
    }

    updateFilters(products) {
        this.renderPriceFilter(products);
        this.renderBrandFilter(products);
        this.renderDiscountFilter(products);
    }

    getWishlist() {
        try {
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            return Array.isArray(wishlist) ? wishlist : [];
        } catch (_) {
            return [];
        }
    }

    renderProducts(products) {
        if (!this.grid) return;

        if (!Array.isArray(products) || !products.length) {
            this.grid.innerHTML = '<div class="loading">No products found</div>';
            return;
        }

        const wishlist = this.getWishlist();
        const wishlistIds = new Set(wishlist.map(item => String(item.id)));
        const fallback = this.getFallbackImage();

        this.grid.innerHTML = products.map(product => {
            const id = product.id;
            const slug = product.slug || id;
            const name = product.name || product.product_name || 'Product';
            const brand = product.brand || 'RAPID RETAIL';
            const price = this.getPrice(product);
            const mrp = this.getMrp(product);
            const discount = this.getDiscount(product);
            const inWishlist = wishlistIds.has(String(id));
            const image = product.image_url || fallback;

            const safeProduct = encodeURIComponent(JSON.stringify({
                id,
                name,
                price,
                image,
                brand,
                slug
            }));

            return `
                <article class="card"
                         data-product-id="${this.escape(id)}"
                         data-product-slug="${this.escape(slug)}">
                    <div class="img-box">
                        <img src="${this.escape(image)}"
                             alt="${this.escape(name)}"
                             loading="lazy"
                             onerror="this.src='${fallback}'">
                        ${discount > 20 ? '<span class="badge">Best Seller</span>' : ''}
                        <button type="button"
                                class="wishlist ${inWishlist ? 'active' : ''}"
                                data-product="${safeProduct}"
                                aria-label="${inWishlist ? 'Remove from wishlist' : 'Add to wishlist'}">
                            ${inWishlist ? '❤️' : '♡'}
                        </button>
                    </div>
                    <div class="info">
                        <div class="brand">${this.escape(brand)}</div>
                        <div class="name">${this.escape(name)}</div>
                        <div class="price">
                            <span class="current">${this.formatPrice(price)}</span>
                            ${mrp > price ? `<span class="original">${this.formatPrice(mrp)}</span>` : ''}
                            ${discount > 0 ? `<span class="off">${discount}% Off</span>` : ''}
                        </div>
                    </div>
                </article>
            `;
        }).join('');
    }

    async loadProducts(categoryId) {
        if (!categoryId || !this.grid) return;

        const requestToken = ++this.productLoadToken;
        this.currentSubId = categoryId;

        this.grid.innerHTML = '<div class="loading">Loading products...</div>';

        try {
            let products = await landingService.getCategoryProducts(categoryId);

            // If the selected category has no direct products, use its first child.
            if (!products.length) {
                const category = this.findCategory(this.allCategories, categoryId);
                const child = category?.children?.[0];

                if (child) {
                    products = await landingService.getCategoryProducts(child.id);
                    this.currentSubId = child.id;
                }
            }

            if (requestToken !== this.productLoadToken) return;

            this.currentProducts = products;
            this.originalProducts = products.slice();

            this.renderProducts(products);
            this.updateFilters(products);
        } catch (error) {
            if (requestToken !== this.productLoadToken) return;
            console.error('Product loading error:', error);
            this.grid.innerHTML = '<div class="loading">Error loading products</div>';
        }
    }

    async loadSearchProducts(query) {
        const q = String(query || '').trim();
        if (!q || !this.grid) return;

        const requestToken = ++this.productLoadToken;
        this.currentSubId = null;
        this.grid.innerHTML = '<div class="loading">Loading products...</div>';

        try {
            const response = await API.get(`/products/search?q=${encodeURIComponent(q)}`);

            if (requestToken !== this.productLoadToken) return;

            const products = Array.isArray(response?.data?.products)
                ? response.data.products
                : Array.isArray(response?.data)
                    ? response.data
                    : [];

            this.currentProducts = products;
            this.originalProducts = products.slice();

            this.renderProducts(products);
            this.updateFilters(products);
        } catch (error) {
            if (requestToken !== this.productLoadToken) return;
            console.error('Search products loading error:', error);
            this.currentProducts = [];
            this.originalProducts = [];
            this.grid.innerHTML = '<div class="loading">No products found</div>';
        }
    }

    getSelectedValues(selector) {
        return [...document.querySelectorAll(`${selector}:checked`)]
            .map(input => input.value);
    }

    async applyAllFilters() {
        const categoryIds = this.getSelectedValues('.desktop-category-filter');
        const brands = new Set(this.getSelectedValues('.desktop-brand-filter'));
        const discounts = this.getSelectedValues('.desktop-discount-filter')
            .map(Number)
            .filter(Number.isFinite);

        // One category only: use the already supported category endpoint.
        if (categoryIds.length === 1 && !brands.size && !discounts.length) {
            await this.loadProducts(categoryIds[0]);
            return;
        }

        let sourceProducts = this.originalProducts;

        if (categoryIds.length > 1) {
            this.grid.innerHTML = '<div class="loading">Loading products...</div>';

            const result = await Promise.all(
                categoryIds.map(id => landingService.getCategoryProducts(id))
            );

            const seen = new Set();
            sourceProducts = result.flat().filter(product => {
                const key = String(product.id);
                if (seen.has(key)) return false;
                seen.add(key);
                return true;
            });

            this.currentProducts = sourceProducts;
        }

        let filtered = sourceProducts.slice();

        if (brands.size) {
            filtered = filtered.filter(product => brands.has(String(product.brand)));
        }

        if (discounts.length) {
            filtered = filtered.filter(product => {
                const discount = this.getDiscount(product);
                return discounts.some(min => discount >= min);
            });
        }

        if (this.maxPrice != null) {
            filtered = filtered.filter(product => this.getPrice(product) <= this.maxPrice);
        }

        this.renderProducts(filtered);
    }

    resetFilters() {
        document.querySelectorAll(
            '.desktop-category-filter, .desktop-brand-filter, .desktop-discount-filter'
        ).forEach(input => {
            input.checked = false;
        });

        if (this.priceSlider) this.priceSlider.value = 100;
        this.maxPrice = null;

        if (this.originalProducts.length) {
            this.renderProducts(this.originalProducts);
            this.updateFilters(this.originalProducts);
        }
    }

    toggleFilter(header) {
        const group = header?.parentElement;
        if (!group) return;

        group.classList.toggle('closed');

        const arrow = header.querySelector('.filter-arrow');
        if (arrow) {
            arrow.textContent = group.classList.contains('closed') ? '+' : '−';
        }
    }

    toggleWishlist(event, button) {
        event.preventDefault();
        event.stopPropagation();

        let product;
        try {
            product = JSON.parse(decodeURIComponent(button.dataset.product || ''));
        } catch (_) {
            return;
        }

        const wishlist = this.getWishlist();
        const index = wishlist.findIndex(item => String(item.id) === String(product.id));

        if (index >= 0) {
            wishlist.splice(index, 1);
            button.textContent = '♡';
            button.classList.remove('active');
            button.setAttribute('aria-label', 'Add to wishlist');
        } else {
            wishlist.push(product);
            button.textContent = '❤️';
            button.classList.add('active');
            button.setAttribute('aria-label', 'Remove from wishlist');
        }

        localStorage.setItem('wishlist', JSON.stringify(wishlist));

        if (typeof updateCartCountBadge === 'function') {
            updateCartCountBadge();
        }
    }

    setupEvents() {
        if (!this.grid) return;

        this.grid.addEventListener('click', event => {
            const wishlistButton = event.target.closest('.wishlist');

            if (wishlistButton) {
                this.toggleWishlist(event, wishlistButton);
                return;
            }

            const card = event.target.closest('.card');
            const slug = card?.dataset.productSlug;

            if (slug) {
                window.location.href = `/product/${encodeURIComponent(slug)}`;
            }
        });

        this.subStrip?.addEventListener('click', event => {
            const item = event.target.closest('.sub-item');
            if (!item) return;
            this.changeSubcategory(item.dataset.subid);
        });

        this.subStrip?.addEventListener('keydown', event => {
            if (event.key !== 'Enter' && event.key !== ' ') return;

            const item = event.target.closest('.sub-item');
            if (!item) return;

            event.preventDefault();
            this.changeSubcategory(item.dataset.subid);
        });

        document.addEventListener('change', event => {
            if (
                event.target.matches(
                    '.desktop-category-filter, .desktop-brand-filter, .desktop-discount-filter'
                )
            ) {
                this.applyAllFilters();
            }
        });
    }

    async changeSubcategory(categoryId) {
        document.querySelectorAll('.sub-item').forEach(item => {
            item.classList.toggle(
                'active',
                String(item.dataset.subid) === String(categoryId)
            );
        });

        await this.loadProducts(categoryId);
    }

    setupMobileFilterPopup() {
        window.showFilterPopup = () => {
            const overlay = document.getElementById('filterPopupOverlay');
            const content = document.getElementById('mobileFilterContent');

            if (!overlay || !content) return;

            const buildGroup = (title, selector, className) => {
                const checks = [...document.querySelectorAll(selector)];
                if (!checks.length) return '';

                return `
                    <section class="mobile-filter-group">
                        <div class="mobile-filter-title">${title}</div>
                        ${checks.map(check => `
                            <label class="filter-checkbox">
                                <input type="checkbox"
                                       class="${className}"
                                       value="${this.escape(check.value)}"
                                       ${check.checked ? 'checked' : ''}>
                                ${this.escape(check.parentElement.textContent.trim())}
                            </label>
                        `).join('')}
                    </section>
                `;
            };

            content.innerHTML = [
                buildGroup('CATEGORY', '.desktop-category-filter', 'mobile-category-filter'),
                buildGroup('BRANDS', '.desktop-brand-filter', 'mobile-brand-filter'),
                buildGroup('DISCOUNT', '.desktop-discount-filter', 'mobile-discount-filter')
            ].join('');

            overlay.classList.add('active');
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        window.hideFilterPopup = () => {
            const overlay = document.getElementById('filterPopupOverlay');
            if (overlay) {
                overlay.classList.remove('active');
                overlay.style.display = 'none';
            }
            document.body.style.overflow = '';
        };

        window.applyMobileFilters = () => {
            document.querySelectorAll('.mobile-category-filter').forEach(input => {
                const desktop = document.querySelector(
                    `.desktop-category-filter[value="${CSS.escape(input.value)}"]`
                );
                if (desktop) desktop.checked = input.checked;
            });

            document.querySelectorAll('.mobile-brand-filter').forEach(input => {
                const desktop = [...document.querySelectorAll('.desktop-brand-filter')]
                    .find(item => item.value === input.value);
                if (desktop) desktop.checked = input.checked;
            });

            document.querySelectorAll('.mobile-discount-filter').forEach(input => {
                const desktop = document.querySelector(
                    `.desktop-discount-filter[value="${CSS.escape(input.value)}"]`
                );
                if (desktop) desktop.checked = input.checked;
            });

            this.applyAllFilters();
            window.hideFilterPopup();
        };

        window.resetMobileFilters = () => {
            document.querySelectorAll(
                '.mobile-category-filter, .mobile-brand-filter, .mobile-discount-filter'
            ).forEach(input => {
                input.checked = false;
            });
        };
    }

    setupSortPopup() {
        window.showSortPopup = () => {
            const overlay = document.getElementById('sortPopupOverlay');
            if (!overlay) return;
            overlay.classList.add('active');
            overlay.style.display = 'flex';
        };

        window.hideSortPopup = () => {
            const overlay = document.getElementById('sortPopupOverlay');
            if (!overlay) return;
            overlay.classList.remove('active');
            overlay.style.display = 'none';
        };

        window.applySort = () => {
            const selected = document.querySelector('input[name="sort"]:checked');
            if (!selected) return;

            const sorted = this.currentProducts.slice();

            if (selected.value === 'price-low') {
                sorted.sort((a, b) => this.getPrice(a) - this.getPrice(b));
            } else if (selected.value === 'price-high') {
                sorted.sort((a, b) => this.getPrice(b) - this.getPrice(a));
            }

            this.renderProducts(sorted);
            window.hideSortPopup();
        };
    }

    async init() {
        if (this.initialized || !this.grid) return;
        this.initialized = true;

        this.setupEvents();
        this.setupSortPopup();
        this.setupMobileFilterPopup();

        const currentPath = window.location.pathname.replace(/\/+$/, '');

        // Top-selling page does not need the category tree. Load products immediately.
        if (currentPath === '/top-selling') {
            this.mainCategoryData = null;
            this.currentSubId = null;

            try {
                const products = await landingService.getTopSelling();

                this.currentProducts = products;
                this.originalProducts = products.slice();

                this.renderProducts(products);
                this.updateFilters(products);
            } catch (error) {
                console.error('Top selling products loading error:', error);
                this.grid.innerHTML = '<div class="loading">Error loading products</div>';
            }

            return;
        }

        const searchQuery = new URLSearchParams(window.location.search).get('search');
        if (searchQuery?.trim()) {
            await this.loadSearchProducts(searchQuery);
            return;
        }

        // Collection pages need the category tree. Shared cache prevents duplicate requests.
        const categories = await this.loadCategories();

        const { mainCategory, targetSubId } =
            this.findInitialCategory(categories);

        this.mainCategoryData = mainCategory;

        if (!mainCategory || !targetSubId) {
            this.grid.innerHTML = '<div class="loading">No category found</div>';
            return;
        }

        this.currentSubId = targetSubId;

        const pathMatch = window.location.pathname.match(
    /\/collection\/([^/]+)(?:\/([^/]+))?/
);

const hasSubcategory = Boolean(pathMatch?.[2]);

let currentFilterCategory;

if (hasSubcategory) {
    // Direct subcategory URL:
    // /collection/co-ords/printed-co-ords
    // => Printed Co-ords ke children filter me dikhenge
    currentFilterCategory =
        this.findCategory(categories, targetSubId) || mainCategory;
} else {
    // Main category URL:
    // /collection/co-ords
    // => First subcategory ke children filter me dikhenge
    const firstSubCategory = mainCategory?.children?.[0];

    if (firstSubCategory?.children?.length) {
        currentFilterCategory = firstSubCategory;
    } else {
        currentFilterCategory = mainCategory;
    }
}

this.renderCategoryFilters(currentFilterCategory);
this.renderSubcategories(mainCategory);
await this.loadProducts(targetSubId);
    }
}

window.productPage = new ProductPage();

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page === 'products') {
        window.productPage.init();
    }
});

window.applyFilters = () => window.productPage?.applyAllFilters();
window.resetAllFilters = () => window.productPage?.resetFilters();
window.toggleFilter = header => window.productPage?.toggleFilter(header);
window.toggleWish = (event, button) => window.productPage?.toggleWishlist(event, button);
window.changeSubcategory = id => window.productPage?.changeSubcategory(id);
