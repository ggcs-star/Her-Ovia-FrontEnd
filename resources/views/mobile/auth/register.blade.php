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
    background:#ff3f6c;  
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    -webkit-appearance:none;
    appearance:none;
}
button:hover {
    background:#e6395e;
}

.login-link{
    text-align:center;
    margin-top:20px;
    font-size:14px;
}

.login-link a{
    color:#ff3f6c;  
    text-decoration:none;
    font-weight:600;
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
        background:#ff3f6c; 
    }
    button:hover {
        background:#e6395e;
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

input, button{
    max-width:100%;
    box-sizing:border-box;
}

@media(max-width:768px){
    input, button, .login-link a{
        min-height:48px; 
    }
}
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
@media(max-width:768px){
    .back-arrow {
        top: 15px;
        left: 15px;
        font-size: 26px;
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

.toggle-password:hover {
    color: #ff3f6c;
}
</style>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">←</a>
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
    <source src="{{ asset('videos/Pink_and_White_Brand_Theme_Video.mp4') }}" type="video/mp4">
</video>

    <div class="overlay"></div>

    <div class="left-content">
        <h1>STYLE. SAVE. REPEAT..</h1>
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
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required placeholder="Create a password">
                <span class="toggle-password" onclick="togglePassword('password', this)">
                <svg class="eye-icon open-eye" viewBox="0 0 24 24" width="22" height="22">
                    <path fill="currentColor"
                    d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                </svg>

                <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="22" height="22">
                    <path fill="currentColor"
                    d="M12 5c-5 0-9.27 3.11-11 7 1.05 2.36 2.98 4.3 5.42 5.52L3 21l1.41 1.41L21 5.83 19.59 4.41l-3.01 3.01C15.06 6.54 13.57 5 12 5zm0 12c-1.57 0-3.06-.54-4.58-1.42l1.5-1.5A3 3 0 0 0 12 15a3 3 0 0 0 2.92-2.92l1.5-1.5C17.46 12.06 18 13.55 18 15c0 1.66-2.24 3-6 3z"/>
                </svg>

            </span>
            </div>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <div class="password-wrapper">
                <input type="password" name="password_confirmation" id="confirmPassword" required placeholder="Confirm your password">
                <span class="toggle-password" onclick="togglePassword('confirmPassword', this)">
                <svg class="eye-icon open-eye" viewBox="0 0 24 24" width="22" height="22">
                    <path fill="currentColor"
                    d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                </svg>

                <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="22" height="22">
                    <path fill="currentColor"
                    d="M12 5c-5 0-9.27 3.11-11 7 1.05 2.36 2.98 4.3 5.42 5.52L3 21l1.41 1.41L21 5.83 19.59 4.41l-3.01 3.01C15.06 6.54 13.57 5 12 5zm0 12c-1.57 0-3.06-.54-4.58-1.42l1.5-1.5A3 3 0 0 0 12 15a3 3 0 0 0 2.92-2.92l1.5-1.5C17.46 12.06 18 13.55 18 15c0 1.66-2.24 3-6 3z"/>
                </svg>

            </span>
            </div>
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

function validateField(field, value) {
    const fieldNames = {
        name: { label: 'Full Name', min: 2, max: 50 },
        email: { label: 'Email', pattern: /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/ },
        password: { label: 'Password', min: 8 },
        confirm: { label: 'Confirm Password' }
    };
    
    if (field === 'name') {
        if (value.length < 2) return { valid: false, message: 'Full Name must be at least 2 characters' };
        if (value.length > 50) return { valid: false, message: 'Full Name must be less than 50 characters' };
        if (!/^[a-zA-Z\s]+$/.test(value)) return { valid: false, message: 'Full Name can only contain letters and spaces' };
    }
    
    if (field === 'email') {
        if (!value) return { valid: false, message: 'Email is required' };
        if (!/^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(value)) return { valid: false, message: 'Enter a valid email address' };
    }
    
    if (field === 'password') {
        if (value.length < 8) return { valid: false, message: 'Password must be at least 8 characters' };
        if (!/[A-Z]/.test(value)) return { valid: false, message: 'Password must contain at least one uppercase letter' };
        if (!/[a-z]/.test(value)) return { valid: false, message: 'Password must contain at least one lowercase letter' };
        if (!/[0-9]/.test(value)) return { valid: false, message: 'Password must contain at least one number' };
    }
    
    return { valid: true, message: '' };
}

function showFieldError(fieldId, message) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    
    const existingError = input.parentElement.querySelector('.field-error');
    if (existingError) existingError.remove();
    
    const errorSpan = document.createElement('span');
    errorSpan.className = 'field-error';
    errorSpan.textContent = message;
    errorSpan.style.cssText = 'color: #b91c1c; font-size: 11px; margin-top: 4px; display: block;';
    input.parentElement.appendChild(errorSpan);
    
    input.style.borderColor = '#b91c1c';
    
    setTimeout(() => {
        const err = input.parentElement.querySelector('.field-error');
        if (err) err.remove();
        input.style.borderColor = '';
    }, 3000);
}

function clearFieldError(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const error = input.parentElement.querySelector('.field-error');
    if (error) error.remove();
    input.style.borderColor = '';
}
document.addEventListener("DOMContentLoaded", function () {
    const formElement = document.getElementById("registerForm");
    const nameInput = document.querySelector("input[name='name']");
    const emailInput = document.querySelector("input[name='email']");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirmPassword");
    
    function validateOnBlur() {
        if (nameInput.value.trim()) {
            const result = validateField('name', nameInput.value.trim());
            if (!result.valid) showFieldError('name', result.message);
            else clearFieldError('name');
        }
        if (emailInput.value.trim()) {
            const result = validateField('email', emailInput.value.trim());
            if (!result.valid) showFieldError('email', result.message);
            else clearFieldError('email');
        }
    }
    
    nameInput.addEventListener('blur', validateOnBlur);
    emailInput.addEventListener('blur', validateOnBlur);
    
    passwordInput.addEventListener('blur', function() {
        if (this.value) {
            const result = validateField('password', this.value);
            if (!result.valid) showFieldError('password', result.message);
            else clearFieldError('password');
        }
    });
    
    confirmInput.addEventListener('blur', function() {
        if (this.value && passwordInput.value) {
            if (this.value !== passwordInput.value) {
                showFieldError('confirmPassword', 'Passwords do not match');
            } else {
                clearFieldError('confirmPassword');
            }
        }
    });

    formElement.addEventListener("submit", async function (e) {
        e.preventDefault();

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const passwordConfirmation = confirmInput.value;
        
        clearFieldError('name');
        clearFieldError('email');
        clearFieldError('password');
        clearFieldError('confirmPassword');

        const nameCheck = validateField('name', name);
        if (!nameCheck.valid) {
            showFieldError('name', nameCheck.message);
            return;
        }
        
        const emailCheck = validateField('email', email);
        if (!emailCheck.valid) {
            showFieldError('email', emailCheck.message);
            return;
        }
        
        const passwordCheck = validateField('password', password);
        if (!passwordCheck.valid) {
            showFieldError('password', passwordCheck.message);
            return;
        }
        
        if (password !== passwordConfirmation) {
            showFieldError('confirmPassword', 'Passwords do not match');
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

            if (response.ok && data.success) {
                localStorage.setItem("verify_email", email);
                window.location.href = "/verify-otp?email=" + encodeURIComponent(email);
            } else {
                let errorMsg = "Registration failed";
                if (data.message) errorMsg = data.message;
                else if (data.error) errorMsg = data.error;
                else if (data.errors) {
                    const firstError = Object.values(data.errors)[0];
                    if (firstError && firstError[0]) errorMsg = firstError[0];
                }
                showAlert(errorMsg, 'error');
            }

        } catch (error) {
            console.error("Register error:", error);
            showAlert("Server error. Please try again.", 'error');
        }
    });
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

</body>
</html>