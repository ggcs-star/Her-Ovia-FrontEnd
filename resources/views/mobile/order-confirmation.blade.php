<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>Order Details | Her-Ovia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
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
            --hero-bg: #F8EEE3;
            --hero-bg-card: #FFF9F2;
            --hero-burgundy: #4A0F14;
            --hero-burgundy-dark: #35090D;
            --hero-gold: #B88A62;
            --hero-text: #2E1B1B;
            --hero-text-muted: #765F58;
            --hero-border: #DCC0A8;
            --hero-white: #FCF9F6;
            --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --font-heading: Georgia, "Times New Roman", serif;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #ffffff;
            color: var(--hero-text);
        }
        .herovia-announcement {
            background: var(--hero-burgundy);
            color: var(--hero-white);
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            width: 100%;
        }
        .site-header {
            background: var(--hero-bg) !important;
            border-bottom: 1px solid var(--hero-border) !important;
            padding: 0 !important;
            width: 100% !important;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .web-header {
            background: var(--hero-bg) !important;
            border-bottom: 1px solid var(--hero-border) !important;
            width: 100% !important;
        }
        .main-header {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 12px 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 20px !important;
            background: var(--hero-bg) !important;
            width: 100% !important;
        }
        .logo-area {
            display: flex !important;
            align-items: center !important;
            gap: 30px !important;
            flex-shrink: 0 !important;
        }
        .logo img {
            height: 40px !important;
            width: auto !important;
            max-width: 150px !important;
            object-fit: contain !important;
        }
        .nav-menu {
            display: flex !important;
            gap: 20px !important;
        }
        .nav-item {
            color: var(--hero-text) !important;
            text-decoration: none !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.8px !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
        .nav-item:hover {
            color: var(--hero-burgundy) !important;
        }
        .search-area {
            flex: 1 !important;
            max-width: 550px !important;
            margin: 0 15px !important;
        }
        .search-box {
            display: flex !important;
            align-items: center !important;
            background: #f5f5f6 !important;
            border-radius: 30px !important;
            overflow: visible !important;
            border: 1px solid #e0e0e0 !important;
            padding-right: 4px !important;
            position: relative !important;
            height: 40px !important;
        }
        .search-box input {
            flex: 1 !important;
            padding: 8px 14px !important;
            border: none !important;
            background: transparent !important;
            font-size: 13px !important;
            outline: none !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            height: 100% !important;
        }
        .search-box input::placeholder {
            color: #999 !important;
            font-size: 12px !important;
        }
        .search-box .search-icon-btn {
            background: transparent !important;
            border: none !important;
            cursor: pointer !important;
            padding: 6px 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
        }
        .search-box .search-icon-btn svg {
            stroke: #666 !important;
            width: 18px !important;
            height: 18px !important;
        }
        .search-box .search-icon-btn:hover svg {
            stroke: #440C2C !important;
        }
        .search-box .search-icon-btn:hover {
            background: rgba(68, 12, 44, 0.08) !important;
        }
        .header-actions {
            display: flex !important;
            align-items: center !important;
            gap: 18px !important;
            flex-shrink: 0 !important;
        }
        .action-link {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            color: var(--hero-text) !important;
            text-decoration: none !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
        .action-link:hover {
            color: var(--hero-burgundy) !important;
        }
        .action-link .header-icon {
            width: 16px !important;
            height: 16px !important;
            stroke: currentColor !important;
            fill: none !important;
        }
        .cart-icon-wrapper {
            position: relative !important;
            display: inline-block !important;
        }
        #web-cart-count-badge {
            position: absolute !important;
            top: -8px !important;
            right: -12px !important;
            background: #440C2C !important;
            color: #F4B94E !important;
            font-size: 10px !important;
            font-weight: 600 !important;
            min-width: 18px !important;
            height: 18px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 4px !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .header-container {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 8px !important;
            padding: 8px 16px !important;
            width: 100% !important;
            background: var(--hero-bg) !important;
        }
        .logo-search-container {
            flex: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            background: #f5f5f6 !important;
            border-radius: 30px !important;
            padding: 4px 8px !important;
            border: 1px solid #e0e0e0 !important;
            min-width: 0 !important;
        }
        .header-logo {
            flex-shrink: 0 !important;
        }
        .header-logo .site-logo {
            height: 32px !important;
            width: auto !important;
            max-width: 100px !important;
            object-fit: contain !important;
            display: block !important;
        }
        .search-wrapper {
            display: flex !important;
            align-items: center !important;
            flex: 1 !important;
            gap: 4px !important;
            min-width: 0 !important;
        }
        .search-wrapper input {
            flex: 1 !important;
            border: none !important;
            background: transparent !important;
            outline: none !important;
            font-size: 12px !important;
            padding: 6px 0 !important;
            min-width: 0 !important;
            width: 100% !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .search-wrapper input::placeholder {
            color: #999 !important;
            font-size: 11px !important;
        }
        .search-wrapper .search-icon-btn {
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 6px 8px !important;
            display: flex !important;
            align-items: center !important;
        }
        .search-wrapper .search-icon-btn svg {
            width: 18px !important;
            height: 18px !important;
            stroke: #666 !important;
        }
        .header-icons {
            display: flex !important;
            gap: 8px !important;
            flex-shrink: 0 !important;
        }
        .header-icon-btn {
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 6px !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .header-icon-btn svg {
            width: 20px !important;
            height: 20px !important;
            stroke: var(--hero-text) !important;
            fill: none !important;
        }
        .back-btn-header {
            background: none !important;
            border: none !important;
            font-size: 20px !important;
            cursor: pointer !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
            color: var(--hero-text) !important;
            flex-shrink: 0 !important;
            font-weight: 500 !important;
        }
        .all-categories-popup {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            width: 100% !important;
            background: #ffffff !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
            z-index: 1001 !important;
            border-top: 1px solid #f0f0f0 !important;
        }
        #web-search-suggestions {
            position: absolute !important;
            top: calc(100% + 4px) !important;
            left: 0 !important;
            width: 100% !important;
            min-width: 320px !important;
            padding: 0 !important;
            z-index: 999999 !important;
            max-height: 350px !important;
            overflow-y: auto !important;
            display: none !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        #web-search-suggestions.active {
            display: block !important;
            background: #ffffff !important;
            border: 1px solid #DCC0A8 !important;
            border-radius: 12px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
        }
        .web-suggestion-item {
            padding: 12px 18px !important;
            font-size: 14px !important;
            cursor: pointer !important;
            border-bottom: 1px solid #f0ece8 !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #2E1B1B !important;
            transition: background 0.15s ease !important;
        }
        .web-suggestion-item:hover {
            background: #f5ede6 !important;
        }
        .web-suggestion-item:last-child {
            border-bottom: none !important;
        }
        .web-suggestion-item .highlight {
            font-weight: 700;
            color: #4A0F14;
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
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .order-app {
            min-height: 100vh;
            background: #ffffff;
            padding: 20px 0 40px;
        }
        .order-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }
        @media (max-width: 768px) {
            .order-container {
                padding: 0 16px;
            }
        }
        @media (max-width: 480px) {
            .order-container {
                padding: 0 12px;
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
        .card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--hero-border);
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }
        .card-header {
            padding: 16px 18px;
            border-bottom: 1px solid var(--hero-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: #faf8f6;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-icon {
            width: 36px;
            height: 36px;
            background: rgba(68, 12, 44, 0.08);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--hero-burgundy);
        }
        .card-title {
            font-weight: 700;
            font-size: 16px;
            color: var(--hero-text);
            font-family: Georgia, "Times New Roman", serif;
        }
        .card-body {
            padding: 18px;
        }
        .hero-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff5f8 100%);
            border: 1px solid var(--hero-border);
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
            background: linear-gradient(135deg, var(--hero-burgundy), var(--hero-gold));
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
            font-family: Georgia, "Times New Roman", serif;
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
            background: #f5f0ea;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid var(--hero-border);
            color: var(--hero-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .order-total {
            font-size: 32px;
            font-weight: 800;
            color: var(--hero-text);
            letter-spacing: -1px;
            font-family: Georgia, "Times New Roman", serif;
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
            background: var(--hero-gold);
            color: var(--hero-white);
        }
        .step-dot.active {
            background: var(--hero-burgundy);
            color: var(--hero-white);
            box-shadow: 0 0 0 4px rgba(74, 15, 20, 0.2);
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
            background: var(--hero-gold);
        }
        .step-content-box {
            padding: 0 6px;
        }
        .step-label-text {
            font-weight: 700;
            font-size: 12px;
            color: var(--hero-text);
            white-space: nowrap;
            font-family: Georgia, "Times New Roman", serif;
        }
        .step-date {
            font-size: 10px;
            color: var(--hero-text-muted);
            margin-top: 6px;
            white-space: nowrap;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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
        .product-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            background: #faf8f6;
            border-radius: 16px;
            margin-bottom: 10px;
            border: 1px solid var(--hero-border);
        }
        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            object-fit: contain;
            background: #f5f0ea;
            flex-shrink: 0;
        }
        @media (min-width: 768px) {
            .product-img {
                width: 80px;
                height: 80px;
                border-radius: 16px;
            }
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.4;
            color: var(--hero-text);
            margin-bottom: 5px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .product-variant {
            font-size: 12px;
            color: var(--hero-text-muted);
            margin-bottom: 8px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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
            color: var(--hero-burgundy);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .quantity-badge {
            background: #ffffff;
            border: 1px solid var(--hero-border);
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .price-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--hero-border);
            font-size: 13px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--hero-text);
        }
        .price-detail-row.total {
            border-top: 2px solid var(--hero-border);
            border-bottom: none;
            margin-top: 6px;
            padding-top: 14px;
            font-weight: 800;
            font-size: 16px;
            color: var(--hero-text);
        }
        .price-detail-row.total span:last-child {
            color: var(--hero-burgundy);
        }
        .address-display {
            background: #faf8f6;
            border-radius: 16px;
            padding: 14px;
            border: 1px solid var(--hero-border);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .action-buttons-group {
            display: flex;
            gap: 10px;
            margin-top: 6px;
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
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .btn-primary {
            background: var(--hero-burgundy);
            color: var(--hero-white);
            box-shadow: 0 4px 12px rgba(74, 15, 20, 0.2);
        }
        .btn-primary:hover {
            background: var(--hero-burgundy-dark);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #ffffff;
            border: 1px solid var(--hero-border);
            color: var(--hero-text);
        }
        .btn-secondary:hover {
            background: #faf8f6;
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
        .savings-block {
            background: #faf8f6;
            border-radius: 40px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 12px;
            color: var(--hero-burgundy);
            margin-top: 14px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .status-badge-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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
            border: 3px solid var(--hero-border);
            border-top-color: var(--hero-burgundy);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .error-box {
            text-align: center;
            padding: 50px 20px;
            background: #ffffff;
            border-radius: 24px;
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
        #mobile-bottom-nav {
            display: none !important;
        }
        @media (max-width: 1024px) {
            .main-header {
                padding: 12px 20px !important;
            }
        }
        @media (max-width: 768px) {
            .main-header {
                padding: 8px 16px !important;
            }
            .logo img {
                height: 36px !important;
                max-width: 140px !important;
            }
            .header-logo .site-logo {
                height: 32px !important;
                max-width: 90px !important;
            }
        }
        @media (max-width: 480px) {
            .main-header {
                padding: 6px 12px !important;
            }
            .logo img {
                height: 30px !important;
                max-width: 120px !important;
            }
            .header-logo .site-logo {
                height: 28px !important;
                max-width: 80px !important;
            }
            .header-container {
                padding: 6px 12px !important;
            }
        }
        .logo {
            font-size: 0 !important;
            line-height: 0 !important;
            display: inline-block !important;
            text-decoration: none !important;
        }
        .logo img {
            display: block !important;
            height: 40px !important;
            width: auto !important;
            max-width: 150px !important;
            object-fit: contain !important;
        }
        .logo:not(:has(img[src])) {
            display: none !important;
        }
        .logo a {
            display: inline-block !important;
            font-size: 0 !important;
            line-height: 0 !important;
        }
        .logo a img {
            display: block !important;
        }
        @media screen and (min-width: 1025px) {
            .desktop-sticky-header {
                position: sticky !important;
                top: 0 !important;
                width: 100% !important;
                z-index: 999999 !important;
            }
            .herovia-announcement {
                position: relative !important;
                width: 100% !important;
                margin: 0 !important;
            }
            .site-header {
                position: relative !important;
                top: auto !important;
                width: 100% !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body>
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
    </script>

    <script>
        const API_BASE_URL = window.API_BASE_URL;
        const token = localStorage.getItem('token');
        const orderId = '{{ $orderId }}';

        if (!token) {
            window.location.href = '/user/login';
        }

        // ============================================================
        // 1. HEADER
        // ============================================================
        function renderHeader() {
            const header = document.getElementById('site-header');
            if (!header) return;
            const isDesktop = window.innerWidth >= 1025;

            if (isDesktop) {
                fetch(`${API_BASE_URL}/categories`)
                    .then(r => r.json())
                    .then(catData => {
                        if (catData.success && catData.data) {
                            const categories = catData.data.slice(0, 5);
                            const categoriesHtml = categories.map(cat => {
                                let categorySlug = cat.slug || cat.name.toLowerCase()
                                    .replace(/[^a-z0-9]+/g, '-')
                                    .replace(/^-|-$/g, '');
                                let url = `/collection/${categorySlug}`;
                                if (categorySlug === "trending" || categorySlug === "bestsellers") {
                                    url = "/top-selling";
                                }
                                return `<a href="${url}" class="nav-item" data-cat-id="${cat.id}" data-cat-name="${cat.name}">${cat.name.toUpperCase()}</a>`;
                            }).join('');

                            window.cachedCategories = catData.data;

                            header.innerHTML = `
                                <div class="web-header">
                                    <div class="main-header">
                                        <div class="logo-area">
                                            <a href="/" class="logo">
                                                <img src="" alt="Logo" id="site-logo" class="site-logo" style="display:none;">
                                            </a>
                                            <nav class="nav-menu" id="navMenu">${categoriesHtml}</nav>
                                        </div>
                                        <div class="search-area">
                                            <div class="search-box" style="position:relative;">
                                                <input type="text" id="web-search-input" placeholder="Search for " autocomplete="off">
                                                <button class="search-icon-btn" aria-label="Search">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="10" cy="10" r="7"/>
                                                        <line x1="21" y1="21" x2="15" y2="15"/>
                                                    </svg>
                                                </button>
                                                <div id="web-search-suggestions"></div>
                                            </div>
                                        </div>
                                        <div class="header-actions">
                                            <a href="javascript:void(0)" class="action-link" onclick="if(!localStorage.getItem('token')){showLoginPopup();}else{window.location.href='/profile';}">
                                                <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                                                    <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="2"/>
                                                </svg>
                                                Profile
                                            </a>
                                            <a href="/wishlist" class="action-link">
                                                <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 21s-6-4.35-9-8.5C-1 6.5 4 2 8 5c2 1.5 4 3.5 4 3.5S14 6.5 16 5c4-3 9 1.5 5 7.5C18 16.65 12 21 12 21z" stroke="currentColor" stroke-width="2"/>
                                                </svg>
                                                Wishlist
                                            </a>
                                            <a href="/cart" class="action-link cart-link">
                                                <span class="cart-icon-wrapper">
                                                    <svg class="header-icon" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="9" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                                                        <circle cx="18" cy="21" r="1.5" stroke="currentColor" stroke-width="2"/>
                                                        <path d="M2 2h3l3 12h11l2-8H6" stroke="currentColor" stroke-width="2"/>
                                                    </svg>
                                                    <span id="web-cart-count-badge">0</span>
                                                </span>
                                                Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="all-categories-popup" id="allCategoriesPopup" style="display:none;"></div>
                            `;

                            // Logo
                            fetch(`${API_BASE_URL}/app-settings`)
                                .then(r => r.json())
                                .then(settingsData => {
                                    if (settingsData.success && settingsData.data) {
                                        const logo = document.getElementById('site-logo');
                                        if (logo && settingsData.data.header_logo) {
                                            logo.src = settingsData.data.header_logo;
                                            logo.style.display = 'block';
                                            logo.onerror = function() { this.style.display = 'none'; };
                                        }
                                    }
                                });

                            setupAllCategoriesPopup();
                            setTimeout(initWebSearchDropdown, 500);
                            setTimeout(updateCartCountBadge, 100);
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
                                        <img src="" alt="Logo" class="site-logo" id="mobile-site-logo" onerror="this.style.display='none'">
                                    </a>
                                </div>
                                <div class="search-wrapper">
                                    <input id="landing-search" type="text" placeholder="Search for Category, Product ...">
                                    <button class="search-icon-btn" onclick="window.location.href='/search'" style="background:none; border:none; cursor:pointer; padding:0; display:flex; align-items:center;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

                const searchInput = document.getElementById('landing-search');
                if (searchInput) {
                    searchInput.addEventListener('focus', () => {
                        window.location.href = '/search';
                    });
                }

                fetch(`${API_BASE_URL}/app-settings`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            const logo = document.getElementById('mobile-site-logo');
                            if (logo && data.data.header_logo) {
                                logo.src = data.data.header_logo;
                                logo.style.display = 'block';
                                logo.onerror = function() { this.style.display = 'none'; };
                            }
                        }
                    });
            }
        }

        // ============================================================
        // 2. POPUP SETUP
        // ============================================================
        function setupAllCategoriesPopup() {
            const popup = document.getElementById('allCategoriesPopup');
            const navItems = document.querySelectorAll('#navMenu .nav-item');

            if (!popup || !navItems.length) return;

            let hideTimeout;

            navItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    if (hideTimeout) clearTimeout(hideTimeout);
                    if (window.cachedCategories && window.cachedCategories.length > 0) {
                        renderAllCategoriesPopup(window.cachedCategories);
                        popup.style.display = 'block';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    hideTimeout = setTimeout(() => {
                        popup.style.display = 'none';
                    }, 200);
                });
            });

            popup.addEventListener('mouseenter', function() {
                if (hideTimeout) clearTimeout(hideTimeout);
                popup.style.display = 'block';
            });

            popup.addEventListener('mouseleave', function() {
                hideTimeout = setTimeout(() => {
                    popup.style.display = 'none';
                }, 200);
            });
        }

        // ============================================================
        // 3. RENDER POPUP - NESTED URL
        // ============================================================
        function renderAllCategoriesPopup(categories) {
            const popup = document.getElementById('allCategoriesPopup');
            if (!popup) return;

            const categoriesWithSub = categories.filter(cat => cat.children && cat.children.length > 0);

            if (categoriesWithSub.length === 0) {
                popup.innerHTML = '';
                return;
            }

            const columnSize = Math.ceil(categoriesWithSub.length / 5);
            const columns = [];
            for (let i = 0; i < 5; i++) {
                columns.push(categoriesWithSub.slice(i * columnSize, (i + 1) * columnSize));
            }

            let html = `<div style="max-width:1200px; margin:0 auto; padding:30px; display:grid; grid-template-columns:repeat(5,1fr); gap:25px;">`;

            columns.forEach(col => {
                if (col.length > 0) {
                    html += `<div>`;
                    col.forEach(cat => {
                        let mainSlug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                        let mainUrl = `/collection/${mainSlug}`;
                        if (mainSlug === "trending") mainUrl = "/top-selling";
                        if (mainSlug === "bestsellers") mainUrl = "/best-selling";

                        html += `<div style="margin-bottom:20px;">
                            <h3 style="font-size:14px; font-weight:700; color:#282c3f; margin-bottom:12px; border-bottom:2px solid #ff3f6c; padding-bottom:6px; display:inline-block;">
                                <a href="${mainUrl}" style="color:#282c3f; text-decoration:none;">${cat.name}</a>
                            </h3>
                            <ul style="list-style:none; padding:0; margin-top:12px;">`;

                        if (cat.children && cat.children.length > 0) {
                            cat.children.slice(0, 8).forEach(sub => {
                                let subSlug = sub.slug || sub.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                let subUrl = `/collection/${mainSlug}/${subSlug}`;

                                html += `<li style="margin-bottom:8px;">
                                    <a href="${subUrl}" 
                                       style="text-decoration:none; color:#696b79; font-size:13px; display:block; padding:4px 0; transition:color 0.2s;"
                                       onmouseover="this.style.color='#ff3f6c'"
                                       onmouseout="this.style.color='#696b79'">
                                        ${sub.name}
                                    </a>
                                </li>`;
                            });

                            if (cat.children.length > 8) {
                                let slug = cat.slug || cat.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                                let productUrl = `/collection/${slug}`;
                                if (slug === "trending") productUrl = "/top-selling";
                                if (slug === "bestsellers") productUrl = "/best-selling";
                                html += `<li style="margin-top:5px;">
                                    <a href="${productUrl}" 
                                       style="color:#ff3f6c; font-size:11px; font-weight:600; text-decoration:none;">
                                        +${cat.children.length - 8} more →
                                    </a>
                                </li>`;
                            }
                        }
                        html += `</ul></div>`;
                    });
                    html += `</div>`;
                }
            });
            html += `</div>`;
            popup.innerHTML = html;
        }

        // ============================================================
        // 4. SEARCH DROPDOWN
        // ============================================================
        function initWebSearchDropdown() {
            const input = document.getElementById("web-search-input");

            if (!input) {
                setTimeout(initWebSearchDropdown, 500);
                return;
            }

            let box = document.getElementById("web-search-suggestions");

            if (!box) {
                const parent = input.parentElement;

                const div = document.createElement("div");
                div.id = "web-search-suggestions";
                div.className = "web-search-suggestions";

                parent.appendChild(div);
                box = document.getElementById("web-search-suggestions");
            }

            if (!box) return;

            box.style.display = "none";
            box.innerHTML = "";

            let timer;
            let isFetching = false;

            const slugify = (value) => {
                return String(value || "")
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, "-")
                    .replace(/^-+|-+$/g, "");
            };

            const renderSuggestions = (data) => {
                const products = Array.isArray(data?.products)
                    ? data.products
                    : [];

                const categories = Array.isArray(data?.categories)
                    ? data.categories
                    : [];

                const subcategories = Array.isArray(data?.subcategories)
                    ? data.subcategories
                    : [];

                const brands = Array.isArray(data?.brands)
                    ? data.brands
                    : [];

                let html = "";

                // PRODUCTS
                if (products.length) {
                    html += `
                        <div class="search-suggestion-group">
                            <div class="search-suggestion-title">
                                Products
                            </div>

                            ${products.map(p => {
                                const slug = p.slug || p.id || "";
                                const name = p.name || p.product_name || "";

                                if (!name) return "";

                                return `
                                    <div
                                        class="web-suggestion-item"
                                        role="button"
                                        tabindex="0"
                                        onclick="window.location.href='/product/${encodeURIComponent(slug)}'"
                                        onkeypress="if(event.key==='Enter') window.location.href='/product/${encodeURIComponent(slug)}'"
                                    >
                                        ${escapeHtml(name)}
                                    </div>
                                `;
                            }).join("")}
                        </div>
                    `;
                }

                // CATEGORIES
                if (categories.length) {
                    html += `
                        <div class="search-suggestion-group">
                            <div class="search-suggestion-title">
                                Categories
                            </div>

                            ${categories.map(cat => {
                                const slug = cat.slug || slugify(cat.name);

                                let url = `/collection/${encodeURIComponent(slug)}`;

                                if (slug === "trending") {
                                    url = "/top-selling";
                                } else if (slug === "bestsellers") {
                                    url = "/best-selling";
                                }

                                return `
                                    <div
                                        class="web-suggestion-item"
                                        role="button"
                                        tabindex="0"
                                        onclick="window.location.href='${url}'"
                                        onkeypress="if(event.key==='Enter') window.location.href='${url}'"
                                    >
                                        ${escapeHtml(cat.name)}
                                    </div>
                                `;
                            }).join("")}
                        </div>
                    `;
                }

                // SUBCATEGORIES
                if (subcategories.length) {
                    html += `
                        <div class="search-suggestion-group">
                            <div class="search-suggestion-title">
                                Subcategories
                            </div>

                            ${subcategories.map(sub => {
                                const subSlug =
                                    sub.slug || slugify(sub.name);

                                const parentSlug =
                                    sub.parent?.slug ||
                                    sub.parent_slug ||
                                    (
                                        sub.parent?.name
                                            ? slugify(sub.parent.name)
                                            : ""
                                    );

                                const url = parentSlug
                                    ? `/collection/${encodeURIComponent(parentSlug)}/${encodeURIComponent(subSlug)}`
                                    : `/collection/${encodeURIComponent(subSlug)}`;

                                return `
                                    <div
                                        class="web-suggestion-item"
                                        role="button"
                                        tabindex="0"
                                        onclick="window.location.href='${url}'"
                                        onkeypress="if(event.key==='Enter') window.location.href='${url}'"
                                    >
                                        ${escapeHtml(sub.name)}
                                    </div>
                                `;
                            }).join("")}
                        </div>
                    `;
                }

                // BRANDS
                if (brands.length) {
                    html += `
                        <div class="search-suggestion-group">
                            <div class="search-suggestion-title">
                                Brands
                            </div>

                            ${brands.map(brand => {
                                const brandName =
                                    typeof brand === "string"
                                        ? brand
                                        : brand.name ||
                                        brand.brand ||
                                        "";

                                if (!brandName) return "";

                                return `
                                    <div
                                        class="web-suggestion-item"
                                        role="button"
                                        tabindex="0"
                                        onclick="window.location.href='/products?search=${encodeURIComponent(brandName)}'"
                                        onkeypress="if(event.key==='Enter') window.location.href='/search?q=${encodeURIComponent(brandName)}'"
                                    >
                                        ${escapeHtml(brandName)}
                                    </div>
                                `;
                            }).join("")}
                        </div>
                    `;
                }

                if (html) {
                    box.innerHTML = html;
                    box.style.display = "block";
                    box.className = "web-search-suggestions active";
                } else {
                    box.innerHTML = "";
                    box.style.display = "none";
                    box.className = "web-search-suggestions";
                }
            };

            // INPUT
            input.addEventListener("input", function(e) {
                clearTimeout(timer);

                const q = this.value.trim();

                if (q.length === 0) {
                    box.style.display = "none";
                    box.innerHTML = "";
                    box.className = "web-search-suggestions";
                    return;
                }

                timer = setTimeout(async () => {
                    if (isFetching) return;

                    isFetching = true;

                    try {
                        const apiUrl =
                            window.API_BASE_URL || API_BASE_URL;

                        const res = await fetch(
                            `${apiUrl}/products/suggestions?q=${encodeURIComponent(q)}`,
                            {
                                headers: {
                                    Accept: "application/json"
                                }
                            }
                        );

                        if (!res.ok) {
                            throw new Error(`HTTP ${res.status}`);
                        }

                        const data = await res.json();

                        if (data.success && data.data) {
                            renderSuggestions(data.data);
                        } else {
                            box.innerHTML = "";
                            box.style.display = "none";
                            box.className = "web-search-suggestions";
                        }

                    } catch (err) {
                        box.innerHTML = "";
                        box.style.display = "none";
                        box.className = "web-search-suggestions";
                    }

                    isFetching = false;

                }, 300);
            });

            // ENTER
            input.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();

                    const q = this.value.trim();

                    if (q) {
                        box.style.display = "none";
                        box.innerHTML = "";

                        window.location.href =
                            `/products?search=${encodeURIComponent(q)}`;
                    }
                }
            });

            // CLICK OUTSIDE
            document.addEventListener("click", function(e) {
                if (
                    !input.contains(e.target) &&
                    !box.contains(e.target)
                ) {
                    box.style.display = "none";
                    box.innerHTML = "";
                    box.className = "web-search-suggestions";
                }
            });

            // PLACEHOLDER ROTATION
            const apiUrl =
                window.API_BASE_URL || API_BASE_URL;

            fetch(`${apiUrl}/categories`)
                .then(r => r.json())
                .then(data => {
                    if (
                        data.success &&
                        data.data &&
                        data.data.length > 0
                    ) {
                        const categories =
                            data.data.map(cat => cat.name);

                        let index = 0;

                        input.placeholder =
                            "Search for " + categories[0];

                        setInterval(function() {
                            index =
                                (index + 1) % categories.length;

                            input.placeholder =
                                "Search for " + categories[index];
                        }, 3000);
                    }
                })
                .catch(function() {});
        }

        // ============================================================
        // 5. CART BADGE
        // ============================================================
        function updateCartCountBadge() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let totalItems = cart.length;
            const badge = document.getElementById('web-cart-count-badge');
            if (badge) {
                badge.textContent = totalItems;
                badge.style.display = totalItems > 0 ? 'flex' : 'flex';
            }
        }

        function updateCartCountForOrderPage() {
            try {
                const badge = document.getElementById("web-cart-count-badge");
                let cart = JSON.parse(localStorage.getItem("cart_items")) ||
                    JSON.parse(localStorage.getItem("cart")) || [];
                if (!Array.isArray(cart)) cart = [];
                let count = cart.length;
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? "flex" : "flex";
                }
            } catch (e) {
                console.log("Cart count error:", e);
            }
        }

        // ============================================================
        // 6. UTILITY
        // ============================================================
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

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // ============================================================
        // 7. ORDER STATUS
        // ============================================================
        const statusMap = {
            pending: { label: 'Order Placed', icon: '📦', color: '#f59e0b', bg: '#fffbeb' },
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

        // ============================================================
        // 8. RENDER ORDER
        // ============================================================
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
                                </div>
                                ${idx < stepsConfig.length - 1 ? `<div class="step-connector-line ${isCompleted ? 'completed' : ''}"></div>` : ''}
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
                    <div style="text-align:center; padding:20px;">
                        <div style="background:#fef2f2; border-radius:12px; padding:16px; color:#dc2626;">
                            ❌ Order Cancelled
                            ${order.cancelled_at ? `<div style="font-size:12px; margin-top:8px;">on ${formatShortDateTime(order.cancelled_at)}</div>` : ''}
                        </div>
                    </div>
                `;
            }

            let itemsHtml = '';
            if (order.items && order.items.length) {
                order.items.forEach(item => {
                    let imgUrl = item.variant?.image_url || item.product?.image_url || item.image || '';
                    if (imgUrl && !imgUrl.startsWith('http')) {
                        imgUrl = `https://her-ovia.s3.us-east-1.amazonaws.com/${imgUrl}`;
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
                itemsHtml = `<div style="text-align:center; padding:28px; color:var(--hero-text-muted);">No items available</div>`;
            }

            const priceRows = `
                <div class="price-detail-row"><span>Subtotal</span><span>${formatMoney(subtotal)}</span></div>
                <div class="price-detail-row"><span>Shipping</span><span>${shipping > 0 ? formatMoney(shipping) : 'Free'}</span></div>
                <div class="price-detail-row"><span>Platform Fee</span><span>${formatMoney(platformFee)}</span></div>
                <div class="price-detail-row"><span>Tax (GST)</span><span>${formatMoney(tax)}</span></div>
                ${discount > 0 ? `<div class="price-detail-row" style="color:#10b981;"><span>Discount</span><span>-${formatMoney(discount)}</span></div>` : ''}
                <div class="price-detail-row total"><span>Total Amount</span><span>${formatMoney(total)}</span></div>
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
                    ${phone ? `<div style="font-size:12px; color:var(--hero-text-muted); margin-bottom:8px;">📞 ${escapeHtml(phone)}</div>` : ''}
                    <div style="font-size:13px; line-height:1.5; color:var(--hero-text);">
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
                    <div style="font-size:12px; color:var(--hero-text-muted); margin-bottom:14px;">📅 ${formatLongDate(order.created_at)} • ${formatTime(order.created_at)}</div>
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
                    <div class="card-body">${trackerHtml}</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">🛍️</div>
                            <div class="card-title">Order Items (${order.items?.length || 0})</div>
                        </div>
                    </div>
                    <div class="card-body">${itemsHtml}</div>
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
                    <div class="card-body">${addressHtml}</div>
                </div>
                ` : ''}
                <div class="card" style="border:none; background:transparent; box-shadow:none;">
                    <div class="action-buttons-group">
                        <button class="btn btn-primary" id="viewOrdersDesktop">📋 View All Orders</button>
                        <button class="btn btn-secondary" id="continueShopDesktop">✨ Continue Shopping</button>
                    </div>
                </div>
            `;

            document.getElementById('order-root').innerHTML = `
                <div class="order-main">${mainColumnHtml}</div>
                <div class="order-sidebar">${sidebarHtml}</div>
            `;

            document.getElementById('viewOrdersDesktop')?.addEventListener('click', () => window.location.href = '/orders');
            document.getElementById('continueShopDesktop')?.addEventListener('click', () => window.location.href = '/');
        }

        // ============================================================
        // 9. FETCH ORDER
        // ============================================================
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
                    } catch (e) { console.warn('Address fetch failed'); }
                }

                renderOrderDetails(order);
                localStorage.setItem('last_order_cached', JSON.stringify(order));

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
                    } catch (e) {}
                }
                document.getElementById('order-root').innerHTML = '<div class="error-box" style="grid-column:1/-1">⚠️ Failed to load order. Check connection.</div>';
            }
        }

        // ============================================================
        // 10. AUTO REFRESH
        // ============================================================
        let refreshInterval;

        function startAutoRefresh() {
            if (refreshInterval) clearInterval(refreshInterval);
            refreshInterval = setInterval(() => fetchOrderData(), 5000);
        }

        // ============================================================
        // 11. INIT
        // ============================================================
        document.body.classList.add('order-confirmation-page');
        renderHeader();
        fetchOrderData();
        startAutoRefresh();

        setTimeout(updateCartCountForOrderPage, 800);

        window.addEventListener('resize', () => {
            renderHeader();
            setTimeout(() => {
                if (window.innerWidth >= 1025) {
                    setTimeout(initWebSearchDropdown, 500);
                }
            }, 300);
        });

        document.querySelectorAll('.back-btn-header, [onclick="goBack()"]').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                window.location.replace('/orders');
            };
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                initWebSearchDropdown();
            }, 800);
        });

        // ============================================================
        // 12. SHOW LOGIN POPUP
        // ============================================================
        window.showLoginPopup = function() {
            window.location.href = '/login';
        };
    </script>

    @include('mobile.auth.auth')
</body>
</html>