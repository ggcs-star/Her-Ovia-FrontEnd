<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>My Wishlist | MAHERA JEWEL</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/mjlogo.jpeg') }}">
    <meta name="description" content="View and manage your saved items. Shop your favorite jewellery pieces anytime.">
    <meta name="robots" content="noindex, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('mobile/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('mobile/style.css') }}"></noscript>
    <link rel="stylesheet" href="{{ asset('mobile/wishlist.css') }}">
</head>
<body class="wishlist-page" data-page="wishlist">

<header class="site-header" id="site-header"></header>

<main class="page-content">
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1>My Wishlist</h1>
            <span class="wishlist-count" id="wishlist-count">0 items</span>
        </div>
        <div id="wishlist-grid" class="wishlist-grid"></div>
    </div>
</main>

@include('components.footer')
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script src="{{ asset('mobile/script.js') }}" defer></script>
<script src="{{ asset('mobile/wishlist.js') }}" defer></script>
@include('mobile.auth.auth')

</body>
</html>