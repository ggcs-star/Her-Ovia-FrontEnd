<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
<title>Register - RADIANT JEWEL</title>

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
    color: #F4B94E;
}

.left{
    flex:1;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 40px;
    color:white;
    min-height:300px;
    overflow: hidden;
}

.bg-video{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    width:100%;
    height:100%;
    object-fit:cover;
}

.overlay{
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
    color: #440C2C;
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
    transition:0.3s;
    -webkit-appearance:none;
    appearance:none;
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
    -webkit-appearance:none;
    appearance:none;
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
.login-link a:hover{
    text-decoration:underline;
}

.field-error {
    color: #b91c1c;
    font-size: 11px;
    margin-top: 4px;
    display: block;
}

/* Mobile View - Same as Login */
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
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0;
    }
    .overlay{
        background: linear-gradient(135deg, rgba(68,12,44,0.6), rgba(68,12,44,0.8));
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
        color: #440C2C;
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
        box-shadow:0 0 0 3px rgba(244,185,78,0.15);
    }
    button{
        padding:18px;
        font-size:16px;
        border-radius:12px;
        margin-top:20px;
        background: #440C2C;
    }
    button:hover{
        background: #5a1038;
    }
    .login-link{
        margin-top:25px;
        font-size:15px;
    }
    .login-link a{
        color: #F4B94E;
    }
    .back-arrow {
        top: 15px;
        left: 15px;
        background: rgba(0,0,0,0.4);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        text-shadow: none;
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

/* Web Version - Full Page Center */
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
    .back-arrow {
        display: none !important;
    }

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
    <source src="{{ asset('videos\Radiant_Jewel_video.mp4') }}" type="video/mp4">
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

                <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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

                <svg class="eye-icon closed-eye" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
    window.API_BASE_URL = "{{ env('API_BASE_URL') }}";
</script>
<script>
const BASE_URL = window.API_BASE_URL;

function showAlert(message, type) {
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) existingAlert.remove();
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    alertDiv.style.cssText = `
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        background: ${type === 'error' ? '#fee2e2' : '#dcfce7'};
        color: ${type === 'error' ? '#b91c1c' : '#166534'};
        border: 1px solid ${type === 'error' ? '#fecaca' : '#bbf7d0'};
    `;
    
    const form = document.getElementById('registerForm');
    form.parentNode.insertBefore(alertDiv, form);
    
    setTimeout(() => {
        if (alertDiv) alertDiv.remove();
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

// Pehle HTTP status code check karo
if (response.ok && data.success) {
    localStorage.setItem("verify_email", email);
    window.location.href = "/verify-otp?email=" + encodeURIComponent(email);
} else {
    let errorMsg = "Registration failed";
    
    // Agar email already registered hai
    if (response.status === 422 || response.status === 409) {
        if (data.message && data.message.toLowerCase().includes('email')) {
            errorMsg = "This email is already registered. Please login instead.";
        } else if (data.errors && data.errors.email) {
            errorMsg = data.errors.email[0];
        } else if (data.message) {
            errorMsg = data.message;
        }
    } 
    // Other errors
    else {
        if (data.message) errorMsg = data.message;
        else if (data.error) errorMsg = data.error;
        else if (data.errors) {
            const firstError = Object.values(data.errors)[0];
            if (firstError && firstError[0]) errorMsg = firstError[0];
        }
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