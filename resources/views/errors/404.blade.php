<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="description" content="404 - Page Not Found | MAHERA JEWEL">
    <meta name="author" content="MAHERA JEWEL">
    <title>404 - Page Not Found | MAHERA JEWEL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #440C2C;
            --accent: #F4B94E;
            --white: #ffffff;
            --gray-light: #f5f5f6;
            --gray-dark: #282c3f;
            --text-muted: #696b79;
        }

        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--gray-light);
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            min-height: 100vh;
        }

        .error-container {
            text-align: center;
            max-width: 480px;
            width: 100%;
        }

        .error-oops {
            font-size: 28px;
            font-weight: 300;
            color: #9ca3af;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .error-code {
            font-size: 120px;
            font-weight: 900;
            background: linear-gradient(135deg, #5a1a3a 0%, #f5c95a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 10px;
            letter-spacing: -5px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-dark);
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 36px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary:hover {
            background: #5a1a3a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(68, 12, 44, 0.15);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 36px;
            background: transparent;
            color: var(--gray-dark);
            border: 1.5px solid #d0d0d0;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-secondary:hover {
            background: var(--white);
            border-color: #f5c95a;
        }

        .btn-primary svg,
        .btn-secondary svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        @media (max-width: 480px) {
            body {
                padding: 20px;
            }
            .error-code {
                font-size: 80px;
                letter-spacing: -3px;
            }
            .error-title {
                font-size: 22px;
            }
            .error-message {
                font-size: 15px;
                margin-bottom: 28px;
            }
            .error-oops {
                font-size: 22px;
            }
            .btn-primary, .btn-secondary {
                padding: 14px 24px;
                font-size: 15px;
            }
            .error-container {
                padding: 10px 0;
            }
        }

        @media (min-width: 768px) {
            .error-container {
                max-width: 520px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-oops">Oops!</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Not Found</h1>
        <p class="error-message">
            Sorry, we were unable to find that page.
            <br>Please use main menu or choose from category below.
        </p>

        <div class="error-actions">
            <a href="/" class="btn-primary">
                <svg viewBox="0 0 24 24">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2"/>
                </svg>
                Go to Homepage
            </a>
            <a href="javascript:history.back()" class="btn-secondary">
                <svg viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Go Back
            </a>
        </div>
    </div>
</body>
</html>