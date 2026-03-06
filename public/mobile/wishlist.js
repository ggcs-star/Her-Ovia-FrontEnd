
(function() {
    const wishlistActions = {
        addToWishlist(product) {
            if (!product || !product.id) {
                console.log('Invalid product');
                return false;
            }
            
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        
            const exists = wishlist.some(item => item.id == product.id);
            
            if (!exists) {
                wishlist.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    brand: product.brand,
                    slug: product.slug
                });
                
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                console.log('Added to wishlist:', product);
                
                // Update header
                updateWishlistIcon();
                
                // Show message
                showToast('❤️ Added to wishlist!');
                
                return true;
            } else {
                showToast('Already in wishlist!');
                return false;
            }
        },
        
        // Remove from wishlist
        removeFromWishlist(productId) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist = wishlist.filter(item => item.id != productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            
            console.log('Removed from wishlist:', productId);
            
            // Update header
            updateWishlistIcon();
            
            // Show message
            showToast('Removed from wishlist');
            
            // Reload if on wishlist page
            if (document.body.classList.contains('wishlist-page')) {
                loadWishlistItems();
            }
            
            return true;
        },
        
        // Check if in wishlist
        isInWishlist(productId) {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            return wishlist.some(item => item.id == productId);
        }
    };
    
    // 2. TOAST MESSAGE
    function showToast(message) {
        // Remove existing toast
        const existingToast = document.querySelector('.wishlist-toast');
        if (existingToast) existingToast.remove();
        
        // Create toast
        const toast = document.createElement('div');
        toast.className = 'wishlist-toast';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #282c3f;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            z-index: 9999;
            animation: slideUp 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        `;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Remove after 2 seconds
        setTimeout(() => {
            toast.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
    
    // 3. UPDATE HEADER ICON
    function updateWishlistIcon() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const heartIcons = document.querySelectorAll('.action-item svg[viewBox="0 0 24 24"] path');
        
        heartIcons.forEach(path => {
            if (wishlist.length > 0) {
                path.setAttribute('fill', '#ff3f6c');
                path.setAttribute('stroke', '#ff3f6c');
            } else {
                path.setAttribute('fill', 'none');
                path.setAttribute('stroke', 'currentColor');
            }
        });
    }
    
    // 4. PRODUCT PAGE SETUP
    function setupProductPage() {
        if (!document.body.classList.contains('product-detail-page')) return;
        
        // Check every second for wishlist button
        const checkInterval = setInterval(function() {
            const wishlistBtn = document.getElementById('wishlist-btn');
            const addToCartBtn = document.querySelector('.add-to-cart');
            
            if (!wishlistBtn && addToCartBtn) {
                createWishlistButton();
            } else if (wishlistBtn) {
                setupWishlistButton(wishlistBtn);
                clearInterval(checkInterval);
            }
        }, 500);
        
        // Clear after 10 seconds
        setTimeout(() => clearInterval(checkInterval), 10000);
    }
    
    // Create wishlist button
    function createWishlistButton() {
        const addToCartBtn = document.querySelector('.add-to-cart');
        if (!addToCartBtn) return;
        
        // Check if already exists
        if (document.getElementById('wishlist-btn')) return;
        
        // Get product container
        const productInfo = document.querySelector('.product-info');
        if (!productInfo) return;
        
        // Create buttons container
        const buttonsContainer = document.createElement('div');
        buttonsContainer.style.cssText = `
            display: flex;
            gap: 10px;
            margin-top: 20px;
        `;
        
        // Move add to cart button
        addToCartBtn.parentNode.insertBefore(buttonsContainer, addToCartBtn);
        buttonsContainer.appendChild(addToCartBtn);
        
        // Style add to cart
        addToCartBtn.style.cssText = `
            flex: 1;
            padding: 16px;
            background: #ff3f6c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0;
        `;
        
        // Create wishlist button
        const wishlistBtn = document.createElement('button');
        wishlistBtn.id = 'wishlist-btn';
        wishlistBtn.innerHTML = '♡ SAVE TO WISHLIST';
        wishlistBtn.style.cssText = `
            flex: 1;
            padding: 16px;
            background: white;
            color: #ff3f6c;
            border: 2px solid #ff3f6c;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        `;
        
        buttonsContainer.appendChild(wishlistBtn);
        
        // Setup button
        setupWishlistButton(wishlistBtn);
    }
    
    // Setup wishlist button
    function setupWishlistButton(btn) {
        // Get current product
        const product = getCurrentProduct();
        if (!product || !product.id) return;
        
        // Check if in wishlist
        if (wishlistActions.isInWishlist(product.id)) {
            btn.innerHTML = '❤️ SAVED TO WISHLIST';
            btn.style.background = '#ff3f6c';
            btn.style.color = 'white';
            btn.style.border = 'none';
        }
        
        // Add click handler
        btn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const product = getCurrentProduct();
            if (!product || !product.id) {
                console.log('Product not found');
                return;
            }
            
            if (wishlistActions.isInWishlist(product.id)) {
                // Remove from wishlist
                wishlistActions.removeFromWishlist(product.id);
                this.innerHTML = '♡ SAVE TO WISHLIST';
                this.style.background = 'white';
                this.style.color = '#ff3f6c';
                this.style.border = '2px solid #ff3f6c';
            } else {
                // Add to wishlist
                wishlistActions.addToWishlist(product);
                this.innerHTML = '❤️ SAVED TO WISHLIST';
                this.style.background = '#ff3f6c';
                this.style.color = 'white';
                this.style.border = 'none';
            }
        };
    }
    
    // Get current product
    function getCurrentProduct() {
        return {
            id: document.querySelector('[data-product-id]')?.dataset.productId || 
                Date.now().toString(),
            name: document.querySelector('.title')?.textContent || 
                document.querySelector('h1')?.textContent || 'Product',
            price: document.getElementById('currentPrice')?.textContent?.replace('₹', '').replace(',', '') || 
                document.querySelector('.current-price')?.textContent?.replace('₹', '').replace(',', '') || '0',
            image: document.getElementById('mainImage')?.src || 
                document.querySelector('.main-image')?.src || '',
            brand: document.querySelector('.brand')?.textContent || 'RAPID RETAIL',
            slug: window.location.pathname.split('/').pop()
        };
    }
    
    // 5. WISHLIST PAGE
    function setupWishlistPage() {
        if (!document.body.classList.contains('wishlist-page')) return;
        
        loadWishlistItems();
    }
    
    function loadWishlistItems() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const grid = document.getElementById('wishlist-grid');
        const countEl = document.getElementById('wishlist-count');
        
        if (!grid) return;
        
        // Update count
        if (countEl) {
            countEl.textContent = `${wishlist.length} ${wishlist.length === 1 ? 'item' : 'items'}`;
        }
        
        if (wishlist.length === 0) {
            grid.innerHTML = `
                <div class="empty-wishlist" style="grid-column:1/-1; text-align:center; padding:80px 20px;">
                    <div style="font-size:60px; margin-bottom:20px;">❤️</div>
                    <h2 style="font-size:24px; margin-bottom:10px;">Your wishlist is empty</h2>
                    <p style="color:#878b94; margin-bottom:30px;">Save your favorite items here!</p>
                    <a href="/" style="display:inline-block; padding:15px 40px; background:#ff3f6c; color:white; text-decoration:none; border-radius:4px;">CONTINUE SHOPPING</a>
                </div>
            `;
            return;
        }
        
        // Render items
        grid.innerHTML = wishlist.map(item => `
            <div class="wishlist-item" style="background:white; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                <img src="${item.image}" alt="${item.name}" style="width:100%; height:300px; object-fit:cover; cursor:pointer;" 
                     onclick="window.location.href='/products/${item.slug}'">
                <div style="padding:15px;">
                    <div style="font-size:14px; color:#878b94; margin-bottom:5px;">${item.brand}</div>
                    <div style="font-size:16px; font-weight:600; margin-bottom:10px; cursor:pointer;" 
                         onclick="window.location.href='/products/${item.slug}'">${item.name}</div>
                    <div style="font-size:18px; font-weight:700; margin-bottom:15px;">₹${Number(item.price).toLocaleString()}</div>
                    <div style="display:flex; gap:10px;">
                        <button onclick="window.wishlist.moveToBag('${item.id}')" 
                                style="flex:1; padding:12px; background:#ff3f6c; color:white; border:none; border-radius:4px; cursor:pointer;">
                            MOVE TO BAG
                        </button>
                        <button onclick="window.wishlist.removeFromWishlist('${item.id}')"
                                style="padding:12px 15px; background:white; color:#ff3f6c; border:1px solid #ff3f6c; border-radius:4px; cursor:pointer;">
                            ✕
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    // 6. MOVE TO BAG
    function moveToBag(productId) {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const product = wishlist.find(item => item.id == productId);
        
        if (product) {
            // Add to cart
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({
                ...product,
                quantity: 1,
                size: 'S'
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Remove from wishlist
            wishlistActions.removeFromWishlist(productId);
            
            // Update cart badge
            const badges = document.querySelectorAll('.cart-badge');
            badges.forEach(b => b.textContent = cart.length);
            
            showToast('Moved to bag! 🛒');
        }
    }
    
    // 7. ADD CSS ANIMATIONS
    function addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                from { transform: translate(-50%, 100%); opacity: 0; }
                to { transform: translate(-50%, 0); opacity: 1; }
            }
            @keyframes slideDown {
                from { transform: translate(-50%, 0); opacity: 1; }
                to { transform: translate(-50%, 100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    // 8. INITIALIZE
    function init() {
        console.log('Wishlist system initializing...');
        
        addStyles();
        
        // Setup based on page
        if (document.body.classList.contains('product-detail-page')) {
            console.log('Product page detected');
            setupProductPage();
        }
        
        if (document.body.classList.contains('wishlist-page')) {
            console.log('Wishlist page detected');
            setupWishlistPage();
        }
        
        // Update header
        updateWishlistIcon();
        
        // Make functions global
        window.wishlist = {
            ...wishlistActions,
            moveToBag: moveToBag
        };
        
        console.log('Wishlist system ready');
    }
    
    // Start
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
