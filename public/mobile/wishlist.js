(function() {

    var CONFIG = {
        primary: '#440C2C',
        primaryHover: '#5a1038',
        storageKey: 'wishlist',
        cartKey: 'cart'
    };
    function getAuthToken() {
        return localStorage.getItem('token');
    }

    function getLoggedInUser() {
        try {
            return JSON.parse(localStorage.getItem('user') || '{}');
        } catch (error) {
            return {};
        }
    }

    function isLoggedIn() {
        var token = getAuthToken();
        var user = getLoggedInUser();

        return !!(token && user && user.id);
    }

    async function addWishlistToApi(product) {
        var token = getAuthToken();

        if (!token || !product || !product.id) {
            return;
        }

        try {
            var response = await fetch(
                window.API_BASE_URL + '/wishlist',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({
                        id: product.id,
                        name: product.name || '',
                        price: product.price || 0,
                        image: product.image || '',
                        brand: product.brand || '',
                        slug: product.slug || '',
                        variantId: product.variantId || null,
                        variantValue: product.variantValue || null,
                        variantType: product.variantType || null,
                        mrp: product.mrp || product.price || 0
                    })
                }
            );

            if (!response.ok) {
                console.error(
                    'Wishlist API add failed:',
                    response.status
                );
                return;
            }

            var data = await response.json();

            if (!data.success) {
                console.error(
                    'Wishlist API add error:',
                    data.message || 'Something went wrong'
                );
            }

        } catch (error) {
            console.error('Wishlist API sync error:', error);
        }
    }

    async function removeWishlistFromApi(productId) {
        var token = getAuthToken();

        if (!token || !productId) {
            return;
        }

        try {
            var response = await fetch(
                window.API_BASE_URL + '/wishlist/' + encodeURIComponent(productId),
                {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                }
            );

            if (!response.ok) {
                console.error(
                    'Wishlist API remove failed:',
                    response.status
                );
                return;
            }

            var data = await response.json();

            if (!data.success) {
                console.error(
                    'Wishlist API remove error:',
                    data.message || 'Something went wrong'
                );
            }

        } catch (error) {
            console.error('Wishlist API remove error:', error);
        }
    }

    async function syncLocalWishlistToApi() {
        if (!isLoggedIn()) {
            return;
        }

        var wishlist = [];

        try {
            wishlist = JSON.parse(
                localStorage.getItem(CONFIG.storageKey)
            ) || [];
        } catch (error) {
            wishlist = [];
        }

        if (!Array.isArray(wishlist) || wishlist.length === 0) {
            return;
        }

        for (var i = 0; i < wishlist.length; i++) {
            await addWishlistToApi(wishlist[i]);
        }
    }

    async function loadWishlistFromApi() {
        if (!isLoggedIn()) {
            return;
        }

        var token = getAuthToken();

        if (!token) {
            return;
        }

        try {
            var response = await fetch(
                window.API_BASE_URL + '/wishlist',
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                }
            );

            if (!response.ok) {
                console.error(
                    'Wishlist API fetch failed:',
                    response.status
                );
                return;
            }

            var result = await response.json();

            if (
                !result.success ||
                !result.data ||
                !Array.isArray(result.data)
            ) {
                return;
            }

            var localWishlist = [];

            try {
                localWishlist = JSON.parse(
                    localStorage.getItem(CONFIG.storageKey)
                ) || [];
            } catch (error) {
                localWishlist = [];
            }

            if (!Array.isArray(localWishlist)) {
                localWishlist = [];
            }

            var mergedWishlist = localWishlist.slice();

            for (var i = 0; i < result.data.length; i++) {

                var apiItem = result.data[i];

                if (!apiItem || !apiItem.id) {
                    continue;
                }

                var exists = false;

                for (var j = 0; j < mergedWishlist.length; j++) {

                    if (
                        mergedWishlist[j].id == apiItem.id &&
                        (mergedWishlist[j].variantId || null) ==
                        (apiItem.variantId || null)
                    ) {
                        exists = true;
                        break;
                    }
                }

                if (!exists) {
                    mergedWishlist.push(apiItem);
                }
            }

            localStorage.setItem(
                CONFIG.storageKey,
                JSON.stringify(mergedWishlist)
            );

        } catch (error) {
            console.error(
                'Wishlist API load error:',
                error
            );
        }
    }
    var wishlistActions = {

        addToWishlist: function(product) {

            var token = localStorage.getItem('token');
            var user = getLoggedInUser();

            if (!token || !user.id) {

                sessionStorage.setItem(
                    'redirect_after_login',
                    window.location.pathname
                );

                sessionStorage.setItem(
                    'wishlist_item',
                    JSON.stringify(product)
                );

                if (typeof showLoginPopup === 'function') {
                    showLoginPopup();
                } else {
                    window.location.href = '/user/login';
                }

                return false;
            }

            if (!product || !product.id) {
                return false;
            }

            var wishlist = [];

            try {
                wishlist = JSON.parse(
                    localStorage.getItem(CONFIG.storageKey)
                ) || [];
            } catch (error) {
                wishlist = [];
            }

            var exists = false;

            for (var i = 0; i < wishlist.length; i++) {

                if (
                    wishlist[i].id == product.id &&
                    wishlist[i].variantId == product.variantId
                ) {
                    exists = true;
                    break;
                }
            }

            if (!exists) {

                var wishlistItem = {
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    brand: product.brand,
                    slug: product.slug,
                    variantId: product.variantId || null,
                    variantValue: product.variantValue || null,
                    variantType: product.variantType || null,
                    mrp: product.mrp || product.price
                };

                wishlist.push(wishlistItem);

                localStorage.setItem(
                    CONFIG.storageKey,
                    JSON.stringify(wishlist)
                );

                updateWishlistIcon();

                showToast('❤️ Added to wishlist!');

                addWishlistToApi(wishlistItem);

                return true;

            } else {

                showToast('Already in wishlist!');

                return false;
            }
        },

        removeFromWishlist: function(productId) {

            var wishlist = [];

            try {
                wishlist = JSON.parse(
                    localStorage.getItem(CONFIG.storageKey)
                ) || [];
            } catch (error) {
                wishlist = [];
            }

            var newWishlist = [];

            for (var i = 0; i < wishlist.length; i++) {

                if (wishlist[i].id != productId) {
                    newWishlist.push(wishlist[i]);
                }
            }

            localStorage.setItem(
                CONFIG.storageKey,
                JSON.stringify(newWishlist)
            );

            updateWishlistIcon();

            showToast('Removed from wishlist');

            if (
                document.body.classList.contains('wishlist-page')
            ) {
                loadWishlistItems();
            }
            removeWishlistFromApi(productId);

            return true;
        },
        isInWishlist: function(productId) {

            var wishlist = [];

            try {
                wishlist = JSON.parse(
                    localStorage.getItem(CONFIG.storageKey)
                ) || [];
            } catch (error) {
                wishlist = [];
            }

            for (var i = 0; i < wishlist.length; i++) {

                if (wishlist[i].id == productId) {
                    return true;
                }
            }

            return false;
        },

        moveToBag: function(productId) {

            var wishlist = [];

            try {
                wishlist = JSON.parse(
                    localStorage.getItem(CONFIG.storageKey)
                ) || [];
            } catch (error) {
                wishlist = [];
            }

            var product = null;

            for (var i = 0; i < wishlist.length; i++) {

                if (wishlist[i].id == productId) {
                    product = wishlist[i];
                    break;
                }
            }

            if (product) {

                var cart = [];

                try {
                    cart = JSON.parse(
                        localStorage.getItem(CONFIG.cartKey)
                    ) || [];
                } catch (error) {
                    cart = [];
                }

                var existingIndex = -1;

                for (var j = 0; j < cart.length; j++) {

                    if (
                        cart[j].id == product.id &&
                        cart[j].variantId == product.variantId
                    ) {
                        existingIndex = j;
                        break;
                    }
                }

                var cartItem = {
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    mrp: product.mrp || product.price,
                    image: product.image,
                    brand: product.brand,
                    slug: product.slug,
                    quantity: 1,
                    variantId: product.variantId,
                    variantValue: product.variantValue,
                    variantType: product.variantType
                };

                if (existingIndex >= 0) {

                    cart[existingIndex].quantity =
                        (cart[existingIndex].quantity || 1) + 1;

                } else {

                    cart.push(cartItem);
                }

                localStorage.setItem(
                    CONFIG.cartKey,
                    JSON.stringify(cart)
                );

                wishlistActions.removeFromWishlist(productId);

                if (
                    typeof updateCartCountBadge === 'function'
                ) {
                    updateCartCountBadge();
                }

                showToast('Remove form wishlist!');
            }
        }
    };

    function showToast(message) {

        var existingToast =
            document.querySelector('.wishlist-toast');

        if (existingToast) {
            existingToast.remove();
        }

        var toast = document.createElement('div');

        toast.className = 'wishlist-toast';
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(function() {

            if (toast.parentNode) {
                toast.remove();
            }

        }, 2000);
    }

    function updateWishlistIcon() {

        var wishlist = [];

        try {
            wishlist = JSON.parse(
                localStorage.getItem(CONFIG.storageKey)
            ) || [];
        } catch (error) {
            wishlist = [];
        }

        var icons = document.querySelectorAll(
            '.wishlist-icon, .action-item svg'
        );

        for (var i = 0; i < icons.length; i++) {

            if (wishlist.length > 0) {
                icons[i].classList.add('has-items');
            } else {
                icons[i].classList.remove('has-items');
            }
        }
    }

    function getCurrentProduct() {

        var mainImage =
            document.getElementById('mainImage') ||
            document.querySelector('.pdp-main-image');

        var priceElement =
            document.getElementById('currentPrice') ||
            document.querySelector('.pdp-current-price');

        var productIdElem =
            document.querySelector('[data-product-id]');

        var titleElem =
            document.querySelector('.pdp-title') ||
            document.querySelector('.product-name') ||
            document.querySelector('h1');

        var brandElem =
            document.querySelector('.pdp-brand') ||
            document.querySelector('.brand');

        return {
            id:
                (
                    productIdElem &&
                    productIdElem.dataset &&
                    productIdElem.dataset.productId
                )
                    ? productIdElem.dataset.productId
                    : Date.now().toString(),

            name:
                titleElem
                    ? titleElem.textContent
                    : 'Product',

            price:
                priceElement
                    ? priceElement.textContent
                        .replace('₹', '')
                        .replace(/,/g, '')
                    : '0',

            image:
                mainImage
                    ? mainImage.src
                    : '',

            brand:
                brandElem
                    ? brandElem.textContent
                    : 'Her Ovia',

            slug:
                window.location.pathname
                    .split('/')
                    .pop()
        };
    }

    function updateButtonState(btn, isInWishlist) {

        if (isInWishlist) {

            btn.innerHTML = '❤️ SAVED';
            btn.classList.add('active');

        } else {

            btn.innerHTML = '♡ SAVE';
            btn.classList.remove('active');
        }
    }


    function setupWishlistButton(btn) {

        var product = getCurrentProduct();

        if (!product || !product.id) {
            return;
        }

        var inWishlist =
            wishlistActions.isInWishlist(product.id);

        updateButtonState(btn, inWishlist);

        btn.onclick = function(e) {

            e.preventDefault();
            e.stopPropagation();

            var currentProduct =
                getCurrentProduct();

            if (!currentProduct || !currentProduct.id) {
                return;
            }

            var isInWish =
                wishlistActions.isInWishlist(
                    currentProduct.id
                );

            if (isInWish) {

                wishlistActions.removeFromWishlist(
                    currentProduct.id
                );

                updateButtonState(btn, false);

            } else {

                wishlistActions.addToWishlist(
                    currentProduct
                );

                updateButtonState(
                    btn,
                    true
                );
            }
        };
    }

    function createWishlistButton() {

        var addToCartBtn =
            document.querySelector(
                '.add-to-cart, .pdp-add-to-cart'
            );

        if (
            !addToCartBtn ||
            document.getElementById('wishlist-btn')
        ) {
            return;
        }

        var buttonsContainer =
            document.createElement('div');

        buttonsContainer.className =
            'product-action-buttons';

        buttonsContainer.style.cssText =
            'display: flex; gap: 12px; margin-top: 20px;';

        addToCartBtn.parentNode.insertBefore(
            buttonsContainer,
            addToCartBtn
        );

        buttonsContainer.appendChild(
            addToCartBtn
        );

        addToCartBtn.style.cssText =
            'flex: 1; margin-top: 0;';

        var wishlistBtn =
            document.createElement('button');

        wishlistBtn.id = 'wishlist-btn';
        wishlistBtn.className =
            'wishlist-save-btn';

        wishlistBtn.innerHTML =
            '♡ SAVE';

        buttonsContainer.appendChild(
            wishlistBtn
        );

        setupWishlistButton(
            wishlistBtn
        );
    }

    function setupProductPage() {

        if (
            !document.body.classList.contains(
                'product-detail-page'
            )
        ) {
            return;
        }

        var attempts = 0;
        var maxAttempts = 20;

        var checkInterval =
            setInterval(function() {

                attempts++;

                var addToCartBtn =
                    document.querySelector(
                        '.add-to-cart, .pdp-add-to-cart'
                    );

                var existingBtn =
                    document.getElementById(
                        'wishlist-btn'
                    );

                if (existingBtn) {

                    setupWishlistButton(
                        existingBtn
                    );

                    clearInterval(
                        checkInterval
                    );

                } else if (
                    addToCartBtn &&
                    !existingBtn
                ) {

                    createWishlistButton();

                    clearInterval(
                        checkInterval
                    );
                }

                if (attempts >= maxAttempts) {
                    clearInterval(
                        checkInterval
                    );
                }

            }, 500);
    }

    function escapeHtml(str) {

        if (!str) {
            return '';
        }

        return String(str).replace(
            /[&<>]/g,
            function(m) {

                if (m === '&') {
                    return '&amp;';
                }

                if (m === '<') {
                    return '&lt;';
                }

                if (m === '>') {
                    return '&gt;';
                }

                return m;
            }
        );
    }
    function loadWishlistItems() {

        var wishlist = [];

        try {
            wishlist = JSON.parse(
                localStorage.getItem(CONFIG.storageKey)
            ) || [];
        } catch (error) {
            wishlist = [];
        }

        var grid =
            document.getElementById(
                'wishlist-grid'
            );

        var countEl =
            document.getElementById(
                'wishlist-count'
            );

        if (!grid) {
            return;
        }

        if (countEl) {

            countEl.textContent =
                wishlist.length +
                ' ' +
                (
                    wishlist.length === 1
                        ? 'item'
                        : 'items'
                );
        }

        if (wishlist.length === 0) {

            grid.innerHTML =
                '<div class="empty-wishlist">' +
                    '<div class="empty-icon">❤️</div>' +
                    '<h2>Your wishlist is empty</h2>' +
                    '<p>Save your favorite items here!</p>' +
                    '<a href="/" class="shop-now-btn">SHOP NOW</a>' +
                '</div>';

            return;
        }

        var html = '';

        for (var i = 0; i < wishlist.length; i++) {

            var item = wishlist[i];

            html +=
                '<div class="wishlist-card" data-product-id="' +
                    escapeHtml(String(item.id)) +
                '">' +

                    '<div class="wishlist-image-container" ' +
                        'onclick="location.href=\'/product/' +
                            escapeHtml(item.slug || '') +
                        '\">' +

                        '<img src="' +
                            escapeHtml(item.image || '') +
                            '" ' +

                            'data-main="' +
                                escapeHtml(item.image || '') +
                            '" ' +

                            'data-slug="' +
                                escapeHtml(item.slug || '') +
                            '" ' +

                            'onmouseenter="window.loadHoverImage(this)" ' +

                            'onmouseleave="this.src=this.dataset.main" ' +

                            'alt="' +
                                escapeHtml(item.name || 'Product') +
                            '" ' +

                            'loading="lazy" ' +
                            'width="300" ' +
                            'height="360">' +

                        '<button class="wishlist-remove-btn" ' +
                            'onclick="event.stopPropagation(); window.wishlist.removeFromWishlist(\'' +
                                escapeHtml(String(item.id)) +
                            '\')" ' +
                            'aria-label="Remove">✕</button>' +

                    '</div>' +

                    '<div class="wishlist-info">' +

                        '<div class="wishlist-brand">' +
                            escapeHtml(
                                item.brand || 'Her Ovia'
                            ) +
                        '</div>' +

                        '<div class="wishlist-title" ' +
                            'onclick="location.href=\'/product/' +
                                escapeHtml(item.slug || '') +
                            '\'">' +
                            escapeHtml(
                                item.name || 'Product'
                            ) +
                        '</div>' +

                        '<div class="wishlist-price">₹' +
                            Number(
                                item.price || 0
                            ).toLocaleString('en-IN') +
                        '</div>' +

                        '<button class="wishlist-remove-from-wishlist" ' +
                            'onclick="window.wishlist.moveToBag(\'' +
                                escapeHtml(String(item.id)) +
                            '\')" ' +
                            'aria-label="REMOVE FROM WISHLIST">' +
                            'REMOVE FROM WISHLIST' +
                        '</button>' +

                    '</div>' +

                '</div>';
        }

        grid.innerHTML = html;
    }


    async function init() {
        if (isLoggedIn()) {
            await syncLocalWishlistToApi();
        }
        if (isLoggedIn()) {
            await loadWishlistFromApi();
        }

        if (
            document.body.classList.contains(
                'product-detail-page'
            )
        ) {
            setupProductPage();
        }

        if (
            document.body.classList.contains(
                'wishlist-page'
            )
        ) {
            loadWishlistItems();
        }

        updateWishlistIcon();

        window.wishlist = {
            addToWishlist:
                wishlistActions.addToWishlist,

            removeFromWishlist:
                wishlistActions.removeFromWishlist,

            isInWishlist:
                wishlistActions.isInWishlist,

            moveToBag:
                wishlistActions.moveToBag
        };
    }


    /* =========================================================
       DOM READY
    ========================================================= */

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            init
        );

    } else {

        init();
    }

})();