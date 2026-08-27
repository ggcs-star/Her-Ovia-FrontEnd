<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StockFlow • Pure API E‑Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/mjlogo.jpeg') }}">
    <!-- Fonts & Icons -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            line-height: 1.5;
        }

        /* ===== TOP BAR ===== */
        .top-bar {
            background: #0f172a;
            color: #f1f5f9;
            font-size: 0.8rem;
            padding: 0.5rem 5%;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .top-bar a {
            color: #f1f5f9;
            text-decoration: none;
            margin-left: 1.5rem;
        }
        .top-bar i {
            margin-right: 0.4rem;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .search-bar {
            flex: 1;
            max-width: 500px;
            display: flex;
            background: #f1f5f9;
            border-radius: 40px;
            align-items: center;
            padding: 0.2rem 0.2rem 0.2rem 1.2rem;
            border: 1px solid #e2e8f0;
        }
        .search-bar input {
            border: none;
            background: transparent;
            padding: 0.7rem 0;
            width: 100%;
            outline: none;
        }
        .search-bar button {
            background: #0f172a;
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
        }

        .nav-icons {
            display: flex;
            gap: 1.5rem;
            font-size: 1.3rem;
        }
        .icon-wrap {
            position: relative;
            cursor: pointer;
        }
        .cart-count {
            position: absolute;
            top: -10px;
            right: -12px;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.5rem;
            border-radius: 30px;
            min-width: 20px;
            text-align: center;
        }

        /* ===== CATEGORY PILLS (API BASED) ===== */
        .category-wrap {
            padding: 0.8rem 5%;
            background: white;
            border-bottom: 1px solid #e9eef2;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            min-height: 60px;
            align-items: center;
        }
        .category-pill {
            background: #f1f5f9;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #0f172a;
            text-decoration: none;
            transition: 0.15s;
            white-space: nowrap;
        }
        .category-pill:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }
        .category-loading {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* ===== HERO (dynamic from API) ===== */
        .hero {
            margin: 1.5rem 5%;
            background: linear-gradient(105deg, #0f172a, #1e293b);
            border-radius: 28px;
            padding: 2.5rem 3rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
            min-height: 250px;
        }
        .hero-content {
            flex: 1;
        }
        .hero-content h1 {
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .hero-content p {
            opacity: 0.9;
            margin-bottom: 1.5rem;
            max-width: 500px;
        }
        .hero-btn {
            background: white;
            color: #0f172a;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }
        .hero-image {
            font-size: 4rem;
            opacity: 0.8;
        }

        /* ===== PRODUCT SECTION ===== */
        .section {
            padding: 2rem 5% 4rem;
            max-width: 1600px;
            margin: 0 auto;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .section-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .product-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            transition: 0.2s;
            border: 1px solid #ecf1f6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.15);
        }
        .product-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            background: #f1f5f9;
        }
        .product-info {
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .product-category {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        .product-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
            color: #0f172a;
        }
        .product-price {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0.5rem 0 1rem;
        }
        .product-price::before {
            content: '₹';
            font-size: 0.9rem;
            margin-right: 2px;
        }
        .btn-add {
            background: #0f172a;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: auto;
            transition: 0.15s;
        }
        .btn-add:hover {
            background: #1e293b;
        }

        /* Loading / Error States */
        .loading-state, .error-state, .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem;
            background: #f1f5f9;
            border-radius: 30px;
            color: #475569;
        }
        .error-state i, .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* ===== CART SIDEBAR ===== */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100vh;
            background: white;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            z-index: 200;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
        }
        .cart-sidebar.open {
            right: 0;
        }
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 1.4rem;
            font-weight: 700;
        }
        .cart-header i {
            cursor: pointer;
            font-size: 1.5rem;
        }
        .cart-items {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .cart-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
        }
        .cart-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .checkout-btn {
            background: #0f172a;
            color: white;
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 40px;
            font-weight: 700;
            cursor: pointer;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            opacity: 0;
            visibility: hidden;
            transition: 0.2s;
            z-index: 150;
        }
        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 2rem 5%;
            text-align: center;
            margin-top: 2rem;
        }

        @media (max-width: 700px) {
            .cart-sidebar {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- Top Bar (static UI only) -->
<div class="top-bar">
    <div><i class="fas fa-truck"></i> FREE SHIPPING on orders ₹999+</div>
    <div>
        <a href="#"><i class="far fa-user"></i> Account</a>
    </div>
</div>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">StockFlow</div>
    <div class="search-bar">
        <input type="text" placeholder="Search products..." id="searchInput">
        <button id="searchBtn"><i class="fas fa-search"></i></button>
    </div>
    <div class="nav-icons">
        <div class="icon-wrap" id="cartIcon">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCount">0</span>
        </div>
    </div>
</div>

<!-- Categories Container - PURE API -->
<div id="categoryContainer" class="category-wrap">
    <span class="category-loading"><i class="fas fa-spinner fa-pulse"></i> Loading categories...</span>
</div>

<!-- Hero Banner - PURE API -->
<div id="heroContainer" class="hero">
    <div class="hero-content">
        <h1 id="heroTitle">Loading...</h1>
        <p id="heroSubtitle"></p>
        <button class="hero-btn" id="heroBtn">Shop Now <i class="fas fa-arrow-right"></i></button>
    </div>
    <div class="hero-image" id="heroIcon">
        <i class="fas fa-tag"></i>
    </div>
</div>

<!-- Products Section - PURE API -->
<div class="section">
    <div class="section-header">
        <h2><i class="fas fa-bolt"></i> <span id="sectionTitle">Trending Products</span></h2>
    </div>
    <div id="productsGrid" class="products-grid">
        <div class="loading-state">
            <i class="fas fa-spinner fa-pulse"></i>
            <p>Loading products from API...</p>
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div class="overlay" id="overlay"></div>
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <span>Shopping Cart</span>
        <i class="fas fa-times" id="closeCart"></i>
    </div>
    <div class="cart-items" id="cartItems"></div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total</span>
            <span id="cartTotal">₹0</span>
        </div>
        <button class="checkout-btn" onclick="handleCheckout()">Checkout</button>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2026 StockFlow · Pure API E-Commerce</p>
</footer>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script>
    // ==================== API CONFIGURATION ====================
const BASE_URL = window.API_BASE_URL;
const token = localStorage.getItem("token");

    // ==================== STATE MANAGEMENT ====================
    let cart = [];
    let categories = [];
    let products = [];

    // DOM Elements
    const categoryContainer = document.getElementById('categoryContainer');
    const productsGrid = document.getElementById('productsGrid');
    const heroTitle = document.getElementById('heroTitle');
    const heroSubtitle = document.getElementById('heroSubtitle');
    const cartIcon = document.getElementById('cartIcon');
    const cartSidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('overlay');
    const closeCart = document.getElementById('closeCart');
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');

    // ==================== API CALLS ====================
async function fetchCategories() {
    try {
        const response = await fetch(BASE_URL + '/categories', {
            headers: { 'Accept': 'application/json' }
        });

        if (!response.ok) {
            throw new Error("Categories API failed");
        }

        const result = await response.json();
        console.log("CATEGORIES:", result);

        if (result.success && Array.isArray(result.data)) {
            categories = result.data;
        } else {
            categories = [];
        }

        renderCategories();

    } catch (error) {
        console.error('Categories API error:', error);
        categoryContainer.innerHTML = `
            <span class="error-state">
                Failed to load categories
            </span>
        `;
    }
}


    // Fetch Products (Top Selling)
   async function fetchProducts() {
    try {

        console.log("Fetching products...");

        const response = await fetch(BASE_URL + '/products/top-selling', {
            headers: { 'Accept': 'application/json' }
        });

        if (!response.ok) {
            throw new Error("Products API failed");
        }

        const result = await response.json();
        console.log("PRODUCTS RESPONSE:", result);

        // 🔥 Smart structure detection
        if (result.success) {

            if (Array.isArray(result.data)) {
                products = result.data;

            } else if (Array.isArray(result.data?.products)) {
                products = result.data.products;

            } else {
                products = [];
            }

        } else {
            products = [];
        }

        renderProducts();

    } catch (error) {
        console.error('Products API error:', error);

        productsGrid.innerHTML = `
            <div class="error-state">
                <i class="fas fa-exclamation-circle"></i>
                <p>Products API Failed</p>
            </div>
        `;
    }
}

    // Fetch Hero Banner Data
    async function fetchHeroData() {
        try {
            const response = await fetch(BASE_URL + '/banner');
            const data = await response.json();
            const banner = data.data || {};
            heroTitle.textContent = banner.title || 'NEW SEASON COLLECTION';
            heroSubtitle.textContent = banner.subtitle || 'Discover the latest trends';
        } catch (error) {
            console.error('Hero API error:', error);
            heroTitle.textContent = 'NEW SEASON COLLECTION';
            heroSubtitle.textContent = 'Discover the latest trends';
        }
    }

    // Search Products
    async function searchProducts(query) {
        try {
            productsGrid.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-pulse"></i> Searching...</div>';
            const response = await fetch(BASE_URL + `/products/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            products = data.data || [];
            renderProducts();
        } catch (error) {
            console.error('Search error:', error);
        }
    }

    // Add to Cart API
    async function addToCartAPI(productId, quantity = 1) {
        if (!token) {
            alert('Please login to add items to cart');
            return false;
        }

        try {
            const response = await fetch(BASE_URL + '/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });
            const data = await response.json();
            return data.success;
        } catch (error) {
            console.error('Add to cart error:', error);
            return false;
        }
    }

    // Fetch Cart
    async function fetchCart() {
        if (!token) return;

        try {
            const response = await fetch(BASE_URL + '/cart', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const data = await response.json();
            cart = data.data?.items || [];
            renderCart();
        } catch (error) {
            console.error('Fetch cart error:', error);
        }
    }

    // ==================== RENDER FUNCTIONS ====================

    function renderCategories() {
        if (!categories.length) {
            categoryContainer.innerHTML = '<span class="empty-state">No categories found</span>';
            return;
        }

        categoryContainer.innerHTML = categories.map(cat => `
            <a href="#" class="category-pill" onclick="filterByCategory(${cat.id})">${cat.name}</a>
        `).join('');
    }

    function renderProducts() {
        if (!products.length) {
            productsGrid.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>No products found</p>
                </div>
            `;
            return;
        }

        productsGrid.innerHTML = products.map(product => `
            <div class="product-card">
                <img class="product-img" 
                     src="${product.image_url || 'https://via.placeholder.com/300x400?text=Product'}" 
                     alt="${product.name}"
                     onerror="this.src='https://via.placeholder.com/300x400?text=Image+Error'">
                <div class="product-info">
                    <div class="product-category">${product.category_name || 'General'}</div>
                    <div class="product-title">${product.name}</div>
                    <div class="product-price">${product.price}</div>
                    <button class="btn-add" onclick="handleAddToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image_url || ''}')">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>
        `).join('');
    }

    function renderCart() {
        if (!cart.length) {
            cartItems.innerHTML = '<div style="text-align: center; color: #94a3b8;">Your cart is empty</div>';
            cartTotal.textContent = '₹0';
            cartCount.textContent = '0';
            return;
        }

        let total = 0;
        let itemCount = 0;

        cartItems.innerHTML = cart.map(item => {
            total += item.price * item.quantity;
            itemCount += item.quantity;
            return `
                <div class="cart-item">
                    <img src="${item.image_url || 'https://via.placeholder.com/70'}" alt="${item.name}" style="width: 70px; height: 70px; border-radius: 12px; object-fit: cover;">
                    <div style="flex: 1;">
                        <div style="font-weight: 600;">${item.name}</div>
                        <div>₹${item.price} x ${item.quantity}</div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.3rem;">
                            <button onclick="updateCartItem(${item.id}, ${item.quantity - 1})" style="background: #f1f5f9; border: none; padding: 0.2rem 0.8rem; border-radius: 20px;">−</button>
                            <button onclick="updateCartItem(${item.id}, ${item.quantity + 1})" style="background: #f1f5f9; border: none; padding: 0.2rem 0.8rem; border-radius: 20px;">+</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        cartTotal.textContent = `₹${total}`;
        cartCount.textContent = itemCount;
    }

    // ==================== HANDLERS ====================

    window.handleAddToCart = async function(productId, name, price, image) {
        const success = await addToCartAPI(productId);
        if (success) {
            await fetchCart(); // Refresh cart from API
            alert('Added to cart!');
        } else {
            alert('Login required or error adding to cart');
        }
    };

    window.filterByCategory = async function(categoryId) {
        try {
            productsGrid.innerHTML = '<div class="loading-state"><i class="fas fa-spinner fa-pulse"></i> Loading...</div>';
            const response = await fetch(BASE_URL + `/products?category_id=${categoryId}`);
            const data = await response.json();
            products = data.data?.products || [];
            renderProducts();
        } catch (error) {
            console.error('Filter error:', error);
        }
    };

    window.updateCartItem = async function(productId, newQuantity) {
        if (newQuantity <= 0) {
            // Remove from cart
            await fetch(BASE_URL + '/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({ product_id: productId })
            });
        } else {
            // Update quantity
            await fetch(BASE_URL + '/cart/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({ 
                    product_id: productId, 
                    quantity: newQuantity 
                })
            });
        }
        await fetchCart();
    };

    window.handleCheckout = function() {
        if (!token) {
            alert('Please login to checkout');
            return;
        }
        window.location.href = '/checkout';
    };

    // Search handler
    searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query) {
            searchProducts(query);
        }
    });

    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchBtn.click();
        }
    });

    // Cart sidebar
    cartIcon.addEventListener('click', () => {
        cartSidebar.classList.add('open');
        overlay.classList.add('show');
    });

    closeCart.addEventListener('click', () => {
        cartSidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    overlay.addEventListener('click', () => {
        cartSidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // ==================== INITIALIZE ====================
    async function init() {
        await fetchHeroData();
        await fetchCategories();
        await fetchProducts();
        if (token) {
            await fetchCart();
        }
    }

    init();

    // Section title from API (optional)
    fetch(BASE_URL + '/settings/section-title')
        .then(res => res.json())
        .then(data => {
            const titleSpan = document.getElementById('sectionTitle');
            if (titleSpan && data.data) {
                titleSpan.textContent = data.data;
            }
        })
        .catch(() => {});
</script>
</body>
</html>