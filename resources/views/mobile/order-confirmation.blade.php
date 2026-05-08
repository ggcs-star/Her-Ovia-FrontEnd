<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>Order Details | RADIANT JEWEL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #440C2C;
            --accent: #F4B94E;
            --white: #ffffff;
            --gray-light: #f5f5f6;
            --gray-mid: #eaeaec;
            --gray-dark: #282c3f;
            --text-muted: #696b79;
            --success-green: #03a685;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-light);
            color: var(--gray-dark);
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
            background: #fff5f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--accent);
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
            background: linear-gradient(135deg, var(--primary), var(--accent));
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
            background: #fff5f0;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid #ffe0d9;
            color: var(--accent);
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
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            padding: 20px 0;
            margin: 0;
            position: relative;
        }

        .step-item-wrapper {
            position: relative;
            flex: 1;
            text-align: center;
            min-width: 0;
        }

        .step-icon-box {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 12px;
        }

        .step-dot {
            width: 44px;
            height: 44px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            position: relative;
            z-index: 10;
            color: #64748b;
        }

        .step-dot.completed {
            background: var(--accent);
            color: var(--primary);
        }

        .step-dot.active {
            background: var(--accent);
            color: var(--primary);
            box-shadow: 0 0 0 4px rgba(244, 185, 78, 0.2);
        }

        .step-connector-line {
            position: absolute;
            top: 22px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #e2e8f0;
            z-index: 1;
        }

        .step-connector-line.completed {
            background: var(--accent);
        }

        .step-content-box {
            padding: 0 6px;
        }

        .step-label-text {
            font-weight: 700;
            font-size: 12px;
            color: #0f172a;
            white-space: nowrap;
        }

        .step-date {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 6px;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .step-label-text {
                font-size: 10px;
                white-space: normal;
            }
            .step-date {
                font-size: 9px;
                white-space: normal;
            }
            .step-dot {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
            .step-connector-line {
                top: 18px;
            }
        }

        @media (min-width: 768px) {
            .step-dot {
                width: 48px;
                height: 48px;
                font-size: 22px;
            }
            .step-connector-line {
                top: 24px;
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
            color: var(--accent);
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
            color: var(--accent);
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
            background: var(--accent);
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(244, 185, 78, 0.2);
        }

        .btn-primary:hover {
            background: #e6a83b;
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
            background: #fff5f0;
            border-radius: 40px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 12px;
            color: var(--accent);
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
            border: 3px solid #fff5f0;
            border-top-color: var(--accent);
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
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            width: 100%;
            padding: 12px 0 !important;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px !important;
            padding: 8px 16px !important;
            width: 100%;
            min-height: auto !important;
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
            flex: 1;
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f5f5f6;
            border-radius: 30px;
            padding: 4px 8px;
            border: 1px solid #e0e0e0;
            min-width: 0;
        }
        .header-logo {
            flex-shrink: 0;
        }

        .site-logo {
            height: 32px !important;
            width: auto !important;
            max-width: 100px !important;
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
            background: transparent;
            outline: none;
            font-size: 13px;
            padding: 6px 0;
            min-width: 0;
            width: 100%;
            font-family: 'Inter', sans-serif;
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
            font-family: 'Inter', sans-serif;
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
            width: 18px;
            height: 18px;
            stroke: #666;
            stroke-width: 2;
        }

        .header-icons {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .header-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
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
                display: block;
            }
            .site-logo {
                display: block !important;
                height: 28px !important;
                max-width: 80px !important;
            }
        }
        
        @media (min-width: 481px) and (max-width: 768px) {
            .site-logo {
                height: 32px;
                max-width: 90px;
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
        
        .web-search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #eaeaec;
            border-radius: 8px;
            margin-top: 6px;
            z-index: 99999;
            max-height: 320px;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .web-suggestion-item {
            padding: 10px 14px;
            font-size: 14px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .web-suggestion-item:hover {
            background: #f5f5f5;
        }
        
        .cart-icon-wrapper {
            position: relative;
            display: inline-block;
        }

        #cart-count-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: var(--accent);
            color: var(--primary);
            font-size: 10px;
            font-weight: 600;
            min-width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .header-actions .action-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #333;
            text-decoration: none;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        .header-icon {
            width: 18px;
            height: 18px;
            display: inline-block;
            stroke: #333;
            fill: none;
        }

        .header-actions .action-link:hover .header-icon {
            stroke: var(--accent);
        }
        
        .web-header {
            padding: 0 !important;
            width: 100% !important;
        }
        
        .top-bar {
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary), var(--accent), var(--primary));
            background-size: 300% 100%;
            animation: gradientMove 4s ease infinite;
            color: white;
            text-align: center;
            padding: 8px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            margin: 0 !important;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .main-header {
            max-width: 100% !important;
            margin: 0 auto !important;
            padding: 12px 50px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo-area {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        
        .logo {
            font-size: 20px;
            font-weight: 800;
            color: #000;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
        }
        
        .nav-menu {
            display: flex;
            gap: 20px;
        }
        
        .nav-item {
            color: #333;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        
        .nav-item:hover {
            color: var(--accent);
        }
        
        .search-area {
            flex: 1;
            max-width: 550px;
            margin: 0 20px;
        }
        .search-box {
            display: flex;
            background: #f5f5f5;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        
        .search-box input {
            flex: 1;
            padding: 8px 12px;
            border: none;
            background: transparent;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
        }
        
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
        
        body.order-confirmation-page .site-header {
            padding-top: calc(12px + env(safe-area-inset-top));
        }
        
        @media (max-width: 360px) {
            .header-logo {
                display: none;
            }
            .logo-search-container {
                padding-left: 12px;
            }
        }
        .header-container .site-logo {
    height: 32px !important;
    width: auto !important;
    max-width: 100px !important;
}

.header-container .search-wrapper input {
    font-size: 12px !important;
    padding: 6px 0 !important;
}

.header-container .search-wrapper input::placeholder {
    font-size: 11px !important;
}

.header-container .search-icon-btn svg {
    width: 18px !important;
    height: 18px !important;
}

.header-container .header-icon-btn {
    width: 32px !important;
    height: 32px !important;
}

.header-container .header-icon-btn svg {
    width: 20px !important;
    height: 20px !important;
}

.header-container .back-btn-header {
    font-size: 20px !important;
    width: 32px !important;
    height: 32px !important;
}

@media (min-width: 768px) {
    .header-container .site-logo {
        height: 32px !important;
    }
    .header-container .search-wrapper input {
        font-size: 13px !important;
    }
    .header-container .header-icon-btn {
        width: 36px !important;
        height: 36px !important;
    }
}

@media (max-width: 480px) {
    .header-container .site-logo {
        height: 28px !important;
        max-width: 80px !important;
    }
}
.web-header .top-bar {
    background: linear-gradient(90deg, #440C2C, #F4B94E, #440C2C, #F4B94E, #440C2C);
    background-size: 300% 100%;
    animation: gradientMove 4s ease infinite;
    color: white;
    text-align: center;
    padding: 8px 0;
    font-size: 12px;
    font-weight: 500;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.web-header .main-header {
    max-width: 1200px;
    margin: 0 auto;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.web-header .logo-area {
    display: flex;
    align-items: center;
    gap: 30px;
    flex-shrink: 0;
}

.web-header .logo {
    font-size: 20px;
    font-weight: 800;
    color: #000;
    text-decoration: none;
    white-space: nowrap;
}

.web-header .logo img {
    height: 32px;
    width: auto;
    max-width: 120px;
    object-fit: contain;
}

.web-header .nav-menu {
    display: flex;
    gap: 20px;
}

.web-header .nav-item {
    color: #333;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.web-header .search-area {
    flex: 1;
    max-width: 550px;
    margin: 0 15px;
}

.web-header .search-box {
    display: flex;
    background: #f5f5f6;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #eaeaec;
    position: relative;
}

.web-header .search-box input {
    flex: 1;
    padding: 8px 12px;
    border: none;
    background: transparent;
    font-size: 12px;
    outline: none;
}

.web-header .search-box input::placeholder {
    color: #999;
    font-size: 12px;
}

.web-header .header-actions {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-shrink: 0;
}

.web-header .action-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #333;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
}

.web-header .header-icon {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
}

.web-header .cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

@media screen and (min-width: 1025px) {
    .site-header .header-container {
        display: none !important;
    }
    
    .web-header {
        display: block !important;
    }
}

@media screen and (max-width: 1024px) {
    .web-header {
        display: none !important;
    }
    
    .site-header .header-container {
        display: flex !important;
    }
}

.site-header .header-container .site-logo {
    height: 28px !important;
    width: auto !important;
    max-width: 80px !important;
}

.site-header .header-container .search-wrapper input {
    font-size: 12px !important;
    padding: 6px 0 !important;
}

.site-header .header-container .search-wrapper input::placeholder {
    font-size: 11px !important;
}

.site-header .header-container .header-icon-btn svg {
    width: 18px !important;
    height: 18px !important;
}

#cart-count-badge, #web-cart-count-badge {
    position: absolute;
    top: -8px;
    right: -12px;
    background: #440C2C;
    color: white;
    font-size: 10px;
    font-weight: 600;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}
.web-header .top-bar {
    background: linear-gradient(90deg, #440C2C, #882E5C, #440C2C, #882E5C, #440C2C);
    background-size: 300% 100%;
    animation: gradientMove 4s ease infinite;
    color: white;
    text-align: center;
    padding: 8px 0;
    font-size: 12px;
    font-weight: 500;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

#cart-count-badge, #web-cart-count-badge {
    position: absolute;
    top: -8px;
    right: -12px;
    background: #440C2C;
    color: #F4B94E;
    font-size: 10px;
    font-weight: 600;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}
.cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.web-header .action-link .cart-icon-wrapper svg {
    width: 18px;
    height: 18px;
}
.web-header .top-bar {
    background: linear-gradient(90deg, #440C2C, #F4B94E, #440C2C, #F4B94E, #440C2C);
    background-size: 300% 100%;
    animation: gradientMove 4s ease infinite;
    color: white;
    text-align: center;
    padding: 8px 0;
    font-size: 12px;
    font-weight: 500;
}

#cart-count-badge, #web-cart-count-badge {
    position: absolute;
    top: -8px;
    right: -12px;
    background: #440C2C;
    color: #F4B94E;
    font-size: 10px;
    font-weight: 600;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}

.cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.web-header .nav-item {
    color: #333;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    transition: color 0.2s;
}

.web-header .nav-item:hover {
    color: #F4B94E;
}

.web-header .nav-item:active,
.web-header .nav-item:focus,
.web-header .nav-item:visited {
    color: #333;
    background: transparent;
    outline: none;
}

.web-header .nav-item.active,
.web-header .nav-item[active] {
    color: #333;
    background: transparent;
}
#web-search-suggestions {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    width: 100% !important;
    background: white !important;
    border: 1px solid #ccc !important;
    z-index: 99999 !important;
    display: none;
}
.search-box,
.search-area,
.web-header .search-box,
.web-header .search-area {
    overflow: visible !important;
}

.web-header,
.main-header,
.logo-area,
.nav-menu {
    overflow: visible !important;
}
@media (min-width: 1025px) {
    .site-header .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .web-header {
        width: 100% !important;
    }
    
    .main-header {
        padding-left: 50px !important;
        padding-right: 50px !important;
    }
}
body, .site-header, .web-header, .main-header, .header-container, .header-actions, .action-link, .nav-item, .search-wrapper input, .search-wrapper input::placeholder, .btn, .card-title, .product-name, .price-detail-row, .step-label-text, .order-id, .payment-badge, .order-total {
    font-family: 'Inter', sans-serif !important;
}
.order-app .web-header .nav-menu {
    gap: 12px !important;
}

.order-app .web-header .nav-item {
    font-size: 11px !important;
    padding: 0 !important;
}

.order-app .web-header .main-header {
    padding: 8px 50px !important;
}

.order-app .web-header .logo-area {
    gap: 15px !important;
}

.order-app .web-header .logo img {
    height: 28px !important;
}
@media (max-width: 1024px) {
    .order-app .web-header .nav-item {
        font-size: 12px !important;
    }
    
    .order-app .web-header .nav-menu {
        gap: 8px !important;
    }
}
@media (min-width: 1025px) {
    .order-app .web-header .nav-menu {
        gap: 12px !important;
    }
    
    .order-app .web-header .nav-item {
        font-size: 12px !important;
    }
}
order-app .web-header .nav-item {
    font-size: 12px !important;
    padding: 0 6px !important;
    letter-spacing: 0.3px !important;
}

.order-app .web-header .nav-menu {
    gap: 8px !important;
}

.order-app .web-header .logo-area {
    gap: 20px !important;
}

.order-app .web-header .logo img {
    height: 32px !important;
}

.order-app .web-header .search-area {
    max-width: 380px !important;
    margin: 0 15px !important;
}

.order-app .web-header .search-box input {
    padding: 8px 14px !important;
    font-size: 13px !important;
}
.order-app .web-header .main-header {
    padding: 12px 40px !important;
}

* {
    -webkit-tap-highlight-color: transparent !important;
    -webkit-touch-callout: none !important;
}

.web-header .nav-menu {
    gap: 10px !important;
}

.web-header .nav-item {
    font-size: 12px !important;
    padding: 0 6px !important;
    letter-spacing: 0.3px !important;
    color: #333 !important;
}

.web-header .nav-item:active,
.web-header .nav-item:focus,
.web-header .nav-item:hover,
.web-header .nav-item:visited {
    color: #333 !important;
    background: transparent !important;
}

.web-header .action-link,
.web-header .action-link:active,
.web-header .action-link:focus,
.web-header .action-link:hover,
.web-header .action-link:visited {
    color: #333 !important;
    background: transparent !important;
}

.web-header .action-link .header-icon,
.web-header .action-link .header-icon:active,
.web-header .action-link .header-icon:focus,
.web-header .action-link .header-icon:hover,
.web-header .action-link .header-icon:visited {
    stroke: #333 !important;
    fill: none !important;
}

.web-header .cart-icon-wrapper svg,
.web-header .cart-icon-wrapper svg:active,
.web-header .cart-icon-wrapper svg:focus,
.web-header .cart-icon-wrapper svg:hover {
    stroke: #333 !important;
}

.header-container .header-icon-btn,
.header-container .header-icon-btn:active,
.header-container .header-icon-btn:focus,
.header-container .header-icon-btn:hover {
    color: #333 !important;
    background: transparent !important;
}

.header-container .header-icon-btn svg,
.header-container .header-icon-btn:active svg,
.header-container .header-icon-btn:focus svg,
.header-container .header-icon-btn:hover svg {
    stroke: #333 !important;
    fill: none !important;
}

.back-btn-header,
.back-btn-header:hover,
.back-btn-header:active,
.back-btn-header:focus {
    color: #333 !important;
    background: transparent !important;
}

.web-header .logo-area {
    gap: 15px !important;
}

.web-header .search-area {
    max-width: 420px !important;
}

.web-header .main-header {
    padding: 8px 30px !important;
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
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
    <script>
        const API_BASE_URL = window.API_BASE_URL;
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
        fetch(`${API_BASE_URL}/categories`)
            .then(r => r.json())
            .then(data => {
                if (data.success && data.data) {
                    const categories = data.data.slice(0, 5);
                    const categoriesHtml = categories.map(cat => {
                        let categorySlug = cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                        return `<a href="/collection/${categorySlug}" class="nav-item">${cat.name.toUpperCase()}</a>`;
                    }).join('');
                    
                    header.innerHTML = `
                        <div class="web-header">
                            <div class="top-bar">Free Shipping on Orders Above ₹999 | Use Code: FIRST50</div>
                            <div class="main-header">
                                <div class="logo-area">
                                    <a href="/" class="logo">
                                        <img 
                                            id="site-logo"
                                            class="site-logo"
                                            src=""
                                            alt="Logo"
                                            style="height:40px;width:auto;display:none;"
                                        >
                                    </a>
                                    <nav class="nav-menu">${categoriesHtml}</nav>
                                </div>
                                <div class="search-area">
                                    <div class="search-box" style="position:relative;">
                                        <input type="text" id="web-search-input" placeholder="Search for " autocomplete="off">
                                        <button class="search-icon-btn" aria-label="Search" onclick="window.location.href='/search'">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="10" cy="10" r="7"/>
                                                <line x1="21" y1="21" x2="15" y2="15"/>
                                            </svg>
                                        </button>
                                        <div id="web-search-suggestions" class="web-search-suggestions" style="display:none;"></div>
                                    </div>
                                </div>
                            <div class="header-actions">
                                <a href="/profile"
                                class="action-link">

                                    <svg class="header-icon"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <circle cx="12" cy="7" r="4"/>
                                        <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>

                                    </svg>

                                    Profile

                                </a>

                                <!-- Wishlist -->
                                <a href="/wishlist"
                                class="action-link">

                                    <svg class="header-icon"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0
                                                L12 5.67l-1.06-1.06
                                                a5.5 5.5 0 0 0-7.78 7.78
                                                l1.06 1.06L12 21.23
                                                l7.78-7.78
                                                1.06-1.06
                                                a5.5 5.5 0 0 0 0-7.78z"/>

                                    </svg>

                                    Wishlist

                                </a>

                                <!-- Cart -->
                                <a href="/cart"
                                class="action-link cart-link">

                                    <span class="cart-icon-wrapper">

                                        <svg class="header-icon"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <circle cx="9" cy="21" r="1.5"/>
                                            <circle cx="18" cy="21" r="1.5"/>
                                            <path d="M2 2h3l3 12h11l2-8H6"/>

                                        </svg>

                                        <span id="cart-count-badge">
                                            0
                                        </span>

                                    </span>

                                    Cart

                                </a>

                            </div>
                            </div>
                        </div>
                        <div class="all-categories-popup" id="allCategoriesPopup" style="display:none;"></div>
                    `;

                    const loadDesktopLogo = () => {
                        const webLogo = document.getElementById('site-logo');
                        if (webLogo) {
                            fetch(`${API_BASE_URL}/app-settings`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        const logoUrl = data.data.header_logo || data.data.app_logo;
                                        if (logoUrl && webLogo) {
                                            webLogo.src = logoUrl;
                                            webLogo.style.display = 'block';
                                            webLogo.style.height = '32px';
                                            webLogo.style.width = 'auto';
                                            webLogo.onerror = function() {
                                                this.style.display = 'none';
                                            };
                                        }
                                    }
                                })
                                .catch(err => console.log('Logo error:', err));
                        }
                    };

                    setTimeout(loadDesktopLogo, 50);

                    setTimeout(function() {
                        if (window.innerWidth >= 1025) {
                            initWebSearchDropdown();
                        }
                    }, 300);
                    const navItems = document.querySelectorAll('.nav-item');
                    const popup = document.getElementById('allCategoriesPopup');
                    
                    navItems.forEach(item => {
                        item.addEventListener('mouseenter', () => {
                            fetch(`${API_BASE_URL}/categories`)
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
                                                        let subSlug = sub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                                            html += `<li style="margin-bottom:8px;"><a href="/collection/${subSlug}" style="text-decoration:none; color:#696b79; font-size:13px;">${sub.name}</a></li>`;
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
                        let hideTimeout;
                            item.addEventListener('mouseleave', () => {
                                hideTimeout = setTimeout(() => { 
                                    if (!popup.matches(':hover')) {
                                        popup.style.display = 'none'; 
                                    }
                                }, 300);
                            });

                            popup.addEventListener('mouseenter', () => {
                                clearTimeout(hideTimeout);
                                popup.style.display = 'block';
                            });

                            popup.addEventListener('mouseleave', () => {
                                popup.style.display = 'none';
                            });
                    });
                    popup.addEventListener('mouseenter', () => { popup.style.display = 'block'; });
                    popup.addEventListener('mouseleave', () => { popup.style.display = 'none'; });
                    
                    
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
                                <img src="" alt="Logo" class="site-logo" id="mobile-site-logo"
                                    style="height:32px; width:auto; display:none;"
                                    onerror="this.style.display='none'">
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
    .search-box {display: flex ; background: #f5f5f6; border-radius: 4px; position: relative; overflow: visible; }
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
setTimeout(() => {
    updateCartCountForOrderPage();
}, 800);
function initWebSearchDropdown() {
    const input = document.getElementById("web-search-input");
    const box = document.getElementById("web-search-suggestions");

    if (!input) {
        setTimeout(initWebSearchDropdown, 500);
        return;
    }

    let timer;

    input.addEventListener("input", function(e) {
        clearTimeout(timer);
        const q = e.target.value.trim();

        if (q.length === 0) {
            box.style.display = "none";
            box.innerHTML = "";
            return;
        }

        timer = setTimeout(async () => {
            try {
                const res = await fetch(`${API_BASE_URL}/products/suggestions?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                if (!data.success) return;

                let html = "";
                const products = data.data.products || [];

                products.forEach(p => {
                    html += `<div class="web-suggestion-item" onclick="window.location.href='/product/${p.slug}'">${p.name}</div>`;
                });

                if (html === "") {
                    html = `<div class="web-suggestion-item">No results found</div>`;
                }

                box.innerHTML = html;
                box.style.display = "block";
            } catch (err) {
                console.log(err);
            }
        }, 200);
    });

    document.addEventListener("click", function(e) {
        if (!input.contains(e.target) && !box.contains(e.target)) {
            box.style.display = "none";
        }
    });
}
setTimeout(() => {
    applyAppSettingsForOrderPage();
}, 100);

window.addEventListener('resize', () => {
    renderHeader();

    setTimeout(() => {
        applyAppSettingsForOrderPage();

        if (window.innerWidth >= 1025) {
            initWebSearchDropdown();
        }

    }, 300);
});
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
            { key: 'confirmed', label: 'Confirmed', icon: '✓', timeKey: 'confirmed_at' },
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
            window.currentOrder = order;

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
            if (order.payment_status === 'paid') {
                paymentText = 'Online Payment';
                paymentIcon = '💳';
            } else if (order.payment_method === 'cod' || order.payment_method === 'COD') {
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
                    
                    let statusDate = '';
                    if (step.key === 'pending' && order.created_at) {
                        statusDate = formatShortDateTime(order.created_at);
                    } else if (step.key === 'confirmed' && order.confirmed_at) {
                        statusDate = formatShortDateTime(order.confirmed_at);
                    } else if (step.key === 'processing' && order.processing_at) {
                        statusDate = formatShortDateTime(order.processing_at);
                    } else if (step.key === 'shipped' && order.shipped_at) {
                        statusDate = formatShortDateTime(order.shipped_at);
                    } else if (step.key === 'delivered' && order.delivered_at) {
                        statusDate = formatShortDateTime(order.delivered_at);
                    }
                    
                    trackerHtml += `
                        <div class="step-item-wrapper">
                            <div class="step-icon-box">
                                <div class="step-dot ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}">
                                    ${step.icon}
                                </div>`;
                    
                    if (idx < stepsConfig.length - 1) {
                        trackerHtml += `<div class="step-connector-line ${isCompleted ? 'completed' : ''}"></div>`;
                    }
                    
                    trackerHtml += `
                            </div>
                            <div class="step-content-box">
                                <div class="step-label-text">${step.label}</div>
                                ${statusDate ? `<div class="step-date">${statusDate}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
                trackerHtml += `</div>`;
            } else {
                trackerHtml = `
                    <div style="text-align: center; padding: 20px;">
                        <div style="background: #fef2f2; border-radius: 12px; padding: 16px; color: #dc2626;">
                            ❌ Order Cancelled
                            ${order.cancelled_at ? `<div style="font-size: 12px; margin-top: 8px;">on ${formatShortDateTime(order.cancelled_at)}</div>` : ''}
                        </div>
                    </div>
                `;
            }

            let itemsHtml = '';
            if (order.items && order.items.length) {
                order.items.forEach(item => {
                let imgUrl = item.variant?.image_url 
                    || item.product?.image_url 
                    || item.image 
                    || '';

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
    async function applyAppSettingsForOrderPage() {
        try {
            const res = await fetch(`${API_BASE_URL}/app-settings`);
            const data = await res.json();

            if (data.success) {
                const headerLogo = data.data.header_logo || data.data.app_logo;
                const logoImg = document.getElementById('site-logo');
                if (logoImg && headerLogo) {
                    logoImg.src = headerLogo;
                    logoImg.style.display = 'block';
                    logoImg.onerror = function() {
                        this.style.display = 'none';
                    };
                }
                if (data.data.app_name) {
                    document.title = data.data.app_name;
                }
            }
        } catch (e) {
            console.error('Logo load error:', e);
        }
    }
            
    document.querySelectorAll('.back-btn-header, [onclick="goBack()"]').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                window.location.replace('/orders');
            };
        });
        function updateCartCountForOrderPage() {
            try {
                const mobileBadge = document.getElementById("cart-count-badge");
                const webBadge = document.getElementById("web-cart-count-badge");
                
                let cart = JSON.parse(localStorage.getItem("cart_items")) ||
                    JSON.parse(localStorage.getItem("cart")) ||
                    JSON.parse(localStorage.getItem("shopping_cart")) || [];
                
                if (!Array.isArray(cart)) cart = [];
                
                let count = cart.length;
                
                if (mobileBadge) {
                    mobileBadge.textContent = count;
                    mobileBadge.style.display = count > 0 ? "flex" : "flex";
                }
                
                if (webBadge) {
                    webBadge.textContent = count;
                    webBadge.style.display = count > 0 ? "flex" : "flex";
                }
            } catch (e) {
                console.log("Cart count error:", e);
            }
        }
        document.body.classList.add('order-confirmation-page');
        renderHeader();
        fetchOrderData();
        startAutoRefresh();

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        if (typeof initWebSearchDropdown === 'function') {
            initWebSearchDropdown();
            console.log('Web search initialized on order confirmation page');
        }
    }, 500);
});
setTimeout(function() {
    const categories = ['Necklace', 'Earrings', 'Maang Tikka', 'Bridal Sets', 'Bangles'];
    let index = 0;
    const input = document.getElementById('web-search-input');
    
    if (input) {
        setInterval(function() {
            input.placeholder = 'Search for ' + categories[index];
            index = (index + 1) % categories.length;
        }, 3000);
    }
}, 2000);
    </script>
    @include('mobile.auth.auth')

</body>
</html>