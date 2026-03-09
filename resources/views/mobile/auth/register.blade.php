<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
<title>Register - StockFlow</title>

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

/* LEFT SIDE WITH VIDEO */
.left{
    position:relative;
    flex:1;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    min-height:300px;
}

/* Video */
.bg-video{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    width:100%;
    height:100%;
    object-fit:cover;
}

/* Overlay for readability */
.overlay{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    z-index:1;
}

/* Text content */
.left-content{
    position:relative;
    z-index:2;
    padding:60px 40px;
    width:100%;
}

.left h1{
    font-size:32px;
    margin-bottom:15px;
}

.left p{
    font-size:15px;
    opacity:0.9;
    line-height:1.6;
}

/* RIGHT FORM */
.right{
    flex:1;
    padding:50px 40px;
}

.right h2{
    margin-bottom:10px;
    font-size:24px;
}

.subtitle{
    font-size:14px;
    color:#6b7280;
    margin-bottom:30px;
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
    margin-top:10px;
    -webkit-appearance:none;
    appearance:none;
}

button:hover{
    background:#1d4ed8;
}

.login-link{
    text-align:center;
    margin-top:20px;
    font-size:14px;
}

.login-link a{
    color:#2563eb;
    text-decoration:none;
    font-weight:600;
}

/* Mobile Responsive - Full Video & Form Below */
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

    /* Full Video Section - No Cut */
    .left{
        height:auto;
        min-height:350px;
        width:100%;
        position:relative;
        display:flex;
        aspect-ratio:16/9; /* Maintains video aspect ratio */
    }

    .bg-video{
        position:absolute;
        top:0;
        left:0;
        transform:none;
        width:100%;
        height:100%;
        object-fit:cover;
        object-position:center;
    }

    .overlay{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.5);
        z-index:1;
    }

    .left-content{
        position:relative;
        z-index:2;
        text-align:center;
        padding:50px 20px;
        height:100%;
        width:100%;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }

    .left h1{
        font-size:28px;
        margin-bottom:12px;
        color:white;
        text-shadow:0 2px 8px rgba(0,0,0,0.5);
    }

    .left p{
        font-size:15px;
        line-height:1.6;
        color:white;
        text-shadow:0 1px 4px rgba(0,0,0,0.5);
        max-width:320px;
        margin:0 auto;
    }

    /* Form Section - Moved Down with Space */
    .right{
        background:#ffffff;
        margin-top:0; /* Removed negative margin */
        border-radius:30px 30px 0 0;
        padding:35px 25px 45px 25px;
        box-shadow:0 -5px 20px rgba(0,0,0,0.08);
        position:relative;
        z-index:3;
    }

    .right h2{
        font-size:24px;
        text-align:center;
        margin-bottom:8px;
    }
    
    .subtitle{
        text-align:center;
        font-size:15px;
        margin-bottom:30px;
        color:#6b7280;
    }

    .form-group{
        margin-bottom:20px;
    }

    label{
        font-size:14px;
        margin-bottom:8px;
        font-weight:600;
    }

    input{
        padding:16px 18px;
        font-size:15px;
        border-radius:14px;
        border:1.5px solid #e5e7eb;
        background:#fafafa;
    }

    input:focus{
        background:#ffffff;
    }

    button{
        padding:18px;
        font-size:16px;
        border-radius:14px;
        font-weight:600;
        margin-top:15px;
        background:#2563eb;
    }

    .login-link{
        margin-top:25px;
        font-size:15px;
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
}

/* Small Mobile Devices */
@media(max-width:480px){
    .left{
        min-height:280px;
    }
    
    .left h1{
        font-size:24px;
    }
    
    .left p{
        font-size:14px;
        max-width:260px;
    }
    
    .right{
        padding:30px 20px 40px 20px;
    }
    
    .right h2{
        font-size:22px;
    }
    
    .subtitle{
        font-size:14px;
        margin-bottom:25px;
    }
    
    input{
        padding:15px 16px;
        font-size:14px;
    }
    
    button{
        padding:16px;
    }
}

/* Very Small Devices */
@media(max-width:360px){
    .left{
        min-height:240px;
    }
    
    .left h1{
        font-size:22px;
    }
    
    .left p{
        font-size:13px;
    }
    
    .right{
        padding:25px 16px 35px 16px;
    }
    
    .right h2{
        font-size:20px;
    }
}

