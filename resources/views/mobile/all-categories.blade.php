<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">    <title>All Departments | RAPID RETAILS</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Mobile First Optimizations */
        @media (max-width: 768px) {
            .category-layout {
                display: block !important;
                padding: 10px 0 !important;
            }
            
            .filter-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 85% !important;
                height: 100vh;
                background: white;
                z-index: 10000;
                overflow-y: auto;
                transition: left 0.3s ease;
                padding: 20px 16px !important;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                display: block !important;
            }
            
            .filter-sidebar.active {
                left: 0;
            }
            
            .filter-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-bottom: 15px;
                border-bottom: 1px solid #eaeaec;
                margin-bottom: 20px;
                position: sticky;
                top: 0;
                background: white;
                z-index: 10;
            }
            
            .filter-header h3 {
                font-size: 16px;
                font-weight: 700;
                color: #282c3f;
            }
            
            .clear-all {
                font-size: 12px;
                color: #ff3f6c;
                text-decoration: none;
                font-weight: 600;
            }
            
            .close-filter {
                font-size: 24px;
                color: #696b79;
                cursor: pointer;
                line-height: 1;
            }
            
            .filter-section {
                margin-bottom: 25px;
            }
            
            .filter-section-title {
                font-size: 14px;
                font-weight: 700;
                color: #282c3f;
                margin-bottom: 12px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-transform: uppercase;
            }
            
            .filter-options {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .filter-option {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 12px;
                font-size: 13px;
                color: #282c3f;
            }
            
            .filter-option input[type="checkbox"] {
                width: 18px;
                height: 18px;
                accent-color: #ff3f6c;
            }
            
            .more-link {
                color: #ff3f6c;
                font-size: 12px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                margin-top: 5px;
                background: none;
                border: none;
                padding: 0;
                cursor: pointer;
            }
            
            .products-area {
                padding: 0;
            }
            
            .products-header {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eaeaec;
            }
            
            .result-count {
                font-size: 14px;
                color: #696b79;
            }
            
            .result-count strong {
                font-size: 16px;
                color: #282c3f;
            }
            
            .products-actions {
                display: flex;
                align-items: center;
                gap: 10px;
                width: 100%;
            }
            
            .mobile-filter-btn {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 10px 16px;
                background: white;
                border: 1px solid #eaeaec;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 600;
                color: #282c3f;
                cursor: pointer;
                flex: 1;
            }
            
            .mobile-filter-btn svg {
                width: 16px;
                height: 16px;
            }
            
            .view-options {
                display: none !important;
            }
            
            .sort-select {
                padding: 10px 30px 10px 12px;
                border: 1px solid #eaeaec;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 500;
                background: white;
                cursor: pointer;
                flex: 1;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23696b79' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 8px center;
                background-size: 16px;
            }
            
            .product-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
                margin-bottom: 20px;
            }
            
            .category-card {
                background: white;
                border: 1px solid #eaeaec;
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s;
                cursor: pointer;
            }
            
            .category-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            }
            
            .cat-img-wrap {
                aspect-ratio: 3/4;
                overflow: hidden;
                background: #f5f5f6;
            }
            
            .cat-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .cat-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 10px;
                background: linear-gradient(transparent, rgba(0,0,0,0.7));
                color: white;
            }
            
            .cat-overlay h3 {
                font-size: 12px;
                font-weight: 700;
                margin: 0;
                text-transform: uppercase;
            }
            
            .promo-banner {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 25px 20px;
                border-radius: 8px;
                margin: 20px 0;
                text-align: center;
            }
            
            .promo-banner h3 {
                font-size: 18px;
                font-weight: 800;
                margin-bottom: 8px;
            }
            
            .promo-banner p {
                font-size: 12px;
                opacity: 0.9;
                margin-bottom: 15px;
            }
            
            .promo-banner .btn {
                background: white;
                color: #764ba2;
                padding: 10px 20px;
                border: none;
                font-weight: 700;
                font-size: 12px;
                cursor: pointer;
                border-radius: 4px;
            }
            
            /* Loading state */
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: skeleton-loading 1.5s infinite;
                border-radius: 4px;
            }
            
            @keyframes skeleton-loading {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
            
            /* Modal mobile styles */
            .category-modal .modal-box {
                width: 95%;
                max-width: 400px;
                height: auto;
                max-height: 80vh;
            }
            
            .category-modal .modal-body {
                flex-direction: column;
            }
            
            .category-modal #modal-parent-cats {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eee;
                max-height: 150px;
            }
            
            .category-modal #modal-sub-cats {
                width: 100%;
                max-height: 300px;
            }
            
            .category-modal .modal-parent {
                padding: 12px 16px;
            }
            
            .category-modal .modal-sub-item {
                padding: 8px 12px;
            }
        }
        
        /* Small phones */
        @media (max-width: 380px) {
            .product-grid {
                gap: 8px !important;
            }
            
            .cat-overlay h3 {
                font-size: 10px;
            }
            
            .promo-banner h3 {
                font-size: 16px;
            }
            
            .promo-banner p {
                font-size: 10px;
            }
            
            .promo-banner .btn {
                padding: 8px 16px;
                font-size: 11px;
            }
        }
    </style>
