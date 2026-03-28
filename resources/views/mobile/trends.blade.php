<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>Trending Reels | RAPID RETAIL</title>

<link rel="stylesheet" href="{{ asset('mobile/style.css') }}">
<link rel="stylesheet" href="{{ asset('mobile/trends.css') }}">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="trends-page">

<header class="site-header" id="site-header"></header>

<main class="trends-content">

<div class="trends-container" id="trendsContainer">


<div class="loading">
Loading reels...
</div>

</div>

</main>

<footer class="site-footer" id="site-footer"></footer>

<nav class="mobile-bottom-nav" id="mobile-bottom-nav"></nav>


<div id="global-like-heart" class="global-like-heart">
❤️
</div>

<div id="commentModal" class="comment-modal">

  <div class="comment-sheet">

    <div class="comment-header">
      <span>Comments</span>
      <button onclick="closeComments()">✕</button>
    </div>

    <div id="commentList" class="comment-list"></div>

    <div class="comment-input-box">
      <input type="text" id="commentInput" placeholder="Add a comment..." />
      <button onclick="postComment()">Post</button>
    </div>

  </div>

</div>
<script src="{{ asset('mobile/script.js') }}"></script>
<script src="{{ asset('mobile/trends.js') }}"></script>

</body>
</html>