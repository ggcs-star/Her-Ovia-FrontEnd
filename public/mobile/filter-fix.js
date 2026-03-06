(function() {
    function initFilterFix() {
        if (!window.app) {
            setTimeout(initFilterFix, 100);
            return;
        }
        
        console.log('Filter system initializing...');
        
        window.categoryMap = {
            parents: {},
            children: {}
        };
        
        if (window.app.allCategories) {
            window.app.allCategories.forEach(parent => {
                window.categoryMap.parents[parent.id] = parent;
                if (parent.children) {
                    parent.children.forEach(child => {
                        window.categoryMap.children[child.id] = parent.id;
                    });
                }
            });
        }
        
        setupCategoryFilter();
        setupDynamicFilters();
        setupMobilePopup();
        
        window.applyAllFilters = applyAllFilters;
    }
    
    async function applyAllFilters() {
        console.log('Applying filters...');
        
        const grid = document.getElementById('full-category-grid') || document.getElementById('category-products-grid');
        const countEl = document.getElementById('product-count');
        
        if (!grid) return;
        
        const selectedParents = Array.from(document.querySelectorAll('.parent-category-filter:checked')).map(cb => cb.value);
        const selectedChildren = Array.from(document.querySelectorAll('.sub-category-filter:checked')).map(cb => cb.value);
        const selectedBrands = Array.from(document.querySelectorAll('.brand-filter:checked')).map(cb => cb.value);
        const selectedPrice = document.querySelector('input[name="price"]:checked')?.value;
        const selectedDiscounts = Array.from(document.querySelectorAll('.discount-filter:checked')).map(cb => parseInt(cb.value));
        const selectedOccasions = Array.from(document.querySelectorAll('.occasion-filter:checked')).map(cb => cb.value);
        const selectedColors = Array.from(document.querySelectorAll('.color-circle.selected')).map(c => c.dataset.color);
        
        const minPrice = document.getElementById('min-price')?.value;
        const maxPrice = document.getElementById('max-price')?.value;
        
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading...</div>';
        
        try {
            let allProducts = [];
            
            if (selectedParents.length > 0 || selectedChildren.length > 0) {
                const categoriesToLoad = [...new Set([...selectedParents, ...selectedChildren])];
                for (const catId of categoriesToLoad) {
                    const res = await window.app.callAPI(`${APP_CONFIG.ENDPOINTS.CATEGORIES}/${catId}/products`);
                    if (res.success && res.data?.products) {
                        allProducts.push(...res.data.products);
                    }
                }
            } else {
                const res = await window.app.callAPI(APP_CONFIG.ENDPOINTS.ALL_PRODUCTS);
                if (res.success && res.data?.products) {
                    allProducts = res.data.products;
                }
            }
            
            const unique = {};
            allProducts.forEach(p => unique[p.id] = p);
            allProducts = Object.values(unique);
            
            if (selectedBrands.length > 0) {
                allProducts = allProducts.filter(p => p.brand && selectedBrands.includes(p.brand));
            }
            
            if (selectedPrice) {
                const [min, max] = selectedPrice.split('-').map(Number);
                allProducts = allProducts.filter(p => {
                    const price = parseFloat(p.final_price || p.price || 0);
                    return price >= min && price < max;
                });
            } else if (minPrice && maxPrice) {
                allProducts = allProducts.filter(p => {
                    const price = parseFloat(p.final_price || p.price || 0);
                    return price >= parseFloat(minPrice) && price <= parseFloat(maxPrice);
                });
            }
            
            if (selectedDiscounts.length > 0) {
                allProducts = allProducts.filter(p => {
                    if (p.price && p.final_price) {
                        const original = parseFloat(p.price);
                        const final = parseFloat(p.final_price);
                        if (original > final) {
                            const discount = Math.round(((original - final) / original) * 100);
                            return selectedDiscounts.some(d => discount >= d);
                        }
                    }
                    return false;
                });
            }
            
            if (countEl) countEl.innerText = allProducts.length;
            
            if (allProducts.length > 0) {
                grid.innerHTML = allProducts.map(p => window.app.genProductCard(p)).join('');
            } else {
                grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found</p>';
            }
            
        } catch (error) {
            console.error('Error:', error);
            grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">Error loading products</p>';
        }
    }
    
    function setupCategoryFilter() {
        document.addEventListener('change', async function(e) {
            const isCategory = e.target.classList.contains('parent-category-filter');
            const isSubcategory = e.target.classList.contains('sub-category-filter');
            
            if (!isCategory && !isSubcategory) return;
            
            setTimeout(async () => {
                const selectedParents = Array.from(document.querySelectorAll('.parent-category-filter:checked')).map(cb => cb.value);
                const selectedChildren = Array.from(document.querySelectorAll('.sub-category-filter:checked')).map(cb => cb.value);
                
                if (selectedParents.length === 0 && selectedChildren.length === 0) {
                    if (window.app.page === 'category-detail') {
                        await showCurrentCategoryProducts();
                    } else {
                        window.app.renderCategories(window.app.allCategories);
                    }
                    return;
                }
                
                await applyAllFilters();
            }, 50);
        });
    }
    
    async function showCurrentCategoryProducts() {
        const categoryId = document.body.dataset.categoryId || window.location.pathname.split('/').pop();
        if (!categoryId) return;
        
        const grid = document.getElementById('category-products-grid');
        const countEl = document.getElementById('product-count');
        
        if (!grid) return;
        
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading...</div>';
        
        try {
            const res = await window.app.callAPI(`${APP_CONFIG.ENDPOINTS.CATEGORIES}/${categoryId}/products`);
            if (res.success && res.data?.products) {
                const products = res.data.products || [];
                if (countEl) countEl.innerText = products.length;
                
                if (products.length > 0) {
                    grid.innerHTML = products.map(p => window.app.genProductCard(p)).join('');
                } else {
                    grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found</p>';
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function setupDynamicFilters() {
        loadPriceFilters();
        loadBrandFilters();
        // loadOccasionFilters();
        loadDiscountFilters();
        loadColorFilters();
        setupFilterToggles();
        setupBrandActions();
        setupPriceApply();
    }
    
    async function loadPriceFilters() {
        const priceSection = document.querySelector('.price-presets');
        if (!priceSection) return;
        
        try {
            const res = await window.app.callAPI(APP_CONFIG.ENDPOINTS.ALL_PRODUCTS);
            
            if (res.success && res.data?.products) {
                const products = res.data.products;
                const prices = products.map(p => parseFloat(p.final_price || p.price || 0)).filter(p => p > 0);
                
                if (prices.length > 0) {
                    const min = Math.min(...prices);
                    const max = Math.max(...prices);
                    
                    let ranges = [];
                    if (max <= 1000) {
                        ranges.push({ min: 0, max: 500, label: 'Below ₹500' });
                        ranges.push({ min: 500, max: 1000, label: '₹500 - ₹1000' });
                    } else if (max <= 5000) {
                        ranges.push({ min: 0, max: 1000, label: 'Below ₹1000' });
                        ranges.push({ min: 1000, max: 2000, label: '₹1000 - ₹2000' });
                        ranges.push({ min: 2000, max: 3000, label: '₹2000 - ₹3000' });
                        ranges.push({ min: 3000, max: 5000, label: '₹3000 - ₹5000' });
                    } else {
                        ranges.push({ min: 0, max: 1000, label: 'Below ₹1000' });
                        ranges.push({ min: 1000, max: 2500, label: '₹1000 - ₹2500' });
                        ranges.push({ min: 2500, max: 5000, label: '₹2500 - ₹5000' });
                        ranges.push({ min: 5000, max: 10000, label: '₹5000 - ₹10000' });
                        ranges.push({ min: 10000, max: 20000, label: '₹10000 - ₹20000' });
                        ranges.push({ min: 20000, max: max + 1, label: 'Above ₹20000' });
                    }
                    
                    priceSection.innerHTML = ranges.map(r => {
                        const count = products.filter(p => {
                            const price = parseFloat(p.final_price || p.price || 0);
                            return price >= r.min && price < r.max;
                        }).length;
                        
                        return `
                            <label class="filter-option">
                                <input type="radio" name="price" value="${r.min}-${r.max}" onchange="applyAllFilters()">
                                <span>${r.label}</span>
                                <span class="count">(${count})</span>
                            </label>
                        `;
                    }).join('');
                }
            }
        } catch (error) {
            console.error('Error loading price filters:', error);
        }
    }
    
    async function loadBrandFilters() {
        const brandsList = document.getElementById('brands-list');
        if (!brandsList) return;
        
        try {
            const res = await window.app.callAPI(APP_CONFIG.ENDPOINTS.ALL_PRODUCTS);
            
            if (res.success && res.data?.products) {
                const products = res.data.products;
                const brandCounts = {};
                
                products.forEach(p => {
                    if (p.brand) {
                        brandCounts[p.brand] = (brandCounts[p.brand] || 0) + 1;
                    }
                });
                
                const brands = Object.keys(brandCounts).sort();
                
                brandsList.innerHTML = brands.map(brand => `
                    <li class="filter-option">
                        <input type="checkbox" class="brand-filter" value="${brand}" onchange="applyAllFilters()">
                        <label>${brand}</label>
                        <span class="count">(${brandCounts[brand]})</span>
                    </li>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading brands:', error);
        }
    }
    
   
    
    async function loadDiscountFilters() {
        const discountSection = document.querySelector('.filter-section:nth-child(6) .filter-options');
        if (!discountSection) return;
        
        try {
            const res = await window.app.callAPI(APP_CONFIG.ENDPOINTS.ALL_PRODUCTS);
            
            if (res.success && res.data?.products) {
                const products = res.data.products;
                const discountCounts = { 10:0, 20:0, 30:0, 40:0, 50:0 };
                
                products.forEach(p => {
                    if (p.price && p.final_price) {
                        const original = parseFloat(p.price);
                        const final = parseFloat(p.final_price);
                        if (original > final) {
                            const discount = Math.round(((original - final) / original) * 100);
                            if (discount >= 50) discountCounts[50]++;
                            else if (discount >= 40) discountCounts[40]++;
                            else if (discount >= 30) discountCounts[30]++;
                            else if (discount >= 20) discountCounts[20]++;
                            else if (discount >= 10) discountCounts[10]++;
                        }
                    }
                });
                
                discountSection.innerHTML = [
                    { value: 10, label: '10% and above' },
                    { value: 20, label: '20% and above' },
                    { value: 30, label: '30% and above' },
                    { value: 40, label: '40% and above' },
                    { value: 50, label: '50% and above' }
                ].map(d => `
                    <li class="filter-option">
                        <input type="checkbox" class="discount-filter" value="${d.value}" onchange="applyAllFilters()">
                        <label>${d.label}</label>
                        <span class="count">(${discountCounts[d.value]})</span>
                    </li>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading discount filters:', error);
        }
    }
    
    function loadColorFilters() {
        const colorsGrid = document.querySelector('.colors-grid');
        if (!colorsGrid) return;
        
        const colors = [
            { name: 'red', code: '#ff0000' },
            { name: 'blue', code: '#0000ff' },
            { name: 'green', code: '#00ff00' },
            { name: 'black', code: '#000000' },
            { name: 'white', code: '#ffffff', border: true },
            { name: 'pink', code: '#ffc0cb' },
            { name: 'yellow', code: '#ffff00' },
            { name: 'purple', code: '#800080' }
        ];
        
        colorsGrid.innerHTML = colors.map(c => `
            <span class="color-circle" data-color="${c.name}" 
                  onclick="this.classList.toggle('selected'); applyAllFilters();"
                  style="display: inline-block; width: 30px; height: 30px; border-radius: 50%; 
                         background: ${c.code}; cursor: pointer; 
                         border: 2px solid ${c.border ? '#ddd' : 'transparent'};">
            </span>
        `).join('');
    }
    
    function setupFilterToggles() {
        document.querySelectorAll('.filter-section-title').forEach(title => {
            title.addEventListener('click', (e) => {
                e.preventDefault();
                const section = title.closest('.filter-section');
                const content = section.querySelector('.filter-options, .price-range, .brands-header, .colors-grid');
                const icon = title.querySelector('.toggle-icon');
                
                if (content) {
                    if (content.style.display === 'none') {
                        content.style.display = 'block';
                        if (icon) icon.textContent = '−';
                    } else {
                        content.style.display = 'none';
                        if (icon) icon.textContent = '+';
                    }
                }
            });
        });
    }
    
    function setupBrandActions() {
        const selectAll = document.querySelector('.select-all-btn');
        const clearAll = document.querySelector('.clear-all-btn');
        
        if (selectAll) {
            selectAll.addEventListener('click', () => {
                document.querySelectorAll('.brand-filter').forEach(cb => cb.checked = true);
                applyAllFilters();
            });
        }
        
        if (clearAll) {
            clearAll.addEventListener('click', () => {
                document.querySelectorAll('.brand-filter').forEach(cb => cb.checked = false);
                applyAllFilters();
            });
        }
    }
    
    function setupPriceApply() {
        const applyBtn = document.querySelector('.apply-price-btn');
        if (applyBtn) {
            applyBtn.addEventListener('click', applyAllFilters);
        }
        
        const minInput = document.getElementById('min-price');
        const maxInput = document.getElementById('max-price');
        
        if (minInput) minInput.addEventListener('change', applyAllFilters);
        if (maxInput) maxInput.addEventListener('change', applyAllFilters);
    }
    
    function setupMobilePopup() {
        if (window.innerWidth > 768) return;
        
        document.addEventListener('click', function(e) {
            const catCard = e.target.closest('.category-card');
            if (!catCard || !catCard.dataset.id) return;
            
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const categoryId = catCard.dataset.id;
            const category = window.app.allCategories.find(c => String(c.id) === String(categoryId));
            if (!category) return;
            
            loadCategoryWithBrands(category);
            
        }, true);
    }
    
    async function loadCategoryWithBrands(category) {
        showLoadingPopup(category.name);
        
        try {
            const res = await window.app.callAPI(`${APP_CONFIG.ENDPOINTS.CATEGORIES}/${category.id}/products`);
            
            let brands = [];
            if (res.success && res.data?.products) {
                const brandSet = new Set();
                res.data.products.forEach(p => {
                    if (p.brand) brandSet.add(p.brand);
                });
                brands = Array.from(brandSet);
            }
            
            showCategoryPopupWithDropdown(category, brands);
            
        } catch (error) {
            console.error('Error:', error);
            showCategoryPopupWithDropdown(category, []);
        }
    }
    
    function showLoadingPopup(categoryName) {
        const oldPopup = document.querySelector('.category-popup-mobile');
        if (oldPopup) oldPopup.remove();
        
        const popup = document.createElement('div');
        popup.className = 'category-popup-mobile';
        popup.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 100000;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        `;
        
        popup.innerHTML = `
            <div style="padding: 20px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 24px; font-weight: 800; color: #282c3f; margin: 0;">${categoryName}</h2>
                <button class="close-popup" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #999;">&times;</button>
            </div>
            <div style="text-align: center; padding: 60px 20px;">
                <div style="width: 40px; height: 40px; border: 3px solid #f3f3f3; border-top: 3px solid #ff3f6c; border-radius: 50%; margin: 0 auto 20px; animation: spin 1s linear infinite;"></div>
                <p style="color: #999;">Loading...</p>
            </div>
            <style>
                @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
            </style>
        `;
        
        document.body.appendChild(popup);
        document.body.style.overflow = 'hidden';
        
        popup.querySelector('.close-popup').addEventListener('click', () => {
            popup.remove();
            document.body.style.overflow = '';
        });
    }
    
    function showCategoryPopupWithDropdown(category, brands) {
        const oldPopup = document.querySelector('.category-popup-mobile');
        if (oldPopup) oldPopup.remove();
        
        const popup = document.createElement('div');
        popup.className = 'category-popup-mobile';
        popup.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 100000;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        `;
        
        let html = `
            <div style="padding: 20px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; z-index: 10;">
                <h2 style="font-size: 24px; font-weight: 800; color: #282c3f; margin: 0;">${category.name}</h2>
                <button class="close-popup" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #999;">&times;</button>
            </div>
            <div style="padding: 0 20px;">
        `;
        
        if (category.children && category.children.length > 0) {
            html += `
                <div style="margin: 20px 0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #282c3f; margin-bottom: 15px; text-transform: uppercase;">Subcategories</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
            `;
            
            category.children.forEach(sub => {
                const subImage = window.app.resolveImage(sub.image_url) || window.app.resolveImage(category.image_url) || 'https://via.placeholder.com/60';
                
                html += `
                    <div class="subcategory-item" data-sub-id="${sub.id}" data-cat-id="${category.id}" style="display: flex; align-items: center; padding: 12px; background: white; border: 1px solid #f0f0f0; border-radius: 12px; cursor: pointer;">
                        <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden; margin-right: 15px; background: #f5f5f6;">
                            <img src="${subImage}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/60'">
                        </div>
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="font-size: 16px; font-weight: 600; color: #282c3f; margin: 0;">${sub.name}</h4>
                            <span style="color: #ff3f6c; font-size: 18px;">→</span>
                        </div>
                    </div>
                `;
            });
            
            html += `</div></div>`;
        }
        
        if (brands && brands.length > 0) {
            html += `
                <div style="margin: 20px 0;">
                    <div class="brands-dropdown-header" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                        <h3 style="font-size: 16px; font-weight: 700; color: #282c3f; margin: 0; text-transform: uppercase;">Brands</h3>
                        <span class="dropdown-icon" style="font-size: 20px; color: #ff3f6c; transition: transform 0.3s;">▼</span>
                    </div>
                    <div class="brands-dropdown-content" style="display: none; padding: 15px 0;">
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            `;
            
            brands.forEach(brand => {
                html += `
                    <div class="brand-item" data-brand="${brand}" data-cat-id="${category.id}" style="padding: 10px 20px; background: #f5f5f6; border-radius: 30px; font-size: 14px; font-weight: 600; color: #282c3f; cursor: pointer; border: 1px solid #eaeaec; transition: all 0.2s;">
                        ${brand}
                    </div>
                `;
            });
            
            html += `</div></div></div>`;
        }
        
        html += `
            <div style="margin: 30px 0 20px;">
                <button class="view-all-products" data-cat-id="${category.id}" style="width: 100%; padding: 16px; background: #ff3f6c; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer;">
                    View All ${category.name} Products
                </button>
            </div>
        `;
        
        html += `</div>`;
        
        popup.innerHTML = html;
        document.body.appendChild(popup);
        document.body.style.overflow = 'hidden';
        
        popup.querySelector('.close-popup').addEventListener('click', () => {
            popup.remove();
            document.body.style.overflow = '';
        });
        
        popup.querySelectorAll('.subcategory-item').forEach(item => {
    item.addEventListener('click', async () => {
        // ✅ Subcategory ki apni ID use karo
        const categoryId = item.dataset.subId;  // ✅ Yeh subcategory ki ID hai
        console.log('Loading products for subcategory ID:', categoryId);
        
        // Show loading
        const grid = document.getElementById('full-category-grid');
        if (grid) {
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading products...</div>';
        }
        
        try {
            // ✅ Subcategory ID se API call
            const url = `${APP_CONFIG.ENDPOINTS.CATEGORIES}/${categoryId}/products`;
            console.log('Fetching products from:', url);
            
            const res = await window.app.callAPI(url);
            console.log('API Response:', res);
            
            // Extract products
            let products = [];
            if (res.success && res.data) {
                if (res.data.products && Array.isArray(res.data.products)) {
                    products = res.data.products;
                } else if (Array.isArray(res.data)) {
                    products = res.data;
                }
            }
            
            // Update count
            const countEl = document.getElementById('product-count');
            if (countEl) countEl.innerText = products.length;
            
            // Render products
            if (products.length > 0 && grid) {
                if (window.app && typeof window.app.genProductCard === 'function') {
                    grid.innerHTML = products.map(p => window.app.genProductCard(p)).join('');
                }
            } else if (grid) {
                grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found in this category</p>';
            }
            
        } catch (error) {
            console.error('Error:', error);
            if (grid) {
                grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">Error loading products</p>';
            }
        }
        
        // Close popup
        popup.remove();
        document.body.style.overflow = '';
    });
});
        
        const dropdownHeader = popup.querySelector('.brands-dropdown-header');
        if (dropdownHeader) {
            dropdownHeader.addEventListener('click', () => {
                const content = popup.querySelector('.brands-dropdown-content');
                const icon = popup.querySelector('.dropdown-icon');
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    content.style.display = 'none';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }
        
        popup.querySelectorAll('.brand-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                const brand = item.dataset.brand;
                const catId = item.dataset.catId;
                filterProductsByBrand(catId, brand);
                popup.remove();
            });
        });
        
        popup.querySelector('.view-all-products').addEventListener('click', () => {
            window.app.navigate(`/category/${category.id}`);
        });
        
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.remove();
                document.body.style.overflow = '';
            }
        });
    }
    
    // async function filterProductsBySubcategory(catId, subId) {
    //     const grid = document.getElementById('full-category-grid');
    //     const countEl = document.getElementById('product-count');
        
    //     if (!grid) return;
        
    //     grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading...</div>';
        
    //     try {
    //         const res = await window.app.callAPI(`${APP_CONFIG.ENDPOINTS.CATEGORIES}/${catId}/products`);
            
    //         if (res.success && res.data?.products) {
    //             let subName = '';
    //             for (const cat of window.app.allCategories) {
    //                 if (cat.children) {
    //                     const sub = cat.children.find(s => String(s.id) === String(subId));
    //                     if (sub) {
    //                         subName = sub.name.toLowerCase();
    //                         break;
    //                     }
    //                 }
    //             }
                
    //             let products = res.data.products;
    //             if (subName) {
    //                 products = products.filter(p => p.name && p.name.toLowerCase().includes(subName));
    //             }
                
    //             if (countEl) countEl.innerText = products.length;
                
    //             if (products.length > 0) {
    //                 grid.innerHTML = products.map(p => window.app.genProductCard(p)).join('');
    //             } else {
    //                 grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found</p>';
    //             }
    //         }
    //     } catch (error) {
    //         console.error('Error:', error);
    //     }
    // }
    
    async function filterProductsByBrand(catId, brandName) {
        const grid = document.getElementById('full-category-grid');
        const countEl = document.getElementById('product-count');
        
        if (!grid) return;
        
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading...</div>';
        
        try {
            const res = await window.app.callAPI(`${APP_CONFIG.ENDPOINTS.CATEGORIES}/${catId}/products`);
            
            if (res.success && res.data?.products) {
                const products = res.data.products.filter(p => 
                    p.brand && p.brand.toLowerCase() === brandName.toLowerCase()
                );
                
                if (countEl) countEl.innerText = products.length;
                
                if (products.length > 0) {
                    grid.innerHTML = products.map(p => window.app.genProductCard(p)).join('');
                } else {
                    grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found</p>';
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .brand-item:hover {
            background: #ff3f6c !important;
            color: white !important;
            border-color: #ff3f6c !important;
        }
        .color-circle.selected {
            border-color: #ff3f6c !important;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #ff3f6c;
        }
    `;
    document.head.appendChild(style);
    
    initFilterFix();
})();
async function loadProductsForCategory(categoryId, subCategoryId = null) {
    const grid = document.getElementById('full-category-grid');
    const countEl = document.getElementById('product-count');
    
    if (!grid) {
        console.error('Grid not found');
        return;
    }
    
    grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px;">Loading products...</div>';
    
    try {
        // API call
        const url = `${APP_CONFIG.ENDPOINTS.CATEGORIES}/${categoryId}/products`;
        console.log('Fetching products from:', url);
        
        const res = await window.app.callAPI(url);
        console.log('API Response:', res);
        
        // Extract products based on API structure
        let products = [];
        
        if (res.success) {
            if (res.data && Array.isArray(res.data)) {
                // Case 1: Direct array
                products = res.data;
            } else if (res.data && res.data.products && Array.isArray(res.data.products)) {
                // Case 2: Nested in data.products (your API)
                products = res.data.products;
            } else if (res.data && res.data.data && Array.isArray(res.data.data)) {
                // Case 3: Double nested
                products = res.data.data;
            }
        }
        
        console.log('Extracted products:', products);
        
        // Filter by subcategory if needed
        if (subCategoryId && products.length > 0) {
            // Find subcategory name
            let subName = '';
            for (const cat of window.app.allCategories || []) {
                if (cat.children) {
                    const sub = cat.children.find(s => String(s.id) === String(subCategoryId));
                    if (sub) {
                        subName = sub.name.toLowerCase();
                        break;
                    }
                }
            }
            
            // Filter products
            if (subName) {
                products = products.filter(p => 
                    (p.name && p.name.toLowerCase().includes(subName)) ||
                    (p.category && p.category.toLowerCase().includes(subName))
                );
            }
        }
        
        // Update count
        if (countEl) countEl.innerText = products.length;
        
        // Render products
        if (products.length > 0) {
            if (window.app && typeof window.app.genProductCard === 'function') {
                grid.innerHTML = products.map(p => window.app.genProductCard(p)).join('');
            } else {
                // Fallback rendering
                grid.innerHTML = products.map(p => `
                    <div class="product-card" data-slug="${p.slug || ''}">
                        <div class="product-image-wrapper">
                            <img src="${p.image_url || 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=300&h=400&fit=crop'}" alt="${p.name}">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">${p.brand || 'RAPID RETAIL'}</div>
                            <div class="product-name">${p.name || 'Product'}</div>
                            <div class="price-section">
                                <span class="current-price">₹${parseFloat(p.final_price || p.price || 0).toLocaleString('en-IN')}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            
            // Add click handlers
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const slug = this.dataset.slug;
                    if (slug) window.location.href = `/product/${slug}`;
                });
            });
            
        } else {
            grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No products found</p>';
        }
        
        // Update context
        updateCategoryContext(categoryId, subCategoryId);
        
    } catch (error) {
        console.error('Error loading products:', error);
        grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#999">Error loading products</p>';
    }
}
function updateCategoryContext(categoryId, subCategoryId = null) {
    // Update body dataset
    document.body.dataset.categoryId = categoryId;
    
    // Update breadcrumb or title if exists
    const titleEl = document.getElementById('category-title');
    if (titleEl) {
        const category = window.app.allCategories.find(c => String(c.id) === String(categoryId));
        if (category) {
            if (subCategoryId) {
                const sub = category.children?.find(s => String(s.id) === String(subCategoryId));
                titleEl.textContent = sub ? sub.name : category.name;
            } else {
                titleEl.textContent = category.name;
            }
        }
    }
}