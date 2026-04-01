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

<div id="skeleton-loader">
    <div class="skeleton-container">
        <div class="skeleton skeleton-hero"></div>

        <div class="categories-pills-section">
            <div class="container">
                <div class="skeleton-grid">
                    <div class="skeleton skeleton-category"></div>
                    <div class="skeleton skeleton-category"></div>
                    <div class="skeleton skeleton-category"></div>
                    <div class="skeleton skeleton-category"></div>
                    <div class="skeleton skeleton-category"></div>
                </div>
            </div>
        </div>

        <section class="trending-section">
            <div class="container">
                <div class="section-header centered">
                    <div class="skeleton skeleton-title"></div>
                </div>
                <div class="skeleton-grid">
                    <div class="skeleton skeleton-card"></div>
                    <div class="skeleton skeleton-card"></div>
                    <div class="skeleton skeleton-card"></div>
                    <div class="skeleton skeleton-card"></div>
                </div>
            </div>
        </section>

        <section class="section-container">
            <div class="container">
                <div class="section-header centered">
                    <div class="skeleton skeleton-title"></div>
                </div>
                <div class="skeleton-grid-4">
                    <div class="skeleton skeleton-product"></div>
                    <div class="skeleton skeleton-product"></div>
                    <div class="skeleton skeleton-product"></div>
                    <div class="skeleton skeleton-product"></div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="skeleton-grid-4">
                <div class="skeleton skeleton-brand"></div>
                <div class="skeleton skeleton-brand"></div>
                <div class="skeleton skeleton-brand"></div>
                <div class="skeleton skeleton-brand"></div>
            </div>
        </div>
    </div>
</div>

<div id="real-content" style="display: none;">
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

        <section class="trending-section">
            <div class="container">
                <div class="section-header centered">
                    <h2 class="section-title">What's Trending</h2>
                </div>
                
                <div class="trending-slider-container">
                    <div class="trending-slider" id="trending-slider">
                    </div>
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

       <section class="container">
    <div class="trust-strip-figma">
        <div class="trust-card-figma">
            <div class="trust-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <h4>Fast Delivery</h4>
            <p>Within 24-48 hrs</p>
        </div>
        <div class="trust-card-figma">
            <div class="trust-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12V8H4V12M20 12L22 14V18H2V14L4 12M20 12H4M12 8V16M8 12V16M16 12V16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <rect x="2" y="4" width="20" height="4" rx="1" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <h4>Secure Pay</h4>
            <p>100% protected</p>
        </div>
        <div class="trust-card-figma">
            <div class="trust-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 7L9 18L4 13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h4>Easy Returns</h4>
            <p>30-day return policy</p>
        </div>
        <div class="trust-card-figma">
            <div class="trust-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L15 8H22L16 12L19 18L12 14L5 18L8 12L2 8H9L12 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
            </div>
            <h4>Best Quality</h4>
            <p>Assured products</p>
        </div>
    </div>
</section>
    </main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4 id="footerAppName">RAPID RETAIL</h4>
                <p class="footer-tagline">Your one-stop destination for fashion and lifestyle.</p>
                <div class="footer-location">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>5th Floor, Grand Empio, Shiv Habitat B-Block, Motera Stadium Rd, opp. S Mall, Motera, Ahmedabad, Gujarat 380005</span>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Categories</h4>
                <ul id="footerCategoriesList">
                    <li><a href="/category/jewellery">Jewellery</a></li>
                    <li><a href="/category/electronics">Electronics</a></li>
                    <li><a href="/category/mens-beauty">Men's Beauty</a></li>
                    <li><a href="/category/western-wear">Western Wear</a></li>
                    <li><a href="/category/t-shirts">T-Shirts</a></li>
                    <li><a href="/category/books">Books</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Support</h4>
                <ul class="footer-support-list">
                    <li>Help Center</li>
                    <li>Returns & Refunds</li>
                    <li>Shipping Info</li>
                    <li>Track Order</li>
                    <li>Contact Us</li>
                    <li>FAQs</li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Join Us</h4>
                <div class="social-links">
                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <circle cx="12" cy="12" r="4.5"></circle>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <span>Instagram</span>
                    </div>
                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </div>
                        <span>Facebook</span>
                    </div>
                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </div>
                        <span>Twitter</span>
                    </div>
                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                            </svg>
                        </div>
                        <span>YouTube</span>
                    </div>
                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M8 20.5C8 20.5 9 16 9 13c0-2-1-3-3-3s-3 2-3 4 1 4 4 4 4-3 4-3"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                        </div>
                        <span>Pinterest</span>
                    </div>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Contact Information</h4>
                <ul class="contact-info">
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>info@rapidretail.com</span>
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>+91 8866373077</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <span id="footerYear"></span> <span id="footerAppNameBottom">RAPID RETAIL</span>. All Rights Reserved.</p>
        </div>
    </div>
</footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    <div class="mobile-sticky-cta" id="mobile-sticky-cta"></div>
</div>

<script src="{{ asset('mobile/script.js') }}"></script>
</body>
</html>