<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>Order Details | RAPID RETAIL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            overflow-x: hidden;
        }

        .order-app {
            min-height: 100vh;
            background: #f1f5f9;
        }

        .order-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        @media (min-width: 768px) {
            .order-container {
                padding: 24px 24px;
            }
        }

        @media (min-width: 1024px) {
            .order-container {
                padding: 32px 40px;
            }
        }

        .order-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        @media (min-width: 1024px) {
            .order-grid {
                display: grid;
                grid-template-columns: 1fr 380px;
                gap: 28px;
                align-items: start;
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {
            .order-grid {
                gap: 20px;
            }
        }

        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e9eef3;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        @media (min-width: 768px) {
            .card {
                border-radius: 24px;
            }
        }

        @media (min-width: 1024px) {
            .card {
                border-radius: 28px;
            }
        }

        .card-header {
            padding: 16px 18px;
            border-bottom: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (min-width: 768px) {
            .card-header {
                padding: 18px 22px;
            }
        }

        @media (min-width: 1024px) {
            .card-header {
                padding: 20px 24px;
            }
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .card-header-left {
                gap: 12px;
            }
        }

        .card-icon {
            width: 36px;
            height: 36px;
            background: #ffe8f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ff3f6c;
        }

        @media (min-width: 768px) {
            .card-icon {
                width: 40px;
                height: 40px;
                font-size: 20px;
                border-radius: 14px;
            }
        }

        @media (min-width: 1024px) {
            .card-icon {
                width: 44px;
                height: 44px;
                font-size: 22px;
            }
        }

        .card-title {
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
        }

        @media (min-width: 768px) {
            .card-title {
                font-size: 17px;
            }
        }

        @media (min-width: 1024px) {
            .card-title {
                font-size: 18px;
            }
        }

        .card-body {
            padding: 18px;
        }

        @media (min-width: 768px) {
            .card-body {
                padding: 20px;
            }
        }

        @media (min-width: 1024px) {
            .card-body {
                padding: 24px;
            }
        }

        .hero-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff5f8 100%);
            border: 1px solid #ffe0e8;
            border-radius: 20px;
            padding: 18px 18px;
            margin-bottom: 0;
        }

        @media (min-width: 768px) {
            .hero-card {
                padding: 22px 24px;
                border-radius: 24px;
            }
        }

        @media (min-width: 1024px) {
            .hero-card {
                padding: 28px 28px;
                border-radius: 28px;
            }
        }

        .order-id {
            font-size: 16px;
            font-weight: 800;
            background: linear-gradient(135deg, #ff3f6c, #ff8a5c);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        @media (min-width: 768px) {
            .order-id {
                font-size: 18px;
            }
        }

        @media (min-width: 1024px) {
            .order-id {
                font-size: 20px;
            }
        }

        .payment-badge {
            background: #fff0f3;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid #ffe0e8;
            color: #ff3f6c;
        }

        @media (min-width: 768px) {
            .payment-badge {
                padding: 5px 14px;
                font-size: 12px;
            }
        }

        @media (min-width: 1024px) {
            .payment-badge {
                padding: 6px 16px;
                font-size: 13px;
            }
        }

        .order-total {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -1px;
        }

        @media (min-width: 768px) {
            .order-total {
                font-size: 36px;
            }
        }

        @media (min-width: 1024px) {
            .order-total {
                font-size: 42px;
            }
        }

        .step-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .step-item-wrapper {
            display: flex;
            position: relative;
        }

        .step-icon-box {
            width: 40px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @media (min-width: 768px) {
            .step-icon-box {
                width: 44px;
            }
        }

        @media (min-width: 1024px) {
            .step-icon-box {
                width: 48px;
            }
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 32px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            z-index: 2;
        }

        @media (min-width: 768px) {
            .step-dot {
                width: 34px;
                height: 34px;
                font-size: 15px;
            }
        }

        @media (min-width: 1024px) {
            .step-dot {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
        }

        .step-dot.completed {
            background: #ff3f6c;
            color: white;
        }

        .step-dot.active {
            background: #ff3f6c;
            color: white;
            box-shadow: 0 0 0 4px rgba(255, 63, 108, 0.15);
        }

        .step-connector-line {
            width: 2px;
            background: #e2e8f0;
            flex: 1;
            margin: 4px 0;
            min-height: 28px;
        }

        .step-content-box {
            flex: 1;
            padding-bottom: 20px;
            padding-left: 10px;
        }

        @media (min-width: 768px) {
            .step-content-box {
                padding-bottom: 22px;
                padding-left: 12px;
            }
        }

        @media (min-width: 1024px) {
            .step-content-box {
                padding-bottom: 24px;
            }
        }

        .step-label-text {
            font-weight: 700;
            font-size: 14px;
            color: #0f172a;
        }

        @media (min-width: 768px) {
            .step-label-text {
                font-size: 14.5px;
            }
        }

        @media (min-width: 1024px) {
            .step-label-text {
                font-size: 15px;
            }
        }

        .step-date {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }

        @media (min-width: 768px) {
            .step-date {
                font-size: 11.5px;
            }
        }

        @media (min-width: 1024px) {
            .step-date {
                font-size: 12px;
            }
        }

        .product-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            background: #fafcff;
            border-radius: 16px;
            margin-bottom: 10px;
            border: 1px solid #eff3f8;
        }

        @media (min-width: 768px) {
            .product-item {
                gap: 14px;
                padding: 14px;
                border-radius: 18px;
                margin-bottom: 12px;
            }
        }

        @media (min-width: 1024px) {
            .product-item {
                gap: 16px;
                padding: 16px;
                border-radius: 20px;
            }
        }

        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            object-fit: cover;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .product-img {
                width: 80px;
                height: 80px;
                border-radius: 16px;
            }
        }

        @media (min-width: 1024px) {
            .product-img {
                width: 88px;
                height: 88px;
            }
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.4;
            color: #0f172a;
            margin-bottom: 5px;
        }

        @media (min-width: 768px) {
            .product-name {
                font-size: 14.5px;
            }
        }

        @media (min-width: 1024px) {
            .product-name {
                font-size: 15px;
            }
        }

        .product-variant {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
        }

        @media (min-width: 768px) {
            .product-variant {
                font-size: 12.5px;
            }
        }

        @media (min-width: 1024px) {
            .product-variant {
                font-size: 13px;
            }
        }

        .price-quantity {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-top: 5px;
        }

        .price-current {
            font-weight: 800;
            font-size: 16px;
            color: #ff3f6c;
        }

        @media (min-width: 768px) {
            .price-current {
                font-size: 17px;
            }
        }

        @media (min-width: 1024px) {
            .price-current {
                font-size: 18px;
            }
        }

        .quantity-badge {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
        }

        @media (min-width: 768px) {
            .quantity-badge {
                padding: 4px 12px;
                font-size: 12.5px;
            }
        }

        @media (min-width: 1024px) {
            .quantity-badge {
                font-size: 13px;
            }
        }

        .price-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        @media (min-width: 768px) {
            .price-detail-row {
                padding: 11px 0;
                font-size: 13.5px;
            }
        }

        @media (min-width: 1024px) {
            .price-detail-row {
                padding: 12px 0;
                font-size: 14px;
            }
        }

        .price-detail-row.total {
            border-top: 2px solid #eef2f8;
            border-bottom: none;
            margin-top: 6px;
            padding-top: 14px;
            font-weight: 800;
            font-size: 16px;
        }

        .price-detail-row.total span:last-child {
            color: #ff3f6c;
        }

        @media (min-width: 768px) {
            .price-detail-row.total {
                font-size: 17px;
                padding-top: 15px;
            }
        }

        @media (min-width: 1024px) {
            .price-detail-row.total {
                font-size: 18px;
                padding-top: 16px;
            }
        }

        .address-display {
            background: #fafcff;
            border-radius: 16px;
            padding: 14px;
            border: 1px solid #eff3f8;
        }

        @media (min-width: 768px) {
            .address-display {
                padding: 16px;
                border-radius: 18px;
            }
        }

        @media (min-width: 1024px) {
            .address-display {
                padding: 18px;
                border-radius: 20px;
            }
        }

        .action-buttons-group {
            display: flex;
            gap: 10px;
            margin-top: 6px;
        }

        @media (min-width: 768px) {
            .action-buttons-group {
                gap: 12px;
                margin-top: 8px;
            }
        }

        .btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 13px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        @media (min-width: 768px) {
            .btn {
                padding: 13px 18px;
                font-size: 13.5px;
            }
        }

        @media (min-width: 1024px) {
            .btn {
                padding: 14px 20px;
                font-size: 14px;
            }
        }

        .btn-primary {
            background: #ff3f6c;
            color: white;
            box-shadow: 0 4px 12px rgba(255, 63, 108, 0.2);
        }

        .btn-primary:hover {
            background: #e6355a;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: white;
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        @media (max-width: 560px) {
            .action-buttons-group {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
            }
        }

        .status-badge-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
        }

        @media (min-width: 768px) {
            .status-badge-sm {
                padding: 5px 14px;
                font-size: 12.5px;
            }
        }

        @media (min-width: 1024px) {
            .status-badge-sm {
                font-size: 13px;
            }
        }

        .coupon-block {
            background: #fff5e6;
            border: 1px solid #ffd9b3;
            border-radius: 14px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
        }

        @media (min-width: 768px) {
            .coupon-block {
                padding: 11px 15px;
                border-radius: 15px;
            }
        }

        @media (min-width: 1024px) {
            .coupon-block {
                padding: 12px 16px;
            }
        }

        .savings-block {
            background: #ffe8f0;
            border-radius: 40px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 12px;
            color: #ff3f6c;
            margin-top: 14px;
        }

        @media (min-width: 768px) {
            .savings-block {
                padding: 9px 18px;
                font-size: 12.5px;
            }
        }

        @media (min-width: 1024px) {
            .savings-block {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .spinner {
            width: 44px;
            height: 44px;
            border: 3px solid #ffe8f0;
            border-top-color: #ff3f6c;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-box {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 24px;
        }

        @media (min-width: 768px) {
            .error-box {
                padding: 55px 24px;
                border-radius: 28px;
            }
        }

        @media (min-width: 1024px) {
            .error-box {
                padding: 60px 28px;
            }
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            border-bottom: 1px solid #f0f0f0;
            width: 100%;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-height: 56px;
        }


        @media (min-width: 768px) {
            .header-container {
                padding: 14px 24px;
            }
        }

        @media (min-width: 1024px) {
            .header-container {
                padding: 16px 32px;
            }
        }

        .logo-search-container {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 8px;
            background: #f5f5f6;
            border-radius: 30px;
            padding: 4px 4px 4px 12px;
            border: 1px solid #e0e0e0;
            min-width: 0;
        }
        .header-logo {
            flex-shrink: 0;
        }

        .site-logo {
            height: 28px;
            width: auto;
            max-width: 70px;
            object-fit: contain;
        }

        @media (min-width: 768px) {
            .site-logo {
                height: 32px;
                max-width: 100px;
            }
        }

       .search-wrapper {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 4px;
            min-width: 0;
        }

        .search-wrapper input {
            flex: 1;
            border: none;
            background: none;
            outline: none;
            font-size: 13px;
            padding: 8px 0;
            min-width: 0;
            width: 100%;
        }

        @media (min-width: 768px) {
            .search-wrapper input {
                font-size: 13px;
                padding: 8px 0;
            }
        }

        .search-wrapper input::placeholder {
            color: #999;
            font-size: 12px;
        }

        .search-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .search-icon {
                font-size: 16px;
                padding: 6px 10px;
            }
        }

        
        .search-icon-btn svg {
    width: 20px;
    height: 20px;
    stroke: #666;
    stroke-width: 2;
}

.header-icons {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}

.header-icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    color: #333;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}


        @media (min-width: 768px) {
            .header-icon-btn {
                font-size: 20px;
                width: 36px;
                height: 36px;
            }
        }

        .header-icon-btn svg {
    width: 22px;
    height: 22px;
    stroke: #333;
    stroke-width: 2;
    fill: none;
}

.back-btn-header {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #333;
    flex-shrink: 0;
    font-weight: 500;
}

        @media (min-width: 768px) {
            .back-btn-header {
                width: 36px;
                height: 36px;
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            .header-logo {
                display: none;
            }
        }
        @keyframes slideUpToast {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        }

        .toast-message {
        animation: slideUpToast 0.3s ease;
        }
        @media (min-width: 375px) and (max-width: 480px) {
    .header-container {
        padding: 10px 12px;
        gap: 8px;
    }
    
    .logo-search-container {
        gap: 6px;
        padding: 4px 4px 4px 10px;
    }
    
    .site-logo {
        height: 26px;
        max-width: 65px;
    }
    
    .search-wrapper input {
        font-size: 12px;
        padding: 7px 0;
    }
    
    .search-wrapper input::placeholder {
        font-size: 11px;
    }
    
    .header-icon-btn {
        width: 32px;
        height: 32px;
    }
    
    .header-icon-btn svg {
        width: 20px;
        height: 20px;
    }
    
    .back-btn-header {
        width: 32px;
        height: 32px;
        font-size: 22px;
    }
}
@media (max-width: 374px) {
    .header-container {
        padding: 8px 10px;
        gap: 6px;
    }
    
    .logo-search-container {
        gap: 4px;
        padding: 3px 3px 3px 8px;
    }
    
    .site-logo {
        height: 24px;
        max-width: 55px;
    }
    
    .search-wrapper input {
        font-size: 11px;
        padding: 6px 0;
    }
    
    .search-wrapper input::placeholder {
        font-size: 10px;
    }
    
    .search-icon-btn {
        padding: 4px 6px;
    }
    
    .search-icon-btn svg {
        width: 18px;
        height: 18px;
    }
    
    .header-icon-btn {
        width: 28px;
        height: 28px;
    }
    
    .header-icon-btn svg {
        width: 18px;
        height: 18px;
    }
    
    .back-btn-header {
        width: 28px;
        height: 28px;
        font-size: 20px;
    }
}

/* Large phones (481px - 768px) */
@media (min-width: 481px) and (max-width: 768px) {
    .header-container {
        padding: 12px 16px;
        gap: 12px;
    }
    
    .logo-search-container {
        gap: 10px;
        padding: 5px 5px 5px 14px;
    }
    
    .site-logo {
        height: 32px;
        max-width: 90px;
    }
    
    .search-wrapper input {
        font-size: 14px;
        padding: 9px 0;
    }
    
    .search-wrapper input::placeholder {
        font-size: 13px;
    }
    
    .search-icon-btn svg {
        width: 22px;
        height: 22px;
    }
    
    .header-icon-btn {
        width: 40px;
        height: 40px;
    }
    
    .header-icon-btn svg {
        width: 24px;
        height: 24px;
    }
    
    .back-btn-header {
        width: 40px;
        height: 40px;
        font-size: 26px;
    }
}

/* Hide logo on very small screens if needed */
@media (max-width: 360px) {
    .header-logo {
        display: none;
    }
    
    .logo-search-container {
        padding-left: 12px;
    }
}

/* Tablet (769px - 1024px) */
@media (min-width: 769px) and (max-width: 1024px) {
    .header-container {
        padding: 14px 24px;
        gap: 16px;
    }
    
    .site-logo {
        height: 34px;
        max-width: 100px;
    }
    
    .search-wrapper input {
        font-size: 14px;
    }
    
    .header-icon-btn {
        width: 42px;
        height: 42px;
    }
}

@media (min-width: 1025px) {
    .site-header {
        display: block;
    }
}
body.order-confirmation-page .site-header {
    padding-top: calc(12px + env(safe-area-inset-top));
}

    </style>
</head>
<body>
    <header class="site-header" id="site-header"></header>

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
        const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';
        const token = localStorage.getItem('token');
        const orderId = '{{ $orderId }}';

        if (!token) {
            window.location.href = '/user/login';
        }

function renderHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    const isDesktop = window.innerWidth >= 1025;
    
    if (isDesktop) {
        fetch('https://retailadmin.ggconsultancy.services/api/categories')
            .then(r => r.json())
            .then(data => {
                if (data.success && data.data) {
                    const categories = data.data.slice(0, 5);
                    const categoriesHtml = categories.map(cat => 
                        `<a href="/category/${cat.id}" class="nav-item">${cat.name.toUpperCase()}</a>`
                    ).join('');
                    
                    header.innerHTML = `
                        <div class="web-header">
                            <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
                            <div class="main-header">
                                <div class="logo-area">
                                    <a href="/" class="logo">RAPID RETAIL</a>
                                    <nav class="nav-menu">${categoriesHtml}</nav>
                                </div>
                                <div class="search-area">
                                    <div class="search-box">
                                        <input type="text" placeholder="Search for products, brands..." id="web-search-input">
                                        <button onclick="window.location.href='/search'">⌕</button>
                                    </div>
                                </div>
                                <div class="header-actions">
                                    <a href="${localStorage.getItem('token') ? '/profile' : '/login'}" class="action-link">Profile</a>
                                    <a href="/wishlist" class="action-link">Wishlist</a>
                                    <a href="/cart" class="action-link">Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="all-categories-popup" id="allCategoriesPopup" style="display:none;"></div>
                    `;
                    
                    const navItems = document.querySelectorAll('.nav-item');
                    const popup = document.getElementById('allCategoriesPopup');
                    
                    navItems.forEach(item => {
                        item.addEventListener('mouseenter', () => {
                            fetch('https://retailadmin.ggconsultancy.services/api/categories')
                                .then(r => r.json())
                                .then(res => {
                                    if (res.success && res.data) {
                                        const catsWithSub = res.data.filter(c => c.children && c.children.length > 0);
                                        let html = `<div style="max-width:1200px; margin:0 auto; padding:30px; display:grid; grid-template-columns:repeat(5,1fr); gap:25px;">`;
                                        const colSize = Math.ceil(catsWithSub.length / 5);
                                        for (let i = 0; i < 5; i++) {
                                            const col = catsWithSub.slice(i * colSize, (i + 1) * colSize);
                                            if (col.length) {
                                                html += `<div>`;
                                                col.forEach(cat => {
                                                    html += `<div style="margin-bottom:20px;"><h3 style="font-size:14px; font-weight:700; border-bottom:2px solid #ff3f6c; display:inline-block; margin-bottom:12px;">${cat.name}</h3><ul style="list-style:none; margin-top:12px;">`;
                                                    cat.children.slice(0,6).forEach(sub => {
                                                        html += `<li style="margin-bottom:8px;"><a href="/category/${sub.id}" style="text-decoration:none; color:#696b79; font-size:13px;">${sub.name}</a></li>`;
                                                    });
                                                    if (cat.children.length > 6) {
                                                        html += `<li><a href="/category/${cat.id}" style="color:#ff3f6c; font-size:11px;">+${cat.children.length-6} more →</a></li>`;
                                                    }
                                                    html += `</ul></div>`;
                                                });
                                                html += `</div>`;
                                            }
                                        }
                                        html += `</div>`;
                                        popup.innerHTML = html;
                                        popup.style.display = 'block';
                                    }
                                });
                        });
                        item.addEventListener('mouseleave', () => {
                            setTimeout(() => { popup.style.display = 'none'; }, 200);
                        });
                    });
                    popup.addEventListener('mouseenter', () => { popup.style.display = 'block'; });
                    popup.addEventListener('mouseleave', () => { popup.style.display = 'none'; });
                    
                    const webSearch = document.getElementById('web-search-input');
                    if (webSearch) {
                        webSearch.addEventListener('focus', () => {
                            window.location.href = '/search';
                        });
                    }
                }
            });
    } else {
        const showBackButton = document.body.classList.contains('order-confirmation-page');
        
        header.innerHTML = `
            <div class="container">
                <div class="header-container">
                    ${showBackButton ? '<button class="back-btn-header" onclick="goBack()">←</button>' : ''}
                    <div class="logo-search-container">
                        <div class="header-logo">
                            <a href="/">
                                <img src="/images/logo.jpg" alt="RAPID RETAIL" class="site-logo" 
                                    onerror="this.src='https://via.placeholder.com/100x35?text=RAPID'">
                            </a>
                        </div>
                        <div class="search-wrapper">
                            <input id="order-search" type="text" placeholder="Search for Category, Product ...">
                            <button class="search-icon-btn" onclick="window.location.href='/search'" style="background:none; border:none; cursor:pointer; padding:0;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="10" cy="10" r="7"/>
                                    <line x1="21" y1="21" x2="15" y2="15"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="header-icons">
                        <button class="header-icon-btn" onclick="window.location.href='/wishlist'">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        const searchInput = document.getElementById('order-search');
        if (searchInput) {
            searchInput.addEventListener('focus', () => {
                window.location.href = '/search';
            });
        }
    }
}

const style = document.createElement('style');
style.textContent = `
    .web-header { 
        background: white; 
        border-bottom: 1px solid #f0f0f0; 
        padding: 12px 40px; 
        position: relative;
        z-index: 1000;
    }
    .top-bar { background: #ff3f6c; color: white; text-align: center; padding: 8px; font-size: 12px; margin: -12px -40px 12px -40px; }
    .main-header { display: flex; align-items: center; justify-content: space-between; gap: 30px; }
    .logo-area { display: flex; align-items: center; gap: 40px; flex-shrink: 0; }
    .logo { font-size: 24px; font-weight: 800; color: #ff3f6c; text-decoration: none; }
    .nav-menu { display: flex; gap: 25px; }
    .nav-item { text-decoration: none; color: #282c3f; font-size: 14px; font-weight: 600; letter-spacing: 0.5px; cursor: pointer; }
    .nav-item:hover { color: #ff3f6c; }
    .search-area { flex: 1; max-width: 400px; }
    .search-box { display: flex; background: #f5f5f6; border-radius: 4px; overflow: hidden; }
    .search-box input { flex: 1; border: none; padding: 10px 15px; outline: none; font-size: 14px; background: transparent; }
    .search-box button { background: transparent; border: none; padding: 0 15px; cursor: pointer; font-size: 18px; color: #333; }
    .header-actions { display: flex; gap: 25px; flex-shrink: 0; }
    .action-link { text-decoration: none; color: #282c3f; font-size: 14px; font-weight: 500; }
    .action-link:hover { color: #ff3f6c; }
    
    .all-categories-popup {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1001;
        border-top: 1px solid #f0f0f0;
    }
    
    @media (max-width: 1024px) { 
        .web-header { display: none; } 
        .all-categories-popup { display: none; }
    }
`;
document.head.appendChild(style);
renderHeader();
window.addEventListener('resize', () => renderHeader());
        function goBack() {
            window.history.back();
        }

        window.goBack = goBack;

        function formatMoney(amount) {
            return `₹${Number(amount || 0).toFixed(2)}`;
        }

        function formatLongDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        function formatTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
        }

        function formatShortDateTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleString('en-IN', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
        }

        const statusMap = {
            pending: { label: 'Order Placed', icon: '⏳', color: '#f59e0b', bg: '#fffbeb' },
            confirmed: { label: 'Confirmed', icon: '✅', color: '#3b82f6', bg: '#eff6ff' },
            processing: { label: 'Processing', icon: '⚙️', color: '#8b5cf6', bg: '#f5f3ff' },
            shipped: { label: 'Shipped', icon: '🚚', color: '#ec489a', bg: '#fdf2f8' },
            delivered: { label: 'Delivered', icon: '📦', color: '#10b981', bg: '#ecfdf5' },
            cancelled: { label: 'Cancelled', icon: '❌', color: '#ef4444', bg: '#fef2f2' }
        };

        const stepsConfig = [
            { key: 'pending', label: 'Order Placed', icon: '📦', timeKey: 'created_at' },
            { key: 'confirmed', label: 'Confirmed', icon: '✅', timeKey: 'confirmed_at' },
            { key: 'processing', label: 'Processing', icon: '⚙️', timeKey: 'processing_at' },
            { key: 'shipped', label: 'Shipped', icon: '🚚', timeKey: 'shipped_at' },
            { key: 'delivered', label: 'Delivered', icon: '🏠', timeKey: 'delivered_at' }
        ];

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function renderOrderDetails(order) {
                window.currentOrder = order; // ADD THIS

            if (!order) {
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Order data unavailable</div>';
                return;
            }

            const statusKey = order.status || 'pending';
            const statusInfo = statusMap[statusKey] || statusMap.pending;
            const isCancelled = statusKey === 'cancelled';

            const subtotal = parseFloat(order.subtotal) || 0;
            const shipping = parseFloat(order.shipping) || 0;
            const discount = parseFloat(order.discount) || 0;
            const platformFee = parseFloat(order.platform_fee) || 0;
            const tax = parseFloat(order.tax) || 0;
            const total = parseFloat(order.total) || (subtotal + shipping + tax + platformFee - discount);
            const totalSavings = discount;

            let paymentText = 'Cash on Delivery';
            let paymentIcon = '💵';
            if (
                order.payment_status === 'paid'
            ) {
                paymentText = 'Online Payment';
                paymentIcon = '💳';
            }
            else if (
                order.payment_method === 'cod' ||
                order.payment_method === 'COD'
            ) {
                paymentText = 'Cash on Delivery';
                paymentIcon = '💵';
            }
            const addr = order.shipping_address || {};
            const fullName = addr.full_name || addr.name || 'Customer';
            const phone = addr.phone || '';
            const addressLine1 = addr.address_line1 || addr.address_line_1 || '';
            const addressLine2 = addr.address_line2 || addr.address_line_2 || '';
            const city = addr.city || '';
            const state = addr.state || '';
            const pincode = addr.pincode || addr.postal_code || '';
            const hasAddress = fullName && (addressLine1 || city);

            let trackerHtml = '';
            if (!isCancelled) {
                const currentIdx = stepsConfig.findIndex(s => s.key === statusKey);
                trackerHtml = `<div class="step-list">`;
                stepsConfig.forEach((step, idx) => {
                    const isCompleted = idx <= currentIdx;
                    const isActive = idx === currentIdx;
                    let stepTime = '';
                    if (step.timeKey && order[step.timeKey]) {
                        stepTime = formatShortDateTime(order[step.timeKey]);
                    } else if (step.key === 'pending' && order.created_at) {
                        stepTime = formatShortDateTime(order.created_at);
                    }

                    trackerHtml += `
                        <div class="step-item-wrapper">
                            <div class="step-icon-box">
                                <div class="step-dot ${isCompleted ? 'completed' : (isActive ? 'active' : '')}">
                                    ${step.icon}
                                </div>
                                ${idx < stepsConfig.length - 1 ? `<div class="step-connector-line"></div>` : ''}
                            </div>
                            <div class="step-content-box">
                                <div class="step-label-text">${step.label}</div>
                                ${stepTime ? `<div class="step-date">🕒 ${stepTime}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
                trackerHtml += `</div>`;
            } else {
                const cancelTime = order.cancelled_at ? formatShortDateTime(order.cancelled_at) : '';
                trackerHtml = `
                    <div class="step-item-wrapper">
                        <div class="step-icon-box">
                            <div class="step-dot" style="background:#ef4444; color:white;">❌</div>
                        </div>
                        <div class="step-content-box">
                            <div class="step-label-text">Order Cancelled</div>
                            ${cancelTime ? `<div class="step-date">📅 ${cancelTime}</div>` : ''}
                        </div>
                    </div>
                `;
            }

            let itemsHtml = '';
            if (order.items && order.items.length) {
                order.items.forEach(item => {
                    let imgUrl = item.image || '';
                    if (imgUrl && !imgUrl.startsWith('http')) {
                        imgUrl = `https://inventorydata-s3-bucket.s3.amazonaws.com/${imgUrl}`;
                    }
                    const variantText = item.variant ? 
                        `${item.variant.variant?.name || ''}: ${item.variant.value?.value || ''}` : '';
                    const itemPrice = parseFloat(item.price) || 0;
                    const qty = parseInt(item.quantity) || 1;

                    itemsHtml += `
                        <div class="product-item">
                            <img class="product-img" src="${imgUrl || 'https://via.placeholder.com/88x88?text=Item'}" 
                                 onerror="this.src='https://via.placeholder.com/88x88?text=Product'">
                            <div class="product-info">
                                <div class="product-name">${escapeHtml(item.product_name || 'Product')}</div>
                                ${variantText ? `<div class="product-variant">${escapeHtml(variantText)}</div>` : ''}
                                <div class="price-quantity">
                                    <span class="price-current">${formatMoney(itemPrice)}</span>
                                    <span class="quantity-badge">Qty: ${qty}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                itemsHtml = `<div style="text-align:center; padding:28px; color:#64748b;">No items available</div>`;
            }

            const priceRows = `
                <div class="price-detail-row"><span>Subtotal</span><span>${formatMoney(subtotal)}</span></div>
                <div class="price-detail-row"><span>Shipping</span><span>${shipping > 0 ? formatMoney(shipping) : 'Free'}</span></div>
                <div class="price-detail-row"><span>Platform Fee</span><span>${formatMoney(platformFee)}</span></div>
                <div class="price-detail-row"><span>Tax (GST)</span><span>${formatMoney(tax)}</span></div>
                ${discount > 0 ? `<div class="price-detail-row" style="color:#10b981;"><span>Discount</span><span>-${formatMoney(discount)}</span></div>` : ''}
                <div class="price-detail-row total"><span>Total Amount</span><span style="color:#2563eb;">${formatMoney(total)}</span></div>
            `;

            const couponHtml = order.coupon_code ? `
                <div class="coupon-block">
                    <span style="font-size:18px;">🏷️</span>
                    <span style="font-weight:600;">Coupon: ${escapeHtml(order.coupon_code)}</span>
                </div>
            ` : '';

            const savingsHtml = totalSavings > 0 ? `
                <div style="text-align:center;">
                    <div class="savings-block">💰 You saved ${formatMoney(totalSavings)}</div>
                </div>
            ` : '';

            const addressHtml = hasAddress ? `
                <div class="address-display">
                    <div style="font-weight:700; margin-bottom:5px;">${escapeHtml(fullName)}</div>
                    ${phone ? `<div style="font-size:12px; color:#5e6f8d; margin-bottom:8px;">📞 ${escapeHtml(phone)}</div>` : ''}
                    <div style="font-size:13px; line-height:1.5; color:#334155;">
                        ${escapeHtml(addressLine1)}${addressLine2 ? ', ' + escapeHtml(addressLine2) : ''}<br>
                        ${escapeHtml(city)}${state ? ', ' + escapeHtml(state) : ''} ${pincode ? ' - ' + escapeHtml(pincode) : ''}
                    </div>
                </div>
            ` : '';

            const mainColumnHtml = `
                <div class="hero-card">
                    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:10px; margin-bottom:12px;">
                        <div class="order-id">#${order.order_number || order.id}</div>
                        <div class="payment-badge">${paymentIcon} ${paymentText}</div>
                    </div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:14px;">📅 ${formatLongDate(order.created_at)} • ${formatTime(order.created_at)}</div>
                    <div class="order-total">${formatMoney(total)}</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">📍</div>
                            <div class="card-title">Order Tracker</div>
                        </div>
                        <div class="status-badge-sm" style="background:${statusInfo.bg}; color:${statusInfo.color};">
                            ${statusInfo.icon} ${statusInfo.label}
                        </div>
                    </div>
                    <div class="card-body">
                        ${trackerHtml}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🛍️</div>
                            <div class="card-title">Order Items (${order.items?.length || 0})</div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${itemsHtml}
                    </div>
                </div>
            `;

            const sidebarHtml = `
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">💰</div>
                            <div class="card-title">Payment Summary</div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${priceRows}
                        ${couponHtml}
                        ${savingsHtml}
                    </div>
                </div>

                ${hasAddress ? `
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🏠</div>
                            <div class="card-title">Delivery Address</div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${addressHtml}
                    </div>
                </div>
                ` : ''}

                <div class="card" style="border: none; background: transparent; box-shadow: none;">
                    <div class="action-buttons-group">
                        <button class="btn btn-primary" id="viewOrdersDesktop">📋 View All Orders</button>
                        <button class="btn btn-secondary" id="continueShopDesktop">✨ Continue Shopping</button>
                    </div>
                </div>
            `;

            const finalGrid = `
                <div class="order-main">${mainColumnHtml}</div>
                <div class="order-sidebar">${sidebarHtml}</div>
            `;

            document.getElementById('order-root').innerHTML = finalGrid;

            document.getElementById('viewOrdersDesktop')?.addEventListener('click', () => window.location.href = '/orders');
            document.getElementById('continueShopDesktop')?.addEventListener('click', () => window.location.href = '/');
        }

        async function fetchOrderData() {
            if (!orderId || orderId === '') {
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Invalid Order ID</div>';
                return;
            }

            try {
                const timestamp = new Date().getTime();
                const res = await fetch(`${API_BASE_URL}/orders/${orderId}?_=${timestamp}`, {
                    headers: { 
                        'Authorization': `Bearer ${token}`, 
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache, no-store, must-revalidate',
                        'Pragma': 'no-cache'
                    }
                });
                const json = await res.json();
                let order = null;
                if (json.success && json.data) {
                    order = json.data;
                } else {
                    const lastRaw = localStorage.getItem('last_order');
                    if (lastRaw) {
                        const last = JSON.parse(lastRaw);
                        if (last.id == orderId) order = last;
                    }
                    if (!order) throw new Error('Order not found');
                }

                if (order.shipping_address_id && !order.shipping_address) {
                    try {
                        const addrRes = await fetch(`${API_BASE_URL}/user/addresses/${order.shipping_address_id}`, {
                            headers: { 'Authorization': `Bearer ${token}` }
                        });
                        const addrJson = await addrRes.json();
                        if (addrJson.success && addrJson.data) {
                            order.shipping_address = addrJson.data;
                        }
                    } catch(e) { console.warn('Address fetch failed'); }
                }

                renderOrderDetails(order);
                localStorage.setItem('last_order_cached', JSON.stringify(order));
                                const oldOrder = JSON.parse(localStorage.getItem('last_order_cached') || '{}');
                if (oldOrder.status !== order.status && order.status) {
                    const statusMessages = {
                        'pending': '⏳ Order Placed',
                        'confirmed': '✅ Order Confirmed!',
                        'processing': '⚙️ Order is being processed',
                        'shipped': '🚚 Order Shipped!',
                        'delivered': '📦 Order Delivered!',
                        'cancelled': '❌ Order Cancelled'
                    };
                    const message = statusMessages[order.status] || `Status updated to ${order.status}`;
                    const toast = document.createElement('div');
                    toast.className = 'toast-message info';
                    toast.textContent = message;
                    toast.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#ff3f6c;color:white;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:600;z-index:9999;animation:slideUpToast 0.3s ease;';
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            } catch (err) {
                console.error(err);
                const cached = localStorage.getItem('last_order_cached');
                if (cached) {
                    try {
                        const cachedOrder = JSON.parse(cached);
                        if (cachedOrder.id == orderId) {
                            renderOrderDetails(cachedOrder);
                            return;
                        }
                    } catch(e) {}
                }
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Failed to load order. Check connection.</div>';
            }
        }

        let refreshInterval;
            function startAutoRefresh() {
                if (refreshInterval) clearInterval(refreshInterval);
                refreshInterval = setInterval(() => fetchOrderData(), 5000);
            }

window.addEventListener('popstate', function(event) {
    window.location.replace('/orders');
});

history.pushState(null, null, window.location.href);


function handleBackToOrders() {
    window.location.replace('/orders');
}

document.querySelectorAll('.back-btn-header, [onclick="goBack()"]').forEach(btn => {
    btn.onclick = function(e) {
        e.preventDefault();
        window.location.replace('/orders');
    };
});

        document.body.classList.add('order-confirmation-page');
        renderHeader();
        fetchOrderData();
        startAutoRefresh();
    </script>
</body>
</html>