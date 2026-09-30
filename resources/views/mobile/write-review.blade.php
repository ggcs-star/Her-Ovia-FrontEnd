<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Write a Review | Her-Ovia</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('mobile/write-review.css') }}?v={{ time() }}">
</head>
<body class="write-review-page" data-page="write-review">

    <div class="desktop-sticky-header">
        <div class="herovia-announcement">
            Free Shipping on Orders Above ₹999 | Use Code: FIRST50
        </div>
        <header class="site-header" id="site-header"></header>
    </div>

    <main class="write-review-content">
        <div class="write-review-container">

            <section class="write-review-hero">
                <div class="write-review-hero-copy">
                    <span class="write-review-eyebrow">YOUR EXPERIENCE MATTERS</span>
                    <h1>Write a Review</h1>
                    <p>
                        Share your experience and help other customers
                        find their perfect style.
                    </p>
                </div>

                <div class="write-review-hero-art">
                    <div class="write-review-hero-circle"></div>
                    <div class="write-review-hero-message">
                        Your Opinion
                        <br>
                        Makes a Difference
                        <span>♡</span>
                    </div>
                </div>
            </section>

            <div id="write-review-list">
                <div class="write-review-loading">
                    <div class="write-review-spinner"></div>
                    <p>Loading delivered products...</p>
                </div>
            </div>

        </div>
    </main>

    @include('components.footer')

    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>

    <script src="{{ asset('mobile/script.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('mobile/write-review.js') }}?v={{ time() }}"></script>

    @include('mobile.auth.auth')

</body>
</html>