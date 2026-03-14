const API_BASE = "https://retailadmin.ggconsultancy.services/api";

const input = document.getElementById("searchInput");
const suggestions = document.getElementById("suggestions");
const results = document.getElementById("results");
const clearBtn = document.getElementById("clearBtn");

let timer = null;

window.addEventListener("DOMContentLoaded", () => {
    input.focus();
});

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

clearBtn.addEventListener("click", () => {
    input.value = "";
    suggestions.innerHTML = "";
    results.innerHTML = "";
    clearBtn.style.display = "none";
    input.focus();
});

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
            html += `
<div class="suggestion-item" onclick="searchCategory('${c.slug}')">
${c.name}
</div>
`;
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
        renderProducts(data.data.products);
    } catch (e) {
        console.log(e);
    }
}

function renderProducts(products) {
    if (!products || products.length === 0) {
        results.innerHTML = "<div>No products found</div>";
        return;
    }
    let html = "";
    products.forEach(p => {
        html += `
<div class="product" onclick="openProduct('${p.slug}')">
<img src="${p.image_url}">
<div class="product-info">
<div class="product-name">${p.name}</div>
<div class="product-price">₹${p.final_price || p.price}</div>
</div>
</div>
`;
    });
    results.innerHTML = html;
}

function openProduct(slug) {
    window.location.href = `/product/${slug}`;
}

function searchCategory(slug) {
    window.location.href = `/products?category=${slug}`;
}