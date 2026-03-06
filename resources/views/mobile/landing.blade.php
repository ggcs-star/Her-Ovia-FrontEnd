<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>RAPID RETAIL | Fashion Store</title>
    
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/categories/category-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/product-styles.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body data-page="landing">
    <header class="site-header" id="site-header"></header>

    <main class="page-content">
        <section class="hero-section">
            <div id="hero-slider" class="hero-slider"></div>
            <div class="slider-dots" id="slider-dots"></div>
        </section>

        <section class="categories-pills-section">
            <div class="container">
                <div id="categories-pills" class="categories-pills"></div>
            </div>
        </section>

        
        <!-- WHAT'S TRENDING - FIGMA STYLE -->
<section class="trending-section">
    <div class="section-header centered">
        <h2 class="section-title">What's Trending</h2>
    </div>
    
    <div class="trending-slider-container">
        <div class="trending-slider" id="trending-slider">
            <!-- Cards will be injected here -->
        </div>
    </div>
</section>
        <section class="container" id="mid-banner-1-container"></section>

        <section class="section-container">
            <div class="container">
                <div class="section-header centered">
                    <h2 class="section-title">Style Spotlight</h2>
                </div>
                <div id="style-spotlight-grid" class="spotlight-grid"></div>
            </div>
        </section>
    <section class="container" id="mid-banner-2-container"></section>
        <div id="brands-marquee-container"></div>

        <section class="section-container">
            <div class="container">
                <div id="brands-grid" class="brands-grid-figma"></div>
            </div>
        </section>

        <div id="dynamic-category-sections"></div>

        <section class="container" id="mid-banner-2-container"></section>

        <section class="container">
            <div class="trust-strip-figma">
                <div class="trust-card-figma support">
                    <div class="trust-icon-circle">🕒</div>
                    <h4>24/7 Support</h4>
                    <p>Always here to help</p>
                </div>
                <div class="trust-card-figma pay">
                    <div class="trust-icon-circle">🛡️</div>
                    <h4>Secure Pay</h4>
                    <p>100% protected</p>
                </div>
                <div class="trust-card-figma returns">
                    <div class="trust-icon-circle">🔄</div>
                    <h4>Easy Returns</h4>
                    <p>30-day return policy</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>RAPID RETAIL</h4>
                    <ul>
                        <li>About Us</li>
                        <li>Careers</li>
                        <li>Blog</li>
                        <li>Press</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>SHOP</h4>
                    <ul>
                        <li>Men's Fashion</li>
                        <li>Women's Fashion</li>
                        <li>Kids Corner</li>
                        <li>Beauty & Health</li>
                        <li>Home & Living</li>
                        <li>Electronics</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>SUPPORT</h4>
                    <ul>
                        <li>Help Center</li>
                        <li>Returns & Refunds</li>
                        <li>Shipping Info</li>
                        <li>Track Order</li>
                        <li>Contact Us</li>
                        <li>FAQs</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>FOLLOW US</h4>
                    <ul class="social-links">
                        <li>📱 Instagram</li>
                        <li>📘 Facebook</li>
                        <li>🐦 Twitter</li>
                        <li>📌 Pinterest</li>
                        <li>▶️ YouTube</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>DOWNLOAD APP</h4>
                    <ul>
                        <li>📲 App Store</li>
                        <li>📲 Google Play</li>
                    </ul>
                </div>
            </div>
            <div class="footer-newsletter">
                <h4>SUBSCRIBE TO OUR NEWSLETTER</h4>
                <div class="newsletter-box">
                    <input type="email" placeholder="Enter your email">
                    <button>SUBSCRIBE</button>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="payment-methods">
                    <span>VISA</span>
                    <span>MasterCard</span>
                    <span>PayPal</span>
                    <span>Razorpay</span>
                    <span>Cash on Delivery</span>
                </div>
                <p>© 2025 RAPID RETAIL. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    <div class="mobile-sticky-cta" id="mobile-sticky-cta"></div>

    <div class="category-modal" id="category-modal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>SHOP BY CATEGORY</h2>
                <span class="modal-close" id="close-category-modal">&times;</span>
            </div>
            <div class="modal-body" id="modal-popup-body"></div>
        </div>
    </div>

    <script src="{{ asset('mobile/script.js') }}"></script>
</body>
</html>
