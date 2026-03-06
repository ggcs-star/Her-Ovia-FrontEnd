<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Terms | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f8f8f8;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        .coupon-page {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
        }
        .header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            background: white;
        }
        .back-btn {
            font-size: 24px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            border-radius: 50%;
            text-decoration: none;
            color: #333;
        }
        .header h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .loading {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        .coupon-card-large {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            border: 1px solid #ffe0e0;
        }
        .coupon-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .bank-badge {
            background: #ff3f6c;
            color: white;
        }
        .normal-badge {
            background: #27ae60;
            color: white;
        }
        .coupon-code {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }
        .coupon-desc {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            background: #f8f8f8;
            padding: 20px;
            border-radius: 16px;
            margin: 20px 0;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .info-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }
        .terms-section {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .terms-section h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 16px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .terms-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .terms-list li {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            gap: 12px;
            font-size: 15px;
            color: #333;
        }
        .terms-list li:last-child {
            border-bottom: none;
        }
        .terms-list li::before {
            content: "•";
            color: #ff3f6c;
            font-weight: bold;
            font-size: 20px;
        }
        .apply-btn {
            background: #ff3f6c;
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="coupon-page">
        <div class="header">
            <a href="javascript:history.back()" class="back-btn">←</a>
            <h1>Coupon Details</h1>
        </div>

        <div class="content" id="coupon-details">
            <div class="loading">Loading...</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const code = sessionStorage.getItem('view_coupon_code');
            if (!code) {
                window.location.href = '/cart';
                return;
            }

            fetch('https://retailadmin.ggconsultancy.services/api/coupons')
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const coupon = response.data.find(c => c.code === code);
                        if (coupon) {
                            renderCouponDetails(coupon);
                        } else {
                            document.getElementById('coupon-details').innerHTML = '<div class="loading">Coupon not found</div>';
                        }
                    }
                })
                .catch(() => {
                    document.getElementById('coupon-details').innerHTML = '<div class="loading">Error loading coupon</div>';
                });
        });

        function renderCouponDetails(coupon) {
            const isBank = coupon.coupon_type === 'BANK';
            const badgeClass = isBank ? 'bank-badge' : 'normal-badge';
            const badgeText = isBank ? '🏦 Bank Offer' : '🎫 Special Offer';

            let termsList = '';
            if (coupon.terms) {
                termsList = coupon.terms.split('\n').map(t => `<li>${t}</li>`).join('');
            } else {
                termsList = `
                    <li>Valid on minimum order of ₹${coupon.min_order_amount || '999'}</li>
                    <li>Cannot be combined with other offers</li>
                    <li>Valid for one time use only</li>
                    <li>Offer valid till ${coupon.valid_till ? new Date(coupon.valid_till).toLocaleDateString('en-IN') : 'further notice'}</li>
                `;
            }

            const html = `
                <div class="coupon-card-large">
                    <span class="coupon-badge ${badgeClass}">${badgeText}</span>
                    <div class="coupon-code">${coupon.code}</div>
                    <div class="coupon-desc">${coupon.description || coupon.name || 'Special discount on your order'}</div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Min. Order</span>
                        <span class="info-value">₹${coupon.min_order_amount || '999'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Max Discount</span>
                        <span class="info-value">${coupon.max_discount ? '₹' + coupon.max_discount : 'No limit'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Valid Till</span>
                        <span class="info-value">${coupon.valid_till ? new Date(coupon.valid_till).toLocaleDateString('en-IN') : 'Ongoing'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Discount</span>
                        <span class="info-value">${coupon.discount_type === 'PERCENT' ? coupon.value + '%' : '₹' + coupon.value}</span>
                    </div>
                </div>

                <div class="terms-section">
                    <h3>📋 Terms & Conditions</h3>
                    <ul class="terms-list">
                        ${termsList}
                    </ul>
                </div>

                
            `;

            document.getElementById('coupon-details').innerHTML = html;
        }

        function applyCoupon(code) {
            sessionStorage.setItem('apply_coupon', code);
            window.location.href = '/cart';
        }
    </script>
</body>
</html>