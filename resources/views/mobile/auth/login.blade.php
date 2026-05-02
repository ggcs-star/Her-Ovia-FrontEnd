<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - RADIANT JEWEL</title>
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
.left{
    flex:1;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 40px;
    color:white;
    background:url('{{ asset("images/jewel.jpg") }}') center center / cover no-repeat;
    min-height:300px;
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
    text-align:center;
}
.left h1{
    font-size:30px;
    margin-bottom:15px;
    text-shadow:0 2px 4px rgba(0,0,0,0.3);
}
.left p{
    font-size:15px;
    opacity:0.95;
}
.right{
    flex:1;
    padding:50px 40px;
    background:white;
}
.right h2{
    font-size:24px;
    margin-bottom:8px;
    color: #440C2C;
}
.subtitle{
    font-size:14px;
    color:#6b7280;
    margin-bottom:25px;
}
.form-group{
    margin-bottom:18px;
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
}
input:focus{
    border-color: #F4B94E;
    outline:none;
    box-shadow:0 0 0 3px rgba(244,185,78,0.15);
}
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background: #440C2C;
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:15px;
    transition:0.3s;
}
button:hover{
    background: #5a1038;
    transform:translateY(-2px);
}
.login-link{
    text-align:center;
    margin-top:20px;
    font-size:13px;
}
.login-link a{
    color: #F4B94E;
    text-decoration:none;
    font-weight:600;
}

@media(max-width:768px){
    body{
        display:block;
        padding:0;
    }
    .wrapper{
        flex-direction:column;
        border-radius:0;
    }
    .left{
        min-height:300px;
        padding:0;
    }
    .left-content{
        padding:50px 25px;
    }
    .right{
        padding:35px 25px;
    }
}
@media(min-width:769px){
    body{
        padding:40px;
    }
    .wrapper{
        max-width:1300px;
        border-radius:32px;
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
        
        <form id="loginForm">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
            </div>
            <div class="login-link">
                <a href="javascript:void(0)" onclick="showForgotPopup()">Forgot password?</a>
            </div>
            <button type="submit">Login</button>
            <div class="login-link">
                Don't have an account? <a href="javascript:void(0)" onclick="showRegisterPopup()">Create Account</a>
            </div>
        </form>
    </div>
</div>

<script>
window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
const BASE_URL = window.API_BASE_URL;

// ========== LOGIN FORM SUBMIT ==========
document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const email = document.querySelector("input[name='email']").value.trim();
    const password = document.querySelector("input[name='password']").value;
    
    if(!email || !password) {
        alert("Please enter both email and password");
        return;
    }
    if(!/^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(email)) {
        alert("Please enter a valid email address");
        return;
    }
    
    try {
        const response = await fetch(BASE_URL + "/user/login", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ email, password })
        });
        const data = await response.json();
        
        if(response.ok && data.token) {
            localStorage.setItem("token", data.token);
            if(data.user) localStorage.setItem("user", JSON.stringify(data.user));
            alert("Login Successful!");
            window.location.href = '/profile';
        } else {
            if(data.message && data.message.toLowerCase().includes("verify")) {
                localStorage.setItem("verify_email", email);
                window.location.href = "/verify-otp";
            } else {
                alert(data.message || "Login failed");
            }
        }
    } catch(error) {
        alert("Server error. Please try again.");
    }
});

