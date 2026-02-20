<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">    <title>Product Details | RAPID RETAILS</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Additional fixes for product detail page */
        .product-detail-page .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: calc(100vh - 400px);
        }
        
        .product-detail-page .loading {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #666;
        }
        
        .product-detail-page .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-left: 10px;
            border: 2px solid #ff3f6c;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .product-detail-page .product-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        .product-detail-page .gallery-section {
            display: flex;
            gap: 15px;
        }
        
        .product-detail-page .thumbnail-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 80px;
        }
        
        .product-detail-page .thumbnail-item {
            width: 80px;
            height: 100px;
            border: 2px solid transparent;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .product-detail-page .thumbnail-item.active {
            border-color: #ff3f6c;
        }
        
        .product-detail-page .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-detail-page .main-image-container {
            flex: 1;
            background: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
            height: 500px;
            position: relative;
        }
        
        .product-detail-page .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-detail-page .image-counter {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        
        .product-detail-page .product-info {
            padding: 20px 0;
        }
        
        .product-detail-page .brand {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #282c3f;
        }
        
        .product-detail-page .title {
            font-size: 18px;
            color: #535766;
            margin-bottom: 15px;
        }
        
        .product-detail-page .price-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .product-detail-page .current-price {
            font-size: 28px;
            font-weight: 800;
            color: #282c3f;
        }
        
        .product-detail-page .original-price {
            font-size: 18px;
            color: #878b94;
            text-decoration: line-through;
        }
        
        .product-detail-page .discount {
            color: #ff3f6c;
            font-weight: 600;
        }
        
        .product-detail-page .stock-info {
            color: #03a685;
            font-size: 14px;
            margin: 10px 0;
        }
        
        .product-detail-page .add-to-cart {
            width: 100%;
            padding: 16px;
            background: #ff3f6c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .product-detail-page .add-to-cart:hover {
            background: #e6395e;
        }
        
        .product-detail-page .add-to-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .product-detail-page .variants-section {
            margin: 20px 0;
        }
        
        .product-detail-page .variant-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .product-detail-page .size-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .product-detail-page .size-btn {
            min-width: 50px;
            height: 50px;
            border: 1px solid #d4d5d9;
            background: white;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .product-detail-page .size-btn:hover {
            border-color: #ff3f6c;
        }
        
        .product-detail-page .size-btn.active {
            background: #ff3f6c;
            color: white;
            border-color: #ff3f6c;
        }
        
        .product-detail-page .size-btn.disabled {
            background: #f5f5f5;
            color: #ccc;
            cursor: not-allowed;
            border-color: #ddd;
        }
        
        .product-detail-page .error-container {
            text-align: center;
            padding: 60px 20px;
        }
        
        .product-detail-page .error-container h2 {
            margin-bottom: 20px;
            color: #ff3f6c;
        }
        
        .product-detail-page .btn-home {
            display: inline-block;
            padding: 12px 30px;
            background: #ff3f6c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        /* ===== NEW ADD TO BAG CONFIRMATION STYLES ===== */
        .add-confirmation {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confirmation-content {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .check-icon {
            font-size: 24px;
        }

        .confirmation-text strong {
            font-size: 16px;
            color: #03a685;
            display: block;
            margin-bottom: 4px;
        }

        .confirmation-text p {
            font-size: 14px;
            color: #282c3f;
            font-weight: 500;
        }

        .confirmation-actions {
            display: flex;
            gap: 10px;
        }

        .view-bag-btn {
            flex: 1;
            background: #ff3f6c;
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s;
        }

        .view-bag-btn:hover {
            background: #e6395e;
        }

        .continue-btn {
            flex: 1;
            background: #f5f5f5;
            color: #282c3f;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            padding: 12px;
            transition: background 0.3s;
        }

        .continue-btn:hover {
            background: #e5e5e5;
        }

        .close-confirmation {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
        }

        .close-confirmation:hover {
            color: #ff3f6c;
        }

        .cart-wrap {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff3f6c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
            transition: transform 0.3s;
        }

        .cart-wrap.bounce .cart-badge {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }
        
        @media (max-width: 768px) {
            .product-detail-page .product-wrapper {
                grid-template-columns: 1fr;
            }
            
            .product-detail-page .gallery-section {
                flex-direction: column-reverse;
            }
            
            .product-detail-page .thumbnail-list {
                flex-direction: row;
                width: 100%;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .product-detail-page .thumbnail-item {
                flex-shrink: 0;
            }
            
            .product-detail-page .main-image-container {
                height: 400px;
            }
            
            .product-detail-page .container {
                padding: 10px;
            }
            
            .confirmation-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body class="product-detail-page" data-page="product-detail" data-slug="{{ request()->route('slug') }}">

<!-- Common Header (same as your all-products page) -->
<header class="site-header" id="site-header"></header>

<!-- Main Content -->
<main class="page-content">
    <div class="container">
        <div id="product-container">
            <div class="loading">Loading product details...</div>
        </div>
    </div>
</main>

<!-- Common Footer (same as your all-products page) -->
<footer class="site-footer" id="site-footer"></footer>

<!-- Mobile Bottom Navigation (same as your all-products page) -->
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

<!-- Main Script (your existing script.js which has all the common functionality) -->
<script src="{{ asset('mobile/script.js') }}"></script>

<!-- Product Detail Specific Script -->
<script>
    // ===== CART FUNCTIONS =====
    let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    
    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = cartItems.length;
        }
    }
    
    function showConfirmation(productName) {
        const existingConfirmation = document.querySelector('.add-confirmation');
        if (existingConfirmation) {
            existingConfirmation.remove();
        }
        
        const confirmationHTML = `
            <div class="add-confirmation">
                <div class="confirmation-content">
                    <span class="check-icon">✅</span>
                    <div class="confirmation-text">
                        <strong>Added to bag!</strong>
                        <p>${productName}</p>
                    </div>
                </div>
                <div class="confirmation-actions">
                    <a href="/cart" class="view-bag-btn">VIEW BAG (${cartItems.length + 1})</a>
                    <button class="continue-btn" onclick="this.closest('.add-confirmation').remove()">CONTINUE SHOPPING</button>
                </div>
                <button class="close-confirmation" onclick="this.closest('.add-confirmation').remove()">×</button>
            </div>
        `;
        
        const productInfo = document.querySelector('.product-info');
        if (productInfo) {
            productInfo.insertAdjacentHTML('afterbegin', confirmationHTML);
        }
        
        setTimeout(() => {
            const conf = document.querySelector('.add-confirmation');
            if (conf) conf.remove();
        }, 5000);
    }
    
    function addToBag(product) {
        cartItems.push({
            id: product.id,
            name: product.name,
            price: product.price,
            size: product.selectedSize || 'S',
            image: product.image,
            quantity: 1
        });
        
        localStorage.setItem('cart', JSON.stringify(cartItems));
        updateCartBadge();
        showConfirmation(product.name);
        
        const bagIcon = document.querySelector('.cart-wrap');
        if (bagIcon) {
            bagIcon.classList.add('bounce');
            setTimeout(() => bagIcon.classList.remove('bounce'), 500);
        }
    }
    
    function addToCartFromProduct() {
        const product = {
            id: document.querySelector('[data-product-id]')?.dataset.productId || Date.now().toString(),
            name: document.querySelector('.title')?.textContent || 'Product',
            price: document.getElementById('currentPrice')?.textContent?.replace('₹', '').replace(',', '') || '0',
            image: document.getElementById('mainImage')?.src || '',
            selectedSize: document.querySelector('.size-btn.active')?.textContent || 'S'
        };
        
        addToBag(product);
    }
    
    // Update badge on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
    });

    // Ensure DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get slug from URL
        const pathParts = window.location.pathname.split('/');
        const slug = pathParts[pathParts.length - 1];
        
        // API URL
        const API_URL = `https://retailadmin.ggconsultancy.services/api/products/${slug}`;
        
        // Fallback images
        const FALLBACK_IMAGES = [
            'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=300&h=400&fit=crop',
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=300&h=400&fit=crop',
            'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=300&h=400&fit=crop'
        ];
        
        // Fetch product data
        fetchProduct();
        
        async function fetchProduct() {
            try {
                const response = await fetch(API_URL, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                console.log('API Response:', data);
                
                if (data.success && data.data) {
                    renderProduct(data.data);
                } else {
                    showError('Product not found');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Failed to load product');
            }
        }
        
        function renderProduct(product) {
            const container = document.getElementById('product-container');
            
            // Get gallery images
            const galleryImages = product.gallery_images || [];
            
            // Get variants and prices
            const variants = product.variants || [];
            let minPrice = 0, maxPrice = 0;
            
            if (variants.length > 0) {
                const prices = variants.map(v => parseFloat(v.final_price || 0));
                minPrice = Math.min(...prices);
                maxPrice = Math.max(...prices);
            }
            
            const brand = product.brand || 'RAPID RETAIL';
            const name = product.name || 'Product Name';
            const category = product.category?.name || '';
            const stock = product.stock || 0;
            
            // Build HTML
            let html = '<div class="product-wrapper">';
            
            // LEFT: Gallery
            html += '<div class="gallery-section">';
            
            // Thumbnails
            if (galleryImages.length > 0) {
                html += '<div class="thumbnail-list">';
                galleryImages.forEach((img, index) => {
                    html += `<div class="thumbnail-item ${index === 0 ? 'active' : ''}" onclick="changeImage(${index})">`;
                    html += `<img src="${img}" alt="Thumbnail ${index + 1}" onerror="this.src='${FALLBACK_IMAGES[0]}'">`;
                    html += '</div>';
                });
                html += '</div>';
                
                // Main image
                html += '<div class="main-image-container">';
                html += `<img id="mainImage" src="${galleryImages[0]}" alt="${name}" class="main-image" onerror="this.src='${FALLBACK_IMAGES[0]}'">`;
                if (galleryImages.length > 1) {
                    html += `<div class="image-counter"><span id="currentImage">1</span>/${galleryImages.length}</div>`;
                }
                html += '</div>';
            } else {
                // Fallback image
                html += '<div class="main-image-container">';
                html += `<img id="mainImage" src="${FALLBACK_IMAGES[0]}" alt="${name}" class="main-image">`;
                html += '</div>';
            }
            
            html += '</div>'; // Close gallery
            
            // RIGHT: Product Info
            html += '<div class="product-info">';
            // Add hidden product ID for cart functionality
            html += `<div data-product-id="${product.id}" style="display:none;"></div>`;
            html += `<div class="brand">${brand.toUpperCase()}</div>`;
            html += `<h1 class="title">${name}</h1>`;
            
            if (category) {
                html += `<div style="color: #878b94; margin-bottom: 10px;">Category: ${category}</div>`;
            }
            
            html += '<div class="price-row">';
            if (minPrice > 0) {
                html += `<span class="current-price" id="currentPrice">₹${minPrice.toLocaleString()}</span>`;
                if (maxPrice > minPrice) {
                    html += `<span class="original-price">₹${maxPrice.toLocaleString()}</span>`;
                }
            } else {
                html += '<span class="current-price">Price Coming Soon</span>';
            }
            html += '</div>';
            
            if (stock > 0) {
                html += `<div class="stock-info">✓ In Stock (${stock} units)</div>`;
            }
            
            // Variants
            if (variants.length > 0) {
                html += '<div class="variants-section">';
                html += '<div class="variant-title">Select Size</div>';
                html += '<div class="size-options">';
                
                variants.forEach(variant => {
                    const isInStock = variant.quantity > 0;
                    html += `<button class="size-btn ${isInStock ? '' : 'disabled'}" 
                                    onclick="selectSize(this, '${variant.final_price}')"
                                    ${isInStock ? '' : 'disabled'}>`;
                    html += variant.variant_value;
                    html += '</button>';
                });
                
                html += '</div>';
                html += '</div>';
            }
            
            // Add to cart button with onclick
            html += `<button class="add-to-cart" onclick="addToCartFromProduct()" ${stock === 0 ? 'disabled' : ''}>`;
            html += stock > 0 ? 'ADD TO BAG' : 'OUT OF STOCK';
            html += '</button>';
            
            html += '</div>'; // Close product-info
            html += '</div>'; // Close product-wrapper
            
            container.innerHTML = html;
            
            // Store images for gallery navigation
            window.productImages = galleryImages;
            
            // Update cart badge after rendering
            updateCartBadge();
        }
        
        function showError(message) {
            const container = document.getElementById('product-container');
            container.innerHTML = `
                <div class="error-container">
                    <h2>${message}</h2>
                    <p>Please try again or browse other products.</p>
                    <a href="/landing" class="btn-home">Go to Homepage</a>
                </div>
            `;
        }
        
        // Make functions global
        window.changeImage = function(index) {
            const mainImage = document.getElementById('mainImage');
            const counter = document.getElementById('currentImage');
            const images = window.productImages || [];
            
            if (mainImage && images[index]) {
                mainImage.src = images[index];
                
                // Update active thumbnail
                document.querySelectorAll('.thumbnail-item').forEach((item, i) => {
                    if (i === index) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
                
                // Update counter
                if (counter) {
                    counter.textContent = index + 1;
                }
            }
        };
        
        window.selectSize = function(btn, price) {
            document.querySelectorAll('.size-btn:not(.disabled)').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const priceElement = document.getElementById('currentPrice');
            if (priceElement && price) {
                priceElement.textContent = '₹' + Number(price).toLocaleString();
            }
        };
    });
</script>

</body>
</html>