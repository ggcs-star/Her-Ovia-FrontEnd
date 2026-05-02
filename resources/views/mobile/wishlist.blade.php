<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | RADIANT JEWEL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/wishlist.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="wishlist-page" data-page="wishlist">

<header class="site-header" id="site-header"></header>


<main class="page-content">
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1>My Wishlist</h1>
            <span class="wishlist-count" id="wishlist-count">0 items</span>
        </div>
        
        <div id="wishlist-grid" class="wishlist-grid">
            
        </div>
    </div>
</main>

@include('components.footer')
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script src="{{ asset('mobile/script.js') }}"></script>
<script src="{{ asset('mobile/wishlist.js') }}"></script>
@include('mobile.auth.auth')

</body>
</html>