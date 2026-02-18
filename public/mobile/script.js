document.addEventListener('DOMContentLoaded', function() {
    
    // ========== HERO IMAGE SLIDER ==========
    const heroImages = [
        'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=600&auto=format',
        'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600&auto=format',
        'https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&auto=format',
        'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=600&auto=format',
        'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600&auto=format',
        'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=600&auto=format'
    ];
    
    let currentImageIndex = 0;
    const heroImageElement = document.querySelector('.hero-image img');
    
    if (heroImageElement) {
        // Change image every 4 seconds
        setInterval(() => {
            currentImageIndex = (currentImageIndex + 1) % heroImages.length;
            heroImageElement.style.opacity = '0';
            
            setTimeout(() => {
                heroImageElement.src = heroImages[currentImageIndex];
                heroImageElement.style.opacity = '1';
            }, 500);
        }, 4000);
    }
    
    // Countdown Timer
    function updateTimer() {
        const hoursElement = document.querySelector('.timer-block:first-child .timer-number');
        const minutesElement = document.querySelector('.timer-block:nth-child(2) .timer-number');
        const secondsElement = document.querySelector('.timer-block:last-child .timer-number');
        
        if (hoursElement && minutesElement && secondsElement) {
            let hours = parseInt(hoursElement.textContent);
            let minutes = parseInt(minutesElement.textContent);
            let seconds = parseInt(secondsElement.textContent);
            
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                    }
                }
            }
            
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
        }
    }
    
    setInterval(updateTimer, 1000);
    
    // Shop Now Button
    const shopNowBtn = document.querySelector('.btn-primary');
    if (shopNowBtn) {
        shopNowBtn.addEventListener('click', function() {
            window.location.href = '/dashboard';
        });
    }
    
    // Deal Button
    const dealBtn = document.querySelector('.btn-secondary');
    if (dealBtn) {
        dealBtn.addEventListener('click', function() {
            window.location.href = '/deals';
        });
    }
    
    // Search Functionality
    const searchInput = document.querySelector('.search-bar input');
    const searchIcon = document.querySelector('.search-bar i');
    
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            alert(`Searching for: ${searchTerm}`);
            searchInput.value = '';
        } else {
            searchInput.focus();
        }
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }
    
    if (searchIcon) {
        searchIcon.addEventListener('click', performSearch);
    }
    
    // Header Icons
    const wishlistIcon = document.querySelector('.fa-heart');
    if (wishlistIcon) {
        wishlistIcon.addEventListener('click', function() {
            window.location.href = '/wishlist';
        });
    }
    
    const userIcon = document.querySelector('.fa-user');
    if (userIcon) {
        userIcon.addEventListener('click', function() {
            window.location.href = '/profile';
        });
    }
    
    const cartIcon = document.querySelector('.fa-shopping-bag');
    if (cartIcon) {
        cartIcon.addEventListener('click', function() {
            window.location.href = '/cart';
        });
    }
    
    // Category Cards
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const categoryName = this.querySelector('span').textContent;
            window.location.href = `/category/${categoryName.toLowerCase().replace(' ', '-')}`;
        });
    });
    
    // Product Cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            const productName = this.querySelector('h4').textContent;
            window.location.href = `/product/${productName.toLowerCase().replace(/ /g, '-')}`;
        });
    });
    
    // View All Links
    const viewAllLinks = document.querySelectorAll('.section-header a');
    viewAllLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/products';
        });
    });
    
    // Navigation Links
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.textContent;
            window.location.href = `/category/${category.toLowerCase()}`;
        });
    });
    
    // Footer Links
    const footerLinks = document.querySelectorAll('.footer-section a');
    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            alert('This feature is coming soon!');
        });
    });
    
    // Social Media Icons
    const socialIcons = document.querySelectorAll('.social-links i');
    socialIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const platform = this.className.split(' ')[1].replace('fa-', '');
            window.open(`https://www.${platform}.com`, '_blank');
        });
    });
    
    // Smooth Scroll for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    
    // Header Scroll Effect
    let lastScroll = 0;
    const header = document.querySelector('.header');
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.02)';
        }
        
        lastScroll = currentScroll;
    });
    
});