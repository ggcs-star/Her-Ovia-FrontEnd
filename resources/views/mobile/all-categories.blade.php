<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover"
    >

    <title>All Categories | Her-Ovia</title>

    <meta
        name="description"
        content="Browse all clothing categories at Her-Ovia including co-ord sets, dresses, kurta sets and more."
    >
    <meta name="robots" content="index,follow">
    <meta name="author" content="Her-Ovia">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">

    <link
        rel="stylesheet"
        href="{{ asset('mobile/style.css') }}?v={{ time() }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('mobile/categories/category-styles.css') }}?v={{ time() }}"
    >
</head>

<body data-page="categories">

<div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>

<main class="categories-page">

    <div class="categories-heading">

        <div>
            <h2>All Categories</h2>

            <p>
                Discover our complete collection of elegant styles,
                everyday essentials and festive wear.
            </p>
        </div>

        <div class="categories-benefits">

            <div class="category-benefit">
                <span aria-hidden="true">♢</span>

                <div>
                    <strong>Free Shipping</strong>
                    <small>Above ₹999</small>
                </div>
            </div>

            <div class="category-benefit">
                <span aria-hidden="true">◇</span>

                <div>
                    <strong>Premium Quality</strong>
                    <small>Made for you</small>
                </div>
            </div>

            <div class="category-benefit">
                <span aria-hidden="true">↻</span>

                <div>
                    <strong>Easy Returns</strong>
                    <small>Hassle free</small>
                </div>
            </div>

            <div class="category-benefit">
                <span aria-hidden="true">♡</span>

                <div>
                    <strong>24/7 Support</strong>
                    <small>We're here</small>
                </div>
            </div>

        </div>

    </div>

    <div class="categories-main-layout">

        <aside class="categories-sidebar">

            <div
                class="categories-sidebar-title"
                id="categories-sidebar-toggle"
            >
                <h2>Explore Categories</h2>
            </div>

            <div id="categories-sidebar-list">

                <div class="category-sidebar-loading">
                    Loading categories...
                </div>

            </div>

        </aside>

        <section class="categories-content">

            <section
                class="categories-hero"
                id="categories-hero"
                aria-label="Category promotional banner"
            >
                <div
                    class="categories-hero-image"
                    id="category-hero-image"
                ></div>
            </section>

            <section class="category-section">

                <div class="category-section-heading">

                    <div>
                        <span class="section-eyebrow">
                            DISCOVER
                        </span>

                        <h2>Explore Her-Ovia</h2>
                    </div>

                </div>

                <div
                    class="main-category-cards"
                    id="main-category-cards"
                ></div>

            </section>

            <section class="category-section">

                <div class="category-section-heading">

                    <div>
                        <span class="section-eyebrow">
                            EXPLORE MORE
                        </span>

                        <h2>Shop by Style</h2>
                    </div>

                    <span
                        class="category-count-label"
                        id="subcategory-count"
                    ></span>

                </div>

                <div
                    class="featured-subcategories"
                    id="featured-subcategories"
                ></div>

            </section>
            <section class="category-section category-products-section" id="you-may-also-like">
                <div class="category-section-heading">
                    <div>
                    <span class="section-eyebrow">RECOMMENDED FOR YOU</span>
                    <h2>You May Also Like</h2>
                    </div>
                </div>

                <div
                    class="category-product-grid"
                    id="top-selling-products"
                    aria-live="polite"
                ></div>
            </section>

        </section>

    </div>

</main>

@include('components.footer')

<nav
    class="mobile-bottom-nav"
    id="mobile-bottom-nav"
    aria-label="Mobile navigation"
></nav>

<script>
    window.API_BASE_URL = @json(env('API_BASE_URL'));
    window.S3_BASE_URL = @json(env('S3_BASE_URL'));
</script>

<script src="{{ asset('mobile/script.js') }}?v={{ time() }}"></script>

<script
    src="{{ asset('mobile/categories/all-categories.js') }}?v={{ time() }}"
></script>

@include('mobile.auth.auth')

</body>
</html>