</head>

<body data-page="all-products">

<header class="site-header" id="site-header"></header>

<main class="page-content">
    <div class="container">

        <!-- BREADCRUMB (DYNAMIC) -->
        <div class="breadcrumb" id="breadcrumb">
            <!-- JS will inject breadcrumb -->
        </div>

        <!-- MAIN LAYOUT -->
        <div class="category-layout">

            <!-- FILTER SIDEBAR -->
            <aside class="filter-sidebar" id="filter-sidebar">
                <div class="filter-header">
                    <h3>REFINE BY</h3>
                    <a href="#" class="clear-all">Clear All</a>
                    <span class="close-filter mobile-only" id="close-filter">×</span>
                </div>

                <!-- PARENT CATEGORIES -->
                <div class="filter-section">
                    <div class="filter-section-title">
                        Category
                        <span class="toggle-icon">−</span>
                    </div>
                    <ul class="filter-options" id="filter-shop-for">
                        <!-- JS inject parent categories -->
                    </ul>
                </div>

                <!-- SUB CATEGORIES -->
                <div class="filter-section">
                    <div class="filter-section-title">
                        Sub Category
                        <span class="toggle-icon">−</span>
                    </div>
                    <ul class="filter-options" id="filter-categories">
                        <!-- JS inject sub categories -->
                    </ul>
                    <button type="button" class="more-link">+ MORE</button>
                </div>
            </aside>

            <!-- PRODUCTS AREA -->
            <div class="products-area">

                <!-- PRODUCTS HEADER -->
                <div class="products-header">
                    <div class="result-count">
                        <strong id="product-count">0</strong> Items Found
                    </div>

                    <div class="products-actions">
                        <button class="mobile-filter-btn" id="mobile-filter-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                            </svg>
                            FILTER
                        </button>

                        <select class="sort-select">
                            <option>Relevance</option>
                            <option>Newest First</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <!-- PRODUCTS GRID -->
                <div id="full-category-grid" class="product-grid">
                    <!-- JS inject category cards / products -->
                </div>

                <!-- PROMO BANNER -->
                <div class="promo-banner">
                    <h3>Sign In / Join RAPID RETAILS</h3>
                    <p>Customer Care | Visit RAPIDLUXE</p>
                    <button class="btn">Search RAPID RETAILS</button>
                </div>

            </div>
        </div>
    </div>
</main>

<footer class="site-footer" id="site-footer"></footer>
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

<!-- Global Category Popup (shared header modal) -->
<div class="category-modal" id="category-modal">
    <div class="modal-box">
        <div class="modal-header">
            <h2>SHOP BY CATEGORY</h2>
            <span class="modal-close" id="close-category-modal">&times;</span>
        </div>
        <div class="modal-body" id="modal-popup-body">
            <!-- Categories will be loaded by JavaScript -->
        </div>
    </div>
</div>

<!-- MAIN SCRIPT -->
<script src="{{ asset('mobile/script.js') }}"></script>

