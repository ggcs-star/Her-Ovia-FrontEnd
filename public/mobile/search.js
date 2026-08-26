const API_BASE = window.API_BASE_URL;
// const S3_BASE_URL = 'https://her-ovia.s3.us-east-1.amazonaws.com/';
const API_BASE_URL = window.API_BASE_URL;
const S3_BASE_URL = window.S3_BASE_URL;
const input = document.getElementById("searchInput");
const suggestions = document.getElementById("suggestions");
const results = document.getElementById("results");
const clearBtn = document.getElementById("clearBtn");

let timer = null;
window.addEventListener("DOMContentLoaded", () => {
    if (input) {
        input.focus();
        showRecentSearches();
    }
});
async function resolveImage(slug) {

    try {
        const res = await fetch(`${API_BASE}/products/${slug}`);
        const data = await res.json();

        if (data.success && data.data.gallery_images?.length) {
            return data.data.gallery_images[0];
        }

    } catch (e) {
        console.log(e);
    }

    return "https://via.placeholder.com/300x400?text=No+Image";
}
if (input) {
    input.addEventListener("input", () => {
    const q = input.value.trim();
    clearBtn.style.display = q ? "block" : "none";
    clearTimeout(timer);
    if (q.length === 0) {
        suggestions.innerHTML = "";
        results.innerHTML = "";
        return;
    }
    timer = setTimeout(() => {
        loadSuggestions(q);
        loadProducts(q);
    }, 300);
});
}
if (input) {

    input.addEventListener("keydown", function (e) {

        if (e.key === "Enter") {

            e.preventDefault();

            handleEnterSearch();

        }

    });

}
if (clearBtn) {
clearBtn.addEventListener("click", () => {
    input.value = "";
    suggestions.innerHTML = "";
    results.innerHTML = "";
    clearBtn.style.display = "none";
    input.focus();
});
}

async function loadSuggestions(q) {
    try {
        const res = await fetch(`${API_BASE}/products/suggestions?q=${encodeURIComponent(q)}`);
        const data = await res.json();
        if (!data.success) return;
        renderSuggestions(data.data);
    } catch (e) {
        console.log(e);
    }
}

function renderSuggestions(data) {
    let html = "";
    if (data.categories) {
        data.categories.forEach(c => {

        let subId = c.children && c.children.length ? c.children[0].id : c.id;

            html += `
        <div class="suggestion-item" onclick="searchCategory('${subId}')">
        ${c.name}
        </div>`;
});
    }
    if (data.products) {
        data.products.forEach(p => {
            html += `
<div class="suggestion-item" onclick="openProduct('${p.slug}')">
${p.name}
</div>
`;
        });
    }
    suggestions.innerHTML = html;
}

async function loadProducts(q) {
    try {
        const res = await fetch(`${API_BASE}/products/search?q=${encodeURIComponent(q)}`);
        const data = await res.json();
        if (!data.success) return;
        saveRecentSearch(q);
        renderProducts(data.data.products);
    } catch (e) {
        console.log(e);
    }
}

async function renderProducts(products) {

    let html = "";

    for (const p of products) {

        let imageUrl = await resolveImage(p.slug);

        html += `
            <div class="product" onclick="openProduct('${p.slug}')">
            <img src="${imageUrl}" 
                style="width:100%;height:160px;object-fit:cover;"
                onerror="this.src='https://via.placeholder.com/300x400?text=No+Image'">

            <div class="product-info">
            <div class="product-name">${p.name}</div>
            <div class="product-price">₹${p.final_price || p.price || ''}</div>
            </div>
            </div>
            `;
                }

        results.innerHTML = html;
}
function openProduct(slug) {
    window.location.href = `/product/${slug}`;
}
function searchCategory(id) {
    window.location.href = `/products?subcategory=${id}`;
}
function saveRecentSearch(query) {

    let searches = JSON.parse(localStorage.getItem("recent_searches")) || [];
    searches = searches.filter(q => q !== query);

    searches.unshift(query); 

    searches = searches.slice(0,10); 

    localStorage.setItem("recent_searches", JSON.stringify(searches));
}
function showRecentSearches() {

    let searches = JSON.parse(localStorage.getItem("recent_searches")) || [];

    if (searches.length === 0) {
        suggestions.innerHTML = "";
        return;
    }

    let html = `<div class="recent-title">Recent Searches</div>`;

    searches.forEach(q => {
        html += `
        <div class="suggestion-item recent-item">
            <span class="recent-text" onclick="searchRecent('${q}')">🕘 ${q}</span>
            <span class="remove-recent" onclick="removeRecent(event,'${q}')">✕</span>
        </div>
        `;
    });

    suggestions.innerHTML = html;
}
function removeRecent(event, query) {

    event.stopPropagation(); // ⭐ important

    let searches = JSON.parse(localStorage.getItem("recent_searches")) || [];

    searches = searches.filter(q => q !== query);

    localStorage.setItem("recent_searches", JSON.stringify(searches));

    showRecentSearches();
}
async function handleEnterSearch() {
    const q = input.value.trim();
    if (!q) return;

    // Direct search - redirect to products page with search query
    window.location.href = `/products?search=${encodeURIComponent(q)}`;
}