<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>Order Details | Her-Ovia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <link rel="stylesheet" href="{{ asset('mobile/order-confirmation.css') }}">
</head>
<body class="order-confirmation-page" data-page="order-confirmation">

    <div class="desktop-sticky-header">
        <div class="herovia-announcement">
            Free Shipping on Orders Above ₹999 | Use Code: FIRST50
        </div>
        <header class="site-header" id="site-header"></header>
    </div>

    <div class="order-app">
        <div class="order-container">
            <div id="order-root" class="order-grid">
                <div class="loader-container" style="grid-column:1/-1">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
        window.ORDER_CONFIRMATION_ID = "{{ $orderId }}";
    </script>

    <script src="{{ asset('mobile/script.js') }}"></script>
    <script src="{{ asset('mobile/order-confirmation.js') }}"></script>

    @include('mobile.auth.auth')
</body>
</html>
