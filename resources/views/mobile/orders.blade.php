<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>My Orders | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/orders.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="orders-page">
    <header class="site-header" id="site-header"></header>
    
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
    
    <footer class="site-footer" id="site-footer"></footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    
    <script src="{{ asset('mobile/script.js') }}"></script>
    <script src="{{ asset('mobile/orders.js') }}"></script>
</body>
</html>