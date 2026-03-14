<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Search</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial;
            background: #f6f6f6;
        }

        .search-header {
            position: sticky;
            top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: calc(env(safe-area-inset-top) + 8px) 12px 10px 12px;
            background: #fff;
            border-bottom: 1px solid #eee;
            z-index: 1000;
        }

        .back-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: none;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .search-box {
            flex: 1;
            display: flex;
            align-items: center;
            background: #f2f2f2;
            border-radius: 10px;
            padding: 0 10px;
            height: 40px;
        }

        .search-icon {
            margin-right: 6px;
            color: #777;
        }

        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
        }

        .clear-btn {
            display: none;
            cursor: pointer;
            color: #777;
        }

        .suggestions {
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .suggestion-item {
            padding: 12px;
            border-bottom: 1px solid #f3f3f3;
            font-size: 14px;
            cursor: pointer;
        }

        .results {
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .product {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .product img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .product-info {
            padding: 8px;
        }

        .product-name {
            font-size: 13px;
            font-weight: 600;
        }

        .product-price {
            font-size: 14px;
            font-weight: 700;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="search-header">
        <button class="back-btn" onclick="history.back()">←</button>
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input id="searchInput" class="search-input" placeholder="Search products">
            <span id="clearBtn" class="clear-btn">✕</span>
        </div>
    </div>

    <div id="suggestions" class="suggestions"></div>
    <div id="results" class="results"></div>

    <script src="/mobile/search.js"></script>
</body>
</html>