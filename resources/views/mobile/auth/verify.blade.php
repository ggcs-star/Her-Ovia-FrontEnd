    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Verify OTP - StockFlow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        color:white;
        padding:60px 40px;
        display:flex;
        flex-direction:column;
        justify-content:center;
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

    .left h1, .left p{
        position:relative;
        z-index:2;
    }

    .left p{
        font-size:15px;
        opacity:0.9;
        line-height:1.6;
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
        padding:14px;
        border-radius:10px;
        border:1px solid #e5e7eb;
        font-size:18px;
        text-align:center;
        letter-spacing:6px;
        font-weight:600;
        transition:0.3s;
    }

    input:focus{
        border-color:#ff3f6c;
        outline:none;
        box-shadow:0 0 0 3px rgba(255,63,108,0.15);
    }

    .timer{
        font-size:13px;
        color:#6b7280;
        margin-top:10px;
        margin-bottom:20px;
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
        transition:0.3s;
    }
    button:hover{
        background:#e6395e;
        transform:translateY(-2px);
    }

    .resend{
        text-align:center;
        margin-top:15px;
        font-size:14px;
    }

    .resend a{
        color:#ff3f6c;
        text-decoration:none;
        font-weight:600;
    }

    .back{
        text-align:center;
        margin-top:20px;
        font-size:14px;
    }

    .back a{
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
        .left{
            width:100%;
            min-height:350px;
            padding:60px 25px;
            text-align:center;
            display:flex;
            flex-direction:column;
            justify-content:center;
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
            padding:16px;
            font-size:20px;
            border-radius:12px;
            background:#fafafa;
        }
        .timer{
            text-align:center;
            font-size:14px;
        }
        button{
            padding:18px;
            font-size:16px;
            border-radius:12px;
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
        <h1>Email Verification</h1>
        <p>We’ve sent a secure 6-digit code to your email. Enter it to activate your StockFlow account.</p>
    </div>

    <div class="right">
        <h2>Verify OTP</h2>
        <div class="subtitle">Enter the 6-digit verification code.</div>
        <div id="alertContainer"></div>

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

    <form id="otpForm">


            <label>One-Time Password</label>
            <input type="text"
                name="otp"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                autocomplete="one-time-code"
                required>

            <div class="timer">
                Code valid for 5 minutes
            </div>

            <button type="submit">Verify & Continue</button>

            <div class="resend">
                Didn’t receive the code? <a href="#" id="resendOtp">Resend OTP</a>
            </div>

            <div class="back">
                <a href="/login">← Back to Login</a>
            </div>
        </form>
    </div>
<script>
const BASE_URL = "https://retailadmin.ggconsultancy.services/api";
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
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
    const otpForm = document.getElementById("otpForm");
    const resendBtn = document.getElementById("resendOtp");
    
    // Add alert container if not exists
    const form = document.querySelector('.right');
    if (!document.getElementById('alertContainer')) {
        const alertDiv = document.createElement('div');
        alertDiv.id = 'alertContainer';
        form.insertBefore(alertDiv, form.firstChild);
    }
    
    // ✅ URL se email lo, localStorage se nahi
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get('email');
    
    if (!email) {
        showAlert("Email not found. Please try again.", "error");
        setTimeout(() => {
            window.location.href = "/login";
        }, 2000);
        return;
    }

    otpForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const otp = document.querySelector("input[name='otp']").value.trim();

        if (otp.length !== 6) {
            showAlert("Please enter a valid 6-digit OTP.", "error");
            return;
        }

        try {
            // ✅ Check for reset password flow via URL parameter
            const isReset = urlParams.get('reset') === 'true';
            
            const apiEndpoint = isReset
                ? BASE_URL + "/user/verify-reset-otp"
                : BASE_URL + "/user/verify-email-otp";

            const response = await fetch(apiEndpoint, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ email, otp })
            });

            const data = await response.json();
            console.log("Verify Response:", data);

            if (response.ok && data.success) {
                const successDiv = document.createElement('div');
                successDiv.className = 'alert alert-success';
                successDiv.textContent = "Verified successfully!";
                
                const alertContainer = document.getElementById('alertContainer');
                alertContainer.innerHTML = '';
                alertContainer.appendChild(successDiv);
                
                if (isReset) {
                    sessionStorage.setItem("reset_verified", "true");
                    sessionStorage.setItem("reset_otp", otp);
                    sessionStorage.setItem("reset_email", email);
                    
                    setTimeout(() => {
                        window.location.href = "/reset-password";
                    }, 1500);
                    
                } else {
                    setTimeout(() => {
                        window.location.href = "/login?verified=true";
                    }, 1500);
                }
            } else {
                const errorMsg = data.message || "Invalid OTP";
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-error';
                errorDiv.textContent = errorMsg;
                
                const alertContainer = document.getElementById('alertContainer');
                alertContainer.innerHTML = '';
                alertContainer.appendChild(errorDiv);
            }

        } catch (error) {
            console.error("OTP error:", error);
            showAlert("Server error. Please try again.", "error");
        }
    });

    resendBtn.addEventListener("click", async function (e) {
        e.preventDefault();

        if (!email) {
            showAlert("Email not found.", "error");
            return;
        }

        try {
            // ✅ Check reset flow
            const isReset = urlParams.get('reset') === 'true';
            
            const resendEndpoint = isReset
                ? BASE_URL + "/user/forgot-password"
                : BASE_URL + "/user/resend-email-otp";

            const response = await fetch(resendEndpoint, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();
            console.log("Resend Response:", data);

            if (response.ok) {
                const successDiv = document.createElement('div');
                successDiv.className = 'alert alert-success';
                successDiv.textContent = "OTP resent successfully! Check your email.";
                
                const alertContainer = document.getElementById('alertContainer');
                alertContainer.innerHTML = '';
                alertContainer.appendChild(successDiv);
            } else {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-error';
                errorDiv.textContent = data.message || "Failed to resend OTP.";
                
                const alertContainer = document.getElementById('alertContainer');
                alertContainer.innerHTML = '';
                alertContainer.appendChild(errorDiv);
            }

        } catch (error) {
            console.error("Resend OTP error:", error);
            showAlert("Server error while resending OTP.", "error");
        }
    });
});
</script>

    </div>

    </body>
    </html>
