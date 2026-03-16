<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/wishlist.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="wishlist-page" data-page="wishlist">

<!-- Common Header -->
<header class="site-header" id="site-header"></header>


<!-- Main Content -->
<main class="page-content">
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1>My Wishlist</h1>
            <span class="wishlist-count" id="wishlist-count">0 items</span>
        </div>
        
        <div id="wishlist-grid" class="wishlist-grid">
            <!-- Wishlist items will be loaded here -->
        </div>
    </div>
</main>

<!-- Common Footer -->
<footer class="site-footer" id="site-footer"></footer>

<!-- Mobile Bottom Navigation -->
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

<script src="{{ asset('mobile/script.js') }}"></script>
<script src="{{ asset('mobile/wishlist.js') }}"></script>

</body>
</html>