<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - RADIANT JEWEL</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
.back-arrow {
    position: fixed;
    top: 30px;
    left: 30px;
    z-index: 1000;
    color: white;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    transition: all 0.3s ease;
}
.back-arrow:hover {
    transform: translateX(-5px);
    background: rgba(255, 255, 255, 0.2);
}
body{
    font-family:'Inter',sans-serif;
    background:#ffffff;
    min-height:100vh;
    overflow-x: hidden;
}
.wrapper{
    width:100%;
    min-height:100vh;
    display:flex;
    background:#fff;
}
.password-wrapper {
    position: relative;
    width: 100%;
}
.password-wrapper input {
    padding-right: 45px;
}
.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.3s;
}
.toggle-password:hover {
    color: #F4B94E;
}
.left{
    flex: 0 0 40%;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:80px;
    color:white;
    background:url('{{ asset("images/jewel.jpg") }}') center center / cover no-repeat;
}
.left::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: linear-gradient(135deg, rgba(68,12,44,0.6), rgba(68,12,44,0.8));
    z-index:1;
}
.left-content{
    position:relative;
    z-index:2;
    max-width: 500px;
}
.left h1{
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 24px;
    line-height: 1.1;
    letter-spacing: -0.02em;
}
.left p{
    font-size: 18px;
    opacity: 0.9;
    line-height: 1.6;
    margin-bottom: 40px;
}
.right{
    flex: 1;
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #fff;
}
.form-container {
    width: 100%;
    max-width: 420px;
}
.brand-logo {
    font-size: 32px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 40px;
    letter-spacing: -0.02em;
}
.brand-logo span {
    color: #F4B94E;
}
.right h2{
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    text-align: center;
    color: #111827;
}
.subtitle{
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 40px;
    text-align: center;
}
.alert{
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    border: 1px solid transparent;
}
.alert-error{
    background: #fef2f2;
    color: #991b1b;
    border-color: #fee2e2;
}
.alert-success{
    background: #f0fdf4;
    color: #166534;
    border-color: #dcfce7;
}
label{
    font-size: 14px;
    font-weight: 500;
    display: block;
    margin-bottom: 8px;
    color: #374151;
}
input{
    width: 100%;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 15px;
    transition: all 0.3s ease;
    color: #111827;
}
input::placeholder {
    color: #9ca3af;
}
input:focus{
    border-color: #F4B94E;
    box-shadow: 0 0 0 4px rgba(244,185,78,0.1);
    background: #fff;
    outline: none;    
}
button{
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    background: #440C2C;
    box-shadow: 0 4px 6px -1px rgba(68,12,44,0.2);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 24px;
    transition: all 0.3s ease;
}
button:hover{
    background: #5a1038;
    box-shadow: 0 10px 15px -3px rgba(68,12,44,0.3);
    transform: translateY(-1px);
}
button:active {
    transform: translateY(0);
}
.links{
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
.links a{
    color: #F4B94E;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.3s;
}
.links a:hover{
    color: #d4a13e;
}
.register-section {
    margin-top: 40px;
    text-align: center;
    border-top: 1px solid #f3f4f6;
    padding-top: 32px;
}
.register-text {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 16px;
}
.register-btn {
    display: inline-block;
    width: 100%;
    padding: 14px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    color: #374151;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}
.register-btn:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #111827;
}

@media(max-width:1024px){
    .left {
        padding: 40px;
    }
    .left h1 {
        font-size: 36px;
    }
}

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
    .left{
        width:100%;
        min-height:350px;
        height:auto;
        padding:0;
        background:url('{{ asset("images/jewel.jpg") }}') center center / cover no-repeat;
        background-size:cover;
        background-position:center;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0;
    }
    .left::before{
        background:linear-gradient(135deg,rgba(0,0,0,0.6),rgba(255,63,108,0.6));
    }
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
        border-color: #F4B94E;
        box-shadow: 0 0 0 3px rgba(244,185,78,0.15);
    }
    button{
        padding:18px;
        font-size:16px;
        border-radius:12px;
        margin-top:20px;
        background: #440C2C;
    }
    button:hover{
        background:#e6395e;
    }
    .links{
        justify-content:center;
    }
    .register{
        margin-top:25px;
        font-size:15px;
    }
    .links a, .register a{
        color: #F4B94E;
}
}
.eye-icon {
    display: none;
    color: #9ca3af;
}
.open-eye {
    display: inline;
}
.toggle-password.active .open-eye {
    display: none;
}
.toggle-password.active .closed-eye {
    display: inline;
}
@media(min-width: 769px){
    body{
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: #f5f7fb;
    }
    .wrapper{
        max-width: 1300px;
        width: 100%;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    }
    .left{
        flex: 0 0 45%;
        padding: 60px 50px;
    }
    .right{
        flex: 0 0 55%;
        padding: 60px 50px;
    }
    .form-container{
        max-width: 450px;
        margin: 0 auto;
    }
}
</style>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">←</a>
<div class="wrapper">
<div class="left">
    <div class="left-content">
        <h1>Welcome Back</h1>
        <p>Shop smarter. Earn rewards. Enjoy exclusive discounts.</p>
    </div>
