const API_BASE_URL = window.API_BASE_URL || '';
const S3_BASE_URL = window.S3_BASE_URL || '';
const FALLBACK_IMAGE = 'https://placehold.co/600x700/f7eadf/440c2c?text=Her-Ovia';

const state = {
  categories: [],
  subcategories: [],
  topSellingProducts: []
};

document.addEventListener('DOMContentLoaded', initializeCategoriesPage);

function initializeCategoriesPage() {
  showSkeletons();
  bindPageEvents();

  Promise.all([
    loadCategories(),
    loadCategoryHeroBanner(),
    loadTopSellingProducts()
  ]).catch(error => console.error('Categories page loading error:', error));
}

function bindPageEvents() {
  document.addEventListener('click', handlePageClick);
  document.addEventListener('keydown', handlePageKeydown);
  document.addEventListener('error', handleImageError, true);
}

function handlePageClick(event) {
  const target = event.target.closest('[data-action]');
  if (!target) return;

  switch (target.dataset.action) {
    case 'toggle-category':
      toggleCategoryDropdown(Number(target.dataset.categoryId));
      break;
    case 'open-category':
      openCategory(Number(target.dataset.categoryId));
      break;
    case 'open-subcategory':
      openSubcategory(Number(target.dataset.subcategoryId));
      break;
    case 'open-product':
      openProduct(target.dataset.productSlug, target.dataset.productId);
      break;
  }
}

function handlePageKeydown(event) {
  if (event.key !== 'Enter' && event.key !== ' ') return;

  const target = event.target.closest('[data-action]');
  if (!target) return;

  event.preventDefault();
  target.click();
}

function handleImageError(event) {
  const image = event.target;

  if (
    !(image instanceof HTMLImageElement) ||
    !image.dataset.fallbackImage ||
    image.dataset.fallbackApplied === 'true'
  ) {
    return;
  }

  image.dataset.fallbackApplied = 'true';
  image.src = image.dataset.fallbackImage;
}

async function fetchJson(url) {
  const response = await fetch(url, {
    headers: { Accept: 'application/json' }
  });

  if (!response.ok) {
    throw new Error(`API request failed: ${response.status}`);
  }

  return response.json();
}

async function loadCategories() {
  try {
    const result = await fetchJson(`${API_BASE_URL}/categories`);
    const categories = extractCategories(result);

    state.categories = categories;
    buildCategoryTree(categories);
    renderSidebar();
    renderMainCategories();
    renderSubcategories();
  } catch (error) {
    console.error('Categories loading error:', error);

    renderEmptyState('main-category-cards', 'Unable to load categories.');
    renderEmptyState('featured-subcategories', 'Unable to load subcategories.');

    const sidebar = document.getElementById('categories-sidebar-list');

    if (sidebar) {
      sidebar.innerHTML = `
        <div class="category-sidebar-loading">
          Unable to load categories.
        </div>
      `;
    }
  }
}

function extractCategories(result) {
  if (Array.isArray(result)) return result;
  if (Array.isArray(result?.data)) return result.data;
  if (Array.isArray(result?.data?.categories)) return result.data.categories;
  if (Array.isArray(result?.categories)) return result.categories;
  if (Array.isArray(result?.data?.data)) return result.data.data;
  return [];
}

function buildCategoryTree(categories) {
  state.subcategories = [];

  categories.forEach(category => {
    getChildren(category).forEach(subcategory => {
      state.subcategories.push({
        ...subcategory,
        parentCategory: category
      });
    });
  });
}

function getChildren(item) {
  if (!item) return [];
  if (Array.isArray(item.children)) return item.children;
  if (Array.isArray(item.subcategories)) return item.subcategories;
  if (Array.isArray(item.sub_categories)) return item.sub_categories;
  if (Array.isArray(item.subCategories)) return item.subCategories;
  return [];
}

