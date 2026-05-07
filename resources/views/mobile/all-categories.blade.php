<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>All Categories | RADIANT JEWEL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/categories/category-styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body data-page="all-categories">
<header class="site-header" id="site-header"></header>
<main class="page-content">
    <div class="categories-layout-web" id="categoriesLayoutWeb">
        <div class="categories-page-header">
            <h1>Shop by Category</h1>
            <p>Discover our exquisite collection of handcrafted jewellery</p>
        </div>
        <div class="all-categories-grid" id="all-categories-grid"></div>
    </div>
</main>
@include('components.footer')
<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    window.S3_BASE_URL = "{{ env('S3_BASE_URL') }}";
</script>
<script src="{{ asset('mobile/categories/all-categories.js') }}"></script>
@include('mobile.auth.auth')
</body>
</html>