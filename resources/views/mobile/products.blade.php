<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php
        $pageTitle = 'Products | Her-Ovia';
        $pageDescription = 'Shop beautiful clothing at Her-Ovia. Find co-ord sets, dresses, kurta sets, Indian wear, and contemporary styles with amazing offers.';
        
        if(request()->route('categorySlug')) {
            $categoryName = ucfirst(str_replace('-', ' ', request()->route('categorySlug')));
            $pageTitle = $categoryName . ' | Her-Ovia';
            $pageDescription = 'Shop beautiful ' . $categoryName . ' at Her-Ovia. Discover premium ' . $categoryName . ' with amazing offers. Free shipping on orders above ₹999.';
        }
        
        if(request()->query('subcategory')) {
            $pageDescription = 'Shop beautiful clothing at Her-Ovia. Find the perfect style for every occasion.';
        }
    @endphp

    <title>{{ $pageTitle }}</title>

    <meta name="description" content="{{ $pageDescription }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <meta name="keywords" content="women's clothing, co-ord sets, dresses, kurta sets, Indian wear, ethnic wear, contemporary clothing, women's fashion">
    <meta name="author" content="Her-Ovia">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ filemtime(public_path('mobile/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('mobile/products.css') }}?v={{ filemtime(public_path('mobile/products.css')) }}">
</head>

<body data-page="products" data-subcategory-id="{{ request()->query('subcategory') }}" data-category-id="{{ request()->query('category') }}" data-category-slug="{{ request()->route('categorySlug') }}">
<div class="desktop-sticky-header">
    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <!-- Shared header: rendered by public/mobile/script.js -->
    <header class="site-header" id="site-header"></header>
</div>

    <div class="products-page-wrapper">
        <aside class="desktop-filters-sidebar" id="desktopFiltersSidebar">
            <div class="filter-group" id="filterGroupCategory">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span class="filter-title" id="categoryFilterTitle">CATEGORY</span>
                    <span class="filter-arrow">−</span>
                </div>
                <div class="filter-body" id="desktopCategoryFilters"></div>
            </div>

            <div class="filter-group" id="filterGroupPrice">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span class="filter-title">PRICE</span>
                    <span class="filter-arrow">−</span>
                </div>
                <div class="filter-body" id="desktopPriceFilters"></div>
            </div>

            <div class="filter-group" id="filterGroupBrand">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span class="filter-title">BRANDS</span>
                    <span class="filter-arrow">−</span>
                </div>
                <div class="filter-body" id="desktopBrandFilters"></div>
            </div>

            <div class="filter-group" id="filterGroupDiscount">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span class="filter-title">DISCOUNT</span>
                    <span class="filter-arrow">−</span>
                </div>
                <div class="filter-body" id="desktopDiscountFilters"></div>
            </div>

            <button class="filter-reset" onclick="resetAllFilters()">Reset All Filters</button>
        </aside>

        <div class="desktop-products-area">
            <!-- <div class="sub-strip" id="subStrip"></div> -->
            <div class="products" id="productsGrid"></div>
        </div>
    </div>

    <nav id="mobile-bottom-nav" class="mobile-bottom-nav" aria-label="Mobile navigation"></nav>

    <div class="action-bar">
        <button class="action-btn" onclick="showSortPopup()"><span>⇅</span> Sort</button>
        <button class="action-btn" onclick="showFilterPopup()"><span>⚲</span> Filter</button>
    </div>

    <div class="sort-popup-overlay" id="sortPopupOverlay" onclick="hideSortPopup()">
        <div class="sort-popup-content" onclick="event.stopPropagation()">
            <div class="sort-popup-header">
                <h3>Sort By</h3>
                <span class="sort-popup-close" onclick="hideSortPopup()">×</span>
            </div>
            <div class="sort-popup-body">
                <label class="sort-option"><input type="radio" name="sort" value="price-low"> Price: Low to High</label>
                <label class="sort-option"><input type="radio" name="sort" value="price-high"> Price: High to Low</label>
            </div>
            <div class="sort-popup-footer">
                <button class="sort-apply-btn" onclick="applySort()">Apply</button>
            </div>
        </div>
    </div>

    <div class="filter-popup-overlay" id="filterPopupOverlay" onclick="hideFilterPopup()">
        <div class="filter-popup-content" onclick="event.stopPropagation()">
            <div class="filter-popup-header">
                <h3>Filters</h3>
                <span class="filter-popup-close" onclick="hideFilterPopup()">×</span>
            </div>
            <div class="filter-popup-body">
                <div id="mobileFilterContent"></div>
            </div>
            <div class="filter-popup-footer">
                <button class="reset-btn" onclick="resetMobileFilters()">Reset</button>
                <button class="apply-btn" onclick="applyMobileFilters()">Apply</button>
            </div>
        </div>
    </div>
@include('components.footer')
    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>
    <script src="{{ asset('mobile/script.js') }}?v={{ filemtime(public_path('mobile/script.js')) }}"></script>
    @include('mobile.auth.auth')
</body>
</html>