<!-- MOBILE FILTER TOGGLE - IMPROVED -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtn = document.getElementById('mobile-filter-btn');
    const closeFilter = document.getElementById('close-filter');
    const filterSidebar = document.getElementById('filter-sidebar');
    
    if (filterBtn && closeFilter && filterSidebar) {
        // Open filter
        filterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            filterSidebar.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close filter
        closeFilter.addEventListener('click', function(e) {
            e.preventDefault();
            filterSidebar.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Close when clicking outside
        filterSidebar.addEventListener('click', function(e) {
            if (e.target === filterSidebar) {
                filterSidebar.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
    
    // Sort select styling
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            console.log('Sort changed to:', this.value);
            // Add your sort logic here
        });
    }
});
</script>
<!-- Yeh script aapke existing page ke ANDAR laga do, </body> se pehle -->

<script>
document.addEventListener('DOMContentLoaded', () => {

    const grid = document.getElementById('full-category-grid');
    const countEl = document.getElementById('product-count');
    const clearBtn = document.querySelector('.clear-all');

    let selectedCategories = [];

    /* ==========================
       FETCH & RENDER PRODUCTS
    ========================== */
    async function loadProducts(categoryIds = []) {
        grid.innerHTML = skeletonHTML();

        try {
            let url = 'https://retailadmin.ggconsultancy.services/api/products';

            // Agar category selected hai
            if (categoryIds.length > 0) {
                url += '?category_ids=' + categoryIds.join(',');
            }

            const res = await fetch(url);
            const data = await res.json();

            let products = [];

            if (data.data && Array.isArray(data.data.products)) {
                products = data.data.products;
            }

            countEl.innerText = products.length;

            if (products.length === 0) {
                grid.innerHTML = `<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">
                    No products found
                </p>`;
                return;
            }

            grid.innerHTML = products.map(p => productCard(p)).join('');

        } catch (err) {
            console.error(err);
            grid.innerHTML = `<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">
                Error loading products
            </p>`;
        }
    }

    /* ==========================
       CHECKBOX CHANGE HANDLER
    ========================== */
    document.addEventListener('change', (e) => {
        if (!e.target.classList.contains('category-filter')) return;

        const id = e.target.value;

        if (e.target.checked) {
            selectedCategories.push(id);
        } else {
            selectedCategories = selectedCategories.filter(cid => cid !== id);
        }

        loadProducts(selectedCategories);
    });

    /* ==========================
       CLEAR ALL
    ========================== */
    if (clearBtn) {
        clearBtn.addEventListener('click', (e) => {
            e.preventDefault();

            document.querySelectorAll('.category-filter').forEach(cb => cb.checked = false);
            selectedCategories = [];
            loadProducts(); // ALL PRODUCTS
        });
    }

    /* ==========================
       PRODUCT CARD
    ========================== */
    function productCard(product) {
        let img = product.image_url || product.image || '';
        if (img && !img.startsWith('http')) {
            img = 'https://inventorydata-s3-bucket.s3.amazonaws.com/' + img;
        }
        if (!img) {
            img = 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=300&h=400&fit=crop';
        }

        return `
            <div class="product-card" data-slug="${product.slug || ''}">
                <div class="p-img-wrap">
                    <img src="${img}" loading="lazy">
                </div>
                <div class="p-info">
                    <div class="p-brand">${product.brand || 'RAPID RETAIL'}</div>
                    <div class="p-name">${product.name || ''}</div>
                    <div class="p-price-row">
                        <span class="p-price">₹${product.price || product.final_price || 0}</span>
                    </div>
                </div>
            </div>
        `;
    }

    /* ==========================
       SKELETON
    ========================== */
    function skeletonHTML() {
        return Array(6).fill(0).map(() => `
            <div class="product-card skeleton">
                <div class="p-img-wrap skeleton"></div>
                <div class="p-info">
                    <div class="skeleton" style="height:12px;width:60%;margin-bottom:8px"></div>
                    <div class="skeleton" style="height:10px;width:80%"></div>
                </div>
            </div>
        `).join('');
    }

    /* ==========================
       INITIAL LOAD
    ========================== */
    loadProducts();
    loadCategoryFilters(); // 👈 View All → ALL PRODUCTS
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const parentBox = document.getElementById('filter-shop-for');
    const subBox = document.getElementById('filter-categories');
    const grid = document.getElementById('full-category-grid');
    const countEl = document.getElementById('product-count');
    const clearBtn = document.querySelector('.clear-all');

    let ALL_CATEGORIES = [];
    let selectedCategories = [];
    let selectedSubCategories = [];

    /* ===============================
       LOAD CATEGORIES
    =============================== */
    loadCategories();

    async function loadCategories() {
        const res = await fetch('https://retailadmin.ggconsultancy.services/api/categories');
        const data = await res.json();

        ALL_CATEGORIES = data.data || [];
        parentBox.innerHTML = '';
        subBox.innerHTML = '';

        ALL_CATEGORIES.forEach(cat => {
            parentBox.innerHTML += `
                <li class="filter-option">
                    <input type="checkbox"
                           class="parent-category"
                           value="${cat.id}">
                    <label>${cat.name}</label>
                </li>
            `;
        });
    }

    /* ===============================
       PARENT CATEGORY CHANGE
    =============================== */
    document.addEventListener('change', (e) => {

        /* ===== CATEGORY ===== */
        if (e.target.classList.contains('parent-category')) {

            const id = e.target.value;

            if (e.target.checked) {
                selectedCategories.push(id);
            } else {
                selectedCategories = selectedCategories.filter(x => x !== id);
            }

            renderSubCategories();
            loadProducts();
        }

        /* ===== SUB CATEGORY ===== */
        if (e.target.classList.contains('sub-category')) {

            const id = e.target.value;

            if (e.target.checked) {
                selectedSubCategories.push(id);
            } else {
                selectedSubCategories = selectedSubCategories.filter(x => x !== id);
            }

            loadProducts();
        }
    });

    /* ===============================
       RENDER SUB CATEGORIES
    =============================== */
    function renderSubCategories() {
        subBox.innerHTML = '';
        selectedSubCategories = [];

        const added = new Set();

        ALL_CATEGORIES.forEach(cat => {
            if (selectedCategories.includes(String(cat.id)) && cat.children) {

                cat.children.forEach(sub => {
                    if (!added.has(sub.id)) {
                        added.add(sub.id);

                        subBox.innerHTML += `
                            <li class="filter-option">
                                <input type="checkbox"
                                       class="sub-category"
                                       value="${sub.id}">
                                <label>${sub.name}</label>
                            </li>
                        `;
                    }
                });
            }
        });
    }

    /* ===============================
       LOAD PRODUCTS
    =============================== */
    async function loadProducts() {

        grid.innerHTML = skeleton();
        let products = [];

        try {
            for (let catId of selectedCategories) {

                const res = await fetch(
                    `https://retailadmin.ggconsultancy.services/api/categories/${catId}/products`
                );
                const data = await res.json();

                if (data.data?.products) {
                    products.push(...data.data.products);
                }
            }

            /* SUB CATEGORY FILTER */
            if (selectedSubCategories.length) {
                products = products.filter(p =>
                    selectedSubCategories.includes(String(p.sub_category_id))
                );
            }

            /* REMOVE DUPLICATES */
            const unique = {};
            products.forEach(p => unique[p.id] = p);
            products = Object.values(unique);

            countEl.innerText = products.length;

            grid.innerHTML = products.length
                ? products.map(productCard).join('')
                : `<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">
                    No products found
                  </p>`;

        } catch (err) {
            console.error(err);
            grid.innerHTML = `<p style="grid-column:1/-1;text-align:center">Error</p>`;
        }
    }

    /* ===============================
       CLEAR ALL
    =============================== */
    clearBtn.addEventListener('click', (e) => {
        e.preventDefault();

        selectedCategories = [];
        selectedSubCategories = [];

        document.querySelectorAll(
            '.parent-category,.sub-category'
        ).forEach(cb => cb.checked = false);

        subBox.innerHTML = '';
        grid.innerHTML = '';
        countEl.innerText = 0;
    });

    /* ===============================
       PRODUCT CARD
    =============================== */
    function productCard(p) {
        let img = p.image_url || '';
        if (!img) img = 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=300';

        return `
            <div class="product-card" data-slug="${p.slug}">
                <div class="p-img-wrap">
                    <img src="${img}">
                </div>
                <div class="p-info">
                    <div class="p-brand">${p.brand || 'RAPID RETAIL'}</div>
                    <div class="p-name">${p.name}</div>
                    <div class="p-price-row">
                        <span class="p-price">₹${p.final_price || p.price || 0}</span>
                    </div>
                </div>
            </div>
        `;
    }

    function skeleton() {
        return Array(6).fill(0).map(() => `
            <div class="product-card skeleton">
                <div class="p-img-wrap skeleton"></div>
                <div class="p-info"></div>
            </div>
        `).join('');
    }
});
</script>
</body>
</html>