<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Shipping Policy | MAHERA JEWEL</title>
    <meta name="description" content="MAHERA JEWEL shipping policy - delivery timelines, charges, tracking, and international shipping information.">
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
                <p>Effective Date: 2025 | Last updated: May 2026</p>
            </div>
            
            <div class="policy-content">
                <div class="policy-section">
                    <p>At <strong>MAHERA JEWEL</strong>, we strive to deliver your precious jewelry orders with care, speed, and reliability. Please read our shipping policy carefully to understand how we process and deliver your orders.</p>
                </div>
                
                <div class="policy-section">
                    <h2>1. Processing Time</h2>
                    <p>All orders are processed within <strong>1-3 business days</strong> (Monday to Saturday, excluding public holidays).</p>
                    <ul>
                        <li>Orders placed before <strong>12:00 PM</strong> are processed the same day</li>
                        <li>Orders placed after 12:00 PM are processed the next business day</li>
                        <li>Orders placed on <strong>Sunday</strong> or <strong>public holidays</strong> are processed on the next business day</li>
                        <li>Customized or personalized jewelry may require <strong>5-7 business days</strong> for processing</li>
                    </ul>
                    <div class="highlight">
                        <strong>📌 Note:</strong> Processing time does not include shipping time. The total delivery time = Processing Time + Shipping Time.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>2. Shipping Methods & Delivery Timelines</h2>
                    <p>We offer multiple shipping options to suit your needs. Delivery timelines are estimated and may vary based on location and courier partner.</p>
                    
                    <table class="shipping-table">
                        <thead>
                            <tr>
                                <th>Shipping Method</th>
                                <th>Delivery Time</th>
                                <th>Charges</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Standard Shipping</strong></td>
                                <td>3-5 business days</td>
                                <td>₹99</td>
                                <td><span class="shipping-badge badge-standard">Standard</span></td>
                            </tr>
                            <tr>
                                <td><strong>Express Shipping</strong></td>
                                <td>1-2 business days</td>
                                <td>₹199</td>
                                <td><span class="shipping-badge badge-express">Express</span></td>
                            </tr>
                            <tr>
                                <td><strong>Free Shipping</strong></td>
                                <td>3-5 business days</td>
                                <td><strong>FREE</strong> on orders above ₹5,000</td>
                                <td><span class="shipping-badge badge-free">FREE</span></td>
                            </tr>
                            <tr>
                                <td><strong>International Shipping</strong></td>
                                <td>7-14 business days</td>
                                <td>Calculated at checkout</td>
                                <td><span class="shipping-badge badge-standard">International</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="success-box">
                        <strong>🎉 Free Shipping:</strong> Enjoy free standard shipping on all orders above ₹5,000. No coupon code required!
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>3. Order Tracking</h2>
                    <p>Once your order is shipped, you will receive:</p>
                    <ul>
                        <li>A <strong>shipping confirmation email</strong> with your tracking number</li>
                        <li>An <strong>SMS</strong> with tracking details on your registered mobile number</li>
                        <li>Real-time <strong>tracking updates</strong> via our <a href="javascript:void(0)" onclick="checkLoginAndTrack()" style="color: #440C2C; font-weight: 500;">Track Order</a> page</li>
                    </ul>
                    <div class="highlight">
                        <strong>📌 Note:</strong> It may take 24-48 hours for tracking information to update after dispatch.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>4. Shipping Charges</h2>
                    <p>Shipping charges are calculated based on the following factors:</p>
                    <ul>
                        <li><strong>Order Value:</strong> Orders above ₹5,000 qualify for free standard shipping</li>
                        <li><strong>Shipping Method:</strong> Standard (₹99) or Express (₹199)</li>
                        <li><strong>Delivery Location:</strong> Metro cities, tier-2 cities, and remote areas may have different rates</li>
                        <li><strong>International Orders:</strong> Shipping charges are calculated at checkout based on destination</li>
                    </ul>
                    <div class="warning">
                        <strong>⚠️ Important:</strong> Shipping charges are non-refundable, even if the order is returned or cancelled.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>5. Delivery Areas</h2>
                    <p>We currently ship to:</p>
                    <ul>
                        <li><strong>PAN India:</strong> All states and union territories of India</li>
                        <li><strong>Metro Cities:</strong> Mumbai, Delhi, Bengaluru, Chennai, Hyderabad, Kolkata, Pune, Ahmedabad</li>
                        <li><strong>Tier-2 & Tier-3 Cities:</strong> All major cities and towns across India</li>
                        <li><strong>International:</strong> Select countries (USA, UK, UAE, Canada, Australia, Singapore, and more)</li>
                    </ul>
                    <p><em>For international shipping inquiries, please contact us at info@maherajewel.com</em></p>
                </div>
                
                <div class="policy-section">
                    <h2>6. Delivery Attempts & Failed Deliveries</h2>
                    <p>Our courier partners will make <strong>up to 3 delivery attempts</strong>:</p>
                    <ul>
                        <li>If delivery fails after 3 attempts, the package will be returned to our warehouse</li>
                        <li>A <strong>re-shipping fee</strong> will be charged for re-delivery attempts</li>
                        <li>Please ensure someone is available to receive the package at the delivery address</li>
                        <li>If you wish to reschedule delivery, contact our support team immediately</li>
                    </ul>
                </div>
                
                <div class="policy-section">
                    <h2>7. Damaged or Missing Packages</h2>
                    <p>We take utmost care in packaging your jewelry. However, in case of:</p>
                    <ul>
                        <li><strong>Damaged Package:</strong> Please refuse delivery and contact us immediately</li>
                        <li><strong>Missing Items:</strong> Contact us within 24 hours of delivery</li>
                        <li><strong>Wrong Item:</strong> Report within 24 hours with a photograph of the received item</li>
                    </ul>
                    <div class="warning">
                        <strong>⚠️ Important:</strong> Always unbox and inspect your order immediately upon delivery. Any damage or discrepancy must be reported within 24 hours.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>8. Address Changes</h2>
                    <p>If you need to change your shipping address:</p>
                    <ul>
                        <li><strong>Before Processing:</strong> Contact us immediately for free address change</li>
                        <li><strong>After Processing:</strong> Address changes may not be possible after dispatch</li>
                        <li><strong>Incorrect Address:</strong> A re-shipping fee will apply for orders returned due to incorrect address</li>
                    </ul>
                    <div class="highlight">
                        <strong>📌 Tip:</strong> Double-check your shipping address before placing your order to avoid delays.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>9. Customs & International Shipping</h2>
                    <p>For international orders:</p>
                    <ul>
                        <li>Customs duties and taxes are <strong>not included</strong> in our prices</li>
                        <li>These charges are the <strong>responsibility of the customer</strong></li>
                        <li>We recommend checking with your local customs office for applicable duties</li>
                        <li>Delivery timelines may be affected by customs clearance procedures</li>
                        <li>Please provide a valid phone number for customs contact</li>
                    </ul>
                    <div class="warning">
                        <strong>⚠️ Important:</strong> International orders may be delayed at customs. MAHERA JEWEL is not responsible for customs delays or additional charges.
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>10. Shipping Partner</h2>
                    <p>We partner with trusted logistics providers for safe and timely delivery:</p>
                    <ul>
                        <li><strong>Domestic:</strong> Delhivery, Ecom Express, Blue Dart, DTDC, India Post</li>
                        <li><strong>International:</strong> DHL, FedEx, Aramex, India Post International</li>
                    </ul>
                    <p><em>We reserve the right to choose the most appropriate shipping partner for your order based on location and delivery speed.</em></p>
                </div>
                
                <div class="policy-section">
                    <h2>11. Shipping Insurance</h2>
                    <p>All orders are <strong>fully insured</strong> during transit:</p>
                    <ul>
                        <li>Insurance covers the full value of your jewelry</li>
                        <li>In case of loss or damage, we will process a full refund or replacement</li>
                        <li>Insurance claims require supporting documentation (photographs, courier reports)</li>
                    </ul>
                    <div class="success-box">
                        <strong>✅ Peace of Mind:</strong> Every order is insured at no additional cost to you. Your precious jewelry is protected!
                    </div>
                </div>
                
                <div class="policy-section">
                    <h2>12. Contact Us</h2>
                    <p>For any shipping-related queries, reach out to us:</p>
                    
                    <div class="contact-box">
                        <h3>📧 Email:</h3>
                        <p>info@maherajewel.com</p>
                        
                        <h3>📞 Phone:</h3>
                        <p>+91 9653270168</p>
                        
                        <h3>🕐 Hours:</h3>
                        <p>Mon–Sat, 10AM – 10PM</p>
                        
                        <h3>📍 Address:</h3>
                        <p>Demo Street, Business Park, Mumbai, Maharashtra, India, 400068</p>
                    </div>
                </div>
                
                <div class="policy-section" style="text-align: center; border-bottom: none;">
                    <p style="font-size: 12px; color: #999;">© 2026 MAHERA JEWEL. All rights reserved.</p>
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