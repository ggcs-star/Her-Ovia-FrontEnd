<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>RAPID RETAIL | Fashion Store</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
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

        <section class="section-container">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">CLEARANCE SALE</h2>
                    <p class="section-subtitle">50-90% OFF* ENDS 24TH FEB</p>
                </div>
                <div id="category-grid" class="category-grid"></div>
            </div>
        </section>

        <section class="container">
            <div class="spring-banner">
                <div class="spring-content">
                    <h3>Spring Is Here, So Is Style</h3>
                    <p>Let Your Wardrobe Catch The Sunshine</p>
                </div>
                <div class="spring-offer">
                    <span class="brand">PARK AVENUE & more</span>
                    <span class="offer">MIN. 50% OFF*</span>
                </div>
            </div>
        </section>

        <section class="section-container">
            <div class="container">
                <div class="section-header flex-header">
                    <div>
                        <h2 class="section-title">HOTTEST BRANDS</h2>
                        <p class="section-subtitle">Min. 40% Off on top labels</p>
                    </div>
                    <a href="/products" class="view-all-link desktop-only">VIEW ALL &rarr;</a>
                </div>
                <div class="brand-grid">
                    <div class="brand-card">
                        <div class="brand-img">
                            <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=200&h=250&fit=crop" alt="Levi's">
                        </div>
                        <div class="brand-info">
                            <h4>Levi's</h4>
                            <p>MIN. 50% OFF*</p>
                        </div>
                    </div>
                    <div class="brand-card">
                        <div class="brand-img">
                            <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=200&h=250&fit=crop" alt="H&M">
                        </div>
                        <div class="brand-info">
                            <h4>H&M</h4>
                            <p>UP TO 50% OFF*</p>
                        </div>
                    </div>
                    <div class="brand-card">
                        <div class="brand-img">
                            <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=200&h=250&fit=crop" alt="GAP">
                        </div>
                        <div class="brand-info">
                            <h4>GAP</h4>
                            <p>MIN. 40% OFF*</p>
                        </div>
                    </div>
                    <div class="brand-card">
                        <div class="brand-img">
                            <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=200&h=250&fit=crop" alt="SUPERDRY">
                        </div>
                        <div class="brand-info">
                            <h4>SUPERDRY®</h4>
                            <p>MIN. 40% OFF*</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-container">
            <div class="container">
                <div class="section-header flex-header">
                    <div>
                        <h2 class="section-title">TOP SELLING</h2>
                        <p class="section-subtitle">Most loved styles this week</p>
                    </div>
                    <a href="/products" class="view-all-link desktop-only">VIEW ALL &rarr;</a>
                </div>
                <div class="product-grid" id="top-selling-grid"></div>
            </div>
        </section>

        <section class="container">
            <div class="fashion-grid">
                <div class="fashion-card">
                    <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=400&h=500&fit=crop" alt="Jeans">
                    <div class="fashion-content">
                        <h4>Jeans</h4>
                        <p>MIN. 60% OFF*</p>
                    </div>
                </div>
                <div class="fashion-card">
                    <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400&h=500&fit=crop" alt="Tops">
                    <div class="fashion-content">
                        <h4>Tops, Tees & Shirts</h4>
                        <p>MIN. 60% OFF*</p>
                    </div>
                </div>
                <div class="fashion-card">
                    <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=400&h=500&fit=crop" alt="Trackpants">
                    <div class="fashion-content">
                        <h4>Trackpants</h4>
                        <p>MIN. 40% OFF*</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="kids-grid">
                <div class="kids-card">
                    <img src="https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=400&h=500&fit=crop" alt="Boys Clothing">
                    <div class="kids-content">
                        <h4>Boys Clothing</h4>
                        <p>STARTING ₹129*</p>
                    </div>
                </div>
                <div class="kids-card">
                    <img src="https://images.unsplash.com/photo-1514090458221-65bb69cf3436?w=400&h=500&fit=crop" alt="Kids Footwear">
                    <div class="kids-content">
                        <h4>Kids Footwear</h4>
                        <p>30-50% OFF*</p>
                    </div>
                </div>
                <div class="kids-card">
                    <img src="https://images.unsplash.com/photo-1485546246426-74dc88dec4d9?w=400&h=500&fit=crop" alt="Girls Clothing">
                    <div class="kids-content">
                        <h4>Girls Clothing</h4>
                        <p>STARTING ₹199*</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="beauty-banner">
                <div class="beauty-content">
                    <h3>Sun, Skin & Shine</h3>
                    <div class="beauty-offers">
                        <span>Summer Collection UP TO 40% OFF*</span>
                        <span>Summer Skin Care UP TO 50% OFF*</span>
                        <span>Make Up UP TO 60% OFF*</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="ajio-cares">
                <strong>RAPID CARES</strong>
                <p>WE DO NOT ASK FOR YOUR BANK ACCOUNT OR CARD DETAILS VERBALLY OR TELEPHONICALLY. WE ALSO DO NOT ASK FOR MONEY TO PARTICIPATE IN ANY OF OUR OFFERS OR RUN ANY LUCKY DRAWS.</p>
            </div>
        </section>

        <section class="container">
            <div class="trust-strip">
                <div class="trust-flex">
                    <div class="trust-item">
                        <span class="trust-icon">↺</span>
                        <div class="trust-text">
                            <h4>EASY EXCHANGE</h4>
                            <p>30-day returns</p>
                        </div>
                    </div>
                    <div class="trust-item">
                        <span class="trust-icon">✓</span>
                        <div class="trust-text">
                            <h4>100% HANDPICKED</h4>
                            <p>Curated collections</p>
                        </div>
                    </div>
                    <div class="trust-item">
                        <span class="trust-icon">⭐</span>
                        <div class="trust-text">
                            <h4>ASSURED QUALITY</h4>
                            <p>Brand certified</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="popular-searches">
                <h4>POPULAR SEARCHES</h4>
                <div class="search-tags">
                    <span>Denim</span><span>Backless Blouses</span><span>Handloom Sarees</span>
                    <span>Monte Carlo Jackets</span><span>Ajrakh Sarees</span><span>Chinos</span>
                    <span>Formal Pants</span><span>Cotton Kurtis</span><span>Printed Shirts</span>
                    <span>Oxford Shoes</span><span>Mini Skirts</span><span>Jogger Pants</span>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="popular-searches">
                <h4>POPULAR BRANDS</h4>
                <div class="search-tags">
                    <span>puma</span><span>nike</span><span>red tape</span><span>superdry</span>
                    <span>gap</span><span>us polo assn</span><span>adidas</span><span>levis</span>
                    <span>hm</span><span>skechers</span><span>crocs</span><span>tommy hilfiger</span>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer" id="site-footer"></footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    <div class="mobile-sticky-cta" id="mobile-sticky-cta"></div>

    <!-- Category Modal - AJIO Style Popup -->
    <div class="category-modal" id="category-modal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>SHOP BY CATEGORY</h2>
                <span class="modal-close" id="close-category-modal">&times;</span>
            </div>
            <div class="modal-body" id="modal-popup-body">
                <!-- Categories will be loaded here by JavaScript -->
            </div>
        </div>
    </div>

    <script src="{{ asset('mobile/script.js') }}"></script>
    
</body>
</html>