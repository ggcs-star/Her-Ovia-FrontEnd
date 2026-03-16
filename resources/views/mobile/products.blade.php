<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Products | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        .header-left img {
            height: 30px;
            width: auto;
            object-fit: contain;
        }

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
        .sub-item.active .sub-img { border-color: #ff3f6c; }
        .sub-name {
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }
        .sub-item.active .sub-name { color: #ff3f6c; }

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
            background: #ff4d6d;
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
        .wishlist.active { color: #ff3f6c; }
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
            color: #ff3f6c;
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
        .nav-item.active { color: #ff3f6c; }
        .nav-icon { font-size: 20px; }

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
            accent-color: #ff3f6c;
        }
        .sort-popup-footer {
            padding: 16px 20px;
            border-top: 1px solid #f0f0f0;
        }
        .sort-apply-btn {
            width: 100%;
            padding: 14px;
            background: #ff3f6c;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        /* Filter Popup Styles */
/* Filter Popup Styles */
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

/* Left Column - Filter Titles */
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
    color: #ff3f6c;
    font-size: 18px;
}

/* Right Column - Filter Options */
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
    color: #ff3f6c;
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
    accent-color: #ff3f6c;
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
    background: #ff3f6c;
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
        .filter-checkbox {
            display: block;
            padding: 8px 0;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
        .filter-checkbox input {
            margin-right: 10px;
            accent-color: #ff3f6c;
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
    color: #ff3f6c;
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
    stroke: #ff3f6c;
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
    stroke: #ff3f6c;
}
</style>
</head>
<body data-page="products" data-subcategory-id="{{ request()->query('subcategory') }}" data-category-id="{{ request()->query('category') }}">

<div class="header">
    <div class="header-left">
        <span class="back-btn" onclick="window.history.back()">←</span>
        <img src="{{ asset('images/logo.jpg') }}" alt="RAPID RETAIL" style="height: 32px; width: auto;">
        <h1>Products</h1>
    </div>
    <div class="header-right">
        <span onclick="window.location.href='/search'">🔍</span>
        <button class="header-icon-btn" onclick="window.location.href='/wishlist'" style="background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
    </svg>
</button>
        <!-- <span onclick="window.location.href='/cart'">🛒</span> -->
    </div>
</div>

<div class="sub-strip" id="subStrip"></div>

<div class="products" id="productsGrid"></div>

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
    <a href="/profile" class="nav-item-figma">
        <div class="nav-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <span>Profile</span>
    </a>
    <a href="/cart" class="nav-item-figma">
        <div class="nav-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                <circle cx="20" cy="21" r="1.5" fill="currentColor"/>
            </svg>
        </div>
        <span>Cart</span>
    </a>
</div>

<!-- Sort Popup -->
<div class="sort-popup-overlay" id="sortPopupOverlay" onclick="hideSortPopup()">
    <div class="sort-popup-content" onclick="event.stopPropagation()">
        <div class="sort-popup-header">
            <h3>Sort By</h3>
            <span class="sort-popup-close" onclick="hideSortPopup()">×</span>
        </div>
        <div class="sort-popup-body">
            <label class="sort-option"><input type="radio" name="sort" value="popularity"> Popularity</label>
            <label class="sort-option"><input type="radio" name="sort" value="newest"> Newest</label>
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

<!-- Filter Popup -->
<div class="filter-popup-overlay" id="filterPopupOverlay" onclick="hideFilterPopup()">
    <div class="filter-popup-content" onclick="event.stopPropagation()">
        <div class="filter-popup-header">
            <h3>Filters</h3>
            <span class="filter-popup-close" onclick="hideFilterPopup()">×</span>
        </div>
        <div class="filter-popup-body">
            <!-- Left Column - Filter Titles -->
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
            
            <!-- Right Column - Filter Options (Initially Hidden) -->
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
            const res = await fetch('https://retailadmin.ggconsultancy.services/api/categories');
            const data = await res.json();
            
            if (data.success) {
                let mainCat;
                if (catId) {
                    mainCat = data.data.find(c => c.id == catId);
                } else {
                    mainCat = data.data.find(c => c.children?.some(child => child.id == subId));
                }
                
                if (mainCat) {
                    allSubs = mainCat.children || [];
                    renderSubs();
                    if (currentSub) fetchProducts(currentSub);
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

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
            const res = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${subId}/products`);
            const data = await res.json();
            
            if (data.success && data.data.products) {
                currentProducts = data.data.products;
                originalProducts = [...data.data.products];
                renderProducts(currentProducts);
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

        const fallback = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=200&auto=format&fit=crop';

        grid.innerHTML = products.map(p => {
            const price = parseFloat(p.final_price || p.price || 0);
            const mrp = parseFloat(p.price || 0);
            const discount = mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0;
            const rating = 4.3;
            const full = Math.floor(rating);
            const half = (rating % 1) >= 0.3;
            let stars = '';
            for (let i = 0; i < full; i++) stars += '★';
            if (half) stars += '½';
            for (let i = stars.length; i < 5; i++) stars += '☆';
            
            const inWish = wishlist.some(item => item.id == p.id);
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

    window.toggleWish = function(btn, product) {
        event.stopPropagation();
        const exists = wishlist.some(item => item.id == product.id);
        if (exists) {
            wishlist = wishlist.filter(item => item.id != product.id);
            btn.innerHTML = '♡';
            btn.classList.remove('active');
        } else {
            wishlist.push(product);
            btn.innerHTML = '❤️';
            btn.classList.add('active');
        }
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
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
        if (!selected) { alert('Please select a sort option'); return; }
        
        const sortBy = selected.value;
        let sorted = [...currentProducts];
        
        switch(sortBy) {
            case 'price-low':
                sorted.sort((a, b) => (a.final_price || a.price || 0) - (b.final_price || b.price || 0));
                break;
            case 'price-high':
                sorted.sort((a, b) => (b.final_price || b.price || 0) - (a.final_price || a.price || 0));
                break;
            case 'newest':
                sorted.sort((a, b) => (b.id || 0) - (a.id || 0));
                break;
            default:
                break;
        }
        
        renderProducts(sorted);
        hideSortPopup();
    };

    // Show filter popup
    window.showFilterPopup = function() {
        document.getElementById('filterPopupOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
        hideFilterOptions();
    };

    // Hide filter popup
    window.hideFilterPopup = function() {
        document.getElementById('filterPopupOverlay').classList.remove('active');
        document.body.style.overflow = '';
    };

    // Show filter options for selected category
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

    // Hide filter options
    window.hideFilterOptions = function() {
        const titlesColumn = document.querySelector('.filter-titles-column');
        const optionsColumn = document.getElementById('filterOptionsColumn');
        
        titlesColumn.classList.remove('half-width');
        optionsColumn.style.display = 'none';
    };

    // Load filter options dynamically
    async function loadFilterOptions(filterType, container) {
        let options = [];
        
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category');
        const subcategoryId = urlParams.get('subcategory');
        
        switch(filterType) {
            case 'category':
                try {
                    const res = await fetch('https://retailadmin.ggconsultancy.services/api/categories');
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
                options = [
                    { value: '0-500', label: 'Below ₹500' },
                    { value: '500-1000', label: '₹500 - ₹1000' },
                    { value: '1000-2000', label: '₹1000 - ₹2000' },
                    { value: '2000-3000', label: '₹2000 - ₹3000' },
                    { value: '3000-5000', label: '₹3000 - ₹5000' },
                    { value: '5000-999999', label: 'Above ₹5000' }
                ];
                break;
                
            case 'brand':
                try {
                    const targetId = subcategoryId || categoryId;
                    if (targetId) {
                        const res = await fetch(`https://retailadmin.ggconsultancy.services/api/categories/${targetId}/products`);
                        const data = await res.json();
                        
                        if (data.success && data.data.products) {
                            const brands = new Set();
                            data.data.products.forEach(p => {
                                if (p.brand) brands.add(p.brand);
                            });
                            options = Array.from(brands).map(b => ({ value: b, label: b }));
                        }
                    }
                } catch (error) {
                    console.error('Error loading brands:', error);
                }
                break;
                
            case 'discount':
                options = ['10%', '20%', '30%', '40%', '50%', '60%', '70%'].map(d => ({ 
                    value: d, 
                    label: `${d} & above` 
                }));
                break;
                
            case 'size':
                options = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'].map(s => ({ value: s, label: s }));
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

    // Apply filters - FINAL VERSION
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
        
        console.log('Selected filters:', selected);
        
        // Handle category filter first
        if (selected.category.length > 0) {
            const firstCategory = selected.category[0];
            if (firstCategory) {
                window.changeSubcategory(firstCategory);
                setTimeout(() => {
                    applyOtherFilters(selected);
                }, 500);
            }
        } else {
            applyOtherFilters(selected);
        }
        
        hideFilterPopup();
    };

    function applyOtherFilters(selected) {
        let filtered = [...currentProducts];
        let filterApplied = false;
        
        // Price filter
        if (selected.price.length > 0) {
            filterApplied = true;
            filtered = filtered.filter(p => {
                const price = parseFloat(p.final_price || p.price || 0);
                return selected.price.some(range => {
                    const [min, max] = range.split('-').map(Number);
                    return price >= min && price <= max;
                });
            });
        }
        
        // Brand filter
        if (selected.brand.length > 0) {
            filterApplied = true;
            filtered = filtered.filter(p => selected.brand.includes(p.brand));
        }
        
        // Discount filter
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

    // Reset filters
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

    // Attach to filter button
    document.querySelector('.action-btn:last-child').onclick = showFilterPopup;
    
    fetchData();
})();
</script>
</body>
</html>