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
            muted
            loop
            playsinline
            preload="metadata"
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
    checkDescriptions();
    setupObserver();
    enableDoubleTap();
}



/* AUTOPLAY */

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



/* VIEW COUNT */

function increaseView(id){

    fetch(API_BASE_URL + "/reels/" + id + "/view",{
        method:"POST"
    }).catch(()=>{});

}



/* PROGRESS BAR */

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



/* DESCRIPTION */

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



/* LIKE SYSTEM */

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



/* DOUBLE TAP LIKE */
function enableDoubleTap(){

let lastTap = 0;

document.querySelectorAll(".reel-video-player").forEach(video=>{

video.addEventListener("touchend",function(e){

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



/* HEART ANIMATION */

function showGlobalHeart(){

    const heart = document.getElementById("global-like-heart");

    if(!heart) return;

    heart.classList.add("show");

    setTimeout(()=>{
        heart.classList.remove("show");
    },700);

}



/* SHARE */

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



/* ERROR */

function showError(){

    const container = document.getElementById("trendsContainer");

    if(container){
        container.innerHTML = '<div class="error">Failed to load reels</div>';
    }

}