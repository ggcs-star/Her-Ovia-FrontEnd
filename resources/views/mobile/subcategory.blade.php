<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Products | MAHERA JEWEL</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/mjlogo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/categories/category-styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            padding: 16px;
        }
        .product-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid #f0f0f0;
        }
        .product-image {
            width: 100%;
            aspect-ratio: 1/1;
            background: #f8f8f8;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .product-info {
            padding: 12px;
            border-top: 1px solid #f0f0f0;
        }
        .product-name {
            font-size: 14px;
            font-weight: 500;
            color: #000;
        }
        .product-price {
            font-size: 16px;
            font-weight: 700;
            color: #000;
            margin-top: 4px;
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
    </style>
</head>
<body data-page="subcategory" data-subcategory-id="{{ request()->route('id') }}">
<header class="site-header" id="site-header"></header>
<main class="page-content">
    <div class="subcategory-container">
        <div class="subcategory-header">
            <div class="back-button" onclick="window.location.href='/categories'">←</div>
            <h1 id="category-title">Loading...</h1>
        </div>
        <div class="products-grid" id="products-grid">
            <div class="loading">Loading products...</div>
        </div>
    </div>
</main>
<footer class="site-footer" id="site-footer"></footer>
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subcategoryId = document.body.dataset.subcategoryId;
    
    fetch(`${API_BASE_URL}/categories/${subcategoryId}/products`)
        .then(r => r.json())
        .then(data => {
            const grid = document.getElementById('products-grid');
            if (data.success && data.data.products) {
                grid.innerHTML = data.data.products.map(p => `
                    <div class="product-card" onclick="window.location.href='/product/${p.slug}'">
                        <div class="product-image">
                            <img src="${p.image_url}" alt="${p.name}">
                        </div>
                        <div class="product-info">
                            <div class="product-name">${p.name}</div>
                            <div class="product-price">₹${p.final_price || p.price}</div>
                        </div>
                    </div>
                `).join('');
            }
        });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subcategoryId = document.body.dataset.subcategoryId;
    
    renderBottomNav();
    
     fetch(`${API_BASE_URL}/categories/${subcategoryId}/products`)
        .then(r => r.json())
        .then(data => {
            const grid = document.getElementById('products-grid');
            if (data.success && data.data.products) {
                document.getElementById('category-title').textContent = data.data.category?.name || 'Products';
                grid.innerHTML = data.data.products.map(p => `
                    <div class="product-card" onclick="window.location.href='/product/${p.slug}'">
                        <div class="product-image">
                            <img src="${p.image_url}" alt="${p.name}">
                        </div>
                        <div class="product-info">
                            <div class="product-name">${p.name}</div>
                            <div class="product-price">₹${p.final_price || p.price}</div>
                        </div>
                    </div>
                `).join('');
            }
        });
});

function renderBottomNav() {
    const nav = document.getElementById('mobile-bottom-nav');
    if (!nav) return;
    
    const currentPath = window.location.pathname;
    
    nav.innerHTML = `
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
        <a href="/categories" class="nav-item-figma">
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
    `;
}
</script>
@include('mobile.auth.auth')

@include('components.footer')
</body>
</html>