const API_BASE_URL = 'https://retailadmin.ggconsultancy.services/api';

document.addEventListener("DOMContentLoaded", () => {
    loadTrendingReels();
});


/* LOAD REELS */

function loadTrendingReels(){

    const container = document.getElementById("trendsContainer");
    if(!container) return;

    container.innerHTML = '<div class="loading">Loading reels...</div>';

    fetch(API_BASE_URL + "/reels")
    .then(res => res.json()) 
    .then(res => {

        if(!res || !res.data){
            showError();
            return;
        }

        renderReels(res.data);

    })
    .catch(showError);

}



/* RENDER REELS */

function renderReels(reels){

    const container = document.getElementById("trendsContainer");
    let html = "";

    reels.forEach((reel,index)=>{

        const media = reel.video;
        const product = reel.product || {};

        html += `
<div class="reel-card">

    <div class="reel-video">
<video
src="${media}"
autoplay
muted
loop
playsinline
preload="auto"
class="reel-video-player"
data-id="${reel.id}"
id="video-${index}">
</video>
    </div>

    <div class="reel-gradient"></div>

    <div class="reel-info">

        <div class="reel-product">

            <h3>${product.name ?? "Trending Product"}</h3>

            <p id="desc-${index}" class="reel-desc">
                ${reel.description ?? ""}
            </p>

            <span class="reel-more" onclick="toggleDesc(${index})">
                More
            </span>

            <a href="/product/${product.slug ?? ""}" class="reel-buy">
                Buy at ₹${product.price ?? "999"}
            </a>

        </div>

    </div>
    

<div class="reel-actions">

<div class="reel-action-item">

<button class="reel-icon-btn like-btn" id="like-${reel.id}">
<i class="bi bi-heart"></i>
</button>

<span class="reel-count" id="like-count-${reel.id}">
${reel.likes ?? 0}
</span>
<button class="reel-icon-btn comment-btn" data-id="${reel.id}">
<i class="bi bi-chat"></i>
</button>

<span class="reel-count" id="comment-count-${reel.id}">
${reel.comments ?? 0}
</span>
</div>

<div class="reel-action-item">

<button class="reel-icon-btn share-btn" data-id="${reel.id}">
<i class="bi bi-send"></i>
</button>

<span class="reel-count" id="share-count-${reel.id}">
${reel.shares ?? 0}
</span>

</div>

</div>

<div class="reel-progress">
<div class="reel-progress-bar" id="progress-${index}"></div>
</div>

</div>
`;
    });

    container.innerHTML = html;

    initLikeButtons();
    initShareButtons();
        initCommentButtons(); 

    checkDescriptions();
    setupObserver();
    enableDoubleTap();
}

let currentReelId = null;

/* init buttons */
function initCommentButtons(){

    document.querySelectorAll(".comment-btn").forEach(btn=>{

        btn.addEventListener("click",function(){

            const id = btn.dataset.id;
            openComments(id);

        });

    });

}

/* open modal */
function openComments(id){

    currentReelId = id;

    document.getElementById("commentModal").style.display = "block";

    loadComments(id);

    // 🔥 ADD THIS
    setTimeout(()=>{
        document.getElementById("commentInput").focus();
    },300);
}

