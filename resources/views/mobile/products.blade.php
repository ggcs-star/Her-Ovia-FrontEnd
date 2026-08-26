<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php
        $pageTitle = 'Products | MAHERA JEWEL';
        $pageDescription = 'Shop beautiful jewellery at MAHERA JEWEL. Find necklaces, earrings, maang tikka, bridal sets, and bangles with amazing discounts.';
        
        if(request()->route('categorySlug')) {
            $categoryName = ucfirst(str_replace('-', ' ', request()->route('categorySlug')));
            $pageTitle = $categoryName . ' | MAHERA JEWEL';
            $pageDescription = 'Shop beautiful ' . $categoryName . ' at MAHERA JEWEL. Best quality ' . $categoryName . ' with amazing discounts. Free shipping on orders above ₹999.';
        }
        
        if(request()->query('subcategory')) {
            $pageDescription = 'Shop beautiful jewellery at MAHERA JEWEL. Find the perfect piece for every occasion.';
        }
    @endphp

    <title>{{ $pageTitle }}</title>

    <meta name="description" content="{{ $pageDescription }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/mjlogo.jpeg') }}">
    <meta name="keywords"
    content="jewellery, necklace, earrings, maang tikka, bridal sets, bangles, kundan jewellery">

    <meta name="author" content="MAHERA JEWEL">

    <meta name="robots" content="index,follow">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="description"
    content="Explore premium jewellery collection from Mahera Jewel. Find necklaces, earrings, bangles and bridal jewellery.">

    <link rel="canonical" href="{{ url()->current() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <style>
        /* ==========================================
   PRODUCTS PAGE - COMPLETE STYLES
   ========================================== */

/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #fff;
    padding-bottom: env(safe-area-inset-bottom);
    -webkit-overflow-scrolling: touch;
}

/* ==========================================
   HEADER - LANDING PAGE EXACT COPY
   ========================================== */

/* Site Header Container */
.site-header {
    background: #F8EEE3 !important;
    border-bottom: 1px solid #DCC0A8 !important;
    padding: 0 !important;
    width: 100% !important;
    position: sticky;
    top: 0;
    z-index: 1000;
}

/* Web Header (Desktop) */
.web-header {
    background: #F8EEE3 !important;
    border-bottom: 1px solid #DCC0A8 !important;
}

/* Top Bar */
.web-header .top-bar {
    background: #4A0F14 !important;
    color: #ffffff !important;
    padding: 8px 40px !important;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
}

/* Main Header Layout */
.web-header .main-header {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 12px 40px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 30px !important;
    background: #F8EEE3 !important;
    flex-wrap: nowrap !important;
}

/* Logo Area */
.web-header .logo-area {
    display: flex !important;
    align-items: center !important;
    gap: 40px !important;
    flex-shrink: 0 !important;
}

.web-header .logo-area .logo {
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
}

.web-header .logo-area .logo img {
    height: 48px !important;
    width: auto !important;
    max-width: 180px !important;
    object-fit: contain !important;
    background: transparent !important;
    border: none !important;
    border-radius: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    display: block !important;
}

/* Navigation Menu */
.web-header .nav-menu {
    display: flex !important;
    gap: 25px !important;
}

.web-header .nav-item {
    color: #2E1B1B !important;
    text-decoration: none !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-family: 'Inter', sans-serif !important;
    white-space: nowrap !important;
    background: transparent !important;
}

.web-header .nav-item:hover {
    color: #4A0F14 !important;
}

/* Search Area */
.web-header .search-area {
    flex: 1 !important;
    max-width: 380px !important;
    margin: 0 20px !important;
    min-width: 150px !important;
}

.web-header .search-box {
    display: flex !important;
    align-items: center !important;
    background: #f5f5f6 !important;
    border-radius: 30px !important;
    overflow: hidden !important;
    border: 1px solid #e0e0e0 !important;
    padding-right: 4px !important;
    position: relative !important;
}

.web-header .search-box input {
    flex: 1 !important;
    padding: 8px 14px !important;
    border: none !important;
    background: transparent !important;
    font-size: 13px !important;
    outline: none !important;
    font-family: 'Inter', sans-serif !important;
}

.web-header .search-box input::placeholder {
    color: #999 !important;
    font-size: 12px !important;
}

.web-header .search-box .search-icon-btn {
    background: transparent !important;
    border: none !important;
    cursor: pointer !important;
    padding: 6px 10px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
}

.web-header .search-box .search-icon-btn svg {
    stroke: #666 !important;
    width: 18px !important;
    height: 18px !important;
}

.web-header .search-box .search-icon-btn:hover svg {
    stroke: #440C2C !important;
}

.web-header .search-box .search-icon-btn:hover {
    background: rgba(68, 12, 44, 0.08) !important;
}

/* Header Actions */
.web-header .header-actions {
    display: flex !important;
    align-items: center !important;
    gap: 24px !important;
    flex-shrink: 0 !important;
    flex-wrap: nowrap !important;
    white-space: nowrap !important;
}

.web-header .action-link {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    color: #2E1B1B !important;
    text-decoration: none !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    font-family: 'Inter', sans-serif !important;
    white-space: nowrap !important;
    background: transparent !important;
}

.web-header .action-link:hover {
    color: #4A0F14 !important;
}

.web-header .action-link .header-icon {
    width: 18px !important;
    height: 18px !important;
    stroke: currentColor !important;
    fill: none !important;
    flex-shrink: 0 !important;
}

/* Cart Badge */
.web-header .cart-icon-wrapper {
    position: relative !important;
    display: inline-block !important;
}

#web-cart-count-badge {
    position: absolute !important;
    top: -8px !important;
    right: -12px !important;
    background: #440C2C !important;
    color: #F4B94E !important;
    font-size: 10px !important;
    font-weight: 600 !important;
    min-width: 18px !important;
    height: 18px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 4px !important;
    font-family: 'Inter', sans-serif !important;
}

/* All Categories Popup */
.all-categories-popup {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    width: 100% !important;
    background: #ffffff !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    z-index: 1001 !important;
    border-top: 1px solid #f0f0f0 !important;
}

/* Search Suggestions */
#web-search-suggestions {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    width: 100% !important;
    background: #ffffff !important;
    border: 1px solid #ccc !important;
    border-radius: 8px !important;
    margin-top: 4px !important;
    z-index: 99999 !important;
    max-height: 320px !important;
    overflow-y: auto !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
}

