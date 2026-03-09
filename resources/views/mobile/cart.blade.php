<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Shopping Bag | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/cart.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="cart-page" data-page="cart">

<header class="site-header" id="site-header"></header>

<div class="safety-alert">
    <i>🔒</i> A gentle reminder to stay alert against prevalent fraudulent practices. RAPID RETAIL will never ask for OTPs, payments via unofficial links, or personal details for any contests or promotions.
</div>

<div class="gifts-banner">
    🎁 You're Getting Free Gifts Up to ₹1800! 🎁
</div>

<main class="cart-page-content">
    <div class="cart-container">
        <section class="cart-left">

            <h2>My Bag <span id="cart-count">0</span></h2>
            <div id="cart-items" class="cart-items-container"></div>
        </section>

        <aside class="cart-right">
            <div class="coupon-section">
                <div class="coupon-header-row">
                    <h4>Apply Coupon</h4>
                    <a href="#" class="view-coupons-link">View Coupons</a>
                </div>
                
                <div class="coupon-box">
                    <input type="text" id="coupon-code-input" placeholder="Enter Coupon Code" value="">
                    <button id="apply-coupon-btn" class="apply-coupon">APPLY</button>
                </div>
                
                <div class="applied-coupon" style="display: none;">
                    <span class="coupon-tag" id="applied-coupon-code"></span>
                    <button id="remove-coupon-btn" class="remove-coupon">✕</button>
                </div>

                <div class="applicable-coupons">
                    <h5>Applicable Coupons</h5>
                    <div id="coupons-list" class="coupons-list">
                        <div class="loading-coupons">Loading coupons...</div>
                    </div>
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
                
                <div class="summary-row total">
                    <span class="label">Total Amount</span>
                    <span class="value" id="final-total">₹0.00</span>
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

<footer class="site-footer" id="site-footer"></footer>


<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>


<script src="{{ asset('mobile/script.js') }}"></script>
<script src="{{ asset('mobile/cart.js') }}"></script>
<script src="{{ asset('mobile/wishlist.js') }}"></script>

</body>
</html>
