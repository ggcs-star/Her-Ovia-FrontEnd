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
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ time() }}">

    @php
        use Illuminate\Support\Facades\Cache;
        use Illuminate\Support\Facades\Http;
        
        $headerCategories = Cache::remember('header_categories_prod', 3600, function() {
            try {
                $response = Http::timeout(3)->get(env('API_BASE_URL') . '/categories');
                if ($response->successful() && $response->json()['success']) {
                    return $response->json()['data'];
                }
            } catch (\Exception $e) {
                \Log::error('Categories fetch failed: ' . $e->getMessage());
            }
            return [];
        });
        
        $appSettings = Cache::remember('header_app_settings_prod', 3600, function() {
            try {
                $response = Http::timeout(3)->get(env('API_BASE_URL') . '/app-settings');
                if ($response->successful() && $response->json()['success']) {
                    return $response->json()['data'];
                }
            } catch (\Exception $e) {
                \Log::error('App settings fetch failed: ' . $e->getMessage());
            }
            return null;
        });
        
        $topCategories = !empty($headerCategories) ? array_slice($headerCategories, 0, 5) : [];
        
        $logoUrl = '';
        if (!empty($appSettings['header_logo'])) {
            $logoUrl = $appSettings['header_logo'];
        } elseif (!empty($appSettings['app_logo'])) {
            $logoUrl = $appSettings['app_logo'];
        }
        if (empty($logoUrl)) {
            $logoUrl = asset('images/her-ovia.png');
        }
    @endphp

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --font-heading: Georgia, "Times New Roman", serif;
        }

        body {
            font-family: var(--font-primary);
            background: #fff;
            padding-bottom: env(safe-area-inset-bottom);
            -webkit-overflow-scrolling: touch;
        }

        h1, h2, h3, h4, .header h1, .page-title, .product-name {
            font-family: var(--font-heading);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: calc(56px + env(safe-area-inset-top));
            padding: env(safe-area-inset-top) 16px 0 16px;
            border-bottom: 1px solid #f0f0f0;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            font-size: 20px;
            cursor: pointer;
            color: #333;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .header-right {
            display: flex;
            gap: 16px;
            font-size: 18px;
        }

        .header-right span {
            cursor: pointer;
        }

        .sub-strip {
            padding: 12px 16px;
            display: flex;
            gap: 16px;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            background: #fff;
            position: sticky;
            top: calc(56px + env(safe-area-inset-top));
            z-index: 999;
            list-style: none !important;
        }

        .sub-strip::-webkit-scrollbar {
            display: none;
        }

        .sub-item {
            min-width: 80px;
            flex-shrink: 0;
            text-align: center;
            cursor: pointer;
            list-style: none !important;
        }

        .sub-item::before,
        .sub-item::after,
        .sub-strip li::before {
            display: none !important;
            content: none !important;
        }

        .sub-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            background: #f8f8f8;
            margin: 0 auto 6px;
            border: 2px solid transparent;
        }

        .sub-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sub-item.active .sub-img {
            border-color: #F4B94E;
        }

        .sub-name {
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }

        .sub-item.active .sub-name {
            color: #F4B94E;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            padding: 16px;
            padding-bottom: calc(130px + env(safe-area-inset-bottom));
        }

        .card {
            cursor: pointer;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            transition: transform .2s, box-shadow .2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        .img-box {
            position: relative;
            aspect-ratio: 3/4;
            background: #f8f8f8;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #F4B94E;
            color: #440C2C;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .wishlist {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            cursor: pointer;
            border: none;
        }

        .wishlist.active {
            color: #e53935 !important;
        }

        .info {
            padding: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .brand {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            margin-bottom: 2px;
        }

        .name {
            font-size: 13px;
            font-weight: 500;
            color: #000;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .current {
            font-size: 15px;
            font-weight: 700;
            color: #000;
        }

        .original {
            font-size: 12px;
            color: #999;
            text-decoration: line-through;
        }

        .off {
            font-size: 11px;
            font-weight: 600;
            color: #F4B94E;
        }

        .action-bar {
            position: fixed;
            bottom: calc(70px + env(safe-area-inset-bottom));
            left: 0;
            right: 0;
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            z-index: 999;
        }

        .action-btn {
            flex: 1;
            padding: 12px;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #333;
        }

        .action-btn:hover {
            background: #e8e8e8;
        }

        .action-btn:active {
            transform: scale(0.97);
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: calc(65px + env(safe-area-inset-bottom));
            padding-bottom: env(safe-area-inset-bottom);
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            z-index: 1000;
        }

        .nav-item-figma {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #666;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            flex: 1;
            transition: color .2s;
            cursor: pointer;
        }

        .nav-item-figma.active {
            color: #F4B94E;
        }

        .nav-icon-box {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .nav-icon-box svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .nav-item-figma.active svg {
            stroke: #F4B94E;
        }

        .products-page-wrapper {
            display: block;
            border: none !important;
        }

        .desktop-products-area {
            border: none !important;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
            grid-column: 1/-1;
        }

        .header-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .header-icon-btn svg {
            stroke: #333;
            fill: none;
        }

        .header-icon-btn:hover svg {
            stroke: #F4B94E;
        }

        .header-left img {
            height: 24px;
            width: 20px;
            object-fit: contain;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
        }

        .web-search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #eaeaec;
            border-radius: 12px;
            margin-top: 6px;
            z-index: 9999;
            max-height: 320px;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            display: none;
        }

        .web-suggestion-item {
            padding: 10px 14px;
            font-size: 14px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .web-suggestion-item:hover {
            background: #f5f5f5;
        }

        .header-actions .action-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #333;
            text-decoration: none;
            font-size: 12px;
        }

        .header-icon {
            width: 18px;
            height: 18px;
            display: inline-block;
            stroke: #333;
            fill: none;
        }

        .header-actions .action-link:hover .header-icon {
            stroke: #F4B94E;
        }

        .web-header .top-bar {
            background: linear-gradient(90deg, #440C2C, #F4B94E, #440C2C, #F4B94E, #440C2C);
            background-size: 300% 100%;
            animation: gradientMove 4s ease infinite;
            color: #fff;
            text-align: center;
            padding: 8px 0;
            font-size: 12px;
            font-weight: 500;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        #cart-count-badge,
        #web-cart-count-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #440C2C;
            color: #F4B94E;
            font-size: 10px;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .cart-icon-wrapper {
            position: relative;
            display: inline-block;
        }

        .site-header {
            background: #F8EEE3 !important;
            border-bottom: 1px solid #DCC0A8 !important;
        }

        .web-header {
            background: #F8EEE3 !important;
        }

        .main-header {
            background: #F8EEE3 !important;
        }

        .sort-popup-overlay,
        .filter-popup-overlay {
            display: none;
        }

        .cart-count-badge {
            display: none;
        }

        .desktop-filters-sidebar {
            display: none !important;
        }

        @media screen and (min-width: 1024px) {
            .header {
                display: none !important;
            }

            .product-desktop-header {
                display: block !important;
                position: sticky;
                top: 0;
                z-index: 1001;
                background: #fff;
            }

            .products-page-wrapper {
                display: flex;
                max-width: 1440px;
                margin: 0 auto;
                gap: 24px;
                padding: 20px 24px;
            }

            .desktop-filters-sidebar {
                display: block !important;
                width: 280px;
                flex-shrink: 0;
                background: #fff;
                border-radius: 0;
                position: sticky;
                top: calc(56px + 20px);
                height: fit-content;
                max-height: calc(100vh - 80px);
                overflow-y: auto;
                padding: 20px;
                border: 1px solid #e8e8e8;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                
            }

            .action-bar {
                display: none !important;
            }

            .desktop-products-area {
                flex: 1;
                min-width: 0;
            }

            .products {
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 20px;
                padding: 0 0 40px 0;
            }

            .sub-strip {
                position: relative;
                top: 0;
                padding: 16px 0 20px 0;
                margin-bottom: 20px;
                background: transparent;
                gap: 20px;
                display: flex !important;
            }

            .sub-item {
                min-width: 70px;
            }

            .sub-img {
                width: 70px;
                height: 70px;
            }

            .filter-group {
                margin-bottom: 24px;
                border-bottom: 1px solid #f0f0f0;
                padding-bottom: 16px;
            }

            .filter-group:last-child {
                border-bottom: none;
            }

            .filter-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
                padding: 4px 0 10px 0;
            }

            .filter-title {
                font-size: 13px;
                font-weight: 700;
                color: #000;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .filter-arrow {
                font-size: 18px;
                color: #F4B94E;
                font-weight: 300;
                transition: transform .3s ease;
            }

            .filter-group.closed .filter-arrow {
                transform: rotate(180deg);
            }

            .filter-body {
                display: block;
                padding-top: 4px;
            }

            .filter-group.closed .filter-body {
                display: none;
            }

            .filter-option {
                display: flex;
                align-items: center;
                padding: 6px 0;
                font-size: 13px;
                color: #666;
                cursor: pointer;
                transition: color .2s;
            }

            .filter-option:hover {
                color: #F4B94E;
            }

            .filter-option input[type="checkbox"] {
                -webkit-appearance: none;
                appearance: none;
                width: 16px;
                height: 16px;
                border: 2px solid #ccc;
                border-radius: 3px;
                outline: none;
                cursor: pointer;
                margin-right: 10px;
                position: relative;
                vertical-align: middle;
                background: #fff;
                flex-shrink: 0;
            }

            .filter-option input[type="checkbox"]:checked {
                background: #F4B94E;
                border-color: #F4B94E;
            }

            .filter-option input[type="checkbox"]:checked::after {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #fff;
                font-size: 11px;
                font-weight: 700;
            }

            .filter-reset {
                width: 100%;
                padding: 10px;
                background: #f5f5f5;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                color: #333;
                margin-top: 8px;
                transition: all .2s;
            }

            .filter-reset:hover {
                background: #e8e8e8;
                border-color: #ccc;
            }

            .price-slider-wrap {
                padding: 4px 0 8px 0;
            }

            .price-slider-wrap input[type="range"] {
                width: 100%;
                accent-color: #F4B94E;
                height: 4px;
                -webkit-appearance: none;
                appearance: none;
                background: linear-gradient(to right, #F4B94E 100%, #ddd 100%);
                border-radius: 10px;
                outline: none;
            }

            .price-slider-wrap input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background: #F4B94E;
                cursor: pointer;
                border: 2px solid #fff;
                box-shadow: 0 1px 4px rgba(0,0,0,0.15);
            }

            .price-labels {
                display: flex;
                justify-content: space-between;
                font-size: 12px;
                color: #999;
                margin-top: 4px;
            }

            .bottom-nav {
                display: none;
            }

            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }

            .all-categories-popup {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #fff;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                z-index: 9999;
                border-top: 1px solid #f0f0f0;
                max-height: 500px;
                overflow-y: auto;
                display: none;
            }
        }

        @media screen and (max-width: 1024px) {
            .product-desktop-header {
                display: none !important;
            }

            .header {
                display: flex !important;
            }

            .desktop-filters-sidebar {
                display: none !important;
            }

            .products-page-wrapper {
                display: block !important;
            }

            .desktop-products-area {
                width: 100% !important;
            }

            .sub-strip {
                display: flex !important;
            }
        }

        @media screen and (max-width: 767px) {
            .desktop-filters-sidebar {
                display: none !important;
            }

            .products-page-wrapper {
                display: block !important;
            }

            .sub-strip {
                display: flex !important;
            }
            
        }
        
        .sort-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: flex-end;
            justify-content: center;
            z-index: 10001;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sort-popup-overlay.active {
            opacity: 1;
            visibility: visible;
            display: flex !important;
        }

        .sort-popup-content {
            background: #fff;
            width: 100%;
            max-width: 500px;
            border-radius: 20px 20px 0 0;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sort-popup-overlay.active .sort-popup-content {
            transform: translateY(0);
        }

        .sort-popup-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sort-popup-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin: 0;
        }

        .sort-popup-close {
            font-size: 24px;
            cursor: pointer;
            color: #999;
            line-height: 1;
        }

        .sort-popup-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .sort-option {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            font-size: 15px;
            color: #333;
        }

        .sort-option input[type="radio"] {
            margin-right: 12px;
            accent-color: #F4B94E;
        }

        .sort-popup-footer {
            padding: 16px 20px;
            border-top: 1px solid #f0f0f0;
        }

        .sort-apply-btn {
            width: 100%;
            padding: 14px;
            background: #F4B94E;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ============================================
        MOBILE FILTER POPUP
        ============================================ */
        .filter-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: flex-end;
            justify-content: center;
            z-index: 10001;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .filter-popup-overlay.active {
            opacity: 1;
            visibility: visible;
            display: flex !important;
        }

        .filter-popup-content {
            background: #fff;
            width: 100%;
            max-width: 500px;
            border-radius: 20px 20px 0 0;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .filter-popup-overlay.active .filter-popup-content {
            transform: translateY(0);
        }

        .filter-popup-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-popup-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin: 0;
        }

        .filter-popup-close {
            font-size: 24px;
            cursor: pointer;
            color: #999;
            line-height: 1;
        }

        .filter-popup-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .filter-popup-footer {
            padding: 16px 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 12px;
        }

        .reset-btn {
            flex: 1;
            padding: 14px;
            background: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .apply-btn {
            flex: 2;
            padding: 14px;
            background: #F4B94E;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ============================================
        FILTER OPTIONS INSIDE POPUP
        ============================================ */
        .filter-checkbox {
            display: block;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }

        .filter-checkbox input[type="checkbox"] {
            margin-right: 12px;
            accent-color: #F4B94E;
        }

        .filter-checkbox:hover {
            background: #f8f8f8;
        }

        /* ============================================
        RESPONSIVE - HIDE ON DESKTOP
        ============================================ */
        @media screen and (min-width: 1024px) {
            .sort-popup-overlay,
            .filter-popup-overlay {
                display: none !important;
            }
            /* ✅ CART BADGE VISIBLE */
#cart-count-badge,
#web-cart-count-badge,
.cart-count-badge {
    display: flex !important;
    align-items: center;
    justify-content: center;
    background: #440C2C;
    color: #F4B94E;
    font-size: 10px;
    font-weight: 600;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    padding: 0 4px;
    position: absolute;
    top: -6px;
    right: -10px;
    z-index: 10;
}

/* ✅ MOBILE NAV BADGE */
.nav-icon-box {
    position: relative !important;
}
            
}
    </style>
</head>

<body data-page="products" data-subcategory-id="{{ request()->query('subcategory') }}" data-category-id="{{ request()->query('category') }}" data-category-slug="{{ request()->route('categorySlug') }}">

    <div class="header">
        <div class="header-left">
            <span class="back-btn" onclick="goBack()">←</span>
        </div>
        <div class="header-right">
    <button class="search-icon-btn" onclick="window.location.href='/search'" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="10" cy="10" r="7"/>
            <line x1="21" y1="21" x2="15" y2="15"/>
        </svg>
    </button>
    <button class="wishlist-icon-btn" onclick="window.location.href='/wishlist'" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
    </button>
    <button onclick="window.location.href='/cart'" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;position:relative;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1.5"/>
            <circle cx="18" cy="21" r="1.5"/>
            <path d="M2 2h3l3 12h11l2-8H6"/>
        </svg>
        <span id="mobile-cart-badge" style="position:absolute;top:-6px;right:-6px;background:#440C2C;color:#F4B94E;font-size:10px;font-weight:600;min-width:16px;height:16px;border-radius:50%;display:none;align-items:center;justify-content:center;padding:0 3px;">0</span>
    </button>
</div>
    </div>

    <div class="product-desktop-header">
        <div class="web-header">
            <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
            <div class="main-header">
                <div class="logo-area">
                    <a href="/" class="logo">
                        <img id="desktopHeaderLogo" class="site-logo" src="{{ $logoUrl }}" alt="Her-Ovia" onerror="this.style.display='none'">
                    </a>
                    <nav class="nav-menu" id="productNavMenu">
                        @if(!empty($topCategories))
                            @foreach($topCategories as $cat)
    @php
        // ✅ SAHI - API se aaya hua slug use karo
        $slug = isset($cat['slug']) && !empty($cat['slug']) 
            ? $cat['slug'] 
            : strtolower(preg_replace('/[^a-z0-9]+/i', '-', $cat['name']));
        $slug = trim($slug, '-');
        
        $url = ($slug === 'trending' || $slug === 'bestsellers') 
            ? '/top-selling' 
            : "/collection/{$slug}";
    @endphp
    <a href="{{ $url }}" class="nav-item" data-cat-id="{{ $cat['id'] }}" data-cat-name="{{ $cat['name'] }}">
        {{ strtoupper($cat['name']) }}
    </a>
@endforeach
                        @endif
                    </nav>
                </div>
                <div class="search-area">
                    <div class="search-box">
                        <input type="text" id="web-search-input" placeholder="Search for {{ request()->route('categorySlug') ? ucfirst(str_replace('-', ' ', request()->route('categorySlug'))) : 'Products' }}" autocomplete="off">
                        <button class="search-icon-btn" aria-label="Search">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="10" cy="10" r="7"/>
                                <line x1="21" y1="21" x2="15" y2="15"/>
                            </svg>
                        </button>
                        <div id="web-search-suggestions" class="web-search-suggestions"></div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="javascript:void(0)" class="action-link" onclick="if(!localStorage.getItem('token')){showLoginPopup();}else{window.location.href='/profile';}">
                        <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
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
        <div class="all-categories-popup" id="productAllCategoriesPopup"></div>
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
            <div class="sub-strip" id="subStrip"></div>
            <div class="products" id="productsGrid"></div>
        </div>
    </div>

    <div class="action-bar">
        <button class="action-btn" onclick="showSortPopup()"><span>⇅</span> Sort</button>
        <button class="action-btn" onclick="showFilterPopup()"><span>⚲</span> Filter</button>
    </div>

    <div class="bottom-nav">
        <a href="/" class="nav-item-figma">
            <div class="nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Home</span>
        </a>
        <a href="/categories" class="nav-item-figma active">
            <div class="nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="13" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="13" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Categories</span>
        </a>
        <a href="/cart" class="nav-item-figma">
            <div class="nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6"/>
                    <circle cx="9" cy="21" r="1.5"/>
                    <circle cx="20" cy="21" r="1.5"/>
                </svg>
                <span id="cart-count-badge" class="cart-count-badge">0</span>
            </div>
            <span>Cart</span>
        </a>
        <a href="javascript:void(0)" class="nav-item-figma" onclick="if(!localStorage.getItem('token')){showLoginPopup();}else{window.location.href='/profile';}">
            <div class="nav-icon-box">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <span>Profile</span>
        </a>
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

    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
        window.goBack = function() {
            if (window.location.pathname === '/cart' || window.location.pathname.includes('/checkout')) {
                window.location.href = '/';
            } else {
                window.history.back();
            }
        };
        window.showLoginPopup = function() {
            window.location.href = '/login';
        };

        (function() {
            var CACHE_DURATION = 300000;
            var grid = document.getElementById('productsGrid');
            var subStrip = document.getElementById('subStrip');
            var categoryFilters = document.getElementById('desktopCategoryFilters');
            var categoryTitle = document.getElementById('categoryFilterTitle');
            var priceFilters = document.getElementById('desktopPriceFilters');
            var brandFilters = document.getElementById('desktopBrandFilters');
            var discountFilters = document.getElementById('desktopDiscountFilters');
            var resetBtn = document.querySelector('.filter-reset');
            var popup = document.getElementById('productAllCategoriesPopup');
            var navItems = document.querySelectorAll('#productNavMenu .nav-item');
            var currentProducts = [];
            var originalProducts = [];
            var allCategories = [];
            var mainCategoryData = null;
            var priceSlider = null;
            var currentSubId = null;

            function getCache(k) {
                try {
                    var c = localStorage.getItem(k);
                    if (c) {
                        var p = JSON.parse(c);
                        if (p.timestamp && (Date.now() - p.timestamp) < CACHE_DURATION) {
                            return p.data;
                        }
                    }
                } catch (e) {}
                return null;
            }

            function setCache(k, d) {
                try {
                    localStorage.setItem(k, JSON.stringify({ data: d, timestamp: Date.now() }));
                } catch (e) {}
            }

            function getPrice(p) {
                return parseFloat(p.product_price || p.price || 0);
            }

            function getMrp(p) {
                return parseFloat(p.price || p.mrp || p.product_price || 0);
            }

            function formatPrice(n) {
                return '₹' + Number(n).toLocaleString('en-IN');
            }

            function renderProducts(products) {
                    if (!grid) return;
                    if (!products || products.length === 0) {
                        grid.innerHTML = '<div class="loading">No products found</div>';
                        return;
                    }
                    var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
                    var fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
                    var html = '';
                    for (var i = 0; i < products.length; i++) {
                        var p = products[i];
                        var price = getPrice(p);
                        var mrp = getMrp(p);
                        var discount = 0;
                        if (mrp > price) {
                            discount = Math.round(((mrp - price) / mrp) * 100);
                        } else if (p.discount && p.discount.value) {
                            discount = parseFloat(p.discount.value);
                        }
                        var inWish = wishlist.some(function(item) { return item.id == p.id; });
                        var mainImg = p.image_url || fallback;
                        var isBest = discount > 20;
                        
                        // ✅ SAFE PRODUCT DATA - ESCAPE SINGLE QUOTES
                        var productData = {
                            id: p.id,
                            name: p.name.replace(/'/g, "\\'"),
                            price: price,
                            image: mainImg,
                            brand: (p.brand || '').replace(/'/g, "\\'"),
                            slug: p.slug
                        };
                        var productDataStr = JSON.stringify(productData);
                        
                        html += '<div class="card" data-product-id="' + p.id + '" data-product-slug="' + p.slug + '">' +
                        '<div class="img-box">'  +
                        '<img src="' + mainImg + '" onerror="this.src=\'' + fallback + '\'" loading="lazy" alt="' + p.name.replace(/'/g, "\\'") + '">' +
                        (isBest ? '<span class="badge">Best Seller</span>' : '') +
                        '<button type="button" class="wishlist ' + (inWish ? 'active' : '') + '" onclick=\'toggleWish(event, this, JSON.parse(decodeURIComponent("' + encodeURIComponent(productDataStr) + '")))\'>' +
                        (inWish ? '❤️' : '♡') +
                        '</button>' +
                        '</div>' +
                        '<div class="info" onclick="window.location.href=\'/product/' + p.slug + '\'">' +
                        '<div class="brand">' + (p.brand || 'RAPID RETAIL') + '</div>' +
                        '<div class="name">' + p.name + '</div>' +
                        '<div class="price">' +
                        '<span class="current">' + formatPrice(price) + '</span>' +
                        (mrp > price ? '<span class="original">' + formatPrice(mrp) + '</span>' : '') +
                        (discount > 0 ? '<span class="off">' + discount + '% Off</span>' : '') +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    }
                    grid.innerHTML = html;
                    

                var cards = grid.querySelectorAll('.card');

                cards.forEach(function(card) {
                    card.addEventListener('click', function(e) {

                        if (e.target.closest('.wishlist')) {
                            return;
                        }

                        var slug = card.getAttribute('data-product-slug');

                        if (slug) {
                            window.location.href = '/product/' + slug;
                        }
                    });
                });
                }

            function loadCategoryFilters(mainCategory) {
                if (!categoryFilters || !categoryTitle) return;
                if (!mainCategory || !mainCategory.children || mainCategory.children.length === 0) {
                    categoryFilters.innerHTML = '';
                    categoryTitle.textContent = 'CATEGORY';
                    return;
                }
                var hasSubSub = false;
                var subCategoryName = '';
                var subCategoryId = null;
                for (var i = 0; i < mainCategory.children.length; i++) {
                    if (mainCategory.children[i].children && mainCategory.children[i].children.length > 0) {
                        hasSubSub = true;
                        subCategoryName = mainCategory.children[i].name;
                        subCategoryId = mainCategory.children[i].id;
                        break;
                    }
                }
                var html = '';
                if (hasSubSub) {
                    categoryTitle.textContent = subCategoryName;
                    for (var ci = 0; ci < mainCategory.children.length; ci++) {
                        var child = mainCategory.children[ci];
                        if (child.children && child.children.length > 0) {
                            for (var si = 0; si < child.children.length; si++) {
                                var subSub = child.children[si];
                                html += '<label class="filter-option"><input type="checkbox" class="desktop-category-filter" value="' + subSub.id + '" onchange="applyFilters()"> ' + subSub.name + '</label>';
                            }
                        }
                    }
                } else {
                    categoryTitle.textContent = mainCategory.children[0] ? mainCategory.children[0].name : 'CATEGORY';
                    for (var ci2 = 0; ci2 < mainCategory.children.length; ci2++) {
                        html += '<label class="filter-option"><input type="checkbox" class="desktop-category-filter" value="' + mainCategory.children[ci2].id + '" onchange="applyFilters()"> ' + mainCategory.children[ci2].name + '</label>';
                    }
                }
                categoryFilters.innerHTML = html;
            }

            function loadPriceFilter(products) {
                if (!priceFilters) return;
                var prices = [];
                for (var i = 0; i < products.length; i++) {
                    var p = getPrice(products[i]);
                    if (p > 0) prices.push(p);
                }
                if (prices.length === 0) {
                    priceFilters.innerHTML = '';
                    return;
                }
                var minPrice = Math.min.apply(null, prices);
                var maxPrice = Math.max.apply(null, prices);
                priceFilters.innerHTML = '<div class="price-slider-wrap"><input type="range" id="priceRangeSlider" min="0" max="100" value="100"><div class="price-labels"><span>₹0</span><span>₹' + (maxPrice + 100) + '</span></div></div>';
                var slider = document.getElementById('priceRangeSlider');
                if (slider) {
                    priceSlider = slider;
                    slider.addEventListener('input', function() {
                        var val = parseInt(this.value);
                        var max = maxPrice + 100;
                        var currentMax = Math.round((val / 100) * max);
                        var labels = this.parentElement.querySelector('.price-labels');
                        if (labels) {
                            labels.innerHTML = '<span>₹0</span><span>₹' + currentMax + '</span>';
                        }
                        applyPriceRange(currentMax);
                    });
                }
            }

            function loadBrandFilter(products) {
                if (!brandFilters) return;
                var brands = [];
                var brandSet = {};
                for (var i = 0; i < products.length; i++) {
                    if (products[i].brand && !brandSet[products[i].brand]) {
                        brandSet[products[i].brand] = true;
                        brands.push(products[i].brand);
                    }
                }
                if (brands.length === 0) {
                    brandFilters.innerHTML = '';
                    return;
                }
                var html = '';
                for (var b = 0; b < brands.length; b++) {
                    html += '<label class="filter-option"><input type="checkbox" class="desktop-brand-filter" value="' + brands[b] + '" onchange="applyFilters()"> ' + brands[b] + '</label>';
                }
                brandFilters.innerHTML = html;
            }

            function loadDiscountFilter(products) {
                if (!discountFilters) return;
                var discounts = {};
                for (var i = 0; i < products.length; i++) {
                    var p = products[i];
                    if (p.price && p.final_price) {
                        var original = parseFloat(p.price);
                        var final = parseFloat(p.final_price);
                        if (original > final) {
                            var disc = Math.round(((original - final) / original) * 100);
                            if (disc > 0) discounts[disc] = true;
                        }
                    }
                }
                var keys = Object.keys(discounts);
                if (keys.length === 0) {
                    discountFilters.innerHTML = '';
                    return;
                }
                keys.sort(function(a, b) { return a - b; });
                var html = '';
                for (var d = 0; d < keys.length; d++) {
                    html += '<label class="filter-option"><input type="checkbox" class="desktop-discount-filter" value="' + keys[d] + '" onchange="applyFilters()"> ' + keys[d] + '% & above</label>';
                }
                discountFilters.innerHTML = html;
            }

            function applyPriceRange(maxPrice) {
                var filtered = [];
                for (var i = 0; i < originalProducts.length; i++) {
                    if (getPrice(originalProducts[i]) <= maxPrice) filtered.push(originalProducts[i]);
                }
                if (filtered.length > 0) {
                    renderProducts(filtered);
                } else {
                    grid.innerHTML = '<div class="loading">No products in this price range</div>';
                }
            }

            window.applyFilters = function() {
            var catChecks = document.querySelectorAll('.desktop-category-filter:checked');
            var brandChecks = document.querySelectorAll('.desktop-brand-filter:checked');
            var discChecks = document.querySelectorAll('.desktop-discount-filter:checked');
            
            // ✅ Agar koi filter nahi hai - sab products dikhao
            if (catChecks.length === 0 && brandChecks.length === 0 && discChecks.length === 0) {
                renderProducts(originalProducts);
                return;
            }
            
            // ✅ Agar sirf 1 category select hai - uski products dikhao
            if (catChecks.length === 1 && brandChecks.length === 0 && discChecks.length === 0) {
                changeSubcategory(catChecks[0].value);
                return;
            }
            
            // ✅ MULTIPLE CATEGORIES - Sab categories ki products fetch karo
            var categoryIds = [];
            catChecks.forEach(function(check) {
                categoryIds.push(check.value);
            });
            
            grid.innerHTML = '<div class="loading">Loading products...</div>';
            
            var allProducts = [];
            var fetchPromises = [];
            var totalCategories = categoryIds.length;
            var loadedCount = 0;
            
            // ✅ Sab categories ke products fetch karo (Parallel)
            categoryIds.forEach(function(catId) {
                var cacheKey = 'products_' + catId;
                var cached = getCache(cacheKey);
                
                if (cached && cached.length > 0) {
                    allProducts = allProducts.concat(cached);
                    loadedCount++;
                    if (loadedCount === totalCategories) {
                        renderFilteredProducts(allProducts, brandChecks, discChecks);
                    }
                } else {
                    var promise = fetch(API_BASE_URL + '/categories/' + catId + '/products')
                        .then(function(r) { return r.json(); })
                        .then(function(data) {
                            if (data.success && data.data && data.data.products) {
                                var products = data.data.products;
                                setCache(cacheKey, products);
                                allProducts = allProducts.concat(products);
                            }
                            loadedCount++;
                            if (loadedCount === totalCategories) {
                                renderFilteredProducts(allProducts, brandChecks, discChecks);
                            }
                        });
                    fetchPromises.push(promise);
                }
            });
            
    if (fetchPromises.length > 0) {
        Promise.all(fetchPromises).then(function() {
        });
    }
};

            function renderFilteredProducts(products, brandChecks, discChecks) {
                // ✅ Remove duplicates
                var unique = [];
                var seen = {};
                products.forEach(function(p) {
                    if (!seen[p.id]) {
                        seen[p.id] = true;
                        unique.push(p);
                    }
                });
                
                var filtered = unique;
                
                // ✅ Brand filter
                if (brandChecks && brandChecks.length > 0) {
                    var brands = {};
                    brandChecks.forEach(function(b) { brands[b.value] = true; });
                    filtered = filtered.filter(function(p) { return brands[p.brand]; });
                }
                
                // ✅ Discount filter
                if (discChecks && discChecks.length > 0) {
                    var discs = {};
                    discChecks.forEach(function(d) { discs[parseInt(d.value)] = true; });
                    filtered = filtered.filter(function(p) {
                        if (p.price && p.final_price) {
                            var original = parseFloat(p.price);
                            var final = parseFloat(p.final_price);
                            if (original > final) {
                                var disc = Math.round(((original - final) / original) * 100);
                                var keys = Object.keys(discs);
                                for (var i = 0; i < keys.length; i++) {
                                    if (disc >= parseInt(keys[i])) return true;
                                }
                            }
                        }
                        return false;
                    });
                }
                
                if (filtered.length > 0) {
                    renderProducts(filtered);
                } else {
                    grid.innerHTML = '<div class="loading">No products match filters</div>';
                }
            }

            window.resetAllFilters = function() {
                var allChecks = document.querySelectorAll('.desktop-category-filter, .desktop-brand-filter, .desktop-discount-filter');
                for (var i = 0; i < allChecks.length; i++) {
                    allChecks[i].checked = false;
                }
                if (priceSlider) {
                    priceSlider.value = 100;
                    var maxLabel = document.querySelector('.price-labels');
                    if (maxLabel) {
                        var parts = maxLabel.textContent.split('₹');
                        if (parts.length > 1) {
                            var maxVal = parseInt(parts[1].replace(/,/g, ''));
                            if (!isNaN(maxVal)) {
                                var maxPrice = maxVal;
                                var filtered = [];
                                for (var pi = 0; pi < originalProducts.length; pi++) {
                                    if (getPrice(originalProducts[pi]) <= maxPrice) filtered.push(originalProducts[pi]);
                                }
                                if (filtered.length > 0) {
                                    renderProducts(filtered);
                                } else {
                                    grid.innerHTML = '<div class="loading">No products in this price range</div>';
                                }
                            }
                        }
                    }
                }
                renderProducts(originalProducts);
            };

            window.toggleFilter = function(header) {
                var group = header.parentElement;
                group.classList.toggle('closed');
                var arrow = header.querySelector('.filter-arrow');
                if (arrow) {
                    arrow.textContent = group.classList.contains('closed') ? '+' : '−';
                }
            };

            window.toggleWish = function(event, btn, product) {

    event.preventDefault();
    event.stopPropagation();

    var wishlist = JSON.parse(
        localStorage.getItem('wishlist') || '[]'
    );

    var exists = wishlist.some(function(item) {
        return item.id == product.id;
    });

    if (exists) {

        wishlist = wishlist.filter(function(item) {
            return item.id != product.id;
        });

        btn.innerHTML = '♡';
        btn.classList.remove('active');

    } else {

        wishlist.push(product);

        btn.innerHTML = '❤️';
        btn.classList.add('active');
    }

    localStorage.setItem(
        'wishlist',
        JSON.stringify(wishlist)
    );

    return false;
};
                
            window.changeSubcategory = function(newSubId) {
                currentSubId = newSubId;
                var items = document.querySelectorAll('.sub-item');
                for (var i = 0; i < items.length; i++) {
                    if (items[i].dataset.subid == newSubId) {
                        items[i].classList.add('active');
                    } else {
                        items[i].classList.remove('active');
                    }
                }
                fetchProducts(newSubId);
            };

            async function fetchProducts(subId) {
                if (!grid) return;
                
                var cacheKey = 'products_' + subId;
                var cached = getCache(cacheKey);
                if (cached && cached.length > 0) {
                    currentProducts = cached;
                    originalProducts = cached.slice(0);
                    renderProducts(cached);
                    updateFilters(cached);
                    return;
                }
                
                grid.innerHTML = '<div class="loading">Loading products...</div>';
                
                try {
                    // ✅ Step 1: Direct products fetch
                    var res = await fetch(API_BASE_URL + '/categories/' + subId + '/products');
                    var data = await res.json();
                    
                    if (data.success && data.data && data.data.products && data.data.products.length > 0) {
                        // ✅ Products hain - show karo
                        var products = data.data.products;
                        currentProducts = products;
                        originalProducts = products.slice(0);
                        setCache(cacheKey, products);
                        renderProducts(products);
                        updateFilters(products);
                        return;
                    }
                    
                    // ✅ Step 2: Direct products nahi hain - children check
                    var catRes = await fetch(API_BASE_URL + '/categories');
                    var catData = await catRes.json();
                    
                    if (catData.success && catData.data) {
                        var currentCat = findCategory(catData.data, subId);
                        
                        if (currentCat && currentCat.children && currentCat.children.length > 0) {
                            // ✅ Pehle child ki products fetch (RECURSIVE)
                            await fetchProducts(currentCat.children[0].id);
                            return;
                        }
                    }
                    
                    // ❌ Koi products nahi mili
                    grid.innerHTML = '<div class="loading">No products found</div>';
                    
                } catch (e) {
                    console.error('Fetch error:', e);
                    grid.innerHTML = '<div class="loading">Error loading products</div>';
                }
            }

            // ✅ Helper: Category finder
            function findCategory(categories, categoryId) {
                for (var i = 0; i < categories.length; i++) {
                    if (categories[i].id == categoryId) return categories[i];
                    if (categories[i].children) {
                        var found = findCategory(categories[i].children, categoryId);
                        if (found) return found;
                    }
                }
                return null;
            }

            function updateFilters(products) {
                loadPriceFilter(products);
                loadBrandFilter(products);
                loadDiscountFilter(products);
            }

            async function fetchCategories() {
                var cached = getCache('categories_all');
                if (cached) {
                    allCategories = cached;
                    processCategories(cached);
                    return;
                }
                try {
                    var res = await fetch(API_BASE_URL + '/categories');
                    var data = await res.json();
                    if (data.success && data.data) {
                        allCategories = data.data;
                        setCache('categories_all', data.data);
                        processCategories(data.data);
                    }
                } catch (e) {}
            }

            function processCategories(categories) {
                var path = window.location.pathname;
                var match = path.match(/\/collection\/([^\/]+)(?:\/([^\/]+))?/);
                var targetSubId = null;
                var targetSubSubId = null;
                var mainCategoryFound = null;
                
                if (match && match[1]) {
                    var mainSlug = match[1];
                    var subSlug = match[2] || null;
                    
                    for (var i = 0; i < categories.length; i++) {
                        var cat = categories[i];
                        var catSlug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                        
                        if (catSlug === mainSlug) {
                            mainCategoryFound = cat;
                            mainCategoryData = cat;
                            
                            if (subSlug) {
                                for (var s = 0; s < cat.children.length; s++) {
                                    var sub = cat.children[s];
                                    var subCatSlug = sub.slug || sub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                    if (subCatSlug === subSlug) {
                                        targetSubId = sub.id;
                                        break;
                                    }
                                    if (sub.children) {
                                        for (var ss = 0; ss < sub.children.length; ss++) {
                                            var subSub = sub.children[ss];
                                            var subSubSlug = subSub.slug || subSub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                            if (subSubSlug === subSlug) {
                                                targetSubSubId = subSub.id;
                                                targetSubId = sub.id;
                                                break;
                                            }
                                        }
                                        if (targetSubId) break;
                                    }
                                }
                            }
                            
                            // ✅ MAIN POINT: Agar main category hai toh pehli sub-subcategory le lo
                            if (!targetSubId && cat.children && cat.children.length > 0) {
                                var firstSub = cat.children[0];
                                if (firstSub.children && firstSub.children.length > 0) {
                                    // ✅ SUB-SUBCATEGORY LE LO (jahan products hain)
                                    targetSubId = firstSub.children[0].id;
                                } else {
                                    targetSubId = firstSub.id;
                                }
                            }
                            break;
                        }
                    }
                }
                
                if (!mainCategoryFound && categories.length > 0) {
                    mainCategoryData = categories[0];
                    if (mainCategoryData.children && mainCategoryData.children.length > 0) {
                        var firstSub = mainCategoryData.children[0];
                        if (firstSub.children && firstSub.children.length > 0) {
                            targetSubId = firstSub.children[0].id;
                        } else {
                            targetSubId = firstSub.id;
                        }
                    } else {
                        targetSubId = mainCategoryData.id;
                    }
                }
                
                if (targetSubSubId) {
                    targetSubId = targetSubSubId;
                }
                
                if (targetSubId && mainCategoryData) {
                    loadCategoryFilters(mainCategoryData);
                    renderSubcategories(mainCategoryData);
                    fetchProducts(targetSubId);
                } else if (targetSubId) {
                    fetchProducts(targetSubId);
                } else {
                    grid.innerHTML = '<div class="loading">No category found</div>';
                }
            }

            function renderSubcategories(mainCategory) {
                if (!subStrip) return;
                var children = getAllChildren(mainCategory);
                if (!children || children.length === 0) {
                    subStrip.style.display = 'none';
                    return;
                }
                var fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
                var html = '';
                for (var i = 0; i < children.length; i++) {
                    var sub = children[i];
                    // html += '<div class="sub-item" data-subid="' + sub.id + '" onclick="changeSubcategory(' + sub.id + ')">' +
                    //     '<div class="sub-img"><img src="' + (sub.image_url || fallback) + '" onerror="this.src=\'' + fallback + '\'"></div>' +
                    //     '<div class="sub-name">' + sub.name + '</div>' +
                    //     '</div>';
                }
                subStrip.innerHTML = html;
                subStrip.style.display = 'flex';
            }

            function getAllChildren(category) {
                var result = [];
                if (category.children) {
                    for (var i = 0; i < category.children.length; i++) {
                        result.push(category.children[i]);
                        if (category.children[i].children) {
                            for (var j = 0; j < category.children[i].children.length; j++) {
                                result.push(category.children[i].children[j]);
                            }
                        }
                    }
                }
                return result;
            }

            function setupPopup() {
                if (!popup || !navItems.length) return;
                var hideTimeout;

                function showPopup() {
                    if (hideTimeout) clearTimeout(hideTimeout);
                    var cached = getCache('categories_all');
                    if (cached) {
                        renderPopup(cached);
                        popup.style.display = 'block';
                    } else {
                        fetch(API_BASE_URL + '/categories').then(function(r) { return r.json() }).then(function(data) {
                            if (data.success && data.data) {
                                setCache('categories_all', data.data);
                                renderPopup(data.data);
                                popup.style.display = 'block';
                            }
                        }).catch(function() {});
                    }
                }

                function hidePopup() {
                    hideTimeout = setTimeout(function() {
                        popup.style.display = 'none';
                    }, 300);
                }

                function renderPopup(categories) {
                    var withSub = [];
                    for (var i = 0; i < categories.length; i++) {
                        if (categories[i].children && categories[i].children.length > 0) withSub.push(categories[i]);
                    }
                    if (withSub.length === 0) {
                        popup.innerHTML = '';
                        return;
                    }
                    var colSize = Math.ceil(withSub.length / 5);
                    var html = '<div style="max-width:1200px;margin:0 auto;padding:30px;display:grid;grid-template-columns:repeat(5,1fr);gap:25px;">';
                    for (var c = 0; c < 5; c++) {
                        var col = withSub.slice(c * colSize, (c + 1) * colSize);
                        if (!col.length) continue;
                        html += '<div>';
                        for (var ci = 0; ci < col.length; ci++) {
                            var cat = col[ci];
                            
                            // ✅ MAIN CATEGORY SLUG
                            var catSlug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                            var catUrl = '/collection/' + catSlug;
                            if (catSlug === 'trending') catUrl = '/top-selling';
                            else if (catSlug === 'bestsellers') catUrl = '/best-selling';
                            
                            html += '<div style="margin-bottom:20px;"><h3 style="font-size:14px;font-weight:700;color:#282c3f;margin-bottom:12px;border-bottom:2px solid #F4B94E;padding-bottom:6px;display:inline-block;"><a href="' + catUrl + '" style="color:#282c3f;text-decoration:none;">' + cat.name + '</a></h3><ul style="list-style:none;padding:0;margin-top:12px;">';
                            
                            if (cat.children) {
                                for (var si = 0; si < cat.children.length && si < 8; si++) {
                                    var sub = cat.children[si];
                                    
                                    // ✅ SUB-CATEGORY SLUG
                                    var subSlug = sub.slug || sub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                    
                                    // 🔥 IMPORTANT: Sub-category ka URL main category + sub category
                                    var subUrl = '/collection/' + catSlug + '/' + subSlug;
                                    
                                    // Agar sub-category trending/bestseller hai toh override
                                    if (subSlug === 'trending') subUrl = '/top-selling';
                                    else if (subSlug === 'bestsellers') subUrl = '/best-selling';
                                    
                                    html += '<li style="margin-bottom:8px;"><a href="' + subUrl + '" style="text-decoration:none;color:#696b79;font-size:13px;display:block;padding:4px 0;" onmouseover="this.style.color=\'#F4B94E\'" onmouseout="this.style.color=\'#696b79\'">' + sub.name + '</a></li>';
                                }
                            }
                            
                            if (cat.children && cat.children.length > 8) {
                                var slug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                var url = '/collection/' + slug;
                                if (slug === 'trending') url = '/top-selling';
                                else if (slug === 'bestsellers') url = '/best-selling';
                                html += '<li style="margin-top:5px;"><a href="' + url + '" style="color:#F4B94E;font-size:11px;font-weight:600;text-decoration:none;">+' + (cat.children.length - 8) + ' more →</a></li>';
                            }
                            html += '</ul></div>';
                        }
                        html += '</div>';
                    }
                    html += '</div>';
                    popup.innerHTML = html;
                }

                for (var ni = 0; ni < navItems.length; ni++) {
                    navItems[ni].addEventListener('mouseenter', showPopup);
                    navItems[ni].addEventListener('mouseleave', hidePopup);
                }
                if (popup) {
                    popup.addEventListener('mouseenter', function() {
                        if (hideTimeout) clearTimeout(hideTimeout);
                        popup.style.display = 'block';
                    });
                    popup.addEventListener('mouseleave', hidePopup);
                }
            }

            function updateCartCountBadge() {
                var cart = JSON.parse(localStorage.getItem('cart') || '[]');
                var count = cart.length;
                var badges = document.querySelectorAll('#cart-count-badge, .cart-count-badge, #web-cart-count-badge');
                for (var i = 0; i < badges.length; i++) {
                    badges[i].textContent = count;
                    badges[i].style.display = 'flex';
                }
            }

            function init() {
                fetchCategories();
                setupPopup();
                updateCartCountBadge();
                
                var searchInput = document.getElementById('web-search-input');
                if (searchInput) {
                    // ENTER KEY
                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            var q = this.value.trim();
                            if (q) window.location.href = '/products?search=' + encodeURIComponent(q);
                        }
                    });
                    
                    // LIVE SUGGESTIONS
                    var suggestionsBox = document.getElementById('web-search-suggestions');
                    if (!suggestionsBox) {
                        var parent = searchInput.parentElement;
                        var div = document.createElement('div');
                        div.id = 'web-search-suggestions';
                        div.className = 'web-search-suggestions';
                        parent.appendChild(div);
                        suggestionsBox = div;
                    }
                    
                    var timer;
                    searchInput.addEventListener('input', function(e) {
                        clearTimeout(timer);
                        var q = this.value.trim();
                        if (q.length === 0) {
                            suggestionsBox.style.display = 'none';
                            suggestionsBox.innerHTML = '';
                            return;
                        }
                        timer = setTimeout(function() {
                            fetch(API_BASE_URL + '/products/suggestions?q=' + encodeURIComponent(q))
                                .then(function(r) { return r.json(); })
                                .then(function(data) {
                                    if (!data.success || !data.data) {
                                        suggestionsBox.style.display = 'none';
                                        suggestionsBox.innerHTML = '';
                                        return;
                                    }
                                    var products = data.data.products || [];
                                    if (products.length === 0) {
                                        suggestionsBox.style.display = 'none';
                                        suggestionsBox.innerHTML = '';
                                        return;
                                    }
                                    var html = '';
                                    products.forEach(function(p) {
                                        var slug = p.slug || p.id || '';
                                        var name = p.name || p.product_name || 'Product';
                                        html += '<div class="web-suggestion-item" onclick="window.location.href=\'/product/' + slug + '\'">' + name + '</div>';
                                    });
                                    suggestionsBox.innerHTML = html;
                                    suggestionsBox.style.display = 'block';
                                })
                                .catch(function() {
                                    suggestionsBox.style.display = 'none';
                                    suggestionsBox.innerHTML = '';
                                });
                        }, 300);
                    });
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
                suggestionsBox.innerHTML = '';
            }
        });
        
        // ✅ DYNAMIC PLACEHOLDER ROTATION
        fetch(API_BASE_URL + '/categories')
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success && data.data && data.data.length > 0) {
                    var categories = data.data.map(function(cat) { return cat.name; });
                    var index = 0;
                    if (categories.length > 0) {
                        searchInput.placeholder = 'Search for ' + categories[0];
                    }
                    setInterval(function() {
                        index = (index + 1) % categories.length;
                        searchInput.placeholder = 'Search for ' + categories[index];
                    }, 3000);
                }
            })
            .catch(function() {
                var fallback = ['Co-ords set', 'Dresses', 'Kurta Sets'];
                var index = 0;
                if (fallback.length > 0) {
                    searchInput.placeholder = 'Search for ' + fallback[0];
                }
                setInterval(function() {
                    index = (index + 1) % fallback.length;
                    searchInput.placeholder = 'Search for ' + fallback[index];
                }, 3000);
            });
    }
}

            window.showSortPopup = function() {
                document.getElementById('sortPopupOverlay').style.display = 'block';
                document.getElementById('sortPopupOverlay').classList.add('active');
            };
            window.hideSortPopup = function() {
                document.getElementById('sortPopupOverlay').style.display = 'none';
                document.getElementById('sortPopupOverlay').classList.remove('active');
            };
            window.applySort = function() {
                var selected = document.querySelector('input[name="sort"]:checked');
                if (!selected) { alert('Please select a sort option'); return; }
                var sortBy = selected.value;
                var sorted = currentProducts.slice(0);
                if (sortBy === 'price-low') {
                    sorted.sort(function(a, b) { return getPrice(a) - getPrice(b); });
                } else if (sortBy === 'price-high') {
                    sorted.sort(function(a, b) { return getPrice(b) - getPrice(a); });
                }
                renderProducts(sorted);
                hideSortPopup();
            };
            window.showFilterPopup = function() {
    var overlay = document.getElementById('filterPopupOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    var content = document.getElementById('mobileFilterContent');
    if (content) {
        var html = '';
        var catChecks = document.querySelectorAll('.desktop-category-filter');
        if (catChecks.length > 0) {
            html += '<div style="margin-bottom:16px;"><div style="font-weight:600;font-size:14px;margin-bottom:8px;">CATEGORY</div>';
            for (var i = 0; i < catChecks.length; i++) {
                var label = catChecks[i].parentElement;
                html += '<label class="filter-checkbox" style="display:block;padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:14px;color:#666;cursor:pointer;">';
                html += '<input type="checkbox" class="mobile-category-filter" value="' + catChecks[i].value + '" ' + (catChecks[i].checked ? 'checked' : '') + ' style="margin-right:12px;accent-color:#F4B94E;"> ' + label.textContent.trim();
                html += '</label>';
            }
            html += '</div>';
        }
        var brandChecks = document.querySelectorAll('.desktop-brand-filter');
        if (brandChecks.length > 0) {
            html += '<div style="margin-bottom:16px;"><div style="font-weight:600;font-size:14px;margin-bottom:8px;">BRANDS</div>';
            for (var i = 0; i < brandChecks.length; i++) {
                var label = brandChecks[i].parentElement;
                html += '<label class="filter-checkbox" style="display:block;padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:14px;color:#666;cursor:pointer;">';
                html += '<input type="checkbox" class="mobile-brand-filter" value="' + brandChecks[i].value + '" ' + (brandChecks[i].checked ? 'checked' : '') + ' style="margin-right:12px;accent-color:#F4B94E;"> ' + label.textContent.trim();
                html += '</label>';
            }
            html += '</div>';
        }
        var discChecks = document.querySelectorAll('.desktop-discount-filter');
        if (discChecks.length > 0) {
            html += '<div style="margin-bottom:16px;"><div style="font-weight:600;font-size:14px;margin-bottom:8px;">DISCOUNT</div>';
            for (var i = 0; i < discChecks.length; i++) {
                var label = discChecks[i].parentElement;
                html += '<label class="filter-checkbox" style="display:block;padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:14px;color:#666;cursor:pointer;">';
                html += '<input type="checkbox" class="mobile-discount-filter" value="' + discChecks[i].value + '" ' + (discChecks[i].checked ? 'checked' : '') + ' style="margin-right:12px;accent-color:#F4B94E;"> ' + label.textContent.trim();
                html += '</label>';
            }
            html += '</div>';
        }
        content.innerHTML = html;
    }
};

window.hideFilterPopup = function() {
    var overlay = document.getElementById('filterPopupOverlay');
    if (overlay) {
        overlay.style.display = 'none';
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
};
            
            window.applyMobileFilters = function() {
                var catChecks = document.querySelectorAll('.mobile-category-filter');
                for (var i = 0; i < catChecks.length; i++) {
                    var desktop = document.querySelector('.desktop-category-filter[value="' + catChecks[i].value + '"]');
                    if (desktop) desktop.checked = catChecks[i].checked;
                }
                var brandChecks = document.querySelectorAll('.mobile-brand-filter');
                for (var i = 0; i < brandChecks.length; i++) {
                    var desktop = document.querySelector('.desktop-brand-filter[value="' + brandChecks[i].value + '"]');
                    if (desktop) desktop.checked = brandChecks[i].checked;
                }
                var discChecks = document.querySelectorAll('.mobile-discount-filter');
                for (var i = 0; i < discChecks.length; i++) {
                    var desktop = document.querySelector('.desktop-discount-filter[value="' + discChecks[i].value + '"]');
                    if (desktop) desktop.checked = discChecks[i].checked;
                }
                window.applyFilters();
                hideFilterPopup();
            };
            window.resetMobileFilters = function() {
                document.querySelectorAll('.mobile-category-filter, .mobile-brand-filter, .mobile-discount-filter').forEach(function(cb) { cb.checked = false; });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

    @include('mobile.auth.auth')
    @include('components.footer')

</body>
</html>