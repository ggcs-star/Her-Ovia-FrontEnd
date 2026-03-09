<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Product Details | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mobile/product-styles.css') }}">
</head>
<body class="product-detail-page" data-page="product-detail" data-slug="{{ request()->route('slug') }}">

<main class="page-content">
    <div class="container">
        <div id="product-container">
            <div class="loading">Loading product details...</div>
        </div>
    </div>
</main>

<!-- Size Chart Popup -->
<div class="pdp-size-popup" id="sizeChartPopup" onclick="hideSizeChart()">
    <div class="pdp-size-popup-content" onclick="event.stopPropagation()">
        <div class="pdp-size-popup-header">
            <h3>Size Chart</h3>
            <span class="pdp-size-popup-close" onclick="hideSizeChart()">×</span>
        </div>
        <div class="pdp-size-popup-body">
            <table class="pdp-size-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Bust</th>
                        <th>Waist</th>
                        <th>Hip</th>
                        <th>Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>S</td><td>34</td><td>26</td><td>36</td><td>45</td></tr>
                    <tr><td>M</td><td>36</td><td>28</td><td>38</td><td>46</td></tr>
                    <tr><td>L</td><td>38</td><td>30</td><td>40</td><td>46</td></tr>
                    <tr><td>XL</td><td>40</td><td>32</td><td>42</td><td>46</td></tr>
                    <tr><td>XXL</td><td>42</td><td>34</td><td>44</td><td>46</td></tr>
                </tbody>
            </table>
            <!-- <div class="pdp-measure-link" onclick="alert('How to Measure guide coming soon!')">How to Measure ›</div> -->
        </div>
    </div>
</div>

<!-- Color Popup -->
<div class="pdp-color-popup" id="colorPopup" onclick="hideColorPopup()">
    <div class="pdp-color-popup-content" onclick="event.stopPropagation()">
        <div class="pdp-color-popup-header">
            <h3>All Colors</h3>
            <span class="pdp-color-popup-close" onclick="hideColorPopup()">×</span>
        </div>
        <div class="pdp-color-popup-body" id="colorPopupBody"></div>
    </div>
</div>

<script src="{{ asset('mobile/product-detail.js') }}"></script>

</body>
</html>