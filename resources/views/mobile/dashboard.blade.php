<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>StockFlow Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter',sans-serif;
    background:#fff;
    color:#111;
}

/* Navbar */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    border-bottom:1px solid #eee;
}

.logo{
    font-size:22px;
    font-weight:700;
    letter-spacing:2px;
}

.nav-links{
    display:flex;
    gap:25px;
}

.nav-links a{
    text-decoration:none;
    color:#111;
    font-size:14px;
    font-weight:500;
}

.nav-icons{
    display:flex;
    gap:20px;
    font-size:18px;
}

/* Hero Banner */
.hero{
    height:400px;
    background:url('https://images.unsplash.com/photo-1521335629791-ce4aec67dd53') center/cover no-repeat;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-align:center;
}

.hero h1{
    font-size:40px;
    font-weight:700;
    background:rgba(0,0,0,0.5);
    padding:15px 30px;
}

/* Section */
.section{
    padding:60px 50px;
}

.section-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:30px;
}

/* Product Grid */
.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:30px;
}

.product-card{
    border:1px solid #eee;
    border-radius:10px;
    overflow:hidden;
    transition:0.3s;
    background:#fff;
}

.product-card:hover{
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transform:translateY(-5px);
}

.product-card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.product-info{
    padding:15px;
}

.product-info h3{
    font-size:15px;
    font-weight:500;
    margin-bottom:8px;
}

.price{
    font-weight:700;
    margin-bottom:10px;
}

.btn{
    display:block;
    width:100%;
    padding:10px;
    text-align:center;
    background:#111;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    border-radius:6px;
    transition:0.3s;
}

.btn:hover{
    background:#444;
}

/* Footer */
.footer{
    text-align:center;
    padding:30px;
    border-top:1px solid #eee;
    margin-top:50px;
    font-size:13px;
}

/* Responsive */
@media(max-width:768px){
    .navbar{
        flex-direction:column;
        gap:15px;
    }
    .section{
        padding:40px 20px;
    }
}
</style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">STOCKFLOW</div>
    <div class="nav-links">
        <a href="#">Men</a>
        <a href="#">Women</a>
        <a href="#">Kids</a>
        <a href="#">New Arrivals</a>
    </div>
    <div class="nav-icons">
        🔍 🛒 👤
    </div>
</div>

<!-- Hero Banner -->
<div class="hero">
    <h1>NEW SEASON COLLECTION</h1>
</div>

<!-- Products Section -->
<div class="section">
    <div class="section-title">Trending Products</div>
    <div class="products">

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab">
            <div class="product-info">
                <h3>Casual T-Shirt</h3>
                <div class="price">₹799</div>
                <a href="#" class="btn">Add to Cart</a>
            </div>
        </div>

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1520975916090-3105956dac38">
            <div class="product-info">
                <h3>Denim Jacket</h3>
                <div class="price">₹2,199</div>
                <a href="#" class="btn">Add to Cart</a>
            </div>
        </div>

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff">
            <div class="product-info">
                <h3>Sports Sneakers</h3>
                <div class="price">₹3,499</div>
                <a href="#" class="btn">Add to Cart</a>
            </div>
        </div>

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f">
            <div class="product-info">
                <h3>Stylish Watch</h3>
                <div class="price">₹4,999</div>
                <a href="#" class="btn">Add to Cart</a>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<div class="footer">
    © 2026 StockFlow · All Rights Reserved
</div>

</body>
</html>