function renderSidebar() {
  const container = document.getElementById('categories-sidebar-list');
  if (!container) return;

  if (!state.categories.length) {
    container.innerHTML = `
      <div class="category-sidebar-loading">
        No categories available.
      </div>
    `;
    return;
  }

  container.innerHTML = state.categories.map(category => {
    const id = getId(category);
    const name = escapeHtml(getName(category));
    const image = getImage(category);
    const children = getChildren(category);

    const subcategories = children.length
      ? children.map(subcategory => {
          const subId = getId(subcategory);
          const subName = escapeHtml(getName(subcategory));

          return `
            <div
              class="category-sidebar-subcategory"
              data-action="open-subcategory"
              data-subcategory-id="${subId}"
              role="link"
              tabindex="0"
            >
              <span>${subName}</span>
              <span>›</span>
            </div>
          `;
        }).join('')
      : `
        <div class="category-no-subcategory">
          No subcategories available
        </div>
      `;

    return `
      <div class="category-sidebar-group">
        <div
          class="category-sidebar-item"
          data-action="toggle-category"
          data-category-id="${id}"
          role="button"
          tabindex="0"
        >
          <div class="category-sidebar-image">
            <img
              src="${image}"
              alt="${name}"
              loading="lazy"
              data-fallback-image="${FALLBACK_IMAGE}"
            >
          </div>

          <span class="category-sidebar-name">${name}</span>

          <span
            class="category-sidebar-arrow"
            id="category-arrow-${id}"
          >+</span>
        </div>

        <div
          class="category-sidebar-subcategories"
          id="category-subcategories-${id}"
        >
          ${subcategories}
        </div>
      </div>
    `;
  }).join('');
}

function toggleCategoryDropdown(id) {
  const dropdown = document.getElementById(`category-subcategories-${id}`);
  const arrow = document.getElementById(`category-arrow-${id}`);

  if (!dropdown) return;

  const isOpen = dropdown.classList.toggle('is-open');

  if (arrow) {
    arrow.textContent = isOpen ? '−' : '+';
  }
}

function renderMainCategories() {
  const container = document.getElementById('main-category-cards');
  if (!container) return;

  if (!state.categories.length) {
    renderEmptyState('main-category-cards', 'No categories available.');
    return;
  }

  container.innerHTML = state.categories.map(category => {
    const id = getId(category);
    const name = escapeHtml(getName(category));
    const image = getImage(category);
    const children = getChildren(category);
    const countLabel = children.length === 1 ? 'Subcategory' : 'Subcategories';

    return `
      <article
        class="main-category-card"
        data-action="open-category"
        data-category-id="${id}"
        role="link"
        tabindex="0"
      >
        <div class="main-category-image">
          <img
            src="${image}"
            alt="${name}"
            loading="lazy"
            data-fallback-image="${FALLBACK_IMAGE}"
          >
        </div>

        <div class="main-category-info">
          <h3>${name}</h3>
          <p>${children.length} ${countLabel}</p>
          <span class="main-category-arrow">→</span>
        </div>
      </article>
    `;
  }).join('');
}

function renderSubcategories() {
  const container = document.getElementById('featured-subcategories');
  const count = document.getElementById('subcategory-count');

  if (!container) return;

  if (count) {
    count.textContent = `${state.subcategories.length} Subcategories`;
  }

  if (!state.subcategories.length) {
    renderEmptyState('featured-subcategories', 'No subcategories available.');
    return;
  }

  container.innerHTML = state.subcategories.map(subcategory => {
    const id = getId(subcategory);
    const name = escapeHtml(getName(subcategory));
    const image = getImage(subcategory);

    return `
      <article
        class="featured-subcategory-card"
        data-action="open-subcategory"
        data-subcategory-id="${id}"
        role="link"
        tabindex="0"
      >
        <div class="featured-subcategory-image">
          <img
            src="${image}"
            alt="${name}"
            loading="lazy"
            data-fallback-image="${FALLBACK_IMAGE}"
          >
        </div>

        <div class="featured-subcategory-info">
          <h3>${name}</h3>
          <p>Explore ${name} collection</p>
          <span class="featured-subcategory-arrow">→</span>
        </div>
      </article>
    `;
  }).join('');
}
async function loadTopSellingProducts() {
    const section = document.getElementById('you-may-also-like');
    const container = document.getElementById('top-selling-products');

    if (!section || !container) return;

    renderTopSellingSkeletons();

    try {
        const result = await fetchJson(`${API_BASE_URL}/products/top-selling`);
        const products = extractProducts(result);

        state.topSellingProducts = products;

        if (!products.length) {
            section.style.display = 'none';
            return;
        }

        renderTopSellingProducts();
    } catch (error) {
        console.error('Top selling products loading error:', error);
        section.style.display = 'none';
    }
}
function renderTopSellingSkeletons() {
    const container = document.getElementById('top-selling-products');

    if (!container) return;

    container.innerHTML = Array.from({ length: 4 }, () => `
        <article class="category-product-card category-product-skeleton" aria-hidden="true">
            <div class="category-product-skeleton-image"></div>

            <div class="category-product-skeleton-info">
                <div class="category-product-skeleton-line category-product-skeleton-brand"></div>
                <div class="category-product-skeleton-line"></div>
                <div class="category-product-skeleton-line category-product-skeleton-short"></div>
                <div class="category-product-skeleton-price"></div>
            </div>
        </article>
    `).join('');
}

