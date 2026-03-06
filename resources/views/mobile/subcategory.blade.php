<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Products | RAPID RETAIL</title>
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
document.addEventListener('DOMContentLoaded', function() {
    const subcategoryId = document.body.dataset.subcategoryId;
    
    fetch(`https://retailadmin.ggconsultancy.services/api/categories/${subcategoryId}/products`)
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
</body>
</html>