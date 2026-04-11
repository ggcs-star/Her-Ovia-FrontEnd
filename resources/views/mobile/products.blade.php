<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Products | RADIANT JEWEL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body{
            font-family:'Inter',sans-serif;
            background:#fff;
            padding-bottom:env(safe-area-inset-bottom);
            -webkit-overflow-scrolling:touch;
        }

        .header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            height:calc(56px + env(safe-area-inset-top));
            padding:env(safe-area-inset-top) 16px 0 16px;
            border-bottom:1px solid #f0f0f0;
            background:#fff;
            position:sticky;
            top:0;
            z-index:1000;
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
        .header-right span { cursor: pointer; }
        

        .sub-strip{
            padding:12px 16px;
            display:flex;
            gap:16px;
            overflow-x:auto;
            overflow-y:hidden;
            white-space:nowrap;
            border-bottom:1px solid #f0f0f0;
            background:#fff;
            position:sticky;
            top:calc(56px + env(safe-area-inset-top));
            z-index:999;
        }
        .sub-strip::-webkit-scrollbar { display: none; }
        .sub-item{
            min-width:80px;
            flex-shrink:0;
            text-align:center;
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
        .sub-img img { width: 100%; height: 100%; object-fit: cover; }
        .sub-item.active .sub-img { border-color: var(--accent); }

        .sub-name {
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }
        .sub-item.active .sub-name { color: var(--accent); }

        /* Products Grid Container */
        .products{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:16px;
            padding:16px;
            padding-bottom:calc(130px + env(safe-area-inset-bottom));
        }
        
        .card {
            cursor: pointer;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }
        .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
        .img-box {
            aspect-ratio: 3/4;
            background: #f8f8f8;
        }
        
        .info {
            padding: 10px;
        }
        
        .brand {
            font-size: 11px;
        }
        
        .name {
            font-size: 12px;
            line-height: 1.3;
        }
        
        .price .current {
            font-size: 13px;
        }
        
        .price .original {
            font-size: 10px;
        }
        
        .off {
            font-size: 10px;
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
            background: var(--accent);
            color: white;
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
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            cursor: pointer;
            border: none;
        }
        .wishlist.active { color: var(--accent); }
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
        }
        .rating {
            font-size: 11px;
            color: #666;
            margin-bottom: 4px;
        }
        .stars { color: #ffc107; }
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
            color: var(--accent);
        }

        .action-bar{
            position:fixed;
            bottom:calc(70px + env(safe-area-inset-bottom));
            left:0;
            right:0;
            display:flex;
            gap:12px;
            padding:12px 16px;
            background:#fff;
            border-top:1px solid #f0f0f0;
            z-index:999;
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
        }

        .bottom-nav{
            position:fixed;
            bottom:0;
            left:0;
            right:0;
            height:calc(65px + env(safe-area-inset-bottom));
            padding-bottom:env(safe-area-inset-bottom);
            display:flex;
            justify-content:space-around;
            align-items:center;
            background:#fff;
            border-top:1px solid #f0f0f0;
            z-index:1000;
        }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            font-size: 11px;
            color: #666;
            cursor: pointer;
        }
        .nav-item.active { color: var(--accent); }
        .nav-icon { font-size: 20px; }

        @media screen and (min-width: 1024px) {
            .products-page-wrapper {
                display: flex;
                max-width: 1440px;
                margin: 0 auto;
                position: relative;
                gap: 24px;
                padding: 20px 24px;
            }
            
            .desktop-filters-sidebar {
                width: 280px;
                flex-shrink: 0;
                background: #fff;
                border-radius: 12px;
                position: sticky;
                top: calc(56px + 20px);
                height: fit-content;
                max-height: calc(100vh - 80px);
                overflow-y: auto;
                padding: 20px;
                border: 1px solid #f0f0f0;
            }
            
            .action-bar {
                display: none !important;
            }
            
            .desktop-products-area {
                flex: 1;
                min-width: 0;
            }
            
            .products {
                grid-template-columns: repeat(4, 1fr) !important;  /* 3 se 4 columns kar diya */
                gap: 20px;
                padding: 0 0 40px 0;
            }
            
            .sub-strip {
                position: relative;
                top: 0;
                padding: 16px 0 20px 0;
                margin-bottom: 20px;
                border-bottom: 1px solid #f0f0f0;
                background: transparent;
                gap: 20px;
            }
            
            .sub-item {
                min-width: 70px;
            }
            
            .sub-img {
                width: 70px;
                height: 70px;
            }
            
            .desktop-filter-section {
                margin-bottom: 28px;
                border-bottom: 1px solid #f0f0f0;
                padding-bottom: 20px;
            }
            
            .desktop-filter-section:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            
            .desktop-filter-title {
                font-size: 14px;
                font-weight: 700;
                color: #000;
                margin-bottom: 16px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .desktop-filter-option {
                display: block;
                padding: 8px 0;
                font-size: 13px;
                color: #666;
                cursor: pointer;
                transition: color 0.2s;
            }
            
            .desktop-filter-option:hover { color: var(--accent); }
            
            .desktop-filter-option input {
                margin-right: 12px;
                accent-color: var(--accent);
                cursor: pointer;
            }
            
            .price-range-inputs {
                display: flex;
                gap: 12px;
                width: 100%;
                margin-bottom: 16px;
            }
            
            .price-input {
                flex: 1;
                min-width: 0;      /* IMPORTANT */
                width: 100%;       /* FIX overflow */
                box-sizing: border-box;
                padding: 10px 12px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                font-size: 13px;
                font-family: inherit;
            }
            
            .price-input:focus {
                outline: none;
                border-color: var(--accent);
            }
            
            .apply-price-btn {
                width: 100%;
                padding: 10px;
                background: var(--accent);
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                margin-top: 12px;
            }
            
            .apply-price-btn:hover { background: #e6a83b; }
            
            .desktop-reset-filters {
                width: 100%;
                padding: 12px;
                background: #f5f5f5;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                color: #333;
                margin-top: 20px;
                transition: all 0.2s;
            }
            
            .desktop-reset-filters:hover {
                background: #e8e8e8;
            }
            
            /* Header adjustments for desktop */
            .header {
                position: sticky;
                top: 0;
                z-index: 1001;
                background: #fff;
                border-bottom: 1px solid #f0f0f0;
            }
            
            /* Bottom nav hidden on desktop (use normal navigation) */
            .bottom-nav {
                display: none;
            }
            
            /* Card hover effect on desktop */
            .card {
                transition: transform 0.2s, box-shadow 0.2s;
            }
            
            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }
            /* Desktop Filter Sections - Collapsible */
            .desktop-filter-section .filter-options {
                display: none; /* Pehle band rahega */
            }

            .desktop-filter-section .filter-options.open {
                display: block; /* Jab open class ho tab dikhe */
            }

            .desktop-filter-section .desktop-filter-title {
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .desktop-filter-section .desktop-filter-title::after {
                content: '+';
                font-size: 18px;
                color: #ff3f6c;
                font-weight: 600;
            }

            .desktop-filter-section.open .desktop-filter-title::after {
                content: '−';
            }
            
            /* Hide mobile filter popup on desktop */
            .filter-popup-overlay,
            .sort-popup-overlay {
                display: none !important;
            }
        }
        
        /* Tablet view - 2 columns */
        @media screen and (min-width: 768px) and (max-width: 1023px) {
            .products {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            
            .desktop-filters-sidebar {
                display: none;
            }
        }
        
        /* Mobile view - NO CHANGES, keep original layout */
        @media screen and (max-width: 767px) {
            .desktop-filters-sidebar {
                display: none;
            }
            
            .products-page-wrapper {
                display: block;
            }
        }

        .sort-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
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
        .sort-option input {
            margin-right: 12px;
           accent-color: var(--accent);
        }
        .sort-popup-footer {
            padding: 16px 20px;
            border-top: 1px solid #f0f0f0;
        }
        .sort-apply-btn {
            width: 100%;
            padding: 14px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .filter-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
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
            padding: 0;
            overflow-y: auto;
            flex: 1;
            display: flex;
            position: relative;
            min-height: 300px;
        }
        .filter-titles-column {
            width: 100%;
            padding: 10px 0;
            transition: all 0.3s ease;
        }
        .filter-titles-column.half-width {
            width: 50%;
            border-right: 1px solid #f0f0f0;
        }
        .filter-title-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }
        .filter-title-item:hover {
            background: #f8f8f8;
        }
        .filter-title-item .arrow-icon {
            color: var(--accent);
            font-size: 18px;
        }
        .filter-options-column {
            width: 50%;
            padding: 10px 0;
            background: #fff;
            height: 100%;
            overflow-y: auto;
        }
        .filter-options-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .back-arrow {
            font-size: 24px;
            cursor: pointer;
            color: var(--accent);
            font-weight: 600;
        }
        .options-title {
            font-size: 16px;
            font-weight: 700;
            color: #000;
        }
        .filter-options-content {
            padding: 10px 0;
        }
        .filter-checkbox {
            display: block;
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
        .filter-checkbox input {
            margin-right: 12px;
            accent-color: var(--accent);
        }
        .filter-checkbox:hover {
            background: #f8f8f8;
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
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        .filter-section {
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .filter-section-title {
            padding: 15px 0;
            font-size: 16px;
            font-weight: 600;
            color: #000;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-section-title .toggle-icon {
            font-size: 20px;
            color: #ff3f6c;
            font-weight: 600;
        }
        .filter-section-content {
            padding: 5px 0 15px 0;
            max-height: 250px;
            overflow-y: auto;
        }
        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
            grid-column: 1/-1;
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
            transition: color 0.2s;
            cursor: pointer;
        }
        .nav-item-figma.active {
            color: var(--accent);
        }
        .nav-icon-box {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-icon-box svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .nav-item-figma.active svg {
            stroke: var(--accent); 
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
            stroke: #333333;
            fill: none;
        }
        .header-icon-btn:hover svg {
            stroke: var(--accent); 
        }
@media screen and (min-width: 1025px) {
    .product-desktop-header {
        display: block !important;
        position: sticky;
        top: 0;
        z-index: 1000;
        background: white;
    }
    .header {
        display: none !important;
    }
}

@media screen and (max-width: 1024px) {
    .product-desktop-header {
        display: none !important;
    }
    
    .header {
        display: flex !important;
    }
}
.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-right button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
}

.header-right button svg {
    width: 22px;
    height: 22px;
    stroke: #333;
    fill: none;
}

.header-right button:hover svg {
    stroke: var(--accent);
}
.nav-icon-box {
    position: relative;
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
}

.header-icon {
    display: inline-block;
}

.cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

#cart-count-badge {
    position: absolute;

    top: -6px;
    right: -8px;

    background: var(--accent); 
    color: #fff;

    font-size: 10px;
    font-weight: 600;

    min-width: 16px;
    height: 16px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 18px;
}

.header-actions .action-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
}

.header-icon {
    width: 18px;
    height: 18px;

    display: inline-block;

    stroke: #333;
    fill: none;
}

.header-actions .action-link:hover .header-icon {
   stroke: var(--accent);
}
.nav-item-figma span {
    font-size: 11px !important;
}
.header-actions .action-link {
    font-size: 12px !important;
}
.web-header .top-bar {
    background: linear-gradient(90deg, #440C2C, #F4B94E, #440C2C, #F4B94E, #440C2C);
    background-size: 300% 100%;
    animation: gradientMove 4s ease infinite;
    color: white;
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

#cart-count-badge, #web-cart-count-badge {
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

.web-header .nav-item:active,
.web-header .nav-item:focus,
.web-header .nav-item.active {
    color: #333;
    background: transparent;
}
    </style>
</head>
<body data-page="products" data-subcategory-id="{{ request()->query('subcategory') }}" data-category-id="{{ request()->query('category') }}">

<div class="header">
        <div class="header-left">
        <span class="back-btn" onclick="goBack()">←</span>
        <!-- <img src="" id="mobileHeaderLogo" style="height: 28px; width: auto;" onerror="this.style.display='none'">        <h1>Products</h1> -->
    </div>
    <div class="header-right">
    <button class="search-icon-btn" onclick="window.location.href='/search'">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="10" cy="10" r="7"/>
            <line x1="21" y1="21" x2="15" y2="15"/>
        </svg>
    </button>
    <button class="wishlist-icon-btn" onclick="window.location.href='/wishlist'">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
    </button>
</div>
</div>

<div class="product-desktop-header" id="productDesktopHeader" style="display: none;">
    <div class="web-header">
        <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
        <div class="main-header">
            <div class="logo-area">
                <a href="/" class="logo">
                    <img 
                        src=""
                        id="desktopHeaderLogo"
                        class="site-logo"
                        alt="Logo"
                        style="height:40px;width:auto;"
                        onerror="this.src='https://placehold.co/120x40?text=LOGO'"
                    >
                </a>
                <nav class="nav-menu" id="productNavMenu">
                </nav>
            </div>
            <div class="search-area">
                <div class="search-box" style="position:relative;">
                <input
                        type="text"
                        id="web-search-input"
                        placeholder="Search for products, brands..."
                        autocomplete="off"
                    >

                    <div
                        id="web-search-suggestions"
                        class="web-search-suggestions"
                        style="display:none;"
                    ></div>

                </div>
            </div>
            <div class="header-actions">

    <!-- Profile -->
    <a href="/profile"
       class="action-link">

        <svg class="header-icon"
             width="18"
             height="18"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <circle cx="12" cy="7" r="4"/>
            <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>

        </svg>

        Profile

    </a>

    <!-- Wishlist -->
    <a href="/wishlist"
       class="action-link">

        <svg class="header-icon"
             width="18"
             height="18"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0
                     L12 5.67l-1.06-1.06
                     a5.5 5.5 0 0 0-7.78 7.78
                     l1.06 1.06L12 21.23
                     l7.78-7.78
                     1.06-1.06
                     a5.5 5.5 0 0 0 0-7.78z"/>

        </svg>

        Wishlist

    </a>

    <!-- Cart -->
    <a href="/cart"
       class="action-link cart-link">

        <span class="cart-icon-wrapper">

            <svg class="header-icon"
                 width="18"
                 height="18"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <circle cx="9" cy="21" r="1.5"/>
                <circle cx="18" cy="21" r="1.5"/>
                <path d="M2 2h3l3 12h11l2-8H6"/>

            </svg>

            <span id="cart-count-badge">
                0
            </span>

        </span>

        Cart

    </a>

</div>
        </div>
    </div>
    <div class="all-categories-popup" id="productAllCategoriesPopup" style="display:none; position:absolute; top:100%; left:0; width:100%; background:white; box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:1000; border-top:1px solid #f0f0f0;"></div>
</div>
<div class="products-page-wrapper">
    <aside class="desktop-filters-sidebar" id="desktopFiltersSidebar">
        <div class="desktop-filter-section">
            <div class="desktop-filter-title">CATEGORY</div>
            <div class="filter-options" id="desktopCategoryFilters"></div> 
        </div>

        <div class="desktop-filter-section">
            <div class="desktop-filter-title">PRICE</div>
            <div class="filter-options">
                <div class="price-range-inputs">
                    <input type="number" class="price-input" id="minPrice" placeholder="Min" step="1">
                    <input type="number" class="price-input" id="maxPrice" placeholder="Max" step="1">
                </div>
                <button class="apply-price-btn" onclick="applyDesktopPriceFilter()">Apply</button>
            </div>
        </div>

        <div class="desktop-filter-section">
            <div class="desktop-filter-title">BRANDS</div>
            <div class="filter-options" id="desktopBrandFilters"></div>
        </div>
        <div class="desktop-filter-section">
            <div class="desktop-filter-title">DISCOUNT</div>
            <div class="filter-options" id="desktopDiscountFilters"></div>
        </div>
        <div class="desktop-filter-section">
            <div class="desktop-filter-title">SIZE</div>
            <div class="filter-options" id="desktopSizeFilters"></div>
        </div>
        <div class="desktop-filter-section">
            <div class="desktop-filter-title">COLOR</div>
            <div class="filter-options" id="desktopColorFilters"></div>
        </div>
                
        <button class="desktop-reset-filters" onclick="resetDesktopFilters()">Reset All Filters</button>
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
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <span>Home</span>
    </a>
    <!--
    <a href="/trends" class="nav-item-figma">
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
    -->
    <a href="/categories" class="nav-item-figma active">
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
    
    <a href="/cart" class="nav-item-figma">
        <div class="nav-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 1H5L7.68 14.39
                        C7.77144 14.8504 8.02191 15.264
                        8.38755 15.5583
                        C8.75318 15.8526 9.2107 16.009
                        9.68 16
                        H19.4
                        C19.8693 16.009 20.3268 15.8526
                        20.6925 15.5583
                        C21.0581 15.264 21.3086 14.8504
                        21.4 14.39
                        L23 6H6"/>
                <circle cx="9" cy="21" r="1.5"/>
                <circle cx="20" cy="21" r="1.5"/>
            </svg>
            <span id="cart-count-badge" class="cart-count-badge">
                0
            </span>
        </div>
        <span>Cart</span>
    </a>
    <a href="/profile" class="nav-item-figma">
        <div class="nav-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
            <!-- <label class="sort-option"><input type="radio" name="sort" value="popularity"> Popularity</label>
            <label class="sort-option"><input type="radio" name="sort" value="newest"> Newest</label> -->
            <label class="sort-option"><input type="radio" name="sort" value="price-low"> Price: Low to High</label>
            <label class="sort-option"><input type="radio" name="sort" value="price-high"> Price: High to Low</label>
            <label class="sort-option"><input type="radio" name="sort" value="rating"> Rating</label>
            <label class="sort-option"><input type="radio" name="sort" value="discount"> Discount</label>
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
            <div class="filter-titles-column" id="filterTitlesColumn">
                <div class="filter-title-item" onclick="showFilterOptions('category')">
                    <span>CATEGORY</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('price')">
                    <span>PRICE</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('brand')">
                    <span>BRAND</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('size')">
                    <span>SIZE</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('color')">
                    <span>COLOR</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('fabric')">
                    <span>FABRIC</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('occasion')">
                    <span>OCCASION</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('discount')">
                    <span>DISCOUNT</span>
                    <span class="arrow-icon">›</span>
                </div>
                <div class="filter-title-item" onclick="showFilterOptions('rating')">
                    <span>RATING</span>
                    <span class="arrow-icon">›</span>
                </div>
            </div>
            <div class="filter-options-column" id="filterOptionsColumn" style="display: none;">
                <div class="filter-options-header">
                    <span class="back-arrow" onclick="hideFilterOptions()">‹</span>
                    <span class="options-title" id="currentFilterTitle">CATEGORY</span>
                </div>
                <div class="filter-options-content" id="filterOptionsContent"></div>
            </div>
        </div>
        <div class="filter-popup-footer">
            <button class="reset-btn" onclick="resetFilters()">Reset</button>
            <button class="apply-btn" onclick="applyFilters()">Apply</button>
        </div>
    </div>
</div>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>

<script src="{{ asset('mobile/script.js') }}"></script>


<script>
    
(function() {
    const subId = document.body.dataset.subcategoryId;
    const catId = document.body.dataset.categoryId;
    
    let allSubs = [];
    let currentSub = subId;
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    let currentProducts = [];
    let originalProducts = [];

    async function fetchData() {
        try {
             const urlParams = new URLSearchParams(window.location.search);
                const type = urlParams.get('type');
                
                if (type === 'top-selling') {
                    await fetchTopSellingProducts();
                    return;
                }
            const res = await fetch(`${API_BASE_URL}/categories`);
            const data = await res.json();
            
            if (data.success) {
                let mainCat;
                mainCat = data.data.find(c => c.id == subId);
                if (mainCat) {
                    currentSub = mainCat.children?.length ? mainCat.children[0].id : null;
                } else {
                    mainCat = data.data.find(c => c.children?.some(child => child.id == subId));
                }
                if (mainCat) {
                    allSubs = mainCat.children || [];
                    renderSubs();
                    if (currentSub) {
                        fetchProducts(currentSub);
                    }
                    loadDesktopFilters(mainCat);
                    initDesktopFiltersToggle();
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function updateMobileLogo() {
    try {
        const res = await fetch(`${API_BASE_URL}/app-settings`);
        const data = await res.json();
        if (data.success) {
            const logo = data.data.header_logo || data.data.app_logo;
            const img = document.getElementById('mobileHeaderLogo');
            if (img && logo) img.src = logo;
        }
    } catch(e) { console.log(e); }
}
updateMobileLogo();
    function renderSubs() {
        const strip = document.getElementById('subStrip');
        if (!strip) return;
        if (!allSubs.length) { strip.style.display = 'none'; return; }
        
        const fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
        
        strip.innerHTML = allSubs.map(sub => `
            <div class="sub-item ${sub.id == currentSub ? 'active' : ''}" onclick="changeSubcategory(${sub.id})">
                <div class="sub-img"><img src="${sub.image_url || fallback}" onerror="this.src='${fallback}'"></div>
                <div class="sub-name">${sub.name}</div>
            </div>
        `).join('');
        
        document.querySelectorAll('.sub-item').forEach((item, i) => item.dataset.subid = allSubs[i].id);
    }

    window.changeSubcategory = function(newSubId) {
        currentSub = newSubId;
        document.querySelectorAll('.sub-item').forEach(item => {
            item.classList.toggle('active', item.dataset.subid == newSubId);
        });
        fetchProducts(newSubId);
        const url = new URL(window.location);
        url.searchParams.set('subcategory', newSubId);
        window.history.pushState({}, '', url);
    };

    async function fetchProducts(subId) {
        const grid = document.getElementById('productsGrid');
        
        try {
            const res = await fetch(`${API_BASE_URL}/categories/${subId}/products`);
            const data = await res.json();
            
            if (data.success && data.data.products) {
                currentProducts = data.data.products;
                originalProducts = [...data.data.products];
                renderProducts(currentProducts);
                updateDesktopFiltersFromProducts(currentProducts);
            } else {
                grid.innerHTML = '<div class="loading">No products found</div>';
            }
        } catch (error) {
            grid.innerHTML = '<div class="loading">Error loading products</div>';
        }
    }

    function renderProducts(products) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;
    if (!products.length) { grid.innerHTML = '<div class="loading">No products found</div>'; return; }
    
    const latestWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

    const fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';

    grid.innerHTML = products.map(p => {
        // const price = parseFloat(p.final_price || p.price || 0);
        const price = parseFloat(
        (p.product_price && p.product_price != "0.00")
            ? p.product_price
            : (p.final_price || p.price || 0)
    );
        const mrp = parseFloat(
        (p.product_price && p.product_price != "0.00")
            ? p.product_price
            : (p.price || 0)
    );
        const discount = mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0;
        const rating = 4.3;
        const full = Math.floor(rating);
        const half = (rating % 1) >= 0.3;
        let stars = '';
        for (let i = 0; i < full; i++) stars += '★';
        if (half) stars += '½';
        for (let i = stars.length; i < 5; i++) stars += '☆';
        
        const inWish = latestWishlist.some(item => item.id == p.id);
        const isBest = discount > 20;
        
        return `
            <div class="card">
                <div class="img-box" onclick="window.location.href='/product/${p.slug}'">
                    <img src="${p.image_url || fallback}" onerror="this.src='${fallback}'">
                    ${isBest ? '<span class="badge">Best Seller</span>' : ''}
                    <button class="wishlist ${inWish ? 'active' : ''}" 
                            onclick="event.stopPropagation(); toggleWish(this, ${JSON.stringify({
                                id: p.id, name: p.name, price: price,
                                image: p.image_url, brand: p.brand, slug: p.slug
                            }).replace(/"/g, '&quot;')})">
                        ${inWish ? '❤️' : '♡'}
                    </button>
                </div>
                <div class="info" onclick="window.location.href='/product/${p.slug}'">
                    <div class="brand">${p.brand || 'RAPID RETAIL'}</div>
                    <div class="name">${p.name}</div>
                    <div class="rating"><span class="stars">${stars}</span> | ${Math.floor(Math.random() * 50) + 10}</div>
                    <div class="price">
                        <span class="current">₹${price.toLocaleString('en-IN')}</span>
                        ${mrp > price ? `<span class="original">₹${mrp.toLocaleString('en-IN')}</span>` : ''}
                        ${discount > 0 ? `<span class="off">${discount}% Off</span>` : ''}
                    </div>
                </div>
            </div>
        `;
    }).join('');
}
    function loadDesktopFilters(mainCategory) {
        const categoryContainer = document.getElementById('desktopCategoryFilters');
        if (categoryContainer && mainCategory.children && mainCategory.children.length) {
            categoryContainer.innerHTML = mainCategory.children.map(child => `
                <label class="desktop-filter-option">
                    <input type="checkbox" class="desktop-category-filter" value="${child.id}" onchange="applyDesktopFilters()"> ${child.name}
                </label>
            `).join('');
        }
    }
    function updateDesktopFiltersFromProducts(products) {
    const brands = new Set();
    products.forEach(p => {
        if (p.brand) brands.add(p.brand);
    });
    
    const brandContainer = document.getElementById('desktopBrandFilters');
    if (brandContainer) {
        brandContainer.innerHTML = Array.from(brands).map(brand => `
            <label class="desktop-filter-option">
                <input type="checkbox" class="desktop-brand-filter" value="${brand}" onchange="applyDesktopFilters()"> ${brand}
            </label>
        `).join('');
    }
    
    const discountContainer = document.getElementById('desktopDiscountFilters');

if (discountContainer) {

    const discountSet = new Set();

    products.forEach(p => {

        if (p.price && p.final_price) {

            const original = parseFloat(p.price);
            const final = parseFloat(p.final_price);

            if (original > final) {

                const discount =
                    Math.round(
                        ((original - final) / original) * 100
                    );

                discountSet.add(discount);

            }

        }

    });

    const sortedDiscounts =
        Array.from(discountSet)
            .sort((a, b) => a - b);

    discountContainer.innerHTML =
        sortedDiscounts.map(d => `

            <label class="desktop-filter-option">
                <input
                    type="checkbox"
                    class="desktop-discount-filter"
                    value="${d}"
                    onchange="applyDesktopFilters()"
                >
                ${d}% & above
            </label>

        `).join('');

}
}
    window.applyDesktopFilters = function() {

    let filtered = [...currentProducts];
    let filterApplied = false;

    const selectedCategories =
        Array.from(
            document.querySelectorAll(
                '.desktop-category-filter:checked'
            )
        ).map(cb => cb.value);

    /* MULTIPLE SUBCATEGORY SUPPORT */

    if (selectedCategories.length === 1) {

        changeSubcategory(
            selectedCategories[0]
        );

        return;
    }

    if (selectedCategories.length > 1) {

        fetchMultipleSubcategories(
            selectedCategories
        );

        return;
    }

    /* BRAND FILTER */

    const selectedBrands =
        Array.from(
            document.querySelectorAll(
                '.desktop-brand-filter:checked'
            )
        ).map(cb => cb.value);

    if (selectedBrands.length > 0) {

        filterApplied = true;

        filtered = filtered.filter(p =>
            selectedBrands.includes(p.brand)
        );

    }

    if (!filterApplied) {

        renderProducts(currentProducts);

    }
    else if (filtered.length > 0) {

        renderProducts(filtered);

    }
    else {

        document.getElementById('productsGrid').innerHTML =
            '<div class="loading">No products match your filters</div>';

    }

};
async function fetchTopSellingProducts() {
    const grid = document.getElementById('productsGrid');
    try {
        const res = await fetch(`${API_BASE_URL}/products/top-selling`);
        const data = await res.json();
        
        if (data.success && data.data) {
            let products = Array.isArray(data.data) ? data.data : (data.data.products || []);
            currentProducts = products;
            originalProducts = [...products];
            renderProducts(products);
            
            // Subs strip hide karo
            const subStrip = document.getElementById('subStrip');
            if (subStrip) subStrip.style.display = 'none';
        } else {
            grid.innerHTML = '<div class="loading">No products found</div>';
        }
    } catch (error) {
        grid.innerHTML = '<div class="loading">Error loading products</div>';
    }
}
    window.applyDesktopPriceFilter = function() {
        const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
        const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
        
        let filtered = [...originalProducts];
        filtered = filtered.filter(p => {
            // const price = parseFloat(p.final_price || p.price || 0);
            const price = parseFloat(
                (p.product_price && p.product_price != "0.00")
                    ? p.product_price
                    : (p.final_price || p.price || 0)
            );
            return price >= minPrice && price <= maxPrice;
        });
        
        renderProducts(filtered);
    };

    window.resetDesktopFilters = function() {
        document.querySelectorAll('.desktop-category-filter, .desktop-brand-filter, .desktop-discount-filter, .desktop-size-filter, .desktop-color-filter').forEach(cb => cb.checked = false);
        document.getElementById('minPrice').value = '';
        document.getElementById('maxPrice').value = '';
        renderProducts(originalProducts);
    };

    window.toggleWish = function(btn, product) {
        event.stopPropagation();
        let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const exists = currentWishlist.some(item => item.id == product.id);
        if (exists) {
            currentWishlist = currentWishlist.filter(item => item.id != product.id);
            btn.innerHTML = '♡';
            btn.classList.remove('active');
        } else {
            currentWishlist.push(product);
            btn.innerHTML = '❤️';
            btn.classList.add('active');
        }
        localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
        window.wishlist = currentWishlist;
        
        // ✅ Force re-render by calling renderProducts with currentProducts
        renderProducts(currentProducts);
    };
        
    window.showSortPopup = function() {
        document.getElementById('sortPopupOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.hideSortPopup = function() {
        document.getElementById('sortPopupOverlay').classList.remove('active');
        document.body.style.overflow = '';
    };

    window.applySort = function() {
    const selected = document.querySelector('input[name="sort"]:checked');
    if (!selected) {
        alert('Please select a sort option');
        return;
    }

    const sortBy = selected.value;
    let sorted = [...currentProducts];

    switch (sortBy) {

        case 'price-low':
            sorted.sort((a, b) => {
                const priceA = parseFloat(
                    (a.product_price && a.product_price != "0.00")
                        ? a.product_price
                        : (a.final_price || a.price || 0)
                );

                const priceB = parseFloat(
                    (b.product_price && b.product_price != "0.00")
                        ? b.product_price
                        : (b.final_price || b.price || 0)
                );

                return priceA - priceB;
            });
            break;

        case 'price-high':
            sorted.sort((a, b) => {
                const priceA = parseFloat(
                    (a.product_price && a.product_price != "0.00")
                        ? a.product_price
                        : (a.final_price || a.price || 0)
                );

                const priceB = parseFloat(
                    (b.product_price && b.product_price != "0.00")
                        ? b.product_price
                        : (b.final_price || b.price || 0)
                );

                return priceB - priceA;
            });
            break;
        case 'newest':
            sorted.sort((a, b) =>
                new Date(b.created_at || 0) -
                new Date(a.created_at || 0)
            );
            break;

        case 'popularity':
            sorted.sort((a, b) =>
                (b.popularity || 0) -
                (a.popularity || 0)
            );
            break;

        case 'rating':
            sorted.sort((a, b) =>
                (b.rating || 0) -
                (a.rating || 0)
            );
            break;

        case 'discount':
            sorted.sort((a, b) => {
                const dA =
                    ((parseFloat(a.price || 0) -
                      parseFloat(a.final_price || 0)) /
                      parseFloat(a.price || 1)) * 100;

                const dB =
                    ((parseFloat(b.price || 0) -
                      parseFloat(b.final_price || 0)) /
                      parseFloat(b.price || 1)) * 100;

                return dB - dA;
            });
            break;

        default:
            break;
    }

    renderProducts(sorted);
    hideSortPopup();
};
    window.showFilterPopup = function() {
        document.getElementById('filterPopupOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
        hideFilterOptions();
    };

    window.hideFilterPopup = function() {
        document.getElementById('filterPopupOverlay').classList.remove('active');
        document.body.style.overflow = '';
    };

    window.showFilterOptions = function(filterType) {
        const titlesColumn = document.querySelector('.filter-titles-column');
        const optionsColumn = document.getElementById('filterOptionsColumn');
        const optionsContent = document.getElementById('filterOptionsContent');
        const titleElement = document.querySelector('.options-title');
        
        let displayTitle = filterType.toUpperCase();
        if (filterType === 'category') {
            displayTitle = 'SUBCATEGORIES';
        }
        titleElement.textContent = displayTitle;
        
        optionsContent.innerHTML = '<div style="padding: 20px; color: #999;">Loading...</div>';
        loadFilterOptions(filterType, optionsContent);
        
        titlesColumn.classList.add('half-width');
        optionsColumn.style.display = 'block';
    };

    window.hideFilterOptions = function() {
        const titlesColumn = document.querySelector('.filter-titles-column');
        const optionsColumn = document.getElementById('filterOptionsColumn');
        
        titlesColumn.classList.remove('half-width');
        optionsColumn.style.display = 'none';
    };
    async function fetchMultipleSubcategories(subIds) {

    const grid =
        document.getElementById('productsGrid');

    try {

        let allProducts = [];

        for (const id of subIds) {

            const res =
                await fetch(
                    `${API_BASE_URL}/categories/${id}/products`
                );

            const data = await res.json();

            if (
                data.success &&
                data.data.products
            ) {

                allProducts =
                    allProducts.concat(
                        data.data.products
                    );

            }

        }

        /* remove duplicates */

        allProducts = [
            ...new Map(
                allProducts.map(
                    p => [p.id, p]
                )
            ).values()
        ];

        currentProducts = allProducts;
        originalProducts = [...allProducts];

        renderProducts(allProducts);

        updateDesktopFiltersFromProducts(
            allProducts
        );

    } catch (error) {

        grid.innerHTML =
            '<div class="loading">Error loading products</div>';

    }

}
async function fetchMultipleSubcategoriesMobile(subIds) {

    const grid =
        document.getElementById('productsGrid');

    try {

        let allProducts = [];

        for (const id of subIds) {

            const res =
                await fetch(
                    `${API_BASE_URL}/categories/${id}/products`
                );

            const data = await res.json();

            if (
                data.success &&
                data.data.products
            ) {

                allProducts =
                    allProducts.concat(
                        data.data.products
                    );

            }

        }

        /* remove duplicates */

        allProducts = [
            ...new Map(
                allProducts.map(
                    p => [p.id, p]
                )
            ).values()
        ];

        currentProducts = allProducts;
        originalProducts = [...allProducts];

        renderProducts(allProducts);

    } catch (error) {

        grid.innerHTML =
            '<div class="loading">Error loading products</div>';

    }

}
    async function loadFilterOptions(filterType, container) {
        let options = [];
        
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category');
        const subcategoryId = urlParams.get('subcategory');
        
        switch(filterType) {
            case 'category':
                try {
                    const res = await fetch(`${API_BASE_URL}/categories`);
                    const data = await res.json();
                    
                    if (data.success) {
                        let targetCategory = null;
                        
                        if (categoryId) {
                            targetCategory = data.data.find(c => c.id == categoryId);
                        } else if (subcategoryId) {
                            targetCategory = data.data.find(c => 
                                c.children?.some(child => child.id == subcategoryId)
                            );
                        }
                        
                        if (targetCategory && targetCategory.children && targetCategory.children.length > 0) {
                            options = targetCategory.children.map(child => ({ 
                                value: child.id, 
                                label: child.name 
                            }));
                        }
                    }
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
                break;
                
            case 'price':
    const targetId2 = subcategoryId || categoryId;
    if (targetId2) {
        const res2 = await fetch(`${API_BASE_URL}/categories/${targetId2}/products`);
        const data2 = await res2.json();

        if (data2.success && data2.data.products && data2.data.products.length > 0) {

            const prices = data2.data.products
                .map(p => parseFloat(p.final_price || p.price))
                .filter(p => !isNaN(p));

            const minPrice = Math.min(...prices);
            const maxPrice = Math.max(...prices);

            const step = 500;

            options = [];

            for (let start = Math.floor(minPrice / step) * step; start < maxPrice; start += step) {

                const end = start + step;

                options.push({
                    value: `${start}-${end}`,
                    label: start === 0
                        ? `Below ₹${end}`
                        : `₹${start} - ₹${end}`
                });

            }

            options.push({
                value: `${maxPrice}-999999`,
                label: `Above ₹${maxPrice}`
            });
        }
    }
    break;            
            case 'brand':
                const targetId = subcategoryId || categoryId;
                if (targetId) {
                    const res = await fetch(`${API_BASE_URL}/categories/${targetId}/products`);
                    const data = await res.json();
                    
                    if (data.success && data.data.products) {
                        const brands = new Set();
                        data.data.products.forEach(p => {
                            if (p.brand) brands.add(p.brand);
                        });
                        options = Array.from(brands).map(b => ({ value: b, label: b }));
                    }
                }
                break;
                
            case 'discount':
                const targetId1 = subcategoryId || categoryId;
                if (targetId1) {
                    const res1 = await fetch(`${API_BASE_URL}/categories/${targetId1}/products`);
                    const data1 = await res1.json();

                    if (data1.success && data1.data.products) {
                        const discountSet = new Set();

                        data1.data.products.forEach(p => {
                            if (p.price && p.final_price) {
                                const original = parseFloat(p.price);
                                const final = parseFloat(p.final_price);

                                if (original > final) {
                                    const discount = Math.round(
                                        ((original - final) / original) * 100
                                    );

                                    discountSet.add(discount);
                                }
                            }
                        });

                        options = Array.from(discountSet)
                            .sort((a, b) => a - b)
                            .map(d => ({
                                value: d,
                                label: `${d}% & above`
                            }));
                    }
                }
                break;
            case 'size':
    const targetId3 = subcategoryId || categoryId;

    if (targetId3) {

        const res3 = await fetch(`${API_BASE_URL}/categories/${targetId3}/products`);
        const data3 = await res3.json();

        if (data3.success && data3.data.products) {

            const sizeSet = new Set();

            data3.data.products.forEach(product => {

                if (Array.isArray(product.variants)) {

                    product.variants.forEach(variant => {

                        if (
                            variant &&
                            typeof variant.variant_type === 'string' &&
                            variant.variant_type.toLowerCase() === 'size' &&
                            variant.variant_value
                        ) {
                            sizeSet.add(
                                String(variant.variant_value).trim()
                            );
                        }

                    });

                }

            });

            options = Array.from(sizeSet)
                .filter(v => v)
                .sort((a, b) => a.localeCompare(b))
                .map(size => ({
                    value: size,
                    label: size
                }));

        }

    }

    break;
                
            case 'color':
                options = ['Red', 'Blue', 'Green', 'Black', 'White', 'Pink', 'Yellow', 'Purple'].map(c => ({ value: c, label: c }));
                break;
                
            case 'fabric':
                options = ['Cotton', 'Polyester', 'Linen', 'Denim', 'Silk', 'Wool', 'Nylon'].map(f => ({ value: f, label: f }));
                break;
                
            case 'occasion':
                options = ['Casual', 'Formal', 'Party', 'Wedding', 'Sports', 'Travel'].map(o => ({ value: o, label: o }));
                break;
                
            case 'rating':
                options = ['4★', '3★', '2★', '1★'].map(r => ({ 
                    value: r, 
                    label: `${r} & above` 
                }));
                break;
        }
        
        if (options.length > 0) {
            container.innerHTML = options.map(opt => `
                <label class="filter-checkbox">
                    <input type="checkbox" class="filter-${filterType}" value="${opt.value}"> ${opt.label}
                </label>
            `).join('');
        } else {
            container.innerHTML = '<div style="padding: 20px; color: #999;">No options available</div>';
        }
    }

    window.applyFilters = function() {
        const selected = {
            category: [],
            price: [],
            brand: [],
            size: [],
            color: [],
            fabric: [],
            occasion: [],
            discount: [],
            rating: []
        };
        
        document.querySelectorAll('.filter-checkbox input:checked').forEach(cb => {
            const classes = Array.from(cb.classList);
            classes.forEach(cls => {
                if (cls.startsWith('filter-')) {
                    const filterType = cls.replace('filter-', '');
                    if (selected[filterType]) {
                        selected[filterType].push(cb.value);
                    }
                }
            });
        });
        
       if (selected.category.length === 1) {
            const firstCategory = selected.category[0];
            if (firstCategory) {
                window.changeSubcategory(firstCategory);
                setTimeout(() => {
                    applyOtherFilters(selected);
                }, 500);
            }
        } else if (selected.category.length > 1) {
            fetchMultipleSubcategoriesMobile(selected.category);
        } else {
            applyOtherFilters(selected);
        }
        
        hideFilterPopup();
    };
    function initWebSearchDropdown() {

        setTimeout(() => {

            const input = document.getElementById("web-search-input");
            if (!input) return;

            let suggestionsBox =
                document.getElementById("web-search-suggestions");

            let timer;

            input.addEventListener("input", async (e) => {

                clearTimeout(timer);

                const q = e.target.value.trim();

                if (q.length === 0) {
                    suggestionsBox.style.display = "none";
                    suggestionsBox.innerHTML = "";
                    return;
                }

                try {

                    /* first letter instant */

                    if (q.length === 1) {

                        const res = await fetch(
                            `${API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`
                        );

                        const data = await res.json();

                        if (!data.success) return;

                        renderSuggestions(data.data.products);

                        return;
                    }

                    /* smooth delay */

                    timer = setTimeout(async () => {

                        const res = await fetch(
                            `${API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`
                        );

                        const data = await res.json();

                        if (!data.success) return;

                        renderSuggestions(data.data.products);

                    }, 200);

                } catch (err) {
                    console.log(err);
                }

            });

            document.addEventListener("click", (e) => {
                if (
                    !input.contains(e.target) &&
                    !suggestionsBox.contains(e.target)
                ) {
                    suggestionsBox.style.display = "none";
                }
            });

            function renderSuggestions(products) {

                let html = "";

                products.forEach(p => {
                    html += `<div class="web-suggestion-item" onclick="window.location.href='/product/${p.slug}'">${p.name}</div>`;
                });

                if (html === "") {
                    html = `<div class="web-suggestion-item">No results found</div>`;
                }

                suggestionsBox.innerHTML = html;
                suggestionsBox.style.display = "block";
            }

        }, 300);

    }
        
    function applyOtherFilters(selected) {
            let filtered = [...currentProducts];
            let filterApplied = false;
            
            if (selected.price.length > 0) {
                filterApplied = true;
                filtered = filtered.filter(p => {
                    // const price = parseFloat(p.final_price || p.price || 0);
                    const price = parseFloat(
                        (p.product_price && p.product_price != "0.00")
                            ? p.product_price
                            : (p.final_price || p.price || 0)
                    );
                    return selected.price.some(range => {
                        const [min, max] = range.split('-').map(Number);
                        return price >= min && price <= max;
                    });
                });
            }
            
            if (selected.brand.length > 0) {
                filterApplied = true;
                filtered = filtered.filter(p => selected.brand.includes(p.brand));
            }
            
            if (selected.discount.length > 0) {
                filterApplied = true;
                filtered = filtered.filter(p => {
                    if (p.price && p.final_price) {
                        const original = parseFloat(p.price);
                        const final = parseFloat(p.final_price);
                        if (original > final) {
                            const discount = Math.round(((original - final) / original) * 100);
                            return selected.discount.some(d => {
                                const discountVal = parseInt(d.replace('%', ''));
                                return discount >= discountVal;
                            });
                        }
                    }
                    return false;
                });
            }
            
            if (filterApplied) {
                if (filtered.length > 0) {
                    renderProducts(filtered);
                } else {
                    document.getElementById('productsGrid').innerHTML = '<div class="loading" style="grid-column:1/-1; padding:40px; text-align:center; color:#999;">No products match your filters</div>';
                }
            }
        }


    window.resetFilters = function() {
        document.querySelectorAll('.filter-checkbox input').forEach(cb => cb.checked = false);
        
        if (currentSub) {
            fetchProducts(currentSub);
        } else {
            const urlParams = new URLSearchParams(window.location.search);
            const subId = urlParams.get('subcategory');
            if (subId) {
                fetchProducts(subId);
            }
        }
    };
    // Load categories for product page desktop header
async function loadProductDesktopHeader() {
    const navMenu = document.getElementById('productNavMenu');
    const popup = document.getElementById('productAllCategoriesPopup');
    
    if (!navMenu) return;
    
    try {
        const res = await fetch(`${API_BASE_URL}/categories`);
        const data = await res.json();
        
        if (data.success) {
            const categories = data.data.slice(0, 5);
            
            navMenu.innerHTML = categories.map(cat => 
                `<a href="/category/${cat.id}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`
            ).join('');
            
            // Setup hover popup
            const navItems = document.querySelectorAll('#productNavMenu .nav-item');
            
            const showPopup = () => {
                if (!popup) return;
                renderProductAllCategoriesPopup(data.data);
                popup.style.display = 'block';
            };
            
            const hidePopup = () => {
                if (!popup) return;
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 200);
            };
            
            navItems.forEach(item => {
                item.addEventListener('mouseenter', showPopup);
                item.addEventListener('mouseleave', hidePopup);
            });
            
            if (popup) {
                popup.addEventListener('mouseenter', () => {
                    popup.style.display = 'block';
                });
                popup.addEventListener('mouseleave', hidePopup);
            }
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

function renderProductAllCategoriesPopup(categories) {
    const popup = document.getElementById('productAllCategoriesPopup');
    if (!popup) return;
    
    const allMainCategories = categories;
    const columnSize = Math.ceil(allMainCategories.length / 5);
    const columns = [];
    
    for (let i = 0; i < 5; i++) {
        columns.push(allMainCategories.slice(i * columnSize, (i + 1) * columnSize));
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
document.addEventListener('DOMContentLoaded', function () {
    updateCartCountBadge();
});
function updateCartCountBadge() {

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let totalItems = cart.length;

    const badge = document.getElementById('cart-count-badge');

    if (!badge) return;

    badge.style.display = 'flex';
    badge.textContent = totalItems;
}
async function fetchAppSettingsForProducts() {
    try {
        const response = await fetch(`${API_BASE_URL}/app-settings`);
        const data = await response.json();
        if (data.success) {
            const appName = data.data.app_name;
            const headerLogo = data.data.header_logo || data.data.app_logo;
            
            const desktopLogoEl = document.getElementById('desktopHeaderLogo');
            if (desktopLogoEl && headerLogo) {
                desktopLogoEl.src = headerLogo;
            }
            
            const mobileLogoEl = document.getElementById('mobileHeaderLogo');
if (mobileLogoEl) {
    mobileLogoEl.style.height = '28px';
    mobileLogoEl.style.width = 'auto';
    mobileLogoEl.src = headerLogo;
}}
    } catch (error) {
        console.error('Error fetching app settings:', error);
    }
}
// Call this function when page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchAppSettingsForProducts();
    loadProductDesktopHeader();
    initWebSearchDropdown();

});
function initDesktopFiltersToggle() {
    document.querySelectorAll('.desktop-filter-section').forEach(section => {
        const title = section.querySelector('.desktop-filter-title');
        const options = section.querySelector('.filter-options');
        
        if (title && options) {
            // Initially closed
            options.classList.remove('open');
            
            // Add click handler
            title.addEventListener('click', function(e) {
                e.preventDefault();
                section.classList.toggle('open');
                options.classList.toggle('open');
            });
        }
    });
}
setTimeout(function() {
    fetch(`${API_BASE_URL}/app-settings`)
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const logo = data.data.header_logo || data.data.app_logo;
                const img = document.getElementById('mobileHeaderLogo');
                if (img && logo) {
                    img.src = logo;
                    img.style.display = 'block';
                }
            }
        });
}, 100);
    fetchData();
    
})();
</script>
<script>
// Force cart count update every 2 seconds for app
setInterval(function() {
    try {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalItems = cart.length;
        
        const badge = document.getElementById('cart-count-badge');
        if (badge && badge.textContent != totalItems) {
            badge.textContent = totalItems;
            if (totalItems > 0) {
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
        
        const mobileBadge = document.querySelector('.cart-count-badge');
        if (mobileBadge && mobileBadge.textContent != totalItems) {
            mobileBadge.textContent = totalItems;
            if (totalItems > 0) {
                mobileBadge.style.display = 'flex';
            } else {
                mobileBadge.style.display = 'none';
            }
        }
    } catch(e) {}
}, 2000);
</script>
@include('components.footer')
</body>
</html>