function extractProducts(result) {
  if (Array.isArray(result?.data?.products)) return result.data.products;
  if (Array.isArray(result?.products)) return result.products;
  if (Array.isArray(result?.data)) return result.data;
  return [];
}

function renderTopSellingProducts() {
  const container = document.getElementById('top-selling-products');
  if (!container) return;

  if (!state.topSellingProducts.length) {
    container.innerHTML = '';
    return;
  }

  container.innerHTML = state.topSellingProducts.map(product => {
    const id = getProductId(product);
    const name = escapeHtml(product?.name || 'Product');
    const brand = escapeHtml(product?.brand || '');
    const slug = product?.slug || '';
    const image = getProductImage(product);
    const price = getProductPrice(product);

    return `
      <article
        class="category-product-card"
        data-action="open-product"
        data-product-id="${id}"
        data-product-slug="${escapeHtml(slug)}"
        role="link"
        tabindex="0"
      >
        <div class="category-product-image-wrap">
          <img
            class="category-product-image"
            src="${image}"
            alt="${name}"
            loading="lazy"
            data-fallback-image="${FALLBACK_IMAGE}"
          >
          <span class="category-product-badge">Top Selling</span>
        </div>

        <div class="category-product-info">
          ${brand ? `<span class="category-product-brand">${brand}</span>` : ''}
          <h3>${name}</h3>
          <div class="category-product-price">₹${formatPrice(price)}</div>
        </div>
      </article>
    `;
  }).join('');
}

function getProductId(product) {
  return Number(product?.id || product?.product_id || 0);
}

function getProductImage(product) {
  const gallery = product?.gallery_images;

  if (Array.isArray(gallery) && gallery.length) {
    const first = gallery[0];

    if (typeof first === 'string' && first.trim()) {
      return normalizeImageUrl(first);
    }

    if (first?.image_url) {
      return normalizeImageUrl(first.image_url);
    }

    if (first?.url) {
      return normalizeImageUrl(first.url);
    }
  }

  const variants = Array.isArray(product?.variants) ? product.variants : [];
  const variantImage = variants.find(item => item?.image_url)?.image_url;

  const image =
    product?.image_url ||
    product?.image ||
    product?.main_image_url ||
    product?.main_image ||
    variantImage ||
    '';

  return image ? normalizeImageUrl(image) : FALLBACK_IMAGE;
}

