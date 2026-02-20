<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products | RAPID RETAILS</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body data-page="all-products">
    <header class="site-header" id="site-header"></header>

    <main class="page-content">
        <div class="container section-container">
            <div class="listing-intro">
                <h1>DISCOVER ALL</h1>
                <p>The global destination for refined shopping.</p>
            </div>
            <div class="listing-main">
                <aside class="sidebar-filters desktop-only">
                    <div class="filter-section">
                        <h4>CATEGORIES</h4>
                        <div id="filter-categories" class="filter-list"></div>
                    </div>
                    <div class="filter-section">
                        <h4>PRICE RANGE</h4>
                        <label class="custom-checkbox"><input type="checkbox"> ₹0 - ₹5,000<span></span></label>
                        <label class="custom-checkbox"><input type="checkbox"> ₹5,001 - ₹15,000<span></span></label>
                        <label class="custom-checkbox"><input type="checkbox"> ₹15,001+<span></span></label>
                    </div>
                </aside>
                <div class="listing-content">
                    <div id="all-products-grid" class="product-grid"></div>
                    <div class="pagination-footer">
                        <button id="load-more" class="btn-load-more">LOAD MORE ITEMS</button>
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

    <script src="{{ asset('mobile/script.js') }}"></script>
</body>
</html>