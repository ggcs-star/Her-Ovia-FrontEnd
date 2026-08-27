<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Our Story | Her-Ovia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <meta name="description" content="Discover the story behind Maherá Jewels. From 20 years of crafting polki and kundan jewellery to a direct-to-consumer legacy.">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
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
            max-width: 1000px; /* Slightly narrower for better readability of a story */
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #440C2C;
            margin-bottom: 10px;
            font-family: 'Playfair Display', serif;
        }
        
        .page-header p {
            color: #666;
            font-size: 14px;
        }
        
        .page-header a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s;
        }

        .page-header a:hover {
            color: #F4B94E;
        }
        
        .about-content {
            background: #fff;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .story-section {
            margin-bottom: 30px;
        }
        
        .story-intro {
            font-size: 22px;
            font-weight: 600;
            color: #F4B94E;
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }
        
        .story-section p {
            font-size: 16px;
            color: #444;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        .quote-block {
            background: #fff5f0;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid #F4B94E;
            margin: 40px 0;
            text-align: center;
        }
        
        .quote-block p {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: #440C2C;
            font-style: italic;
            margin-bottom: 0;
            line-height: 1.5;
        }
        
        .signature-block {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
            text-align: right;
        }
        
        .signature-block p.closing {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-style: italic;
            color: #440C2C;
            margin-bottom: 10px;
        }
        
        .signature-block p.name {
            font-weight: 700;
            font-size: 18px;
            color: #333;
            margin-bottom: 4px;
        }
        
        .signature-block p.title {
            font-size: 14px;
            color: #666;
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
        
        @media (max-width: 768px) {
            .page-container {
                padding: 20px 15px;
            }
            .about-content {
                padding: 30px 20px;
            }
            .page-header h1 {
                font-size: 28px;
            }
            .story-intro {
                font-size: 18px;
            }
            .quote-block p {
                font-size: 20px;
            }
            .signature-block {
                text-align: left;
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
<body data-page="about">
    <header class="site-header" id="site-header"></header>
    
    <main class="page-content">
        <div class="page-container">
            <!-- <a href="javascript:history.back()" class="back-btn">← Back</a> -->
            
            <div class="page-header">
                <h1>Our Story</h1>
                <p><a href="https://www.maherajewels.com">www.maherajewels.com</a></p>
            </div>
            
            <div class="about-content">
                <div class="story-intro">
                    The craft was always ours. The name took twenty years.
                </div>
                
                <div class="story-section">
                    <p>I grew up in a family that knew jewellery the way most people never get to, from the inside. For over 20 years, my family worked as manufacturers in the background, supplying polki jewellery, kundan necklaces, earrings, and bridal sets to retailers and wholesalers across India.</p>
                    
                    <p>We weren’t the name anyone saw. But every piece that left a showroom floor, every bridal set that made a bride feel like herself on the most important morning of her life, a piece of our family went with it.</p>
                    
                    <p>Unseen. Unnamed. But always there.</p>
                </div>
                
                <div class="quote-block">
                    <p>“I watched my family spend 20 years perfecting something beautiful, and never once get to see the face of the woman who wore it.”</p>
                </div>
                
                <div class="story-section">
                    <p>That used to weigh on me. Because I knew what went into each piece. I knew the care behind every uncut polki stone, the patience in every hand-set kundan, the weight of what a bridal jewellery set truly means to a family. It isn’t decoration. It’s memory. It’s moment. It’s the thing she’ll look back at in photographs for the rest of her life.</p>
                    
                    <p>Something that precious deserved more than a middleman.</p>
                    
                    <p>So I made a decision, not just a business one, but a personal one. I wanted to take everything my family had quietly built over two decades and bring it directly to the women it was always meant for. No layers. No markups. No distance between the craft and the customer.</p>
                    
                    <p><strong>I wanted to give our legacy a name. That name is Maherá Jewels.</strong></p>
                    
                    <p>Today, when you browse our polki jewellery, pick a kundan necklace, or find the bridal set you’ve been dreaming of, you’re not just shopping. You’re connecting directly with a family that has spent 20 years learning how to make this right.</p>
                    
                    <p>This is our legacy, wearing its name for the very first time. And it was always made for you.</p>
                </div>
                
                <div class="signature-block">
                    <p class="closing">With love & legacy,</p>
                    <p class="name">Aryan Sanghani</p>
                    <p class="title">Founder, Maherá Jewels · Mumbai</p>
                </div>

                <div class="story-section" style="text-align: center; margin-top: 50px; margin-bottom: 0;">
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