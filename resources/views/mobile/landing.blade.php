<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapid Retail - Royal Luxury Fashion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
</head>
<body>
    <div class="app-wrapper">
        <!-- Royal Purple Header -->
        <header class="header">
            <div class="header-container">
                <div class="logo">
                    <h1>RAPID<span>RETAIL</span></h1>
                </div>
                
                <!-- Dynamic Navigation Menu from Category API -->
             
                  <nav class="nav-menu">
    @foreach($categories->take(6) as $category)
        <a href="{{ url('/category/' . $category['slug']) }}">
            {{ strtoupper($category['name']) }}
        </a>
    @endforeach
</nav>
            
                
                <div class="header-icons">
                    <i class="far fa-heart"></i>
                    <i class="far fa-user"></i>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </header>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search for luxury brands, products and more...">
            </div>
        </div>

        <!-- Royal Hero Section -->
        <section class="hero">
            <div class="hero-main">
                <span class="hero-tag">Royal Collection 2025</span>
                <h1>Experience<br>Royal Luxury</h1>
                <p>Discover our exclusive collection of premium fashion pieces crafted for the modern royalty.</p>
                <button class="hero-btn">SHOP THE COLLECTION</button>
                <div class="hero-img">
                    <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=600&auto=format" alt="">
                </div>
            </div>
            
            <div class="hero-side">
                <div class="hero-card">
                    <div class="hero-card-icon"><i class="fas fa-crown"></i></div>
                    <div class="hero-card-content">
                        <h4>Royal Edit</h4>
                        <p>Curated for you</p>
                    </div>
                </div>
                <div class="hero-card">
                    <div class="hero-card-icon"><i class="fas fa-gem"></i></div>
                    <div class="hero-card-content">
                        <h4>Premium Picks</h4>
                        <p>Luxury pieces</p>
                    </div>
                </div>
                <div class="hero-card">
                    <div class="hero-card-icon"><i class="fas fa-star"></i></div>
                    <div class="hero-card-content">
                        <h4>Exclusive</h4>
                        <p>Member only</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                <h4>Free Delivery</h4>
                <p>On orders above ₹1999</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-undo-alt"></i></div>
                <h4>Easy Returns</h4>
                <p>30-day royal return</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Secure Payment</h4>
                <p>100% protected</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <h4>Royal Support</h4>
                <p>24/7 concierge</p>
            </div>
        </section>

        <!-- Categories Section - Your API se data aayega -->
        <section class="categories">
            <div class="section-header">
                <h2>Shop by Category</h2>
                <p>Discover your perfect style from our royal collection</p>
            </div>

            <div class="category-grid">
                @forelse($categories as $category)
                <div class="category-card">
                    <img src="{{ $category['image_url'] ?? asset('images/default-category.jpg') }}" alt="{{ $category['name'] }}">
                    <div class="category-overlay">
                        <h3>{{ $category['name'] }}</h3>
                        <span>EXPLORE →</span>
                    </div>
                </div>
                @empty
                    <p class="no-categories">No categories available</p>
                @endforelse
            </div>
        </section>

        <!-- Featured Products - Your API se data aayega -->
        <section class="featured-products">
            <div class="section-header">
                <h2>Royal Picks</h2>
                <p>Handpicked luxury just for you</p>
            </div>

            <div class="product-grid">
                @forelse($products as $product)
                <div class="product-card">
                    @if(!empty($product['discount']))
                    <div class="product-badge">{{ $product['discount']['value'] }}{{ $product['discount']['type'] === 'percentage' ? '% OFF' : ' OFF' }}</div>
                    @endif
                    
                    <div class="product-image">
                        <img src="{{ $product['image_url'] ?? asset('images/default-product.jpg') }}" alt="{{ $product['name'] }}">
                        <div class="product-actions">
                            <button class="action-btn"><i class="far fa-heart"></i></button>
                            <button class="action-btn"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    
                    <div class="product-details">
                        <div class="product-category">LUXURY COLLECTION</div>
                        <h3 class="product-title">{{ $product['name'] }}</h3>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(4.8k reviews)</span>
                        </div>

                        <div class="product-price">
                            @if($product['final_price'])
                            <span class="price-current">₹{{ number_format($product['final_price']) }}</span>
                            @endif

                            @if(!empty($product['price']) && $product['price'] > $product['final_price'])
                            <span class="price-original">₹{{ number_format($product['price']) }}</span>
                            <span class="discount">{{ round((($product['price'] - $product['final_price']) / $product['price']) * 100) }}% off</span>
                            @endif
                        </div>

                        <button class="product-btn">Quick View</button>
                    </div>
                </div>
                @empty
                <p class="no-products">No products available</p>
                @endforelse
            </div>
        </section>

        <!-- Royal Deal Banner -->
        <section class="deal-banner">
            <div class="deal-content">
                <span class="deal-tag">⚡ LIMITED EDITION ⚡</span>
                <h2>Royal Summer Sale</h2>
                <p>Extra 30% off on premium ethnic wear + Free Gold Coins</p>
                
                <div class="deal-timer">
                    <div class="timer-box">
                        <span class="number">08</span>
                        <span class="label">Hours</span>
                    </div>
                    <div class="timer-box">
                        <span class="number">45</span>
                        <span class="label">Mins</span>
                    </div>
                    <div class="timer-box">
                        <span class="number">32</span>
                        <span class="label">Secs</span>
                    </div>
                </div>

                <button class="deal-btn">CLAIM OFFER →</button>
            </div>
            
            <div class="deal-image">
                <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=400&auto=format" alt="Royal Deal">
            </div>
        </section>

        <!-- Brands Section -->
        <section class="brands">
            <h3>Luxury Brands We Host</h3>
            <div class="brand-grid">
                <div class="brand-item"><img src="https://logo.clearbit.com/gucci.com" alt="Gucci"></div>
                <div class="brand-item"><img src="https://logo.clearbit.com/louisvuitton.com" alt="Louis Vuitton"></div>
                <div class="brand-item"><img src="https://logo.clearbit.com/chanel.com" alt="Chanel"></div>
                <div class="brand-item"><img src="https://logo.clearbit.com/dior.com" alt="Dior"></div>
                <div class="brand-item"><img src="https://logo.clearbit.com/versace.com" alt="Versace"></div>
                <div class="brand-item"><img src="https://logo.clearbit.com/prada.com" alt="Prada"></div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-col footer-logo">
                    <h3>RAPID<span>RETAIL</span></h3>
                    <p>India's premier luxury fashion destination. Curating elegance since 2020.</p>
                    <div class="social-links">
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-pinterest-p"></i>
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>THE COMPANY</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Royal Club</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Sustainability</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>QUICK LINKS</h4>
                    <ul>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Gift Cards</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Size Guide</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>SUPPORT</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>CONCIERGE</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-phone"></i> +91 98765 43210</a></li>
                        <li><a href="#"><i class="fas fa-envelope"></i> royal@rapidretail.com</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> New Delhi, India</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2025 Rapid Retail. Royalty redefined. All rights reserved.</p>
                <div class="payment-icons">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fab fa-cc-rupay"></i>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('mobile/script.js') }}"></script>
</body>
</html>