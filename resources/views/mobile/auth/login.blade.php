<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - StockFlow</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
.back-arrow {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    color: white;
    text-decoration: none;
    font-size: 28px;
    font-weight: bold;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}
.back-arrow:hover {
    transform: scale(1.1);
    color: white;
}
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
.password-wrapper {
    position: relative;
    width: 100%;
}
.password-wrapper input {
    padding-right: 45px;
}
.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    color: #999;
    user-select: none;
    background: transparent;
    border: none;
    padding: 5px;
    z-index: 10;
}
.toggle-password:hover {
    color: #ff3f6c;
}
.left{
    flex:1;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 40px;
    color:white;
    background:url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format') center center / cover no-repeat;
    min-height:300px;
}
.left::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:linear-gradient(135deg,rgba(0,0,0,0.6),rgba(255,63,108,0.6));
    z-index:1;
}
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
    background:#ff3f6c;
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:15px;
    transition:0.3s;
    -webkit-appearance:none;
    appearance:none;
}
button:hover{
    background:#e6395e;
    transform:translateY(-2px);
}
.links{
    display:flex;
    justify-content:flex-end;
    font-size:13px;
    margin-top:12px;
}
.links a{
    color:#ff3f6c;
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
    color:#ff3f6c;
    font-weight:600;
    text-decoration:none;
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
        background:url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format') center center / cover no-repeat;
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
        border-color:#ff3f6c;
        box-shadow:0 0 0 3px rgba(255,63,108,0.15);
    }
    button{
        padding:18px;
        font-size:16px;
        border-radius:12px;
        margin-top:20px;
        background:#ff3f6c;
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
    color:#ff3f6c;
}
}
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
@media(max-width:768px){
    input, button, .links a, .register a{
        min-height:48px;
    }
    .links a, .register a{
        display:inline-block;
        padding:8px 12px;
    }
}
@media(max-width:768px){
    .left::before{
        background:linear-gradient(135deg,rgba(0,0,0,0.6),rgba(255,63,108,0.6));
    }
}
.eye-icon {
    display: none;
    color: #999;
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
<form id="loginForm">
        @csrf
        <div style="margin-bottom:18px;">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
        </div>
        <div style="margin-bottom:10px;">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
                <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
                    <svg class="eye-icon open-eye" viewBox="0 0 24 24" width="22" height="22">
                        <path fill="currentColor" d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                    </svg>
                    <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="22" height="22">
                        <path fill="currentColor" d="M12 5c-5 0-9.27 3.11-11 7 1.05 2.36 2.98 4.3 5.42 5.52L3 21l1.41 1.41L21 5.83 19.59 4.41l-3.01 3.01C15.06 6.54 13.57 5 12 5zm0 12c-1.57 0-3.06-.54-4.58-1.42l1.5-1.5A3 3 0 0 0 12 15a3 3 0 0 0 2.92-2.92l1.5-1.5C17.46 12.06 18 13.55 18 15c0 1.66-2.24 3-6 3z"/>
                    </svg>
                </span>
            </div>
        </div>
        <div class="links">
            <a href="/forgot-password">Forgot password?</a>
        </div>
        <button type="submit">Login</button>
        <div class="register">
            Don't have an account? <a href="/register">Create Account</a>
        </div>
    </form>
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