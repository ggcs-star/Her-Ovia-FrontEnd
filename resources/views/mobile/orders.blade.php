<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>My Orders | Her-Ovia</title>
    
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('mobile/orders.css') }}?v={{ time() }}">
</head>
<body class="orders-page">
     <div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>

    
    <main class="orders-content">
        <div class="orders-container">
            <div class="orders-header">
                <h1 class="page-title">My Orders</h1>
            </div>
            
            <div id="orders-list" class="orders-list">
                <div class="loading-spinner">Loading orders...</div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    
    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>
    <script src="{{ asset('mobile/script.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('mobile/orders.js') }}?v={{ time() }}"></script>
    @include('mobile.auth.auth')

</body>
</html>