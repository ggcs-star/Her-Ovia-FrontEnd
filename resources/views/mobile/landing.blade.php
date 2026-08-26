<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="description" content="Premium Indian suits and contemporary co-ord sets, thoughtfully made for every chapter of her journey.">
    <meta name="keywords" content="jewellery, necklaces, earrings, bridal sets, maang tikka, bangles, kundan jewellery, pearl jewellery">
    <meta name="author" content="MAHERA JEWEL">
    <title>Her-Ovia — Her Journey</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/mjlogo.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/categories/category-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/product-styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

    <div class="herovia-announcement">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>

    <header class="site-header" id="site-header"></header>

    <main class="page-content">

        <section class="hero-section">
            <div id="hero-slider" class="hero-slider"></div>
            <div class="slider-dots" id="slider-dots"></div>
        </section>

        <section class="herovia-brand-statement">
            <div class="container">
                <p class="herovia-eyebrow">The Her-Ovia point of view</p>
                <h2>Clothes that feel like<br><em>your most beautiful self.</em></h2>
                <p class="herovia-brand-text">Refined Indian suits and contemporary co-ords, thoughtfully created for real celebrations, real movement and every chapter of her journey.</p>
            </div>
        </section>

        <section class="herovia-collections">
            <div class="container">
                <div class="herovia-collections-grid" id="dynamic-collections"></div>
            </div>
        </section>

        <section class="herovia-featured">
            <div class="container">
                <div id="dynamic-featured"></div>
            </div>
        </section>

        <section class="herovia-collection-intro">
            <div class="container">
                <div class="herovia-collection-intro-inner">
                    <div>
                        <p class="herovia-eyebrow">Fresh from the house</p>
                        <h2>Two new ways<br>to make an entrance.</h2>
                    </div>
                    <p class="herovia-collection-intro-text">Modern ease for the day.<br>Luminous craft for the evening.</p>
                </div>
            </div>
        </section>

        <section class="herovia-two-collections">
            <div class="container">
                <div class="herovia-two-collections-grid" id="dynamic-two-collections"></div>
            </div>
        </section>

        <section class="herovia-promise">
            <div class="container">
                <div class="herovia-promise-inner">
                    <p class="herovia-eyebrow">The Her-Ovia Promise</p>
                    <h2>Made for the woman<br><em>who knows her worth.</em></h2>
                    <div class="herovia-promise-grid">
                        <div class="herovia-promise-item">
                            <span class="herovia-promise-number">01</span>
                            <h3>Timeless Design</h3>
                            <p>Created to be worn beyond seasons — our pieces are crafted with enduring elegance that never fades.</p>
                        </div>
                        <div class="herovia-promise-item">
                            <span class="herovia-promise-number">02</span>
                            <h3>Luxurious Comfort</h3>
                            <p>Soft, breathable fabrics that feel like a second skin — because true luxury is how it makes you feel.</p>
                        </div>
                        <div class="herovia-promise-item">
                            <span class="herovia-promise-number">03</span>
                            <h3>Conscious Craft</h3>
                            <p>Every piece is thoughtfully made with respect for the craft, the maker, and the woman who wears it.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="herovia-featured-collections">
            <div class="container">
                <div class="herovia-featured-collections-inner">
                    <div class="herovia-featured-collections-header">
                        <p class="herovia-eyebrow">Where every piece tells a story of grace.</p>
                        <h2>Explore Our <em>Collections</em></h2>
                    </div>
                    <div class="herovia-featured-collections-grid" id="dynamic-featured-collections"></div>
                </div>
            </div>
        </section>

        <section class="herovia-packaging">
            <div class="container">
                <div class="herovia-packaging-inner">
                    <div class="herovia-packaging-image">
                        <img src="{{ asset('images/her-ovia-packaging.png') }}" alt="Her-Ovia Luxury Packaging" loading="lazy">
                    </div>
                    <div class="herovia-packaging-content">
                        <p class="herovia-packaging-eyebrow">HER-OVIA</p>
                        <h2>Luxury Apparel Packaging</h2>
                        <p>Thoughtfully designed packaging that reflects the elegance, grace, and feminine spirit of Her-Ovia.</p>
                        <div class="herovia-packaging-features">
                            <div class="herovia-packaging-feature">
                                <span class="herovia-packaging-feature-icon">✦</span>
                                <div>
                                    <h4>Signature Rigid Box</h4>
                                    <p>Premium ethnic wear packaging</p>
                                </div>
                            </div>
                            <div class="herovia-packaging-feature">
                                <span class="herovia-packaging-feature-icon">✦</span>
                                <div>
                                    <h4>Premium Courier Box</h4>
                                    <p>Secure mailer box delivery</p>
                                </div>
                            </div>
                            <div class="herovia-packaging-feature">
                                <span class="herovia-packaging-feature-icon">✦</span>
                                <div>
                                    <h4>Elegant Presentation</h4>
                                    <p>Thoughtfully designed unboxing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section class="herovia-edit">
            <div class="container">
                <div class="herovia-edit-inner">
                    <div class="herovia-edit-header">
                        <p class="herovia-eyebrow">The Her-Ovia Edit</p>
                        <h2>Where craft meets<br><em>everyday elegance.</em></h2>
                    </div>
                    <div class="herovia-edit-grid">
                        <article class="herovia-edit-card">
                            <span class="herovia-edit-number">01</span>
                            <div class="herovia-edit-icon">✦</div>
                            <h3>The Art of Detail</h3>
                            <p>Every stitch, every fold, every drape — considered with intention. Our designs are born from a quiet obsession with craftsmanship and the way fabric meets the body.</p>
                            <a href="#collections" class="herovia-edit-link">Discover the craft →</a>
                        </article>
                        <article class="herovia-edit-card">
                            <span class="herovia-edit-number">02</span>
                            <div class="herovia-edit-icon">↗</div>
                            <h3>Designed for Movement</h3>
                            <p>Fluid silhouettes that move with you — not against you. Breathable fabrics and thoughtful cuts that honor the rhythm of a woman's day, from morning light to evening glow.</p>
                            <a href="#collections" class="herovia-edit-link">Explore the edit →</a>
                        </article>
                        <article class="herovia-edit-card">
                            <span class="herovia-edit-number">03</span>
                            <div class="herovia-edit-icon">♢</div>
                            <h3>A Lifelong Companion</h3>
                            <p>Not just for a season — but for a lifetime. Timeless pieces that transcend trends, designed to be loved, worn, and passed on. Her-Ovia is a companion to her journey.</p>
                            <a href="#story" class="herovia-edit-link">Read the story →</a>
                        </article>
                        <article class="herovia-edit-card">
                            <span class="herovia-edit-number">04</span>
                            <div class="herovia-edit-icon">◈</div>
                            <h3>The Her-Ovia Woman</h3>
                            <p>She is poised yet effortless. Modern yet rooted. She dresses for herself — in clothes that reflect her grace, her strength, and her journey. This is her wardrobe.</p>
                            <a href="#share-your-look" class="herovia-edit-link">Join the circle →</a>
                        </article>
                    </div>
                </div>
            </div>
        </section> -->

        <section class="herovia-values">
            <div class="container">
                <div class="herovia-values-grid">
                    <div class="herovia-value-item">
                        <span class="herovia-value-icon">◈</span>
                        <h4>Handcrafted with Care</h4>
                        <p>Every piece is made with love and attention to detail.</p>
                    </div>
                    <div class="herovia-value-item">
                        <span class="herovia-value-icon">✦</span>
                        <h4>Premium Fabrics</h4>
                        <p>Only the finest materials that feel as beautiful as they look.</p>
                    </div>
                    <div class="herovia-value-item">
                        <span class="herovia-value-icon">♢</span>
                        <h4>Designed to Last</h4>
                        <p>Timeless pieces that transcend trends and seasons.</p>
                    </div>
                    <div class="herovia-value-item">
                        <span class="herovia-value-icon">↗</span>
                        <h4>Ethically Made</h4>
                        <p>Created with respect for the craft and the people behind it.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('components.footer')

    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    <div class="mobile-sticky-cta" id="mobile-sticky-cta"></div>
</div>

<script>window.API_BASE_URL = "{{ env('API_BASE_URL') }}";</script>
<script src="{{ asset('mobile/script.js') }}"></script>
<script src="{{ asset('mobile/search.js') }}"></script>
@include('mobile.auth.auth')
</body>
</html>