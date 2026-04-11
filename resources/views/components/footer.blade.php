<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            <div class="footer-col">

                <div style="display:flex; align-items:center; gap:10px;">

                    <img id="footer-logo"
                         src=""
                         alt="Logo"
                         class="site-logo"
                         style="height:40px;"
                         onerror="this.src='https://placehold.co/120x40?text=LOGO'">

                </div>

                <p class="footer-tagline">
                    Your one-stop destination for fashion and lifestyle.
                </p>

                <div class="footer-location">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>
                        5th Floor, Grand Emporio, Shiv Habitat B-Block,
                        Motera Stadium Rd, Motera,
                        Ahmedabad, Gujarat 380005
                    </span>
                </div>

            </div>

            <div class="footer-col">
                <h4>Categories</h4>
                <ul id="footerCategoriesList">
                    <li>Loading...</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Support</h4>
                <ul class="footer-support-list">
                    <li>Help Center</li>
                    <li>Returns & Refunds</li>
                    <li>Shipping Info</li>
                    <li>Track Order</li>
                    <li>Contact Us</li>
                    <li>FAQs</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Join Us</h4>
                <div class="social-links">

                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <circle cx="12" cy="12" r="4.5"></circle>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <span>Instagram</span>
                    </div>

                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </div>
                        <span>Facebook</span>
                    </div>

                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </div>
                        <span>Twitter</span>
                    </div>

                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
                                <polygon points="9 15 15 12 9 9 9 15"></polygon>
                            </svg>
                        </div>
                        <span>YouTube</span>
                    </div>

                    <div class="social-link-item">
                        <div class="social-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M8 3a5 5 0 0 0-5 5c0 7 9 13 9 13s9-6 9-13a5 5 0 0 0-5-5z"></path>
                                <circle cx="12" cy="8" r="2"></circle>
                            </svg>
                        </div>
                        <span>Pinterest</span>
                    </div>

                </div>
            </div>

            <div class="footer-col">
                <h4>Contact Information</h4>
                <ul class="contact-info">
                    <li>
                        <a href="mailto:info@radiantjewel.com">info@radiantjewel.com</a>
                    </li>
                    <li>
                        <a href="tel:+918866373077">+91 8866373077</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>
                © <span id="footerYear"></span>
                All Rights Reserved.
            </p>
        </div>

    </div>
</footer>
<style>
    /* ===== FOOTER STYLES - ACCENT COLOR #F4B94E ===== */
.site-footer {
    background: #ffffff;
    border-top: 1px solid #f0f0f0;
    margin-top: 30px;
    padding: 40px 0 30px;
}

.site-footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 30px;
    margin-bottom: 40px;
}

.footer-col h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.footer-col h4:after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #F4B94E;
}

.footer-tagline {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
    margin: 15px 0 20px;
}

.footer-location {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 0;
    border-top: 1px solid #eaeaea;
    border-bottom: 1px solid #eaeaea;
}

.footer-location svg {
    width: 18px;
    height: 18px;
    color: #F4B94E;
    flex-shrink: 0;
    margin-top: 2px;
}

.footer-location span {
    font-size: 12px;
    color: #666;
    line-height: 1.5;
}

.footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-col ul li {
    margin-bottom: 12px;
}

.footer-col ul li a {
    text-decoration: none;
    color: #555;
    font-size: 13px;
    transition: color 0.2s ease;
}

.footer-col ul li a:hover {
    color: #F4B94E;
}

.footer-support-list li {
    font-size: 13px;
    color: #555;
    cursor: default;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.social-link-item {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.social-link-item:hover {
    transform: translateX(5px);
}

.social-link-item:hover .social-icon {
    background: #F4B94E;
}

.social-link-item:hover .social-icon svg {
    stroke: #440C2C;
}

.social-link-item:hover span {
    color: #F4B94E;
}

.social-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.social-icon svg {
    width: 16px;
    height: 16px;
    stroke: #666;
    transition: all 0.3s ease;
}

.social-link-item span {
    font-size: 13px;
    color: #555;
    transition: color 0.2s ease;
}

.contact-info li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.contact-info li a {
    text-decoration: none;
    color: #555;
    font-size: 13px;
    word-break: break-all;
}

.contact-info li a:hover {
    color: #F4B94E;
}

.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid #eaeaea;
}

.footer-bottom p {
    font-size: 12px;
    color: #888;
    margin: 0;
}

@media screen and (max-width: 1024px) {
    .footer-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }
}

@media screen and (max-width: 768px) {
    .site-footer {
        display: none !important;
    }
}

@media screen and (min-width: 1025px) {
    .site-footer {
        display: block !important;
    }
}
</style>
<script>
async function initFooter() {
    try {
        if (!window.API_BASE_URL) return;

        const settingsRes = await fetch(`${window.API_BASE_URL}/app-settings`);
        const settingsData = await settingsRes.json();

        if (settingsData.success) {
            const logo = settingsData.data.header_logo;

            const footerLogo = document.getElementById('footer-logo');

            if (footerLogo && logo) {
                footerLogo.src = logo;
            }
        }

        const catRes = await fetch(`${window.API_BASE_URL}/categories`);
        const catData = await catRes.json();

        if (catData.success) {
            const list = document.getElementById('footerCategoriesList');
            const categories = catData.data.slice(0, 6);

            if (list) {
                list.innerHTML = categories.map(cat => `
                    <li>
                        <a href="/category/${cat.id}">
                            ${cat.name}
                        </a>
                    </li>
                `).join('');
            }
        }

        const yearEl = document.getElementById('footerYear');
        if (yearEl) {
            yearEl.textContent = new Date().getFullYear();
        }

    } catch (err) {
        console.error('Footer error:', err);
    }
}

document.addEventListener('DOMContentLoaded', initFooter);
</script>