</div>
<div class="right">
    <div class="form-container">
        <div class="brand-logo">RADIANT <span>JEWEL</span></div>
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
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="loginForm">
            @csrf
            <div style="margin-bottom:20px;">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>
            <div style="margin-bottom:12px;">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
                        <svg class="eye-icon open-eye" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>
                        <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="links">
                <a href="/forgot-password">Forgot password?</a>
            </div>
            <button type="submit">Login</button>
            
            <div class="register-section">
                <div class="register-text">Don't have an account?</div>
                <a href="/register" class="register-btn">Create Account</a>
            </div>
        </form>
    </div>
<script>
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script>
    if (localStorage.getItem('token')) {
        window.history.replaceState(null, null, '/profile');

        window.location.replace('/profile');
    }
</script>
<script>
const BASE_URL = window.API_BASE_URL;
function showAlert(message, type) {
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) existingAlert.remove();
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    const form = document.getElementById('loginForm');
    form.parentNode.insertBefore(alertDiv, form);
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const email = document.querySelector("input[name='email']").value.trim();
    const password = document.querySelector("input[name='password']").value;
    if (!email || !password) {
        showAlert("Please enter both email and password", 'error');
        return;
    }
    
    if (!/^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(email)) {
        showAlert("Please enter a valid email address", 'error');
        return;
    }
    try {
        const response = await fetch(BASE_URL + "/user/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ email, password })
        });
        const data = await response.json();
        console.log("LOGIN RESPONSE:", data);
        if (response.ok && data.token) {
    const guestCart = localStorage.getItem('cart');
    const guestWishlist = localStorage.getItem('wishlist');
    const guestCoupon = localStorage.getItem('applied_coupon');
    const guestDiscount = localStorage.getItem('coupon_discount');
    
    localStorage.clear();
    
    if (guestCart) localStorage.setItem('cart', guestCart);
    if (guestWishlist) localStorage.setItem('wishlist', guestWishlist);
    if (guestCoupon) localStorage.setItem('applied_coupon', guestCoupon);
    if (guestDiscount) localStorage.setItem('coupon_discount', guestDiscount);
    
    localStorage.setItem("token", data.token);
    localStorage.setItem("user", JSON.stringify(data.user));
    
    const savedRedirect = sessionStorage.getItem('redirect_after_login');
    let redirectUrl = '/profile';
    
    if (savedRedirect && savedRedirect !== 'null' && savedRedirect !== '') {
        redirectUrl = savedRedirect;
    }
    
    sessionStorage.clear();
    
    console.log('Redirecting to:', redirectUrl);
    window.location.href = redirectUrl;

        } else {
            if (data.message && data.message.toLowerCase().includes("verify")) {
                localStorage.setItem("verify_email", email);
                window.location.href = "/verify-otp";
            } else {
                showAlert(data.message || "Login failed", 'error');  
            }
        }
    } catch (error) {
        console.error("Login error:", error);
        showAlert("Server error. Please try again.", 'error'); 
    }
});
function togglePassword(inputId, element) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        element.classList.add('active');
    } else {
        input.type = 'password';
        element.classList.remove('active');
    }
}
</script>
</div>
</div>
</body>
</html>
