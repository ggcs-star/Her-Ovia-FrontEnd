<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Trending Reels | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/trends.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="trends-page">
    <header class="site-header" id="site-header"></header>
    
    <main class="trends-content">
        <div class="trends-container" id="trendsContainer">
            <div class="loading-spinner">Loading reels...</div>
        </div>
    </main>
    
    <footer class="site-footer" id="site-footer"></footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    
    <script src="{{ asset('mobile/script.js') }}"></script>
    <script src="{{ asset('mobile/trends.js') }}"></script>
</body>
</html>