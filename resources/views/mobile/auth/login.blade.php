<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - StockFlow</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter',sans-serif;
    background:#f5f7fb;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.wrapper{
    width:100%;
    max-width:1000px;
    display:flex;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 25px 50px rgba(0,0,0,0.1);
}

/* Left Branding with Image */
.left{
    flex:1;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 40px;
    color:white;
    background:url('/images/login-bg.jpg') center center / cover no-repeat;
    min-height:300px;
}

/* Dark Overlay */
.left::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:linear-gradient(
        135deg,
        rgba(0,0,0,0.6),
        rgba(37,99,235,0.6)
    );
    z-index:1;
}

/* Keep text above overlay */
.left-content{
    position:relative;
    z-index:2;
    text-align:center;
    width:100%;
}

.left h1{
    font-size:30px;
    margin-bottom:15px;
    text-shadow:0 2px 4px rgba(0,0,0,0.3);
}

.left p{
    font-size:15px;
    opacity:0.95;
    line-height:1.6;
    text-shadow:0 1px 2px rgba(0,0,0,0.3);
}

/* Right Form */
.right{
    flex:1;
    padding:50px 40px;
}

.right h2{
    font-size:24px;
    margin-bottom:8px;
}

.subtitle{
    font-size:14px;
    color:#6b7280;
    margin-bottom:25px;
}

.alert{
    padding:12px 14px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:14px;
}

.alert-error{
    background:#fee2e2;
    color:#b91c1c;
}

.alert-success{
    background:#dcfce7;
    color:#166534;
}

label{
    font-size:13px;
    font-weight:600;
    display:block;
    margin-bottom:6px;
    color:#374151;
}

input{
    width:100%;
    padding:12px 14px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-size:14px;
    transition:0.3s;
    -webkit-appearance:none;
    appearance:none;
}

input:focus{
    border-color:#2563eb;
    outline:none;
    box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#2563eb;
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:15px;
    transition:0.3s;
    -webkit-appearance:none;
    appearance:none;
}

button:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

.links{
    display:flex;
    justify-content:flex-end;
    font-size:13px;
    margin-top:12px;
}

.links a{
    color:#2563eb;
    text-decoration:none;
    font-weight:500;
}

.links a:hover{
    text-decoration:underline;
}

.register{
    text-align:center;
    margin-top:25px;
    font-size:14px;
}

.register a{
    color:#2563eb;
    font-weight:600;
    text-decoration:none;
}

/* ========== MOBILE VIEW - COMPLETELY FIXED ========== */
@media(max-width:768px){
    body{
        display:block;
        background:#f5f7fb;
        padding:0;
    }

    .wrapper{
        flex-direction:column;
        max-width:100%;
        margin:0;
        border-radius:0;
        box-shadow:none;
        background:transparent;
    }

    /* LEFT SIDE - FULL BANNER FIX */
    .left{
        width:100%;
        min-height:350px; /* Fixed height for banner */
        height:auto;
        padding:0;
        background:url('/images/login-bg.jpg') center center / cover no-repeat;
        background-size:cover;
        background-position:center;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0;
    }

    /* Overlay fix */
    .left::before{
        background:linear-gradient(
            135deg,
            rgba(0,0,0,0.6),
            rgba(37,99,235,0.6)
        );
    }

    /* Content positioning */
    .left-content{
        padding:60px 25px;
        width:100%;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        gap:15px;
    }

    .left h1{
        font-size:32px;
        margin-bottom:5px;
        text-shadow:0 2px 8px rgba(0,0,0,0.5);
    }

    .left p{
        font-size:16px;
        line-height:1.5;
        max-width:300px;
        margin:0 auto;
        text-shadow:0 1px 4px rgba(0,0,0,0.5);
    }

    /* RIGHT SIDE - FORM BELOW BANNER */
    .right{
        background:#ffffff;
        margin-top:0;
        border-radius:30px 30px 0 0;
        padding:35px 25px 45px 25px;
        box-shadow:0 -5px 20px rgba(0,0,0,0.08);
    }

    .right h2{
        font-size:24px;
        text-align:center;
        margin-bottom:8px;
    }
    
    .subtitle{
        text-align:center;
        font-size:15px;
        margin-bottom:25px;
    }

    /* Better form inputs for mobile */
    label{
        font-size:14px;
        margin-bottom:8px;
    }

    input{
        padding:16px 18px;
        font-size:15px;
        border-radius:12px;
        background:#fafafa;
    }

    input:focus{
        background:#ffffff;
    }

    button{
        padding:18px;
        font-size:16px;
        border-radius:12px;
        margin-top:20px;
    }

    .links{
        justify-content:center;
    }

    .register{
        margin-top:25px;
        font-size:15px;
    }
}

/* Small Mobile Devices */
@media(max-width:480px){
    .left{
        min-height:300px;
    }
    
    .left-content{
        padding:50px 20px;
    }
    
    .left h1{
        font-size:28px;
    }
    
    .left p{
        font-size:15px;
        max-width:260px;
    }
    
    .right{
        padding:30px 20px 40px 20px;
    }
    
    .right h2{
        font-size:22px;
    }
}

/* Very Small Devices */
@media(max-width:360px){
    .left{
        min-height:280px;
    }
    
    .left-content{
        padding:40px 15px;
    }
    
    .left h1{
        font-size:24px;
    }
    
    .left p{
        font-size:14px;
    }
    
    .right{
        padding:25px 15px 35px 15px;
    }
}

/* iPhone SE */
@media(max-width:320px){
    .left{
        min-height:260px;
    }
    
    .left h1{
        font-size:22px;
    }
    
    .left p{
        font-size:13px;
    }
    
    .right{
        padding:20px 12px 30px 12px;
    }
}

/* Landscape Mode */
@media(max-height:500px) and (orientation:landscape){
    .left{
        min-height:200px;
    }
    
    .left-content{
        padding:30px 20px;
    }
    
    .left h1{
        font-size:24px;
    }
    
    .left p{
        font-size:14px;
    }
    
    .right{
        padding:20px 30px 30px 30px;
    }
}

/* Tablet view */
@media(min-width:769px) and (max-width:1024px){
    .left{
        padding:40px 30px;
    }
    
    .left h1{
        font-size:28px;
    }
    
    .right{
        padding:40px 30px;
    }
}

/* Better touch targets */
@media(max-width:768px){
    input, button, .links a, .register a{
        min-height:48px;
    }
    
    .links a, .register a{
        display:inline-block;
        padding:8px 12px;
    }
}
</style>
</head>
<body>

<div class="wrapper">

<div class="left">
    <div class="left-content">
        <h1>Welcome Back</h1>
        <p>Shop smarter. Earn rewards. Enjoy exclusive discounts.</p>
    </div>
</div>

<div class="right">
    <h2>Login to your account</h2>
    <div class="subtitle">Enter your credentials to continue.</div>

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div style="margin-bottom:18px;">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="links">
            <a href="#">Forgot password?</a>
        </div>

        <button type="submit">Login</button>

        <div class="register">
            Don't have an account? <a href="/register">Create Account</a>
        </div>
    </form>
</div>

</div>

</body>
</html>