function normalizeImageUrl(image) {
  if (!image) return FALLBACK_IMAGE;

  if (
    image.startsWith('http://') ||
    image.startsWith('https://') ||
    image.startsWith('data:')
  ) {
    return image;
  }

  const base = S3_BASE_URL.replace(/\/$/, '');
  const path = String(image).replace(/^\//, '');

  return base ? `${base}/${path}` : `/${path}`;
}

function getProductPrice(product) {
  const variant = Array.isArray(product?.variants)
    ? product.variants.find(item => Number(item?.status ?? 1) !== 0)
    : null;

  return Number(
    product?.final_price ??
    product?.selling_price ??
    product?.price ??
    product?.product_price ??
    variant?.selling_price ??
    0
  );
}

function formatPrice(value) {
  return new Intl.NumberFormat('en-IN', {
    maximumFractionDigits: 0
  }).format(Number(value) || 0);
}

async function loadCategoryHeroBanner() {
  const hero = document.getElementById('categories-hero');
  const container = document.getElementById('category-hero-image');

  if (!hero || !container) return;

  try {
    const result = await fetchJson(`${API_BASE_URL}/banners`);
    const banners = Array.isArray(result?.data) ? result.data : [];
    const now = new Date();

    const validBanners = banners
      .filter(item => {
        if (item.page !== 'category') return false;
        if (item.position !== 'hero') return false;
        if (Number(item.status) !== 1) return false;
        if (!item.image) return false;

        if (item.start_date) {
          const startDate = new Date(item.start_date.replace(' ', 'T'));
          if (now < startDate) return false;
        }

        if (item.end_date) {
          const endDate = new Date(item.end_date.replace(' ', 'T'));
          if (now > endDate) return false;
        }

        return true;
      })
      .sort((a, b) => Number(a.sort_order || 0) - Number(b.sort_order || 0));

    const banner = validBanners[0];

    if (!banner) {
      hero.style.display = 'none';
      return;
    }

    const picture = document.createElement('picture');

    if (banner.mobile_image) {
        const source = document.createElement('source');

        source.media = '(max-width: 767px)';
        source.srcset = normalizeImageUrl(banner.mobile_image);

        picture.appendChild(source);
    }

    const image = document.createElement('img');
    image.src = banner.image;
    image.alt = banner.title || 'Her-Ovia Banner';
    image.loading = 'eager';
    image.dataset.fallbackImage = FALLBACK_IMAGE;

    picture.appendChild(image);
    container.replaceChildren(picture);
    hero.style.display = 'block';
  } catch (error) {
    console.error('Category banner error:', error);
    hero.style.display = 'none';
  }
}

function openCategory(id) {
  const category = state.categories.find(item => getId(item) === id);
  if (!category) return;

  const slug = getSlug(category);

  if (slug) {
    window.location.href = `/collection/${encodeURIComponent(slug)}`;
    return;
  }

  window.location.href = `/products?category=${id}`;
}

function openSubcategory(id) {
  const subcategory = state.subcategories.find(item => getId(item) === id);
  if (!subcategory) return;

  const parentSlug = getSlug(subcategory.parentCategory);
  const subSlug = getSlug(subcategory);

  if (parentSlug && subSlug) {
    window.location.href =
      `/collection/${encodeURIComponent(parentSlug)}/${encodeURIComponent(subSlug)}`;
    return;
  }

  window.location.href = `/products?subcategory=${id}`;
}

function openProduct(slug, id) {
  if (slug) {
    window.location.href = `/product/${encodeURIComponent(slug)}`;
  }
}

function getId(item) {
  return Number(
    item?.id ??
    item?._id ??
    item?.category_id ??
    item?.subcategory_id ??
    item?.sub_category_id ??
    0
  );
}

function getName(item) {
  return (
    item?.name ||
    item?.title ||
    item?.category_name ||
    item?.subcategory_name ||
    item?.sub_category_name ||
    'Category'
  );
}

function getSlug(item) {
  return (
    item?.slug ||
    item?.category_slug ||
    item?.subcategory_slug ||
    item?.sub_category_slug ||
    ''
  );
}

function getImage(item) {
  const possibleImages = [
    item?.image_url,
    item?.image,
    item?.image_path,
    item?.thumbnail,
    item?.thumbnail_url,
    item?.banner_image,
    item?.banner_image_url,
    item?.category_image,
    item?.subcategory_image
  ];

  const image = possibleImages.find(
    value => typeof value === 'string' && value.trim()
  );

  if (!image) return FALLBACK_IMAGE;

  if (
    image.startsWith('http://') ||
    image.startsWith('https://') ||
    image.startsWith('data:')
  ) {
    return image;
  }

  const base = S3_BASE_URL.replace(/\/$/, '');
  const path = image.replace(/^\//, '');

  return base ? `${base}/${path}` : `/${path}`;
}

function showSkeletons() {
  const main = document.getElementById('main-category-cards');
  const sub = document.getElementById('featured-subcategories');

  if (main) {
    main.innerHTML = Array.from({ length: 4 }, () => `
      <div class="category-skeleton">
        <div class="category-skeleton-image"></div>
        <div class="category-skeleton-content"></div>
      </div>
    `).join('');
  }

  if (sub) {
    sub.innerHTML = Array.from({ length: 6 }, () => `
      <div class="category-skeleton">
        <div class="category-skeleton-image"></div>
        <div class="category-skeleton-content"></div>
      </div>
    `).join('');
  }
}

function renderEmptyState(id, message) {
  const container = document.getElementById(id);
  if (!container) return;

  container.innerHTML = `
    <div class="category-empty">
      ${escapeHtml(message)}
    </div>
  `;
}

function escapeHtml(value) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}
