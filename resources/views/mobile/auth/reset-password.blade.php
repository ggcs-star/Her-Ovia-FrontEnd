<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password - RAPID RETAIL</title>
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
    background:url('/images/login-bg.jpg') center center / cover no-repeat;
    min-height:300px;
}

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
        rgba(255,63,108,0.6)
    );
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
    color:#ff3f6c;
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
    padding:14px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-size:15px;
    transition:0.3s;
}

input:focus{
    border-color:#ff3f6c;
    outline:none;
    box-shadow:0 0 0 3px rgba(255,63,108,0.15);
}

.password-hint{
    font-size:12px;
    color:#6b7280;
    margin-top:5px;
    margin-bottom:10px;
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
}

button:hover{
    background:#e6395e;
    transform:translateY(-2px);
}

button:disabled{
    background:#ccc;
    cursor:not-allowed;
    transform:none;
}

.links{
    text-align:center;
    margin-top:20px;
    font-size:14px;
}

.links a{
    color:#ff3f6c;
    text-decoration:none;
    font-weight:600;
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
        padding:60px 25px;
        text-align:center;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .left-content{
        width:100%;
    }
    .left h1{
        font-size:32px;
        margin-bottom:12px;
    }
    .left p{
        font-size:16px;
        max-width:300px;
        margin:0 auto;
        line-height:1.5;
    }
    .right{
        background:#ffffff;
        border-radius:30px 30px 0 0;
        padding:35px 25px 45px 25px;
        box-shadow:0 -5px 20px rgba(0,0,0,0.08);
    }
    .right h2{
        font-size:24px;
        text-align:center;
    }
    .subtitle{
        text-align:center;
        font-size:15px;
        margin-bottom:25px;
    }
    label{
        font-size:14px;
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
    }
    .password-hint{
        font-size:13px;
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
</style>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">←</a>
<div class="wrapper">
    <div class="left">
        <div class="left-content">
            <h1>Reset Password</h1>
            <p>Create a new password for your account.</p>
        </div>
    </div>

    <div class="right">
        <h2>New Password</h2>
        <div class="subtitle">Enter your new password below.</div>

        <div id="alertContainer"></div>

        <form id="resetPasswordForm">
            @csrf
            <div style="margin-bottom:15px;">
                <label>New Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter new password" required>
                    <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
                </div>
                <div class="password-hint">Minimum 8 characters with 1 uppercase, 1 lowercase, 1 number & 1 special character</div>
            </div>

            <div style="margin-bottom:15px;">
                <label>Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</span>
                </div>
            </div>

            <button type="submit" id="resetBtn">Reset Password</button>

            <div class="links">
                <a href="/login">Back to Login</a>
            </div>
        </form>
    </div>
</div>

<script>
const BASE_URL = "https://retailadmin.ggconsultancy.services/api";
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

document.addEventListener("DOMContentLoaded", function () {
    const email = sessionStorage.getItem("reset_email");
    const verified = sessionStorage.getItem("reset_verified");
    
    if (!email || !verified) {
        showAlert('Unauthorized access. Please start from forgot password.', 'error');
        setTimeout(() => {
            window.location.href = '/forgot-password';
        }, 2000);
        return;
    }

    const form = document.getElementById('resetPasswordForm');
    const resetBtn = document.getElementById('resetBtn');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        if (password !== passwordConfirmation) {
            showAlert('Passwords do not match', 'error');
            return;
        }

        if (password.length < 8) {
            showAlert('Password must be at least 8 characters', 'error');
            return;
        }

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/;
        if (!passwordRegex.test(password)) {
            showAlert('Password must contain uppercase, lowercase, number and special character', 'error');
            return;
        }

        resetBtn.disabled = true;
        resetBtn.innerText = 'Resetting...';

        try {
            const response = await fetch(`${BASE_URL}/user/reset-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    email, 
                    otp: sessionStorage.getItem('reset_otp') || '',
                    password, 
                    password_confirmation: passwordConfirmation 
                })
            });

            const data = await response.json();
            console.log('Reset Response:', data);

            if (response.ok && data.success) {
                showAlert('Password reset successfully!', 'success');
                
                localStorage.removeItem('reset_email');
                localStorage.removeItem('reset_verified');
                localStorage.removeItem('reset_otp');
                
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } else {
                showAlert(data.message || 'Failed to reset password', 'error');
                resetBtn.disabled = false;
                resetBtn.innerText = 'Reset Password';
            }
        } catch (error) {
            console.error('Reset error:', error);
            showAlert('Server error. Please try again.', 'error');
            resetBtn.disabled = false;
            resetBtn.innerText = 'Reset Password';
        }
    });
});
function togglePassword(inputId, element) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        element.textContent = '🔒';
    } else {
        input.type = 'password';
        element.textContent = '👁️';
    }
}
</script>

</body>
</html>