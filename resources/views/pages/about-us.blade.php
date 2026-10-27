<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Our Story | Her-Ovia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/her-ovia.png') }}">
    <meta name="description" content="Discover the story behind Her-Ovia, a clothing brand created to bring timeless fashion, effortless style, and thoughtfully designed ethnic wear directly to you.">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('mobile/style.css') }}?v={{ time() }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('mobile/style.css') }}?v={{ time() }}"></noscript>
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
     <div class="desktop-sticky-header">

    <div class="herovia-announcement">
        Free Shipping on Orders Above ₹999 | Use Code: FIRST50
    </div>

    <header class="site-header" id="site-header"></header>

</div>

    
    <main class="page-content">
        <div class="page-container">
            <!-- <a href="javascript:history.back()" class="back-btn">← Back</a> -->
            
            <div class="page-header">
                <h1>Our Story</h1>
                <p><a href="https://heroviafront.jagods.in/">heroviafront.jagods.in</a></p>
            </div>
            
            <div class="about-content">
                <div class="story-intro">
                    Style was always part of our story. Her-Ovia gave it a name.
                </div>
                
                <div class="story-section">
                    <p>Her-Ovia was created with a simple belief: clothing should feel beautiful, comfortable, and true to the woman wearing it. We wanted to create fashion that brings together timeless Indian aesthetics with a fresh, contemporary sense of style.</p>

                    <p>Every outfit is designed to feel special, whether it is something you wear for an everyday moment, a celebration, a festive occasion, or simply because you want to feel your best.</p>

                    <p>Thoughtful. Timeless. Made for you.</p>
                </div>
                
                <div class="quote-block">
                    <p>“We wanted to create clothes that make every woman feel confident, comfortable, and beautifully herself.”</p>
                </div>
                
                <div class="story-section">
                    <p>Fashion is more than what we wear. It is how we express ourselves, how we celebrate moments, and how we carry a little bit of our personality wherever we go.</p>

                    <p>That is why Her-Ovia focuses on creating thoughtfully designed clothing that balances elegance with everyday ease. From coordinated sets and dresses to kurtas and ethnic wear, every collection is designed to become a natural part of your wardrobe.</p>

                    <p>We believe great style should not feel complicated. It should feel effortless, versatile, and personal.</p>

                    <p><strong>We wanted to create a brand that feels personal, timeless, and effortlessly stylish. That name is Her-Ovia.</strong></p>

                    <p>Today, when you explore our collections, discover a new outfit, or find a piece that feels just right for you, you are becoming part of the Her-Ovia story. A story built around fashion, individuality, and the joy of finding something that feels uniquely yours.</p>

                    <p>This is Her-Ovia — thoughtfully designed clothing, timeless style, and fashion made to be a part of your story.</p>
                </div>
                
                <div class="signature-block">
                    <p class="closing">With love & style,</p>
                    <p class="name">Her-Ovia</p>
                    <p class="title">Founder, Her-Ovia · Ahmedabad</p>
                </div>

                <div class="story-section" style="text-align: center; margin-top: 50px; margin-bottom: 0;">
                    <p style="font-size: 12px; color: #999;">©️ {{ date('Y') }} Her-Ovia. All rights reserved.</p>
                </div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>

    <script>
        window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
    </script>
    <script src="{{ asset('mobile/script.js') }}?v={{ time() }}"></script>
    @include('mobile.auth.auth')

    <script>
        setTimeout(function() {
            let index = 0;
            const input = document.getElementById('web-search-input');

            if (input) {
                const updatePlaceholder = () => {
                    const categories = Array.isArray(window.allCategories)
                        ? window.allCategories
                        : [];

                    if (!categories.length) {
                        input.placeholder = 'Search for Category, Product ...';
                        return;
                    }

                    input.placeholder = 'Search for ' + (
                        categories[index]?.name || 'Category'
                    );

                    index = (index + 1) % categories.length;
                };

                updatePlaceholder();

                setInterval(function() {
                    updatePlaceholder();
                }, 3000);
            }
        }, 2000);
    </script>
</body>
</html>