/* iPhone SE and smaller */
@media(max-width:320px){
    .left{
        min-height:200px;
    }
    
    .left h1{
        font-size:20px;
    }
    
    .left p{
        font-size:12px;
    }
    
    .right{
        padding:20px 12px 30px 12px;
    }
}

/* Ensure full video on all mobile devices */
@media(max-width:768px){
    .bg-video{
        object-fit:cover;
        width:100%;
        height:100%;
    }
}

/* iOS specific fixes */
@supports (-webkit-touch-callout) {
    .bg-video {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    
    .left {
        min-height: 350px;
    }
    
    @media(max-width:480px){
        .left {
            min-height: 280px;
        }
    }
}

/* Landscape mode */
@media(max-height:600px) and (orientation:landscape){
    .left{
        min-height:250px;
    }
    
    .left-content{
        padding:30px 20px;
    }
    
    .left h1{
        font-size:22px;
        margin-bottom:8px;
    }
    
    .left p{
        font-size:13px;
    }
    
    .right{
        padding:25px 30px 35px 30px;
    }
}

/* Tablets */
@media(min-width:769px) and (max-width:1024px){
    .left-content{
        padding:40px 30px;
    }
    
    .left h1{
        font-size:28px;
    }
    
    .right{
        padding:40px 30px;
    }
}

/* Ensure form elements don't overflow */
input, button{
    max-width:100%;
    box-sizing:border-box;
}

/* Better touch targets for mobile */
@media(max-width:768px){
    input, button, .login-link a{
        min-height:48px; /* Better touch targets */
    }
}
</style>
</head>
<body>

<div class="wrapper">

<div class="left">
<video
    class="bg-video"
    autoplay
    muted
    loop
    playsinline
    webkit-playsinline
    preload="auto">
    <source src="{{ asset('videos/shop-loop.mp4') }}" type="video/mp4">
</video>


    <div class="overlay"></div>

    <div class="left-content">
        <h1>Shop. Earn. Save.</h1>
        <p>Get exclusive discounts, cashback rewards, and coins on every purchase.</p>
    </div>

</div>

<div class="right">
    <h2>Create Account</h2>
    <div class="subtitle">Start shopping smarter today.</div>

<form id="registerForm">


        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required placeholder="Enter your full name">
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Create a password">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required placeholder="Confirm your password">
        </div>

        <button type="submit">Create Account</button>

        <div class="login-link">
            Already have an account? <a href="/login">Login</a>
        </div>
    </form>
</div>
<script>
const BASE_URL = "https://retailadmin.ggconsultancy.services/api";

function showAlert(message, type) {
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) existingAlert.remove();
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const form = document.getElementById('registerForm');
    form.parentNode.insertBefore(alertDiv, form);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

document.addEventListener("DOMContentLoaded", function () {
    const formElement = document.getElementById("registerForm");

    formElement.addEventListener("submit", async function (e) {
        e.preventDefault();

        const name = document.querySelector("input[name='name']").value.trim();
        const email = document.querySelector("input[name='email']").value.trim();
        const password = document.querySelector("input[name='password']").value;
        const passwordConfirmation = document.querySelector("input[name='password_confirmation']").value;

        if (!name || !email || !password || !passwordConfirmation) {
            showAlert("Please fill in all fields", 'error');
            return;
        }

        if (password !== passwordConfirmation) {
            showAlert("Passwords do not match", 'error');
            return;
        }

        if (password.length < 8) {
            showAlert("Password must be at least 8 characters", 'error');
            return;
        }

        try {
            const response = await fetch(BASE_URL + "/user/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation
                })
            });

            const data = await response.json();
            console.log("API Response:", data);

            if (response.ok) {
                localStorage.setItem("verify_email", email);
                showAlert("Registration successful! Redirecting to verification...", 'success');
                setTimeout(() => {
                    window.location.href = "/verify-otp";
                }, 1500);
            } else {
                showAlert(data.message || "Registration failed", 'error');
            }

        } catch (error) {
            console.error("Register error:", error);
            showAlert("Server error. Please try again.", 'error');
        }
    });
});
</script>
</div>

</body>
</html>