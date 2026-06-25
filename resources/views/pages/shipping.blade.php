<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Shipping Policy | Maherá Jewels</title>
    <meta name="description" content="Maherá Jewels shipping policy - delivery timelines, charges, tracking, and international shipping information.">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('mobile/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('mobile/style.css') }}"></noscript>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #440C2C;
            margin-bottom: 10px;
        }
        
        .page-header p {
            color: #666;
            font-size: 14px;
        }
        
        .policy-content {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .policy-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .policy-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .policy-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #440C2C;
            margin-bottom: 15px;
        }
        
        .policy-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin: 15px 0 10px;
        }
        
        .policy-section p {
            font-size: 14px;
            color: #555;
            margin-bottom: 12px;
            line-height: 1.7;
        }
        
        .policy-section ul {
            margin: 10px 0 10px 25px;
        }
        
        .policy-section li {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }
        
        .policy-section .highlight {
            background: #fff5f0;
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid #F4B94E;
            margin: 15px 0;
        }
        
        .policy-section .warning {
            background: #fef2f2;
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid #ef4444;
            margin: 15px 0;
            color: #991b1b;
        }
        
        .policy-section .success-box {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid #22c55e;
            margin: 15px 0;
            color: #166534;
        }
        
        .contact-box {
            background: #f5f5f6;
            padding: 20px;
            border-radius: 16px;
            margin-top: 20px;
        }
        
        .contact-box h3 {
            margin-top: 0;
            color: #440C2C;
        }
        
        .contact-box p {
            margin-bottom: 8px;
        }
        
        .shipping-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .shipping-table th {
            background: #440C2C;
            color: #fff;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .shipping-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: #555;
        }
        
        .shipping-table tr:hover td {
            background: #f8f9fa;
        }
        
        .shipping-table tr:last-child td {
            border-bottom: none;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #440C2C;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: #6b1a45;
            transform: translateX(-3px);
        }
        
        .shipping-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-free {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-standard {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-express {
            background: #dbeafe;
            color: #1e40af;
        }
        
        @media (max-width: 768px) {
            .page-container {
                padding: 20px 15px;
            }
            .policy-content {
                padding: 20px;
            }
            .page-header h1 {
                font-size: 24px;
            }
            .policy-section h2 {
                font-size: 18px;
            }
            .shipping-table {
                font-size: 13px;
            }
            .shipping-table th,
            .shipping-table td {
                padding: 8px 10px;
            }
        }
        
        .page-content {
            min-height: 100vh;
        }
        
        .site-footer {
            margin-top: 40px;
        }
        
        /* Animated Gradient Top Bar */
        .top-bar {
            background: linear-gradient(90deg, #440C2C, #F4B94E, #440C2C, #F4B94E, #440C2C);
            background-size: 300% 100%;
            animation: gradientMove 4s ease infinite;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body data-page="shipping">
    <header class="site-header" id="site-header"></header>
    
    <main class="page-content">
        <div class="page-container">
            <!-- <a href="javascript:history.back()" class="back-btn">← Back</a> -->
            
            <div class="page-header">
                <h1>Shipping Policy</h1>
                <p>Effective Date: 2026</p>
                <p><a href="https://www.maherajewels.com" style="color: #666; text-decoration: none;">www.maherajewels.com</a></p>
            </div>
            
            <div class="policy-content">
                <div class="policy-section">
                    <p>At <strong>Maherá Jewels</strong>, we take great care to ensure your order reaches you safely and on time. Please read our Shipping Policy carefully before placing your order.</p>
                </div>
                
                <div class="policy-section">
                    <h2>1. Order Processing</h2>
                    <p>All orders are processed within <strong>1–2 business days</strong> of payment confirmation. Orders placed on weekends or public holidays will be processed on the next working day.</p>
                    <p>Once your order is dispatched, you will receive a shipping confirmation email with a tracking link.</p>
                </div>
                
                <div class="policy-section">
                    <h2>2. Shipping Rates</h2>
                    <p>We offer the following shipping options:</p>
                    
                    <h3>A. Domestic Shipping (India)</h3>
                    <ul>
                        <li>Standard shipping charges apply on orders below ₹999</li>
                        <li><strong>Free shipping</strong> on all orders of ₹999 and above</li>
                    </ul>
                    
                    <h3>B. International Shipping</h3>
                    <ul>
                        <li>Standard international shipping charges apply on orders below $49</li>
                        <li><strong>Free international shipping</strong> on all orders of $49 and above</li>
                    </ul>
                </div>
                
                <div class="policy-section">
                    <h2>3. Estimated Delivery Timelines</h2>
                    <ul>
                        <li><strong>Domestic (India):</strong> 5–7 business days from dispatch</li>
                        <li><strong>International:</strong> 10–20 business days from dispatch, depending on destination country and customs clearance</li>
                    </ul>
                    <div class="warning">
                        <strong>⚠️ Important:</strong> Delivery timelines are estimates only and may vary during peak seasons, public holidays, or due to factors beyond our control (including customs delays, weather, or carrier issues).
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>4. Shipment Tracking</h2>
                    <p>Once your order is dispatched, you will receive a tracking number via email. You can use this to monitor your shipment’s status in real time.</p>
                    <p>If you do not receive a tracking email within 3 business days of placing your order, please contact us at info@maherajewels.com.</p>
                </div>
                
                <div class="policy-section">
                    <h2>5. Customs, Duties & Taxes (International Orders)</h2>
                    <p>International shipments may be subject to import duties, taxes, or customs fees levied by the destination country. These charges are the sole responsibility of the customer and are not included in the order total or shipping fee paid to Maherá Jewels.</p>
                    <p>Maherá Jewels is not responsible for delays caused by customs processing. We recommend checking your country’s import regulations before placing an order.</p>
                </div>
                
                <div class="policy-section">
                    <h2>6. Damaged or Lost Shipments</h2>
                    <p>If your order arrives damaged or appears to be lost in transit, please contact us within 24 hours of delivery (or within 24 hours of the expected delivery date in case of non-delivery) with:</p>
                    <ul>
                        <li>Your Order ID</li>
                        <li>A clear photograph of the damaged product and its packaging</li>
                        <li>A photograph of the shipping label</li>
                    </ul>
                    <p>We will work with our shipping partners to investigate and resolve the matter promptly. Verified cases will be eligible for a replacement or full refund including shipping charges.</p>
                </div>

                <div class="policy-section">
                    <h2>7. Exchange Policy</h2>
                    <p>We accept exchanges within 3 days of delivery for items that are unused, unworn, and in their original packaging with all tags intact. We do not offer refunds, except in verified cases of damage or incorrect fulfilment.</p>
                    <p>To initiate an exchange, please contact us within 3 days of delivery at:</p>
                    <ul>
                        <li><strong>Email:</strong> info@maherajewels.com</li>
                        <li><strong>Phone:</strong> +91 9653270168 (Mon–Sat, 10AM – 6:30PM)</li>
                    </ul>
                    <p>Shipping costs for exchanges are borne by the customer, unless the item received was defective or incorrect.</p>
                </div>
                
                <div class="policy-section">
                    <h2>8. Non-Serviceable Areas</h2>
                    <p>We currently ship to most locations within India and internationally. However, certain remote or restricted locations may not be serviceable by our logistics partners. If your pin code or country is not supported at checkout, please contact us at info@maherajewels.com to explore alternative arrangements.</p>
                </div>
                
                <div class="policy-section">
                    <h2>9. Contact Us</h2>
                    <p>For any shipping-related queries, please reach us at:</p>
                    
                    <div class="contact-box">
                        <p><strong>📧 Email:</strong> info@maherajewels.com</p>
                        <p><strong>📞 Phone:</strong> +91 9653270168</p>
                        <p><strong>🕐 Hours:</strong> Mon–Sat, 10AM – 6:30PM</p>
                        <p><strong>🌐 Website:</strong> www.maherajewels.com</p>
                        <p><strong>📍 Registered Address:</strong> 29th Floor, 2901 Siddhi Samarpan, Jaywant Sawant Marg, Dahisar West, Mumbai, Maharashtra, 400 068.</p>
                    </div>
                </div>
                
                <div class="policy-section" style="text-align: center; border-bottom: none;">
                    <p style="font-size: 12px; color: #999;">©️ 2026 Maherá Jewels. All rights reserved.</p>
                </div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>
    <script src="{{ asset('mobile/script.js') }}"></script>
    @include('mobile.auth.auth')

    <script>
        // Rotate search placeholder
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
</body>
</html>