<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Product Details | Her-Ovia</title>
    <meta name="description" content="Shop premium clothing online from Her-Ovia, featuring elegant Indian wear and contemporary styles with secure payment and fast delivery.">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/product-styles.css') }}">
</head>
<body class="product-detail-page" data-page="product-detail" data-slug="{{ request()->route('slug') }}">
 <div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>


    <main class="page-content">
        <div class="container web-product-wrapper">
            <div id="product-container"></div>
        </div>
    </main>

    <!-- ==========================================
         SIZE CHART POPUP
         ========================================== -->
    <div class="pdp-size-popup" id="sizeChartPopup" onclick="hideSizeChart()">
        <div class="pdp-size-popup-content" onclick="event.stopPropagation()">
            <div class="pdp-size-popup-header">
                <h3 id="sizeChartTitle">Size Chart</h3>
                <span class="pdp-size-popup-close" onclick="hideSizeChart()">×</span>
            </div>
            <div class="pdp-size-popup-body" id="sizeChartBody"></div>
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

    <!-- ==========================================
         SCRIPTS
         ========================================== -->
    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>

    <!-- ✅ script.js - Header render karega -->
    <script src="{{ asset('mobile/script.js') }}"></script>

    <!-- ✅ product-detail.js - Product render karega -->
    <script src="{{ asset('mobile/product-detail.js') }}"></script>

    <script>
        // ==========================================
        // HEADER INSTANTLY RENDER - 0ms DELAY
        // ==========================================
        (function() {
            if (typeof window.app !== 'undefined' && window.app) {
                window.app.renderHeader();
                window.app.renderBottomNav();
            } else if (typeof RapidRetailsEngine !== 'undefined') {
                window.app = new RapidRetailsEngine();
                window.app.renderHeader();
                window.app.renderBottomNav();
            }
        })();

        // ==========================================
        // SEARCH SUGGESTIONS
        // ==========================================
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("web-search-input");
            const suggestionsBox = document.getElementById("web-search-suggestions");

            if (!input) return;

            let timer;

            input.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const q = this.value.trim();
                    if (q) {
                        window.location.href = `/products?search=${encodeURIComponent(q)}`;
                    }
                }
            });

            input.addEventListener("input", async function(e) {
                clearTimeout(timer);
                const q = e.target.value.trim();

                if (q.length === 0) {
                    if (suggestionsBox) {
                        suggestionsBox.style.display = "none";
                        suggestionsBox.innerHTML = "";
                    }
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

                        if (suggestionsBox) {
                            suggestionsBox.innerHTML = html;
                            suggestionsBox.style.display = "block";
                        }
                    } catch (err) {
                        console.log(err);
                    }
                }, 200);
            });

            document.addEventListener("click", function(e) {
                if (!input.contains(e.target) &&
                    !suggestionsBox?.contains(e.target)) {
                    if (suggestionsBox) {
                        suggestionsBox.style.display = "none";
                    }
                }
            });
        });

        // ==========================================
        // CART COUNT UPDATE
        // ==========================================
        setTimeout(function() {
            if (typeof updateCartCountBadge === 'function') {
                updateCartCountBadge();
            }
        }, 100);

        console.log('✅ Product Details Page - Header rendered from script.js');
    </script>

    @include('mobile.auth.auth')
    @include('components.footer')

</body>
</html>