/* load comments - WITH CORRECT TIME FORMAT */
function loadComments(id){
    const list = document.getElementById("commentList");
    list.innerHTML = '<div style="text-align:center;padding:20px;">Loading comments...</div>';

    const timestamp = new Date().getTime();
    
    fetch(API_BASE_URL + "/reels/" + id + "/comments?_=" + timestamp, {
        headers:{
            "Accept": "application/json",
            "Cache-Control": "no-cache, no-store, must-revalidate",
            "Pragma": "no-cache"
        }
    })
    .then(res => res.json())
    .then(res => {
        let html = "";
        
        console.log("📝 API Response:", res);
        
        if(!res.data || res.data.length === 0){
            html = '<div style="text-align:center;padding:20px;color:#888;">No comments yet. Be the first to comment!</div>';
        } else {
            res.data.forEach(c => {

                let timeValue = '';
                
                if(c.time) timeValue = c.time;
                else if(c.created_at) timeValue = c.created_at;
                else if(c.createdAt) timeValue = c.createdAt;
                else if(c.timestamp) timeValue = c.timestamp;
                else if(c.date) timeValue = c.date;
                
                const formattedTime = formatTimeProperly(timeValue);
                
                const userName = c.user?.name || c.user?.username || 'User';
                const userAvatar = c.user?.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=ff2c6d&color=fff`;
                
                html += `
                <div class="comment-item insta-comment">
                    <img src="${userAvatar}" class="comment-avatar" onerror="this.src='https://ui-avatars.com/api/?name=User&background=ff2c6d&color=fff'"/>
                    <div class="comment-content">
                        <div class="comment-header">
                            <span class="comment-user" style="font-weight:600;">${escapeHtml(userName)}</span>
                            <span class="comment-time" style="font-size:12px;color:#888;margin-left:8px;">${formattedTime}</span>
                        </div>
                        <div class="comment-text" style="font-size:14px;margin-top:4px;">
                            ${escapeHtml(c.comment)}
                        </div>
                    </div>
                </div>
                `;
            });
        }
        
        list.innerHTML = html;
        list.scrollTop = list.scrollHeight;
    })
    .catch(err => {
        console.error("Comments error:", err);
        list.innerHTML = '<div style="text-align:center;padding:20px;color:#ff3f6c;">Failed to load comments. <span onclick="loadComments(' + id + ')" style="text-decoration:underline;">Retry</span></div>';
    });
}

function formatTimeProperly(dateValue) {
    if(!dateValue) return 'just now';
    
    try {
        if(typeof dateValue === 'string' && (dateValue.includes('ago') || dateValue.includes('just now'))) {
            return dateValue;
        }
        
        let date = new Date(dateValue);
        
        if(isNaN(date.getTime())) {
            return 'just now';
        }
        
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        if(seconds < 5) return 'just now';
        if(seconds < 60) return `${seconds}s ago`;
        
        const minutes = Math.floor(seconds / 60);
        if(minutes < 60) return `${minutes}m ago`;
        
        const hours = Math.floor(minutes / 60);
        if(hours < 24) return `${hours}h ago`;
        
        const days = Math.floor(hours / 24);
        if(days < 7) return `${days}d ago`;
        
        if(days < 30) return `${Math.floor(days / 7)}w ago`;
        
        const months = Math.floor(days / 30);
        if(months < 12) return `${months}mo ago`;
        
        const years = Math.floor(days / 365);
        return `${years}y ago`;
        
    } catch(e) {
        console.error("Time format error:", e);
        return 'just now';
    }
}

function escapeHtml(text) {
    if(!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function postComment() {
    const input = document.getElementById("commentInput");
    const text = input.value.trim();
    
    if (!text) return;
    
    const token = localStorage.getItem("token");
    const isLoggedIn = token && token !== "null" && token !== "undefined";

    if (!isLoggedIn) {
        showLoginRequiredModal();
        return;
    }
    
    const postBtn = document.querySelector(".comment-input-box button");
    const originalText = postBtn.innerText;
    postBtn.disabled = true;
    postBtn.innerText = "Posting...";
    
    const list = document.getElementById("commentList");
    const tempId = 'temp_' + Date.now();
    const tempComment = `
        <div class="comment-item insta-comment temp-comment" id="${tempId}" style="opacity:0.6;">
            <img src="https://ui-avatars.com/api/?name=You&background=ff2c6d&color=fff" class="comment-avatar"/>
            <div class="comment-content">
                <div class="comment-header">
                    <span class="comment-user">You</span>
                    <span class="comment-time">just now</span>
                </div>
                <div class="comment-text">
                    ${escapeHtml(text)}
                </div>
            </div>
        </div>
    `;
    
    if (list.innerHTML.includes("No comments yet")) {
        list.innerHTML = tempComment;
    } else {
        list.innerHTML += tempComment;
    }
    list.scrollTop = list.scrollHeight;
    
    let headers = {
        "Content-Type": "application/json",
        "Accept": "application/json"
    };
    
    if (isLoggedIn) {
        headers["Authorization"] = "Bearer " + token;
    }
    
    fetch(API_BASE_URL + "/reels/" + currentReelId + "/comment", {
        method: "POST",
        headers: headers,
        body: JSON.stringify({ comment: text })
    })
    .then(async res => {
        const data = await res.json();
        
        if (res.status === 401) {
            document.getElementById(tempId)?.remove();
            showLoginRequiredModal();
            return;
        }
        
        if (!data.status) {
            document.getElementById(tempId)?.remove();
            showToast(data.message || "Error");
            return;
        }
        
        input.value = "";
        document.getElementById(tempId)?.remove();
        
        const freshTimestamp = new Date().getTime();
        fetch(API_BASE_URL + "/reels/" + currentReelId + "/comments?_=" + freshTimestamp, {
            headers: {
                "Accept": "application/json",
                "Cache-Control": "no-cache, no-store, must-revalidate"
            }
        })
        .then(res => res.json())
        .then(res => {
            let html = "";
            if (res.data && res.data.length > 0) {
                res.data.forEach(c => {
                    let timeValue = c.time || c.created_at || c.createdAt || '';
                    const formattedTime = formatTimeProperly(timeValue);
                    const userName = c.user?.name || c.user?.username || 'User';
                    const userAvatar = c.user?.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=ff2c6d&color=fff`;
                    html += `
                    <div class="comment-item insta-comment">
                        <img src="${userAvatar}" class="comment-avatar" onerror="this.src='https://ui-avatars.com/api/?name=User&background=ff2c6d&color=fff'"/>
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-user">${escapeHtml(userName)}</span>
                                <span class="comment-time">${formattedTime}</span>
                            </div>
                            <div class="comment-text">${escapeHtml(c.comment)}</div>
                        </div>
                    </div>`;
                });
            } else {
                html = '<div style="text-align:center;padding:20px;color:#888;">No comments yet. Be the first to comment!</div>';
            }
            list.innerHTML = html;
            list.scrollTop = list.scrollHeight;
        });
        
        const count = document.getElementById("comment-count-" + currentReelId);
        if (count) {
            count.innerText = parseInt(count.innerText) + 1;
        }
        
        showToast("Comment posted!");
    })
    .catch(err => {
        console.error("Comment error:", err);
        document.getElementById(tempId)?.remove();
        showToast("Network error. Please try again");
    })
    .finally(() => {
        postBtn.disabled = false;
        postBtn.innerText = originalText;
        input.focus();
    });
}


