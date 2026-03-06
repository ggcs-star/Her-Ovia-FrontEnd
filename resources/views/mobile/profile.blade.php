<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>My Profile | RAPID RETAIL</title>
    <link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/profile.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="profile-page">
    <header class="site-header" id="site-header"></header>
    
    <main class="profile-content">
        <div class="profile-container" id="profile-container">
            <div class="loading-spinner">Loading profile...</div>
        </div>
    </main>
    
    <input type="file" id="avatarUpload" accept="image/*" style="display: none;">
    
    <footer class="site-footer" id="site-footer"></footer>
    <nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>
    
    <script src="{{ asset('mobile/script.js') }}"></script>
    <script src="{{ asset('mobile/profile.js') }}"></script>
</body>
</html>