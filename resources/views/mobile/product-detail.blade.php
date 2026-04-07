<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Product Details | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/product-styles.css') }}">
</head>
<body class="product-detail-page" data-page="product-detail" data-slug="{{ request()->route('slug') }}">

<div class="product-desktop-header">
    <div class="web-header">
        <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
        <div class="main-header">
            <div class="logo-area">
            <a href="/" class="logo">
                <img 
                    id="site-logo"
                    class="site-logo"
                    src=""
                    alt="Logo"
                    style="height:40px;width:auto;"
                    onerror="this.src='https://placehold.co/120x40?text=LOGO'"
                >
            </a>
                <nav class="nav-menu" id="productDesktopNavMenu"></nav>
            </div>
            <div class="search-area">
                <div class="search-box" style="position:relative;">
                    <input
                        type="text"
                        id="web-search-input"
                        placeholder="Search for products, brands..."
                        autocomplete="off"
                    >

                    <span id="clearBtn" class="clear-btn"></span>

                    <div
                        id="web-search-suggestions"
                        class="web-search-suggestions"
                        style="display:none;"
                    ></div>

                </div>
            </div>
            <div class="header-actions">
                <a href="${localStorage.getItem('token') ? '/profile' : '/login'}" class="action-link">Profile</a>
                <a href="/wishlist" class="action-link">Wishlist</a>
                <a href="/cart" class="action-link">Cart</a>
            </div>
        </div>
    </div>
    <div class="all-categories-popup" id="productDesktopPopup" style="display:none;"></div>
</div>
<main class="page-content">
    <div class="container web-product-wrapper">
        <div id="product-container">
        </div>
    </div>
</main>


<div class="pdp-size-popup" id="sizeChartPopup" onclick="hideSizeChart()">
    <div class="pdp-size-popup-content" onclick="event.stopPropagation()">
        <div class="pdp-size-popup-header">
            <h3 id="sizeChartTitle">Size Chart</h3>
            <span class="pdp-size-popup-close" onclick="hideSizeChart()">×</span>
        </div>
        <div class="pdp-size-popup-body" id="sizeChartBody">
        </div>
    </div>
</div>

<div class="pdp-color-popup" id="colorPopup" onclick="hideColorPopup()">
    <div class="pdp-color-popup-content" onclick="event.stopPropagation()">
        <div class="pdp-color-popup-header">
            <h3>All Colors</h3>
            <span class="pdp-color-popup-close" onclick="hideColorPopup()">×</span>
        </div>
        <div class="pdp-color-popup-body" id="colorPopupBody"></div>
    </div>
</div>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script src="{{ asset('mobile/product-detail.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("web-search-input");
    const suggestionsBox = document.getElementById("web-search-suggestions");
    const clearBtn = document.getElementById("clearBtn");

    if (!input) return;

    let timer;

    input.addEventListener("input", async function (e) {

        clearTimeout(timer);

        const q = e.target.value.trim();

        clearBtn.style.display = q ? "block" : "none";

        if (q.length === 0) {
            suggestionsBox.style.display = "none";
            suggestionsBox.innerHTML = "";
            return;
        }

        timer = setTimeout(async () => {

            try {

                const res = await fetch(
                    `${window.API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`
                );

                const data = await res.json();

                if (!data.success) return;

                let html = "";

                const products = data.data.products || [];

                products.forEach(p => {
                    html += `
                        <div class="web-suggestion-item"
                             onclick="window.location.href='/product/${p.slug}'">
                             ${p.name}
                        </div>
                    `;
                });

                if (html === "") {
                    html = `<div class="web-suggestion-item">No results found</div>`;
                }

                suggestionsBox.innerHTML = html;
                suggestionsBox.style.display = "block";

            } catch (err) {
                console.log(err);
            }

        }, 200);

    });

    clearBtn.addEventListener("click", function () {
        input.value = "";
        suggestionsBox.style.display = "none";
        suggestionsBox.innerHTML = "";
        clearBtn.style.display = "none";
        input.focus();
    });

    document.addEventListener("click", function (e) {
        if (!input.contains(e.target) &&
            !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = "none";
        }
    });

});
</script>
@include('components.footer')
</body>
</html>