function closeComments(){
    document.getElementById("commentModal").style.display = "none";
}

function showLoginRequiredModal() {
    if (document.getElementById("loginRequiredModal")) return;
    
    const modal = document.createElement("div");
    modal.id = "loginRequiredModal";
    modal.className = "comment-modal";
    modal.style.display = "block";
    modal.innerHTML = `
        <div class="comment-sheet" style="height: auto; max-height: 60vh; border-radius: 20px; text-align: center; padding: 30px 20px;">
            <div style="margin-bottom: 20px;">
                <div style="font-size: 70px; margin-bottom: 10px;">🔒</div>
                <h3 style="color: #fff; font-size: 22px; margin-bottom: 10px;">Login Required</h3>
                <p style="color: #aaa; font-size: 14px; line-height: 1.5; margin-bottom: 25px;">
                    You need to login first to comment on reels.<br>
                    Please login to share your thoughts!
                </p>
                <button onclick="redirectToLogin()" style="
                    background: linear-gradient(45deg, #ff2c6d, #ff5c8a);
                    color: white;
                    border: none;
                    padding: 12px 30px;
                    border-radius: 30px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    width: 80%;
                    margin-bottom: 12px;
                ">
                    Login Now
                </button>
                <button onclick="closeLoginModal()" style="
                    background: transparent;
                    color: #ff2c6d;
                    border: 1px solid #ff2c6d;
                    padding: 12px 30px;
                    border-radius: 30px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    width: 80%;
                ">
                    Cancel
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.addEventListener("click", function(e) {
        if (e.target === modal) {
            closeLoginModal();
        }
    });
}

function closeLoginModal() {
    const modal = document.getElementById("loginRequiredModal");
    if (modal) modal.remove();
}

function redirectToLogin() {
    closeLoginModal();
    window.location.href = "/login";
}

function showToast(message, duration = 3000) {
    const existingToast = document.querySelector(".custom-toast");
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement("div");
    toast.className = "custom-toast";
    toast.innerHTML = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 100px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.9);
        backdrop-filter: blur(10px);
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        z-index: 10001;
        animation: slideUpToast 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast && toast.remove) {
            toast.style.animation = "slideDownToast 0.3s ease";
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
}
function setupObserver(){

    const videos = document.querySelectorAll(".reel-video-player");

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            const video = entry.target;

            if(entry.isIntersecting){

                video.play().catch(()=>{});

                const reelId = video.dataset.id;

                increaseView(reelId);
                animateProgress(video);

            }else{

                video.pause();

            }

        });

    },{ threshold:0.75 });

    videos.forEach(video => observer.observe(video));

}

const viewed = new Set();

function increaseView(id){

    if(viewed.has(id)) return; 

    viewed.add(id);

    fetch(API_BASE_URL + "/reels/" + id + "/view",{
        method:"POST"
    }).catch(()=>{});
}

document.addEventListener("play", function(e) {

if(e.target.tagName === "VIDEO"){
e.target.style.opacity = 1;
}

}, true);


function animateProgress(video){

    const index = video.id.split("-")[1];
    const bar = document.getElementById("progress-" + index);

    function update(){

        if(!video.duration) return;

        const percent = (video.currentTime / video.duration) * 100;

        if(bar){
            bar.style.width = percent + "%";
        }

        requestAnimationFrame(update);
    }

    requestAnimationFrame(update);

}

function checkDescriptions(){

    document.querySelectorAll(".reel-desc").forEach(desc => {

        const moreBtn = desc.nextElementSibling;

        if(desc.scrollHeight > desc.clientHeight){
            moreBtn.style.display = "inline-block";
        }else{
            moreBtn.style.display = "none";
        }

    });

}

function toggleDesc(index){

    const desc = document.getElementById("desc-" + index);
    const btn = desc.nextElementSibling;

    if(desc.classList.contains("expanded")){
        desc.classList.remove("expanded");
        btn.innerText = "More";
    }else{
        desc.classList.add("expanded");
        btn.innerText = "Less";
    }

}


function initLikeButtons(){

    document.querySelectorAll(".like-btn").forEach(btn=>{

        btn.addEventListener("click",function(){

            const id = btn.id.replace("like-","");
            likeReel(id,btn);

        });

    });

}

function likeReel(id,btn){

fetch(API_BASE_URL + "/reels/" + id + "/like",{
method:"POST"
})
.then(res=>res.json())
.then(res=>{

const icon = btn.querySelector("i");
const count = document.getElementById("like-count-"+id);

if(res.liked){

btn.classList.add("liked");
icon.classList.remove("bi-heart");
icon.classList.add("bi-heart-fill");

}else{

btn.classList.remove("liked");
icon.classList.remove("bi-heart-fill");
icon.classList.add("bi-heart");

}

if(count){
count.innerText = res.likes;
}

})
.catch(()=>{});

}

function enableDoubleTap(){

let lastTap = 0;

document.querySelectorAll(".reel-video-player").forEach(video=>{

video.addEventListener("click",function(e){

const currentTime = new Date().getTime();
const tapLength = currentTime - lastTap;

if(tapLength < 300 && tapLength > 0){

const reelId = video.dataset.id;

const btn = document.getElementById("like-"+reelId);

if(btn && !btn.classList.contains("liked")){

showGlobalHeart();
likeReel(reelId,btn);

}

e.preventDefault();

}

lastTap = currentTime;

});

});

}


function showGlobalHeart(){

    const heart = document.getElementById("global-like-heart");

    if(!heart) return;

    heart.classList.add("show");

    setTimeout(()=>{
        heart.classList.remove("show");
    },700);

}


function initShareButtons(){

    document.querySelectorAll(".share-btn").forEach(btn=>{

        btn.addEventListener("click",function(){

            const id = btn.dataset.id;
            shareReel(id);

        });

    });

}

function shareReel(id){

const reelUrl = window.location.origin + "/reel/" + id;
const message = "🔥 Check this reel\n" + reelUrl;

fetch(API_BASE_URL + "/reels/" + id + "/share",{method:"POST"})
.then(res=>res.json())
.then(res=>{

const count = document.getElementById("share-count-"+id);

if(count){
count.innerText = res.shares;
}

});

if(navigator.share){

navigator.share({
title:"Trending Product",
text:message,
url:reelUrl
}).catch(()=>{});

}else{

const whatsapp = "https://wa.me/?text=" + encodeURIComponent(message);
window.open(whatsapp,"_blank");

}

}



function showError(){

    const container = document.getElementById("trendsContainer");

    if(container){
        container.innerHTML = '<div class="error">Failed to load reels</div>';
    }
    

}

window.postComment = postComment;
window.closeComments = closeComments;
window.toggleDesc = toggleDesc;