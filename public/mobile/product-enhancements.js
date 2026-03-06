
(function() {
    
    if (!document.body.classList.contains('product-detail-page')) return;
    
    let selectedSize = null;

    function addWishlistButton() {
        const addToCartBtn = document.querySelector('.add-to-cart');
        if (!addToCartBtn) return;
        
        if (document.getElementById('wishlist-btn')) return;
        
        const buttonsRow = document.createElement('div');
        buttonsRow.className = 'buttons-row';
        buttonsRow.style.cssText = `
            display: flex;
            gap: 10px;
            margin-top: 20px;
        `;
        addToCartBtn.parentNode.insertBefore(buttonsRow, addToCartBtn);
        buttonsRow.appendChild(addToCartBtn);
        
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
            transition: background 0.3s;
            margin-top: 0;
        `;
        
        const wishlistBtn = document.createElement('button');
        wishlistBtn.id = 'wishlist-btn';
        wishlistBtn.className = 'wishlist-btn';
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
        
        buttonsRow.appendChild(wishlistBtn);
        
        const errorMsg = document.createElement('div');
        errorMsg.id = 'size-error-msg';
        errorMsg.style.cssText = `
            color: #ff3f6c;
            font-size: 13px;
            margin-top: 10px;
            display: none;
            padding-left: 5px;
        `;
        errorMsg.innerHTML = '⚠️ Please select a size to continue';
        buttonsRow.parentNode.insertBefore(errorMsg, buttonsRow.nextSibling);
    
        wishlistBtn.addEventListener('click', function() {
            const product = getCurrentProduct();
            if (!product) return;
            
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            
            const exists = wishlist.some(item => item.id === product.id);
            
            if (!exists) {
                wishlist.push(product);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                
                this.innerHTML = '❤️ SAVED TO WISHLIST';
                this.style.background = '#ff3f6c';
                this.style.color = 'white';
                this.style.border = 'none';
                this.disabled = true;
            }
        });
    }
    
    function getCurrentProduct() {
        return {
            id: document.querySelector('[data-product-id]')?.dataset.productId || Date.now(),
            name: document.querySelector('.title')?.textContent || 'Product',
            price: document.getElementById('currentPrice')?.textContent?.replace('₹', '').replace(',', '') || '0',
            image: document.getElementById('mainImage')?.src || '',
            brand: document.querySelector('.brand')?.textContent || ''
        };
    }
    
    function setupSizeValidation() {
    
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('size-btn') && !e.target.disabled) {
                const errorMsg = document.getElementById('size-error-msg');
                if (errorMsg) {
                    errorMsg.style.display = 'none';
                }
                
                selectedSize = e.target.textContent;
            }
        });
        
        const originalAddToCart = window.addToCartFromProduct;
        
        window.addToCartFromProduct = function() {
            const variants = document.querySelectorAll('.size-btn:not(.disabled)');
            const errorMsg = document.getElementById('size-error-msg');
            
            if (variants.length > 0 && !document.querySelector('.size-btn.active')) {
                if (errorMsg) {
                    errorMsg.style.display = 'block';
                    
                    errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            if (originalAddToCart) {
                
                const originalProduct = {
                    id: document.querySelector('[data-product-id]')?.dataset.productId,
                    name: document.querySelector('.title')?.textContent,
                    price: document.getElementById('currentPrice')?.textContent?.replace('₹', '').replace(',', ''),
                    image: document.getElementById('mainImage')?.src,
                    selectedSize: selectedSize || document.querySelector('.size-btn.active')?.textContent
                };
                
                if (window.addToBag) {
                    window.addToBag(originalProduct);
                } else {
                    originalAddToCart();
                }
            }
        };
    }
    
    function setupButtonTextChange() {
        const originalAddToBag = window.addToBag;
        
        window.addToBag = function(product) {
            
            if (originalAddToBag) {
                originalAddToBag(product);
            }
            
            const addBtn = document.querySelector('.add-to-cart');
            if (addBtn) {
                addBtn.textContent = 'VIEW BAG';
                addBtn.onclick = function() {
                    window.location.href = '/cart';
                };
            }
        };
    }
    
    function init() {
        const observer = new MutationObserver(function(mutations) {
            if (document.querySelector('.product-wrapper')) {
                addWishlistButton();
                setupSizeValidation();
                setupButtonTextChange();
                observer.disconnect();
            }
        });
        
        const container = document.getElementById('product-container');
        if (container) {
            observer.observe(container, {
                childList: true,
                subtree: true
            });
        }
    }
    
    init();
})()