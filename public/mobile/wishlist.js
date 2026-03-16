(function() {
    const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';
    
    const wishlistActions = {
        addToWishlist(product) {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token || !user.id) {
                sessionStorage.setItem('redirect_after_login', window.location.pathname);
                sessionStorage.setItem('wishlist_item', JSON.stringify(product));
                window.location.href = '/user/login';
                return false;
            }
            
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
                updateWishlistIcon();
                showToast('❤️ Added to wishlist!');
                return true;
            } else {
                showToast('Already in wishlist!');
                return false;
            }
        },
        
        removeFromWishlist(productId) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist = wishlist.filter(item => item.id != productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            
            updateWishlistIcon();
            showToast('Removed from wishlist');
            
            if (document.body.classList.contains('wishlist-page')) {
                loadWishlistItems();
            }
            return true;
        },
        
        isInWishlist(productId) {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            return wishlist.some(item => item.id == productId);
        }
    };
    
    function showToast(message) {
        const existingToast = document.querySelector('.wishlist-toast');
        if (existingToast) existingToast.remove();
        
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
        
        setTimeout(() => {
            toast.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
    
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
    
    function setupProductPage() {
        if (!document.body.classList.contains('product-detail-page')) return;
        
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
        
        setTimeout(() => clearInterval(checkInterval), 10000);
    }
    
    function createWishlistButton() {
        const addToCartBtn = document.querySelector('.add-to-cart');
        if (!addToCartBtn) return;
        if (document.getElementById('wishlist-btn')) return;
        
        const productInfo = document.querySelector('.product-info');
        if (!productInfo) return;
        
        const buttonsContainer = document.createElement('div');
        buttonsContainer.style.cssText = `
            display: flex;
            gap: 10px;
            margin-top: 20px;
        `;
        
        addToCartBtn.parentNode.insertBefore(buttonsContainer, addToCartBtn);
        buttonsContainer.appendChild(addToCartBtn);
        
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
        setupWishlistButton(wishlistBtn);
    }
    
    function setupWishlistButton(btn) {
        const product = getCurrentProduct();
        if (!product || !product.id) return;
        
        if (wishlistActions.isInWishlist(product.id)) {
            btn.innerHTML = '❤️ SAVED TO WISHLIST';
            btn.style.background = '#ff3f6c';
            btn.style.color = 'white';
            btn.style.border = 'none';
        }
        
        btn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const product = getCurrentProduct();
            if (!product || !product.id) {
                console.log('Product not found');
                return;
            }
            
            if (wishlistActions.isInWishlist(product.id)) {
                wishlistActions.removeFromWishlist(product.id);
                this.innerHTML = '♡ SAVE TO WISHLIST';
                this.style.background = 'white';
                this.style.color = '#ff3f6c';
                this.style.border = '2px solid #ff3f6c';
            } else {
                wishlistActions.addToWishlist(product);
                this.innerHTML = '❤️ SAVED TO WISHLIST';
                this.style.background = '#ff3f6c';
                this.style.color = 'white';
                this.style.border = 'none';
            }
        };
    }
    
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
    
    function loadWishlistItems() {
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const grid = document.getElementById('wishlist-grid');
    const countEl = document.getElementById('wishlist-count');
    
    if (!grid) return;
    
    if (countEl) {
        countEl.textContent = `${wishlist.length} ${wishlist.length === 1 ? 'item' : 'items'}`;
    }
    
    if (wishlist.length === 0) {
        grid.innerHTML = `
            <div class="empty-wishlist">
                <div class="empty-icon">❤️</div>
                <h2>Your wishlist is empty</h2>
                <p>Save your favorite items here!</p>
                <a href="/" class="shop-now-btn">CONTINUE SHOPPING</a>
            </div>
        `;
        return;
    }
    
    grid.innerHTML = wishlist.map(item => `
        <div class="wishlist-card">
            <div class="wishlist-image-container" onclick="window.location.href='/products/${item.slug}'">
                <img src="${item.image}" alt="${item.name}">
                <button class="wishlist-remove-btn" onclick="event.stopPropagation(); window.wishlist.removeFromWishlist('${item.id}')">✕</button>
            </div>
            <div class="wishlist-details">
                <div class="wishlist-brand">${item.brand || 'RAPID RETAIL'}</div>
                <div class="wishlist-title" onclick="window.location.href='/products/${item.slug}'">${item.name}</div>
                <div class="wishlist-price">₹${Number(item.price).toLocaleString()}</div>
                <button class="wishlist-add-to-bag" onclick="window.wishlist.moveToBag('${item.id}')">
                    MOVE TO BAG
                </button>
            </div>
        </div>
    `).join('');
    
    addWishlistStyles();
}

function addWishlistStyles() {
    const style = document.createElement('style');
    style.textContent = `
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 12px;
            max-width: 100%;
            margin: 0 auto;
            background: #f5f5f5;
        }
        
        .wishlist-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        .wishlist-image-container {
            position: relative;
            width: 100%;
            aspect-ratio: 1/1.2;
            overflow: hidden;
            cursor: pointer;
            background: #fafafa;
        }
        
        .wishlist-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .wishlist-remove-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255,255,255,0.9);
            border: none;
            color: #282c3f;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            z-index: 2;
            padding: 0;
        }
        
        .wishlist-details {
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .wishlist-brand {
            font-size: 10px;
            color: #878b94;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .wishlist-title {
            font-size: 12px;
            font-weight: 500;
            color: #282c3f;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            cursor: pointer;
            min-height: 30px;
            margin: 2px 0;
        }
        
        .wishlist-price {
            font-size: 14px;
            font-weight: 700;
            color: #282c3f;
            margin: 2px 0 4px;
        }
        
        .wishlist-add-to-bag {
            background: #ff3f6c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 2px;
            letter-spacing: 0.3px;
        }
        
        .wishlist-add-to-bag:hover {
            background: #e6355a;
        }
        
        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: white;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .wishlist-header h1 {
            font-size: 18px;
            font-weight: 600;
            color: #282c3f;
            margin: 0;
        }
        
        .wishlist-count {
            font-size: 12px;
            color: #878b94;
            background: #f5f5f6;
            padding: 4px 8px;
            border-radius: 12px;
        }
        
        .empty-wishlist {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: white;
        }
        
        .empty-wishlist .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        
        .empty-wishlist h2 {
            font-size: 18px;
            color: #282c3f;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .empty-wishlist p {
            color: #878b94;
            margin-bottom: 24px;
            font-size: 14px;
        }
        
        .shop-now-btn {
            display: inline-block;
            padding: 10px 24px;
            background: #ff3f6c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
        }
        
        @media (min-width: 768px) {
            .wishlist-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 1200px;
                padding: 16px;
            }
        }
        
        @media (min-width: 1024px) {
            .wishlist-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    `;
    document.head.appendChild(style);
}
    
    function moveToBag(productId) {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const product = wishlist.find(item => item.id == productId);
        
        if (product) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({
                ...product,
                quantity: 1
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            
            wishlistActions.removeFromWishlist(productId);
            
            const badges = document.querySelectorAll('.cart-badge');
            badges.forEach(b => b.textContent = cart.length);
            
            showToast('Moved to bag! 🛒');
        }
    }
    
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
    
    function checkLoginRedirect() {
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        
        if (!token || !user.id) {
            const pendingItem = sessionStorage.getItem('wishlist_item');
            if (pendingItem) {
                try {
                    const product = JSON.parse(pendingItem);
                    sessionStorage.removeItem('wishlist_item');
                    
                    setTimeout(() => {
                        wishlistActions.addToWishlist(product);
                    }, 500);
                } catch (e) {
                    console.log('Error parsing pending item');
                }
            }
        }
    }
    
    function init() {
        console.log('Wishlist system initializing...');
        
        addStyles();
        checkLoginRedirect();
        // setupBackButton();
        
        if (document.body.classList.contains('product-detail-page')) {
            console.log('Product page detected');
            setupProductPage();
        }
        
        if (document.body.classList.contains('wishlist-page')) {
            console.log('Wishlist page detected');
            loadWishlistItems();
        }
        
        updateWishlistIcon();
        
        window.wishlist = {
            ...wishlistActions,
            moveToBag: moveToBag
        };
        
        console.log('Wishlist system ready');
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

