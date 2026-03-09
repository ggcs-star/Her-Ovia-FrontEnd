const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';

document.addEventListener('DOMContentLoaded', function() {
    loadTrendingReels();
    setupScrollObserver();
});

function loadTrendingReels() {
    const container = document.getElementById('trendsContainer');
    if (!container) return;

    fetch(`${API_BASE_URL}/reels`, {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.status && response.data && response.data.length > 0) {
            renderReels(response.data);
        } else {
            showFallbackReels();
        }
    })
    .catch(() => {
        showFallbackReels();
    });
}

function renderReels(reels) {
    const container = document.getElementById('trendsContainer');
    if (!container) return;

    let html = '';
    reels.forEach((reel, index) => {
        const mediaUrl = reel.video || reel.image_url || 'https://images.unsplash.com/photo-1515408320194-59643816c5db?w=600&auto=format';
        const productLink = reel.product?.slug ? `/product/${reel.product.slug}` : '#';
        
        // Check if it's a video or image
        const isVideo = mediaUrl.match(/\.(mp4|webm|ogg|mov)$/i);
        
        html += `
            <div class="reel-card" data-index="${index}" onclick="window.location.href='${productLink}'">
                <div class="reel-progress">
                    <div class="reel-progress-bar" id="progress-${index}"></div>
                </div>
                
                <div class="reel-media">
                    ${isVideo ? 
                        `<video loop muted playsinline autoplay preload="metadata" id="video-${index}">
                            <source src="${mediaUrl}" type="video/mp4">
                        </video>` : 
                        `<img src="${mediaUrl}" alt="${reel.product?.name || 'Trending reel'}" style="width:100%; height:100%; object-fit:cover;">`
                        }
                </div>
                
                <div class="reel-overlay">
                    <h2 class="reel-title">${reel.product?.name || reel.title || 'Trending Now'}</h2>
                    <p class="reel-description">${reel.description || reel.subtitle || 'Check this out!'}</p>
                </div>
                
                <div class="reel-actions" onclick="event.stopPropagation()">
                    <button class="reel-action-btn" onclick="handleLike(${reel.id})">❤️</button>
                    <button class="reel-action-btn" onclick="handleComment(${reel.id})">💬</button>
                    <button class="reel-action-btn" onclick="handleShare(${reel.id})">↗️</button>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    setupVideoAutoplay();
}

function showFallbackReels() {
    const fallbackReels = [
        {
            id: 1,
            product: {
                name: "Women's Cotton T-Shirt",
                slug: "womens-cotton-t-shirt"
            },
            video: "https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format"
        },
        {
            id: 2,
            product: {
                name: "Smartphone Pro",
                slug: "smartphone-pro"
            },
            video: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format"
        }
    ];
    renderReels(fallbackReels);
}

function setupVideoAutoplay() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const card = entry.target;
            const video = card.querySelector('video');
            const progressBar = card.querySelector('.reel-progress-bar');
            
            if (entry.isIntersecting) {
                if (video) {
                    video.play();
                    startProgress(video, progressBar);
                }
                card.classList.add('active');
            } else {
                if (video) {
                    video.pause();
                    video.currentTime = 0;
                }
                if (progressBar) {
                    progressBar.style.width = '0%';
                }
                card.classList.remove('active');
            }
        });
    }, { threshold: 0.8 });

    document.querySelectorAll('.reel-card').forEach(card => {
        observer.observe(card);
    });
}

function startProgress(video, progressBar) {
    if (!video || !progressBar) return;
    
    const updateProgress = () => {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.style.width = `${progress}%`;
        
        if (video.currentTime < video.duration) {
            requestAnimationFrame(updateProgress);
        }
    };
    
    video.addEventListener('loadedmetadata', () => {
        requestAnimationFrame(updateProgress);
    });
}

function setupScrollObserver() {
    const content = document.querySelector('.trends-content');
    if (!content) return;

    content.addEventListener('scroll', () => {
        const cards = document.querySelectorAll('.reel-card');
        const scrollTop = content.scrollTop;
        const cardHeight = cards[0]?.offsetHeight || 0;
        const activeIndex = Math.round(scrollTop / cardHeight);
        
        cards.forEach((card, index) => {
            if (index === activeIndex) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });
    });
}

function handleLike(reelId) {
    showToast('❤️ Liked!', 'success');
}

function handleComment(reelId) {
    showToast('💬 Comments coming soon!', 'info');
}

function handleShare(reelId) {
    if (navigator.share) {
        navigator.share({
            title: 'Check this out!',
            url: window.location.href
        });
    } else {
        showToast('Link copied!', 'success');
    }
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast-message ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 2000);
}