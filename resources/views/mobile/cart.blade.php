<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Shopping Bag | Her-Ovia</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('mobile/cart.css') }}?v={{ time() }}">
    
</head>
<body class="cart-page" data-page="cart">
 <div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>


<!-- <div class="safety-alert">
    <i>🔒</i> A gentle reminder to stay alert against prevalent fraudulent practices. MAHERA JEWEL will never ask for OTPs, payments via unofficial links, or personal details for any contests or promotions.
</div>

<div class="gifts-banner">
    🎁 You're Getting Free Gifts Up to ₹1800! 🎁
</div> -->

<main class="cart-page-content">
    <div class="cart-container">
        <section class="cart-left">

            <h2>My Bag <span id="cart-count">0</span></h2>
            <div id="cart-items" class="cart-items-container"></div>
        </section>

        <aside class="cart-right">
        <div class="coupon-section">

    <h4>Apply Coupon</h4>

    <div class="coupon-box">
        <input
            type="text"
            id="coupon-code-input"
            placeholder="Enter Coupon Code">

        <button
            id="apply-coupon-btn"
            class="apply-coupon">
            APPLY
        </button>
    </div>

    <div class="applied-coupon" style="display:none;">
        <span
            class="coupon-tag"
            id="applied-coupon-code">
        </span>

        <button
            id="remove-coupon-btn"
            class="remove-coupon">
            ✕
        </button>
    </div>

</div>

            <div class="order-summary-card">
                <h3>Order Summary (<span id="item-count">0</span> Items)</h3>
                
                <div class="summary-row">
                    <span class="label">M.R.P.</span>
                    <span class="value" id="total-mrp">₹0.00</span>
                </div>
                
                <div class="summary-row discount">
                    <span class="label">Discount</span>
                    <span class="value" id="total-discount">-₹0.00</span>
                </div>

                <div class="summary-row coupon-discount" style="display: none;">
                    <span class="label">Coupon Discount</span>
                    <span class="value" id="coupon-discount">-₹0.00</span>
                </div>
                
                <div class="checkout-web-wrapper">
                    <div class="summary-row total">
                        <span class="label">Total Amount</span>
                        <span class="value" id="final-total-web">₹0.00</span>
                    </div>
                </div>
            <button class="checkout-btn-web" onclick="proceedToCheckout()">
                    Proceed to Checkout
                </button>               
            </div>
            </div>

            <div class="savings-message" style="display: none;">
                <span>🎉</span> Yay! Your total discount is <span id="savings-amount">₹0</span>
            </div>
        </aside>
    </div>
</main>

<div class="sticky-bottom-bar">
    <div class="bottom-bar-container">
        <div class="total-display">
            <span id="bottom-total">₹0.00</span>
        </div>
        <button class="proceed-checkout-btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
    </div>
</div>

@include('components.footer')


<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script src="{{ asset('mobile/script.js') }}?v={{ time() }}"></script>
<script src="{{ asset('mobile/cart.js') }}?v={{ time() }}"></script>
<script src="{{ asset('mobile/wishlist.js') }}?v={{ time() }}"></script>
@include('mobile.auth.auth')

</body>
</html>
