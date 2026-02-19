<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category | Rapid Retails</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <style>
        /* Mobile First Responsive Styles */
        @media (max-width: 768px) {
            .category-layout {
                display: flex !important;
                flex-direction: column !important;
                gap: 20px !important;
                padding: 10px 0 !important;
            }

            /* Filter Sidebar - Mobile */
            .filter-sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 85% !important;
                height: 100vh;
                background: white;
                z-index: 10000;
                overflow-y: auto;
                padding: 20px 16px !important;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                transition: left 0.3s ease;
            }

            .filter-sidebar.active {
                display: block !important;
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
                margin: 0;
            }

            .clear-all {
                font-size: 12px;
                color: #ff3f6c;
                text-decoration: none;
                font-weight: 600;
            }

            .filter-section {
                margin-bottom: 25px;
            }

            .filter-section-title {
                font-size: 14px;
                font-weight: 700;
                color: #282c3f;
                margin-bottom: 12px;
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

            /* Products Area */
            .products-area {
                width: 100% !important;
                padding: 0 !important;
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

            .sort-select {
                width: 100%;
                padding: 12px 30px 12px 12px;
                border: 1px solid #eaeaec;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 500;
                background: white;
                cursor: pointer;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23696b79' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px;
                appearance: none;
            }

            /* Product Grid - 2 columns on mobile */
            .product-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
                margin-bottom: 30px;
            }

            .product-card {
                background: white;
                border: 1px solid #eaeaec;
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s;
                cursor: pointer;
            }

            .p-img-wrap {
                aspect-ratio: 3/4;
                overflow: hidden;
                background: #f5f5f6;
                position: relative;
            }

            .p-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .ajio-offer-badge {
                position: absolute;
                top: 8px;
                left: 8px;
                background: #ff3f6c;
                color: white;
                font-size: 10px;
                font-weight: 700;
                padding: 3px 6px;
                border-radius: 2px;
                z-index: 2;
            }

            .p-info {
                padding: 8px;
            }

            .p-brand {
                font-size: 11px;
                font-weight: 700;
                color: #282c3f;
                margin-bottom: 4px;
                text-transform: uppercase;
            }

            .p-name {
                font-size: 11px;
                color: #696b79;
                margin-bottom: 6px;
                line-height: 1.3;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .p-price-row {
                display: flex;
                align-items: center;
                gap: 6px;
                margin-bottom: 6px;
            }

            .p-price {
                font-size: 13px;
                font-weight: 700;
                color: #282c3f;
            }

            .p-mrp {
                font-size: 10px;
                color: #696b79;
                text-decoration: line-through;
            }

            .ajio-instant-discount {
                font-size: 9px;
                color: #2a7bbd;
                background: #e6f3ff;
                padding: 3px 6px;
                border-radius: 2px;
                display: inline-block;
            }

            /* Mobile Filter Button */
            .mobile-filter-btn {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 12px;
                background: white;
                border: 1px solid #eaeaec;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 600;
                color: #282c3f;
                cursor: pointer;
                margin-bottom: 15px;
                width: 100%;
            }

            .mobile-filter-btn svg {
                width: 16px;
                height: 16px;
            }

            .filter-close-btn {
                display: block;
                background: #ff3f6c;
                color: white;
                border: none;
                padding: 12px;
                border-radius: 4px;
                font-size: 14px;
                font-weight: 600;
                width: 100%;
                margin-top: 20px;
                cursor: pointer;
            }
        }

        /* Small phones */
        @media (max-width: 380px) {
            .product-grid {
                gap: 8px !important;
            }

            .p-brand {
                font-size: 10px;
            }

            .p-name {
                font-size: 10px;
            }

            .p-price {
                font-size: 12px;
            }

            .p-mrp {
                font-size: 9px;
            }

            .ajio-instant-discount {
                font-size: 8px;
                padding: 2px 4px;
            }
        }

        /* Desktop styles */
        @media (min-width: 769px) {
            .mobile-filter-btn,
            .filter-close-btn {
                display: none !important;
            }
        }

        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>

<body data-page="category-detail">

<header id="site-header"></header>

<main class="page-content">
    <div class="container">

        <!-- BREADCRUMB -->
        <div class="breadcrumb" id="breadcrumb">
            <!-- JS will inject -->
        </div>

        <!-- Mobile Filter Button -->
        <button class="mobile-filter-btn" id="mobileFilterBtn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="3" x2="9" y2="21"></line>
            </svg>
            FILTER
        </button>

        <div class="category-layout">

            <!-- LEFT FILTER -->
            <aside class="filter-sidebar" id="filterSidebar">
                <div class="filter-header">
                    <h3>REFINE BY</h3>
                    <a href="#" class="clear-all">Clear All</a>
                </div>

                <div class="filter-section">
                    <div class="filter-section-title">Sub Category</div>
                    <ul id="sub-category-filter" class="filter-options">
                        <!-- JS inject -->
                    </ul>
                </div>

                <button class="filter-close-btn" id="filterCloseBtn">APPLY FILTERS</button>
            </aside>

            <!-- PRODUCT LIST -->
            <section class="products-area">

                <div class="products-header">
                    <div class="result-count">
                        <strong id="product-count">0</strong> Items Found
                    </div>

                    <select class="sort-select" id="sortSelect">
                        <option value="relevance">Relevance</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                </div>

                <!-- PRODUCT GRID -->
                <div id="category-products-grid" class="product-grid">
                    <!-- JS inject -->
                </div>

            </section>
        </div>
    </div>
</main>

<footer id="site-footer"></footer>
<nav id="mobile-bottom-nav"></nav>

<script src="{{ asset('mobile/script.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const categoryId = window.location.pathname.split('/').pop();
    renderBreadcrumb({ category: 'Category' });

    // Mobile filter toggle
    const filterSidebar = document.getElementById('filterSidebar');
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    const filterCloseBtn = document.getElementById('filterCloseBtn');

    if (mobileFilterBtn && filterSidebar) {
        mobileFilterBtn.addEventListener('click', () => {
            filterSidebar.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (filterCloseBtn && filterSidebar) {
        filterCloseBtn.addEventListener('click', () => {
            filterSidebar.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Close filter when clicking outside
    filterSidebar?.addEventListener('click', (e) => {
        if (e.target === filterSidebar) {
            filterSidebar.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Load products
    const grid = document.getElementById('category-products-grid');
    const countEl = document.getElementById('product-count');
    
    // Show loading skeleton
    grid.innerHTML = Array(4).fill(0).map(() => `
        <div class="product-card skeleton">
            <div class="p-img-wrap skeleton"></div>
            <div class="p-info">
                <div class="p-brand skeleton" style="height:12px; width:60%; margin-bottom:8px;"></div>
                <div class="p-name skeleton" style="height:10px; width:80%; margin-bottom:6px;"></div>
                <div class="p-price-row">
                    <span class="p-price skeleton" style="height:14px; width:40%;"></span>
                </div>
            </div>
        </div>
    `).join('');

    const res = await window.app.callAPI(
        `${APP_CONFIG.ENDPOINTS.ALL_PRODUCTS}?category_id=${categoryId}`
    );

    const products = res?.data?.products || res?.data || [];
    countEl.innerText = products.length;

    grid.innerHTML = products.length
        ? products.map(p => window.app.genProductCard(p)).join('')
        : `<p style="grid-column:1/-1;text-align:center;color:#999;padding:40px;">
            No products found in this category
           </p>`;

    // Sort functionality
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const value = e.target.value;
            let sortedProducts = [...products];

            if (value === 'price-low') {
                sortedProducts.sort((a, b) => (a.final_price || a.price || 0) - (b.final_price || b.price || 0));
            } else if (value === 'price-high') {
                sortedProducts.sort((a, b) => (b.final_price || b.price || 0) - (a.final_price || a.price || 0));
            }

            grid.innerHTML = sortedProducts.map(p => window.app.genProductCard(p)).join('');
        });
    }
});
</script>

</body>
</html>