<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>All Categories | Her-Ovia</title>
    <meta name="description" content="Browse all clothing categories at Her-Ovia including co-ord sets, dresses, kurta sets and more.">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/categories/category-styles.css') }}">
</head>
<body data-page="all-categories">
 <div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>

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