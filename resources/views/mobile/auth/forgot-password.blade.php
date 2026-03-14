<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - RAPID RETAIL</title>
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
    padding:12px 14px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-size:14px;
    transition:0.3s;
    -webkit-appearance:none;
    appearance:none;
}

input:focus{
    border-color:#ff3f6c;
    outline:none;
    box-shadow:0 0 0 3px rgba(255,63,108,0.15);
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

button:disabled{
    background:#ccc;
    cursor:not-allowed;
    transform:none;
}

.links{
    display:flex;
    justify-content:space-between;
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
        background:url('/images/login-bg.jpg') center center / cover no-repeat;
        background-size:cover;
        background-position:center;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0;
    }

    .left::before{
        background:linear-gradient(
            135deg,
            rgba(0,0,0,0.6),
            rgba(255,63,108,0.6)
        );
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
        gap:20px;
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
</style>
</head>
<body>

<div class="wrapper">
    <div class="left">
        <div class="left-content">
            <h1>Reset Password</h1>
            <p>Don't worry! We'll help you recover your account.</p>
        </div>
    </div>

    <div class="right">
        <h2>Forgot Password?</h2>
        <div class="subtitle">Enter your email to receive OTP</div>

        <div id="alertContainer"></div>

        <form id="forgotPasswordForm">
            @csrf
            <div style="margin-bottom:18px;">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <button type="submit" id="sendOtpBtn">Send OTP</button>

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

// Ensure alert container exists
document.addEventListener('DOMContentLoaded', function() {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) {
        const container = document.createElement('div');
        container.id = 'alertContainer';
        const form = document.getElementById('forgotPasswordForm');
        form.parentNode.insertBefore(container, form);
    }
});

document.getElementById("forgotPasswordForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const btn = document.getElementById('sendOtpBtn');
    const originalText = btn.innerText;
    
    if (!email) {
        showAlert('Please enter your email address', 'error');
        return;
    }
    
    btn.disabled = true;
    btn.innerText = 'Sending...';

    try {
        const response = await fetch(`${BASE_URL}/user/forgot-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
        });

        const data = await response.json();
        console.log('Forgot Password Response:', data);

        if (response.ok) {
            showAlert('OTP has been sent to your email if it exists in our system.', 'success');
            
            // ✅ Email URL parameter mein bhejo
            setTimeout(() => {
                window.location.href = '/verify-otp?email=' + encodeURIComponent(email) + '&reset=true';
            }, 2000);
        } else {
            showAlert(data.message || 'Failed to send OTP. Please try again.', 'error');
            btn.disabled = false;
            btn.innerText = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Network error. Please check your connection.', 'error');
        btn.disabled = false;
        btn.innerText = originalText;
    }
});
</script>

</body>
</html>