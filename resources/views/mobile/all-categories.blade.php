<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>All Departments | RAPID RETAILS</title>
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

<body data-page="all-categories">

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

<!-- MODAL -->
<div id="category-modal" class="category-modal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Choose Category</h3>
            <span id="close-category-modal">×</span>
        </div>
        <div class="modal-body">
            <div id="modal-parent-cats"></div>
            <div id="modal-sub-cats"></div>
        </div>
        <button class="modal-apply">APPLY</button>
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

</body>
</html>