.web-suggestion-item {
    padding: 10px 14px !important;
    font-size: 14px !important;
    cursor: pointer !important;
    border-bottom: 1px solid #f0f0f0 !important;
    font-family: 'Inter', sans-serif !important;
}

.web-suggestion-item:hover {
    background: #f5f5f5 !important;
}

/* ===== MOBILE HEADER ===== */
.header-container {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 8px !important;
    padding: 8px 16px !important;
    width: 100% !important;
    background: #F8EEE3 !important;
}

.logo-search-container {
    flex: 1 !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    background: #f5f5f6 !important;
    border-radius: 30px !important;
    padding: 4px 8px !important;
    border: 1px solid #e0e0e0 !important;
    min-width: 0 !important;
}

.header-logo {
    flex-shrink: 0 !important;
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

.header-logo .site-logo {
    height: 32px !important;
    width: auto !important;
    max-width: 100px !important;
    object-fit: contain !important;
    display: block !important;
    background: transparent !important;
    border: none !important;
    border-radius: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
}

.search-wrapper {
    display: flex !important;
    align-items: center !important;
    flex: 1 !important;
    gap: 4px !important;
    min-width: 0 !important;
}

.search-wrapper input {
    flex: 1 !important;
    border: none !important;
    background: transparent !important;
    outline: none !important;
    font-size: 12px !important;
    padding: 6px 0 !important;
    min-width: 0 !important;
    width: 100% !important;
    font-family: 'Inter', sans-serif !important;
}

.search-wrapper input::placeholder {
    color: #999 !important;
    font-size: 11px !important;
}

.search-wrapper .search-icon-btn {
    background: none !important;
    border: none !important;
    cursor: pointer !important;
    padding: 6px 8px !important;
    display: flex !important;
    align-items: center !important;
}

.search-wrapper .search-icon-btn svg {
    width: 18px !important;
    height: 18px !important;
    stroke: #666 !important;
}

.header-icons {
    display: flex !important;
    gap: 8px !important;
    flex-shrink: 0 !important;
}

.header-icon-btn {
    background: none !important;
    border: none !important;
    cursor: pointer !important;
    padding: 6px !important;
    width: 32px !important;
    height: 32px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.header-icon-btn svg {
    width: 20px !important;
    height: 20px !important;
    stroke: #2E1B1B !important;
    fill: none !important;
}

.back-btn-header {
    background: none !important;
    border: none !important;
    font-size: 20px !important;
    cursor: pointer !important;
    width: 32px !important;
    height: 32px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
    color: #2E1B1B !important;
    flex-shrink: 0 !important;
    font-weight: 500 !important;
}

/* ===== HEADER RESPONSIVE ===== */
@media screen and (min-width: 1025px) {
    .site-header .header-container {
        display: none !important;
    }
    .web-header {
        display: block !important;
    }
    .header {
        display: none !important;
    }
}

@media screen and (max-width: 1024px) {
    .web-header {
        display: none !important;
    }
    .site-header .header-container {
        display: flex !important;
    }
    .header {
        display: none !important;
    }
}

@media screen and (min-width: 1025px) and (max-width: 1200px) {
    .web-header .logo-area {
        gap: 15px !important;
    }
    .web-header .nav-menu {
        gap: 12px !important;
    }
    .web-header .nav-item {
        font-size: 10px !important;
    }
    .web-header .search-area {
        max-width: 350px !important;
        margin: 0 10px !important;
    }
    .web-header .header-actions {
        gap: 12px !important;
    }
    .web-header .action-link {
        font-size: 11px !important;
    }
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ==========================================
   PRODUCTS GRID & FILTERS
   ========================================== */

/* Wrapper */
.products-page-wrapper {
    display: flex;
    max-width: 1440px;
    margin: 0 auto;
    gap: 24px;
    padding: 20px 24px;
}

/* Filters Sidebar */
.desktop-filters-sidebar {
    width: 280px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 12px;
    position: sticky;
    top: calc(80px + 20px);
    height: fit-content;
    max-height: calc(100vh - 100px);
    overflow-y: auto;
    padding: 20px;
    border: 1px solid #f0f0f0;
}

/* Products Area */
.desktop-products-area {
    flex: 1;
    min-width: 0;
}

/* Products Grid */
.products {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    padding: 0 0 40px 0;
}

/* Product Card */
.card {
    cursor: pointer;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #f0f0f0;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
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
    color: #fff;
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
    color: #F4B94E;
}

/* Product Info */
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

.stars {
    color: #ffc107;
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

/* ===== FILTER SECTIONS ===== */

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
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.desktop-filter-title::after {
    content: '+';
    font-size: 18px;
    color: #F4B94E;
    font-weight: 600;
}

.desktop-filter-section.open .desktop-filter-title::after {
    content: '−';
}

.filter-options {
    display: none;
}

.filter-options.open {
    display: block;
}

.desktop-filter-option {
    display: block;
    padding: 8px 0;
    font-size: 13px;
    color: #666;
    cursor: pointer;
    transition: color .2s;
}

.desktop-filter-option:hover {
    color: #F4B94E;
}

.desktop-filter-option input {
    margin-right: 12px;
    accent-color: #F4B94E;
    cursor: pointer;
}

/* Reset Button */
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
    transition: all .2s;
}

.desktop-reset-filters:hover {
    background: #e8e8e8;
}

/* ===== SUB STRIP ===== */
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
    display: none !important;
}

.sub-strip::-webkit-scrollbar {
    display: none;
}

.sub-item {
    min-width: 80px;
    flex-shrink: 0;
    text-align: center;
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

/* ===== ACTION BAR (Mobile) ===== */
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
}

/* ===== BOTTOM NAV ===== */
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

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    font-size: 11px;
    color: #000;
    cursor: pointer;
}

.nav-item.active {
    color: #F4B94E;
}

.nav-icon {
    font-size: 20px;
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

/* ===== SORT & FILTER POPUPS ===== */
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
    transition: all .3s ease;
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
    transition: transform .3s ease;
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

/* Filter Popup */
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
    transition: all .3s ease;
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
    transition: transform .3s ease;
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
    transition: all .3s ease;
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
    color: #F4B94E;
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
    color: #F4B94E;
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
    accent-color: #F4B94E;
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
    background: #F4B94E;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}

/* ===== RESPONSIVE ===== */

/* Tablet */
@media screen and (min-width: 768px) and (max-width: 1023px) {
    .products {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .desktop-filters-sidebar {
        display: none;
    }
}

/* Mobile */
@media screen and (max-width: 767px) {
    .desktop-filters-sidebar {
        display: none;
    }
    .products-page-wrapper {
        display: block;
    }
}

/* Desktop filters hide on mobile */
@media screen and (max-width: 1024px) {
    .desktop-filters-sidebar {
        display: none !important;
    }
    .products-page-wrapper {
        display: block !important;
    }
    .desktop-products-area {
        width: 100% !important;
    }
    .action-bar {
        display: flex !important;
    }
}

/* Desktop */
@media screen and (min-width: 1024px) {
    .action-bar {
        display: none !important;
    }
    .bottom-nav {
        display: none;
    }
    .sub-strip {
        position: relative;
        top: 0;
        padding: 16px 0 20px 0;
        margin-bottom: 20px;
        background: transparent;
        gap: 20px;
        border: none !important;
    }
    .sub-item {
        min-width: 70px;
    }
    .sub-img {
        width: 70px;
        height: 70px;
    }
    .filter-popup-overlay,
    .sort-popup-overlay {
        display: none !important;
    }
}

/* Extra Small */
@media screen and (max-width: 480px) {
    .products {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 8px;
    }
    .action-bar {
        bottom: calc(60px + env(safe-area-inset-bottom));
        padding: 10px 12px;
    }
    .bottom-nav {
        height: calc(55px + env(safe-area-inset-bottom));
    }
}

/* ===== UTILITY ===== */
.loading {
    text-align: center;
    padding: 40px;
    color: #999;
    grid-column: 1/-1;
}

#mobile-bottom-nav {
    display: none !important;
}

.sub-strip {
    display: none !important;
}
</style>
</head>
<body data-page="products" data-subcategory-id="{{ request()->query('subcategory') }}" data-category-id="{{ request()->query('category') }}" data-category-slug="{{ request()->route('categorySlug') }}">

    <header class="site-header" id="site-header"></header>

    <div class="products-page-wrapper">
        <aside class="desktop-filters-sidebar" id="desktopFiltersSidebar">
            <div class="desktop-filter-section">
                <div class="desktop-filter-title">CATEGORY</div>
                <div class="filter-options" id="desktopCategoryFilters"></div>
            </div>
            <div class="desktop-filter-section">
                <div class="desktop-filter-title">PRICE</div>
                <div class="filter-options" id="desktopPriceFilters"></div>
            </div>
            <div class="desktop-filter-section">
                <div class="desktop-filter-title">BRANDS</div>
                <div class="filter-options" id="desktopBrandFilters"></div>
            </div>
            <div class="desktop-filter-section">
                <div class="desktop-filter-title">DISCOUNT</div>
                <div class="filter-options" id="desktopDiscountFilters"></div>
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

    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

    <div class="sort-popup-overlay" id="sortPopupOverlay" onclick="hideSortPopup()">
        <div class="sort-popup-content" onclick="event.stopPropagation()">
            <div class="sort-popup-header">
                <h3>Sort By</h3>
                <span class="sort-popup-close" onclick="hideSortPopup()">×</span>
            </div>
            <div class="sort-popup-body">
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
                    <div class="filter-title-item" onclick="showFilterOptions('category')"><span>CATEGORY</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('price')"><span>PRICE</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('brand')"><span>BRAND</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('size')"><span>SIZE</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('color')"><span>COLOR</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('fabric')"><span>FABRIC</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('occasion')"><span>OCCASION</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('discount')"><span>DISCOUNT</span><span class="arrow-icon">›</span></div>
                    <div class="filter-title-item" onclick="showFilterOptions('rating')"><span>RATING</span><span class="arrow-icon">›</span></div>
                </div>
                <div class="filter-options-column" id="filterOptionsColumn" style="display:none;">
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
        (function(){
            if(typeof window.app !== 'undefined' && window.app){
                window.app.renderHeader();
                window.app.renderBottomNav();
            } else if(typeof RapidRetailsEngine !== 'undefined'){
                window.app = new RapidRetailsEngine();
                window.app.renderHeader();
                window.app.renderBottomNav();
            }
        })();

        document.addEventListener('DOMContentLoaded', function(){
            setTimeout(function(){
                if(typeof updateCartCountBadge === 'function'){
                    updateCartCountBadge();
                }
            }, 50);
            setTimeout(function(){
                if(typeof fetchData === 'function'){
                    fetchData();
                }
            }, 300);
        });

        async function preloadAllHoverImages(products){
            const preloadPromises = products.map(async (p)=>{
                if(p.slug){
                    try{
                        const response = await fetch(API_BASE_URL + '/products/' + p.slug);
                        const data = await response.json();
                        if(data.success && data.data){
                            const galleryImages = data.data.gallery_images || [];
                            let hoverImage = galleryImages[1] || galleryImages[0];
                            if(hoverImage && hoverImage !== p.image_url){
                                const img = new Image();
                                img.src = hoverImage;
                                p.preloadedHoverImage = hoverImage;
                            }
                        }
                    } catch(e){}
                }
            });
            await Promise.all(preloadPromises);
        }

        window.loadHoverImage = function(imgElement, slug, hoverUrl){
            if(imgElement.dataset.loading === 'true') return;
            if(hoverUrl && hoverUrl !== imgElement.dataset.main){
                if(imgElement.src === hoverUrl) return;
                imgElement.dataset.loading = 'true';
                const tempImg = new Image();
                tempImg.onload = function(){
                    imgElement.src = hoverUrl;
                    imgElement.dataset.loading = 'false';
                };
                tempImg.onerror = function(){
                    imgElement.dataset.loading = 'false';
                };
                tempImg.src = hoverUrl;
            }
        };

        (function(){
            const subId = document.body.dataset.subcategoryId;
            let allSubs = [];
            let currentSub = subId;
            let currentProducts = [];
            let originalProducts = [];

            function getProductPrice(p){
                return parseFloat(p.product_price || p.price || 0);
            }

            function getProductMrp(p){
                return parseFloat(p.price || p.mrp || p.product_price || 0);
            }

            function renderProducts(products){
                const grid = document.getElementById('productsGrid');
                if(!grid) return;
                if(!products.length){
                    grid.innerHTML = '<div class="loading">No products found</div>';
                    return;
                }
                const latestWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                const fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
                grid.innerHTML = products.map(function(p){
                    const price = getProductPrice(p);
                    const mrp = getProductMrp(p);
                    const discount = mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0;
                    const rating = 4.3;
                    const full = Math.floor(rating);
                    const half = (rating % 1) >= 0.3;
                    let stars = '';
                    for(let i = 0; i < full; i++) stars += '★';
                    if(half) stars += '½';
                    for(let i = stars.length; i < 5; i++) stars += '☆';
                    const inWish = latestWishlist.some(function(item){ return item.id == p.id; });
                    const isBest = discount > 20;
                    const mainImage = p.image_url || fallback;
                    return '<div class="card" data-product-id="' + p.id + '" data-product-slug="' + p.slug + '">' +
                        '<div class="img-box" onclick="window.location.href=\'/product/' + p.slug + '\'">' +
                        '<img class="product-img-' + p.id + '" src="' + mainImage + '" data-main="' + mainImage + '" data-hover="' + (p.preloadedHoverImage || '') + '" onmouseenter="loadHoverImage(this, \'' + p.slug + '\', \'' + (p.preloadedHoverImage || '') + '\')" onmouseleave="this.src=this.dataset.main" onerror="this.src=\'' + fallback + '\'">' +
                        (isBest ? '<span class="badge">Best Seller</span>' : '') +
                        '<button class="wishlist ' + (inWish ? 'active' : '') + '" onclick="event.stopPropagation(); toggleWish(this, ' + JSON.stringify({id:p.id,name:p.name,price:price,image:mainImage,brand:p.brand,slug:p.slug}) + ')">' + (inWish ? '❤️' : '♡') + '</button>' +
                        '</div>' +
                        '<div class="info" onclick="window.location.href=\'/product/' + p.slug + '\'">' +
                        '<div class="brand">' + (p.brand || 'RAPID RETAIL') + '</div>' +
                        '<div class="name">' + p.name + '</div>' +
                        '<div class="rating-row"><div class="rating"><span class="stars">' + stars + '</span> | ' + (Math.floor(Math.random() * 50) + 10) + '</div></div>' +
                        '<div class="price"><span class="current">₹' + price.toLocaleString('en-IN') + '</span>' + (mrp > price ? '<span class="original">₹' + mrp.toLocaleString('en-IN') + '</span>' : '') + (discount > 0 ? '<span class="off">' + discount + '% Off</span>' : '') + '</div>' +
                        '</div></div>';
                }).join('');
            }

            async function fetchData(){
                try{
                    const urlParams = new URLSearchParams(window.location.search);
                    const search = urlParams.get('search');
                    if(search){
                        const res = await fetch(API_BASE_URL + '/products/search?q=' + encodeURIComponent(search));
                        const data = await res.json();
                        currentProducts = data.data.products || data.data || [];
                        originalProducts = currentProducts.slice();
                        await preloadAllHoverImages(currentProducts);
                        renderProducts(currentProducts);
                        updateDesktopFiltersFromProducts(currentProducts);
                        return;
                    }
                    const type = urlParams.get('type');
                    const currentPath = window.location.pathname;
                    if(type === 'top-selling' || currentPath === '/top-selling'){
                        await fetchTopSellingProducts();
                        return;
                    }
                    if(type === 'best-selling' || currentPath === '/best-selling'){
                        await fetchBestSellerProducts();
                        return;
                    }
                    let targetSubId = null;
                    let targetSubName = null;
                    const path = window.location.pathname;
                    const collectionMatch = path.match(/\/collection\/([^\/]+)(?:\/([^\/]+))?/);
                    if(collectionMatch && collectionMatch[2]){
                        targetSubName = decodeURIComponent(collectionMatch[2]);
                    }
                    if(collectionMatch && collectionMatch[1]){
                        const categorySlug = collectionMatch[1];
                        const res = await fetch(API_BASE_URL + '/categories');
                        const data = await res.json();
                        if(data.success){
                            for(let cat of data.data){
                                if(cat.children && cat.children.length){
                                    let mainSlug = cat.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                                    if(mainSlug === categorySlug){
                                        if(targetSubName){
                                            for(let sub of cat.children){
                                                let subSlug = sub.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                                                if(subSlug === targetSubName){
                                                    targetSubId = sub.id;
                                                    currentSub = targetSubId;
                                                    break;
                                                }
                                            }
                                        }
                                        if(!targetSubId && cat.children.length){
                                            targetSubId = cat.children[0].id;
                                            currentSub = targetSubId;
                                        }
                                        break;
                                    }
                                    for(let sub of cat.children){
                                        let subSlug = sub.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                                        if(subSlug === categorySlug){
                                            targetSubId = sub.id;
                                            currentSub = targetSubId;
                                            break;
                                        }
                                    }
                                }
                                if(targetSubId) break;
                            }
                        }
                    } else {
                        targetSubId = document.body.dataset.subcategoryId;
                        currentSub = targetSubId;
                    }
                    if(!targetSubId) return;
                    const res = await fetch(API_BASE_URL + '/categories');
                    const data = await res.json();
                    if(data.success){
                        let mainCat = data.data.find(function(c){ return c.id == targetSubId; });
                        if(!mainCat){
                            mainCat = data.data.find(function(c){ return c.children && c.children.some(function(child){ return child.id == targetSubId; }); });
                        }
                        if(mainCat){
                            allSubs = mainCat.children || [];
                            renderSubs();
                            if(!currentSub || currentSub != targetSubId){
                                currentSub = targetSubId;
                            }
                            fetchProducts(currentSub);
                            loadDesktopFilters(mainCat);
                            initDesktopFiltersToggle();
                        }
                    }
                } catch(error){
                    console.error('Error:', error);
                }
            }

            async function fetchProducts(subId){
                const grid = document.getElementById('productsGrid');
                try{
                    const res = await fetch(API_BASE_URL + '/categories/' + subId + '/products');
                    const data = await res.json();
                    if(data.success && data.data.products){
                        currentProducts = data.data.products;
                        originalProducts = data.data.products.slice();
                        await preloadAllHoverImages(currentProducts);
                        renderProducts(currentProducts);
                        updateDesktopFiltersFromProducts(currentProducts);
                    } else {
                        grid.innerHTML = '<div class="loading">No products found</div>';
                    }
                } catch(error){
                    grid.innerHTML = '<div class="loading">Error loading products</div>';
                }
            }

            function renderSubs(){
                const strip = document.getElementById('subStrip');
                if(!strip) return;
                if(!allSubs.length){
                    strip.style.display = 'none';
                    return;
                }
                const fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';
                strip.innerHTML = allSubs.map(function(sub){
                    return '<div class="sub-item ' + (sub.id == currentSub ? 'active' : '') + '" data-subid="' + sub.id + '" onclick="changeSubcategory(' + sub.id + ')">' +
                        '<div class="sub-img"><img src="' + (sub.image_url || fallback) + '" onerror="this.src=\'' + fallback + '\'"></div>' +
                        '<div class="sub-name">' + sub.name + '</div></div>';
                }).join('');
                document.querySelectorAll('.sub-item').forEach(function(item){
                    if(item.dataset.subid == currentSub){
                        item.classList.add('active');
                    }
                });
            }

            window.changeSubcategory = function(newSubId){
                currentSub = newSubId;
                document.querySelectorAll('.sub-item').forEach(function(item){
                    if(item.dataset.subid == newSubId){
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
                fetchProducts(newSubId);
                let subSlug = newSubId;
                const activeSub = allSubs.find(function(s){ return s.id == newSubId; });
                if(activeSub){
                    subSlug = activeSub.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                }
                const categorySlug = document.body.dataset.categorySlug || 'necklace';
                window.history.pushState({}, '', '/collection/' + categorySlug + '/' + subSlug);
            };

            function loadDesktopFilters(mainCategory){
                const container = document.getElementById('desktopCategoryFilters');
                if(container && mainCategory.children && mainCategory.children.length){
                    container.innerHTML = mainCategory.children.map(function(child){
                        return '<label class="desktop-filter-option"><input type="checkbox" class="desktop-category-filter" value="' + child.id + '" onchange="applyDesktopFilters()"> ' + child.name + '</label>';
                    }).join('');
                }
            }

            window.applyDesktopFilters = function(){
                let filtered = currentProducts.slice();
                let filterApplied = false;
                const selectedCategories = Array.from(document.querySelectorAll('.desktop-category-filter:checked')).map(function(cb){ return cb.value; });
                if(selectedCategories.length === 1){
                    changeSubcategory(selectedCategories[0]);
                    return;
                }
                if(selectedCategories.length > 1){
                    fetchMultipleSubcategoriesCommon(selectedCategories);
                    return;
                }
                const selectedPriceRanges = Array.from(document.querySelectorAll('.desktop-price-filter:checked')).map(function(cb){ return cb.value; });
                if(selectedPriceRanges.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){
                        const price = getProductPrice(p);
                        return selectedPriceRanges.some(function(range){
                            const parts = range.split('-').map(Number);
                            return price >= parts[0] && price <= parts[1];
                        });
                    });
                }
                const selectedBrands = Array.from(document.querySelectorAll('.desktop-brand-filter:checked')).map(function(cb){ return cb.value; });
                if(selectedBrands.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){ return selectedBrands.indexOf(p.brand) !== -1; });
                }
                const selectedDiscounts = Array.from(document.querySelectorAll('.desktop-discount-filter:checked')).map(function(cb){ return parseInt(cb.value); });
                if(selectedDiscounts.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){
                        if(p.price && p.final_price && parseFloat(p.price) > parseFloat(p.final_price)){
                            const discount = Math.round(((parseFloat(p.price) - parseFloat(p.final_price)) / parseFloat(p.price)) * 100);
                            return selectedDiscounts.some(function(d){ return discount >= d; });
                        }
                        return false;
                    });
                }
                if(!filterApplied){
                    renderProducts(currentProducts);
                } else if(filtered.length > 0){
                    renderProducts(filtered);
                } else {
                    document.getElementById('productsGrid').innerHTML = '<div class="loading">No products match your filters</div>';
                }
            };

            window.updateDesktopFiltersFromProducts = function(products){
                const urlParams = new URLSearchParams(window.location.search);
                const type = urlParams.get('type');
                if(type === 'top-selling'){
                    var categorySection = document.querySelector('#desktopCategoryFilters');
                    if(categorySection){
                        var parent = categorySection.closest('.desktop-filter-section');
                        if(parent) parent.style.display = 'none';
                    }
                }
                const brands = new Set();
                products.forEach(function(p){ if(p.brand) brands.add(p.brand); });
                const brandContainer = document.getElementById('desktopBrandFilters');
                if(brandContainer){
                    const currentChecked = Array.from(document.querySelectorAll('.desktop-brand-filter:checked')).map(function(cb){ return cb.value; });
                    brandContainer.innerHTML = Array.from(brands).map(function(brand){
                        return '<label class="desktop-filter-option"><input type="checkbox" class="desktop-brand-filter" value="' + brand + '" onchange="applyDesktopFilters()" ' + (currentChecked.indexOf(brand) !== -1 ? 'checked' : '') + '> ' + brand + '</label>';
                    }).join('');
                }
                const priceContainer = document.getElementById('desktopPriceFilters');
                if(priceContainer && products.length > 0){
                    const currentChecked = Array.from(document.querySelectorAll('.desktop-price-filter:checked')).map(function(cb){ return cb.value; });
                    const prices = products.map(function(p){ return getProductPrice(p); }).filter(function(p){ return !isNaN(p); });
                    const minPrice = Math.min.apply(null, prices);
                    const maxPrice = Math.max.apply(null, prices);
                    const step = Math.ceil((maxPrice - minPrice) / 4);
                    const ranges = [];
                    let current = minPrice;
                    for(let i = 0; i < 4; i++){
                        if(i === 0){
                            ranges.push({min:0, max:current + step, label:'Below ₹' + (current + step).toFixed(0)});
                        } else if(i === 3){
                            ranges.push({min:current, max:maxPrice, label:'Above ₹' + current.toFixed(0)});
                        } else {
                            ranges.push({min:current, max:current + step, label:'₹' + current.toFixed(0) + ' - ₹' + (current + step).toFixed(0)});
                        }
                        current += step;
                    }
                    priceContainer.innerHTML = ranges.map(function(range){
                        return '<label class="desktop-filter-option"><input type="checkbox" class="desktop-price-filter" value="' + range.min + '-' + range.max + '" onchange="applyDesktopFilters()" ' + (currentChecked.indexOf(range.min + '-' + range.max) !== -1 ? 'checked' : '') + '> ' + range.label + '</label>';
                    }).join('');
                }
                const discountContainer = document.getElementById('desktopDiscountFilters');
                if(discountContainer){
                    const currentChecked = Array.from(document.querySelectorAll('.desktop-discount-filter:checked')).map(function(cb){ return cb.value; });
                    const discountSet = new Set();
                    products.forEach(function(p){
                        if(p.price && p.final_price){
                            const original = parseFloat(p.price);
                            const final = parseFloat(p.final_price);
                            if(original > final){
                                discountSet.add(Math.round(((original - final) / original) * 100));
                            }
                        }
                    });
                    const sortedDiscounts = Array.from(discountSet).sort(function(a,b){ return a - b; });
                    discountContainer.innerHTML = sortedDiscounts.map(function(d){
                        return '<label class="desktop-filter-option"><input type="checkbox" class="desktop-discount-filter" value="' + d + '" onchange="applyDesktopFilters()" ' + (currentChecked.indexOf(String(d)) !== -1 ? 'checked' : '') + '> ' + d + '% & above</label>';
                    }).join('');
                }
            };

            window.resetDesktopFilters = function(){
                document.querySelectorAll('.desktop-category-filter, .desktop-brand-filter, .desktop-discount-filter, .desktop-price-filter').forEach(function(cb){ cb.checked = false; });
                renderProducts(originalProducts);
            };

            async function fetchMultipleSubcategoriesCommon(subIds){
                const grid = document.getElementById('productsGrid');
                try{
                    let allProducts = [];
                    for(let id of subIds){
                        const res = await fetch(API_BASE_URL + '/categories/' + id + '/products');
                        const data = await res.json();
                        if(data.success && data.data.products){
                            allProducts = allProducts.concat(data.data.products);
                        }
                    }
                    allProducts = allProducts.filter(function(item, index, self){ return self.findIndex(function(i){ return i.id === item.id; }) === index; });
                    currentProducts = allProducts;
                    originalProducts = allProducts.slice();
                    renderProducts(allProducts);
                    updateDesktopFiltersFromProducts(allProducts);
                } catch(error){
                    grid.innerHTML = '<div class="loading">Error loading products</div>';
                }
            }

            async function fetchMultipleSubcategoriesMobile(subIds){
                const grid = document.getElementById('productsGrid');
                try{
                    let allProducts = [];
                    for(let id of subIds){
                        const res = await fetch(API_BASE_URL + '/categories/' + id + '/products');
                        const data = await res.json();
                        if(data.success && data.data.products){
                            allProducts = allProducts.concat(data.data.products);
                        }
                    }
                    allProducts = allProducts.filter(function(item, index, self){ return self.findIndex(function(i){ return i.id === item.id; }) === index; });
                    currentProducts = allProducts;
                    originalProducts = allProducts.slice();
                    renderProducts(allProducts);
                } catch(error){
                    grid.innerHTML = '<div class="loading">Error loading products</div>';
                }
            }

            function applyOtherFilters(selected){
                let filtered = currentProducts.slice();
                let filterApplied = false;
                if(selected.price.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){
                        const price = getProductPrice(p);
                        return selected.price.some(function(range){
                            const parts = range.split('-').map(Number);
                            return price >= parts[0] && price <= parts[1];
                        });
                    });
                }
                if(selected.brand.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){ return selected.brand.indexOf(p.brand) !== -1; });
                }
                if(selected.discount.length > 0){
                    filterApplied = true;
                    filtered = filtered.filter(function(p){
                        if(p.price && p.final_price && parseFloat(p.price) > parseFloat(p.final_price)){
                            const discount = Math.round(((parseFloat(p.price) - parseFloat(p.final_price)) / parseFloat(p.price)) * 100);
                            return selected.discount.some(function(d){ return discount >= parseInt(d.replace('%','')); });
                        }
                        return false;
                    });
                }
                if(filterApplied){
                    if(filtered.length > 0){
                        renderProducts(filtered);
                    } else {
                        document.getElementById('productsGrid').innerHTML = '<div class="loading" style="grid-column:1/-1; padding:40px; text-align:center; color:#999;">No products match your filters</div>';
                    }
                }
            }

            window.applyFilters = function(){
                const selected = {category:[], price:[], brand:[], size:[], color:[], fabric:[], occasion:[], discount:[], rating:[]};
                document.querySelectorAll('.filter-checkbox input:checked').forEach(function(cb){
                    var classes = Array.from(cb.classList);
                    classes.forEach(function(cls){
                        if(cls.startsWith('filter-')){
                            var filterType = cls.replace('filter-', '');
                            if(selected[filterType]){
                                selected[filterType].push(cb.value);
                            }
                        }
                    });
                });
                if(selected.category.length === 1){
                    var firstCategory = selected.category[0];
                    if(firstCategory){
                        window.changeSubcategory(firstCategory);
                        setTimeout(function(){ applyOtherFilters(selected); }, 500);
                    }
                } else if(selected.category.length > 1){
                    fetchMultipleSubcategoriesMobile(selected.category);
                } else {
                    applyOtherFilters(selected);
                }
                hideFilterPopup();
            };

            window.resetFilters = function(){
                document.querySelectorAll('.filter-checkbox input').forEach(function(cb){ cb.checked = false; });
                if(currentSub){
                    fetchProducts(currentSub);
                } else {
                    var urlParams = new URLSearchParams(window.location.search);
                    var subId = urlParams.get('subcategory');
                    if(subId) fetchProducts(subId);
                }
            };

            async function fetchTopSellingProducts(){
                trackPageImpression('top-selling');
                const grid = document.getElementById('productsGrid');
                try{
                    const res = await fetch(API_BASE_URL + '/products/top-selling');
                    const data = await res.json();
                    if(data.success && data.data){
                        var products = Array.isArray(data.data) ? data.data : (data.data.products || []);
                        currentProducts = products;
                        originalProducts = products.slice();
                        await preloadAllHoverImages(currentProducts);
                        renderProducts(products);
                        var subStrip = document.getElementById('subStrip');
                        if(subStrip) subStrip.style.display = 'none';
                        updateDesktopFiltersFromProducts(products);
                        var desktopCategoryContainer = document.getElementById('desktopCategoryFilters');
                        if(desktopCategoryContainer){
                            desktopCategoryContainer.innerHTML = '';
                            var categoryHeader = desktopCategoryContainer.closest('.desktop-filter-section');
                            if(categoryHeader) categoryHeader.style.display = 'none';
                        }
                        initDesktopFiltersToggle();
                    } else {
                        grid.innerHTML = '<div class="loading">No products found</div>';
                    }
                } catch(error){
                    console.error(error);
                    grid.innerHTML = '<div class="loading">Error loading products</div>';
                }
            }

            async function fetchBestSellerProducts(){
                trackPageImpression('best-selling');
                const grid = document.getElementById('productsGrid');
                try{
                    const res = await fetch(API_BASE_URL + '/best-sellers');
                    const data = await res.json();
                    if(data.success && data.data){
                        var products = Array.isArray(data.data) ? data.data : (data.data.products || []);
                        currentProducts = products;
                        originalProducts = products.slice();
                        await preloadAllHoverImages(products);
                        renderProducts(products);
                        updateDesktopFiltersFromProducts(products);
                        var subStrip = document.getElementById('subStrip');
                        if(subStrip) subStrip.style.display = 'none';
                        var desktopCategoryContainer = document.getElementById('desktopCategoryFilters');
                        if(desktopCategoryContainer){
                            desktopCategoryContainer.innerHTML = '';
                            var categoryHeader = desktopCategoryContainer.closest('.desktop-filter-section');
                            if(categoryHeader) categoryHeader.style.display = 'none';
                        }
                        initDesktopFiltersToggle();
                    } else {
                        grid.innerHTML = '<div class="loading">No Best Seller Products</div>';
                    }
                } catch(e){
                    console.error(e);
                    grid.innerHTML = '<div class="loading">Error loading Best Sellers</div>';
                }
            }

            window.showSortPopup = function(){
                document.getElementById('sortPopupOverlay').classList.add('active');
                document.body.style.overflow = 'hidden';
            };

            window.hideSortPopup = function(){
                document.getElementById('sortPopupOverlay').classList.remove('active');
                document.body.style.overflow = '';
            };

            window.applySort = function(){
                var selected = document.querySelector('input[name="sort"]:checked');
                if(!selected){ alert('Please select a sort option'); return; }
                var sortBy = selected.value;
                var sorted = currentProducts.slice();
                switch(sortBy){
                    case 'price-low': sorted.sort(function(a,b){ return getProductPrice(a) - getProductPrice(b); }); break;
                    case 'price-high': sorted.sort(function(a,b){ return getProductPrice(b) - getProductPrice(a); }); break;
                    case 'rating': sorted.sort(function(a,b){ return (b.rating || 0) - (a.rating || 0); }); break;
                    case 'discount':
                        sorted.sort(function(a,b){
                            var dA = ((parseFloat(a.price || 0) - parseFloat(a.final_price || 0)) / parseFloat(a.price || 1)) * 100;
                            var dB = ((parseFloat(b.price || 0) - parseFloat(b.final_price || 0)) / parseFloat(b.price || 1)) * 100;
                            return dB - dA;
                        });
                        break;
                }
                renderProducts(sorted);
                hideSortPopup();
            };

            window.showFilterPopup = function(){
                document.getElementById('filterPopupOverlay').classList.add('active');
                document.body.style.overflow = 'hidden';
                hideFilterOptions();
            };

            window.hideFilterPopup = function(){
                document.getElementById('filterPopupOverlay').classList.remove('active');
                document.body.style.overflow = '';
            };

            window.showFilterOptions = function(filterType){
                var titlesColumn = document.querySelector('.filter-titles-column');
                var optionsColumn = document.getElementById('filterOptionsColumn');
                var optionsContent = document.getElementById('filterOptionsContent');
                var titleElement = document.querySelector('.options-title');
                titleElement.textContent = filterType === 'category' ? 'SUBCATEGORIES' : filterType.toUpperCase();
                optionsContent.innerHTML = '<div style="padding:20px;color:#999;">Loading...</div>';
                loadFilterOptions(filterType, optionsContent);
                titlesColumn.classList.add('half-width');
                optionsColumn.style.display = 'block';
            };

            window.hideFilterOptions = function(){
                document.querySelector('.filter-titles-column').classList.remove('half-width');
                document.getElementById('filterOptionsColumn').style.display = 'none';
            };

            window.toggleWish = function(btn, product){
                event.stopPropagation();
                var currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                var exists = currentWishlist.some(function(item){ return item.id == product.id; });
                if(exists){
                    currentWishlist = currentWishlist.filter(function(item){ return item.id != product.id; });
                    btn.innerHTML = '♡';
                    btn.classList.remove('active');
                } else {
                    currentWishlist.push(product);
                    btn.innerHTML = '❤️';
                    btn.classList.add('active');
                }
                localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
                window.wishlist = currentWishlist;
                renderProducts(currentProducts);
            };

            function initDesktopFiltersToggle(){
                document.querySelectorAll('.desktop-filter-section').forEach(function(section){
                    var title = section.querySelector('.desktop-filter-title');
                    var options = section.querySelector('.filter-options');
                    if(title && options){
                        options.classList.remove('open');
                        title.addEventListener('click', function(e){
                            e.preventDefault();
                            section.classList.toggle('open');
                            options.classList.toggle('open');
                        });
                    }
                });
            }

            async function loadFilterOptions(filterType, container){
                var options = [];
                var urlParams = new URLSearchParams(window.location.search);
                var categoryId = urlParams.get('category');
                var subcategoryId = urlParams.get('subcategory');
                var path = window.location.pathname;
                var collectionMatch = path.match(/\/collection\/([^\/]+)(?:\/([^\/]+))?/);
                if(!categoryId && !subcategoryId && collectionMatch && collectionMatch[1]){
                    try{
                        var res = await fetch(API_BASE_URL + '/categories');
                        var data = await res.json();
                        if(data.success){
                            var mainSlug = collectionMatch[1];
                            var subSlug = collectionMatch[2] || null;
                            for(var cat of data.data){
                                if(cat.children && cat.children.length){
                                    var mainCatSlug = cat.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                                    if(mainCatSlug === mainSlug){
                                        categoryId = cat.id;
                                        if(subSlug){
                                            for(var sub of cat.children){
                                                var subCatSlug = sub.name.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
                                                if(subCatSlug === subSlug){
                                                    subcategoryId = sub.id;
                                                    break;
                                                }
                                            }
                                        }
                                        if(!subcategoryId && cat.children.length){
                                            subcategoryId = cat.children[0].id;
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    } catch(e){}
                }
                var targetId = subcategoryId || categoryId;
                if(filterType === 'category'){
                    try{
                        var res = await fetch(API_BASE_URL + '/categories');
                        var data = await res.json();
                        if(data.success){
                            var targetCategory = null;
                            if(categoryId) targetCategory = data.data.find(function(c){ return c.id == categoryId; });
                            else if(subcategoryId) targetCategory = data.data.find(function(c){ return c.children && c.children.some(function(child){ return child.id == subcategoryId; }); });
                            if(targetCategory && targetCategory.children && targetCategory.children.length){
                                options = targetCategory.children.map(function(child){ return {value: child.id, label: child.name}; });
                            }
                        }
                    } catch(error){ console.error('Error loading categories:', error); }
                } else if(filterType === 'price'){
                    if(targetId){
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products && data.data.products.length){
                            var prices = data.data.products.map(function(p){ return parseFloat(p.final_price || p.price); }).filter(function(p){ return !isNaN(p); });
                            var minPrice = Math.min.apply(null, prices);
                            var maxPrice = Math.max.apply(null, prices);
                            var step = 500;
                            for(var start = Math.floor(minPrice / step) * step; start < maxPrice; start += step){
                                var end = start + step;
                                options.push({value: start + '-' + end, label: start === 0 ? 'Below ₹' + end : '₹' + start + ' - ₹' + end});
                            }
                            options.push({value: maxPrice + '-999999', label: 'Above ₹' + maxPrice});
                        }
                    }
                } else if(filterType === 'brand'){
                    if(targetId){
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            var brands = new Set();
                            data.data.products.forEach(function(p){ if(p.brand) brands.add(p.brand); });
                            options = Array.from(brands).map(function(b){ return {value: b, label: b}; });
                        }
                    }
                } else if(filterType === 'discount'){
                    if(targetId){
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            var discountSet = new Set();
                            data.data.products.forEach(function(p){
                                if(p.price && p.final_price && parseFloat(p.price) > parseFloat(p.final_price)){
                                    discountSet.add(Math.round(((parseFloat(p.price) - parseFloat(p.final_price)) / parseFloat(p.price)) * 100));
                                }
                            });
                            options = Array.from(discountSet).sort(function(a,b){ return a - b; }).map(function(d){ return {value: d, label: d + '% & above'}; });
                        }
                    }
                } else if(filterType === 'size'){
                    if(targetId){
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            var sizeSet = new Set();
                            data.data.products.forEach(function(product){
                                if(Array.isArray(product.variants)){
                                    product.variants.forEach(function(variant){
                                        if(variant && variant.variant_type && variant.variant_type.toLowerCase() === 'size' && variant.variant_value){
                                            sizeSet.add(String(variant.variant_value).trim());
                                        }
                                    });
                                }
                            });
                            options = Array.from(sizeSet).filter(function(v){ return v; }).sort(function(a,b){ return a.localeCompare(b); }).map(function(size){ return {value: size, label: size}; });
                        }
                    }
                } else if(filterType === 'color'){
                    if(targetId){
                        var colorSet = new Set();
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            data.data.products.forEach(function(product){
                                if(Array.isArray(product.variants)){
                                    product.variants.forEach(function(variant){
                                        if(variant && variant.variant_type && variant.variant_type.toLowerCase() === 'color' && variant.variant_value){
                                            colorSet.add(String(variant.variant_value).trim());
                                        }
                                    });
                                }
                                if(product.color) colorSet.add(product.color);
                            });
                        }
                        options = Array.from(colorSet).filter(function(v){ return v; }).sort().map(function(color){ return {value: color, label: color}; });
                    }
                    if(options.length === 0){
                        options = ['Red','Blue','Green','Black','White','Pink','Yellow','Purple'].map(function(c){ return {value: c, label: c}; });
                    }
                } else if(filterType === 'fabric'){
                    if(targetId){
                        var fabricSet = new Set();
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            data.data.products.forEach(function(product){
                                if(product.fabric) fabricSet.add(product.fabric);
                            });
                        }
                        options = Array.from(fabricSet).filter(function(v){ return v; }).sort().map(function(fabric){ return {value: fabric, label: fabric}; });
                    }
                    if(options.length === 0){
                        options = ['Cotton','Polyester','Linen','Denim','Silk','Wool','Nylon'].map(function(f){ return {value: f, label: f}; });
                    }
                } else if(filterType === 'occasion'){
                    if(targetId){
                        var occasionSet = new Set();
                        var res = await fetch(API_BASE_URL + '/categories/' + targetId + '/products');
                        var data = await res.json();
                        if(data.success && data.data.products){
                            data.data.products.forEach(function(product){
                                if(product.occasion) occasionSet.add(product.occasion);
                            });
                        }
                        options = Array.from(occasionSet).filter(function(v){ return v; }).sort().map(function(occasion){ return {value: occasion, label: occasion}; });
                    }
                    if(options.length === 0){
                        options = ['Casual','Formal','Party','Wedding','Sports','Travel'].map(function(o){ return {value: o, label: o}; });
                    }
                } else if(filterType === 'rating'){
                    options = ['4★','3★','2★','1★'].map(function(r){ return {value: r, label: r + ' & above'}; });
                }
                if(options.length > 0){
                    container.innerHTML = options.map(function(opt){
                        return '<label class="filter-checkbox"><input type="checkbox" class="filter-' + filterType + '" value="' + opt.value + '"> ' + opt.label + '</label>';
                    }).join('');
                } else {
                    container.innerHTML = '<div style="padding:20px;color:#999;">No options available</div>';
                }
            }

            fetchData();

            setInterval(function(){
                try{
                    var cart = JSON.parse(localStorage.getItem('cart')) || [];
                    var totalItems = cart.length;
                    var badge = document.getElementById('cart-count-badge');
                    if(badge && badge.textContent != totalItems){
                        badge.textContent = totalItems;
                        badge.style.display = totalItems > 0 ? 'flex' : 'none';
                    }
                } catch(e){}
            }, 2000);

        })();
    </script>

    <script>
        setInterval(function(){
            try{
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                var totalItems = cart.length;
                var badge = document.getElementById('cart-count-badge');
                if(badge && badge.textContent != totalItems){
                    badge.textContent = totalItems;
                    badge.style.display = totalItems > 0 ? 'flex' : 'none';
                }
                var mobileBadge = document.querySelector('.cart-count-badge');
                if(mobileBadge && mobileBadge.textContent != totalItems){
                    mobileBadge.textContent = totalItems;
                    mobileBadge.style.display = totalItems > 0 ? 'flex' : 'none';
                }
            } catch(e){}
        }, 2000);
    </script>

    @include('mobile.auth.auth')
    @include('components.footer')

</body>
</html>