// ========== REGISTER POPUP ==========
function showRegisterPopup() {
    let popup = document.getElementById('auth-popup');
    if(popup) popup.remove();
    
    const html = `
    <div id="auth-popup" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:99999; display:flex; align-items:center; justify-content:center;">
        <div style="background:white; width:90%; max-width:1000px; border-radius:28px; overflow:hidden; display:flex; flex-wrap:wrap; position:relative;">
            <span onclick="document.getElementById('auth-popup').remove()" style="position:absolute; top:16px; right:20px; font-size:28px; cursor:pointer; background:white; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center;">&times;</span>
            <div style="flex:1; min-width:280px; background:url('{{ asset("images/jewel.jpg") }}') center center/cover no-repeat; position:relative; min-height:450px;">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:linear-gradient(135deg, rgba(68,12,44,0.7), rgba(68,12,44,0.85));"></div>
                <div style="position:relative; z-index:2; display:flex; flex-direction:column; justify-content:center; align-items:center; height:100%; padding:40px; color:white; text-align:center;">
                    <h1 style="font-size:42px; font-weight:800;">Join RADIANT</h1>
                    <p style="font-size:18px;">Get exclusive discounts & cashback rewards</p>
                </div>
            </div>
            <div style="flex:1; min-width:300px; padding:45px 40px; background:white;">
                <div style="max-width:340px; margin:0 auto;">
                    <h2 style="color:#440C2C; font-size:28px; text-align:center;">Create Account</h2>
                    <p style="color:#666; text-align:center; margin-bottom:32px;">Start shopping smarter today</p>
                    <input type="text" id="reg-name" placeholder="Full Name" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:15px;">
                    <input type="email" id="reg-email" placeholder="Email Address" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:15px;">
                    <input type="password" id="reg-password" placeholder="Password" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:20px;">
                    <button id="registerBtn" style="width:100%; background:#440C2C; color:white; padding:15px; border:none; border-radius:12px; font-weight:600; cursor:pointer;">Create Account</button>
                    <div style="text-align:center; margin-top:20px;">
                        <a href="javascript:void(0)" onclick="showLoginPopup()" style="color:#F4B94E;">Already have an account? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', html);
    
    document.getElementById('registerBtn')?.addEventListener('click', async () => {
        const name = document.getElementById('reg-name').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const password = document.getElementById('reg-password').value;
        
        if(!name || !email || !password) { alert("All fields required"); return; }
        if(name.length < 2) { alert("Name must be at least 2 characters"); return; }
        if(!/^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(email)) { alert("Enter valid email"); return; }
        if(password.length < 8) { alert("Password must be at least 8 characters"); return; }
        
        try {
            const res = await fetch(BASE_URL + "/user/register", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({name, email, password, password_confirmation: password})
            });
            const data = await res.json();
            if(res.ok && data.success) {
                alert("Registration successful! Please login.");
                document.getElementById('auth-popup').remove();
                showLoginPopup();
            } else {
                alert(data.message || "Registration failed");
            }
        } catch(err) { alert("Server error"); }
    });
}

// ========== LOGIN POPUP ==========
function showLoginPopup() {
    let popup = document.getElementById('auth-popup');
    if(popup) popup.remove();
    
    const html = `
    <div id="auth-popup" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:99999; display:flex; align-items:center; justify-content:center;">
        <div style="background:white; width:90%; max-width:1000px; border-radius:28px; overflow:hidden; display:flex; flex-wrap:wrap; position:relative;">
            <span onclick="document.getElementById('auth-popup').remove()" style="position:absolute; top:16px; right:20px; font-size:28px; cursor:pointer; background:white; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center;">&times;</span>
            <div style="flex:1; min-width:280px; background:url('{{ asset("images/jewel.jpg") }}') center center/cover no-repeat; position:relative; min-height:450px;">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:linear-gradient(135deg, rgba(68,12,44,0.7), rgba(68,12,44,0.85));"></div>
                <div style="position:relative; z-index:2; display:flex; flex-direction:column; justify-content:center; align-items:center; height:100%; padding:40px; color:white; text-align:center;">
                    <h1 style="font-size:42px; font-weight:800;">Welcome Back</h1>
                    <p style="font-size:18px;">Shop smarter. Earn rewards. Enjoy exclusive discounts.</p>
                </div>
            </div>
            <div style="flex:1; min-width:300px; padding:50px 40px; background:white;">
                <div style="max-width:340px; margin:0 auto;">
                    <h2 style="color:#440C2C; font-size:28px; text-align:center;">Login</h2>
                    <p style="color:#666; text-align:center; margin-bottom:32px;">Enter your credentials</p>
                    <input type="email" id="login-email" placeholder="Email Address" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:15px;">
                    <input type="password" id="login-password" placeholder="Password" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:20px;">
                    <button id="loginBtn" style="width:100%; background:#440C2C; color:white; padding:15px; border:none; border-radius:12px; font-weight:600; cursor:pointer;">Login</button>
                    <div style="text-align:center; margin-top:15px;">
                        <a href="javascript:void(0)" onclick="showForgotPopup()" style="color:#F4B94E;">Forgot Password?</a>
                    </div>
                    <div style="text-align:center; margin-top:20px;">
                        <a href="javascript:void(0)" onclick="showRegisterPopup()" style="color:#F4B94E;">Don't have an account? Create Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', html);
    
    document.getElementById('loginBtn')?.addEventListener('click', async () => {
        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value;
        
        if(!email || !password) { alert("Please enter email and password"); return; }
        
        try {
            const res = await fetch(BASE_URL + "/user/login", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({email, password})
            });
            const data = await res.json();
            if(res.ok && data.token) {
                localStorage.setItem("token", data.token);
                if(data.user) localStorage.setItem("user", JSON.stringify(data.user));
                alert("Login Successful!");
                document.getElementById('auth-popup').remove();
                window.location.reload();
            } else {
                alert(data.message || "Login failed");
            }
        } catch(err) { alert("Server error"); }
    });
}

// ========== FORGOT PASSWORD POPUP ==========
function showForgotPopup() {
    let popup = document.getElementById('auth-popup');
    if(popup) popup.remove();
    
    const html = `
    <div id="auth-popup" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:99999; display:flex; align-items:center; justify-content:center;">
        <div style="background:white; width:90%; max-width:450px; border-radius:28px; position:relative; padding:45px 40px;">
            <span onclick="document.getElementById('auth-popup').remove()" style="position:absolute; top:16px; right:20px; font-size:28px; cursor:pointer;">&times;</span>
            <h2 style="color:#440C2C; font-size:26px; text-align:center;">Reset Password</h2>
            <p style="text-align:center; color:#666; margin-bottom:28px;">Enter your email to receive reset link</p>
            <input type="email" id="forgot-email" placeholder="Email Address" style="width:100%; padding:14px; border-radius:12px; border:1px solid #ddd; margin-bottom:24px;">
            <button id="forgotBtn" style="width:100%; background:#440C2C; color:white; padding:15px; border:none; border-radius:12px; cursor:pointer;">Send Reset Link</button>
            <div style="text-align:center; margin-top:20px;">
                <a href="javascript:void(0)" onclick="showLoginPopup()" style="color:#F4B94E;">Back to Login</a>
            </div>
        </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', html);
    
    document.getElementById('forgotBtn')?.addEventListener('click', async () => {
        const email = document.getElementById('forgot-email').value.trim();
        if(!email) { alert("Please enter your email"); return; }
        
        try {
            const res = await fetch(BASE_URL + "/user/forgot-password", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({email})
            });
            const data = await res.json();
            alert(data.message || "Reset link sent to your email");
            document.getElementById('auth-popup').remove();
            showLoginPopup();
        } catch(err) { alert("Server error"); }
    });
}

// Make functions global
window.showLoginPopup = showLoginPopup;
window.showRegisterPopup = showRegisterPopup;
window.showForgotPopup = showForgotPopup;

// Auto redirect if already logged in
if (localStorage.getItem('token')) {
    window.location.href = '/profile';
}
</script>
</body>
</html>