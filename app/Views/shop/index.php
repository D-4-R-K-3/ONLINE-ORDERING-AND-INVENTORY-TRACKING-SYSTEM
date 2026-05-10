<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .shop-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: clamp(1.4rem, 3.5vw, 2.5rem);
        margin-bottom: 1.5rem;
        background: linear-gradient(130deg, rgba(255, 255, 255, 0.42), rgba(255, 255, 255, 0.2));
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.14);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    html[data-theme="dark"] .shop-hero {
        background: linear-gradient(135deg, rgba(18, 25, 34, 0.72), rgba(18, 25, 34, 0.45));
        border-color: rgba(205, 223, 255, 0.2);
    }

    .shop-hero::before,
    .shop-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(2px);
        pointer-events: none;
    }

    .shop-hero::before {
        width: 180px;
        height: 180px;
        background: rgba(106, 159, 143, 0.26);
        top: -65px;
        right: -40px;
    }

    .shop-hero::after {
        width: 130px;
        height: 130px;
        background: rgba(173, 109, 61, 0.24);
        bottom: -42px;
        left: -28px;
    }

    .shop-eyebrow {
        display: inline-block;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.56);
        color: #1f1f20;
    }

    html[data-theme="dark"] .shop-eyebrow {
        background: rgba(255, 255, 255, 0.1);
        color: #f5f8ff;
    }

    .shop-title {
        margin-top: 0.75rem;
        font-size: clamp(1.8rem, 4vw, 2.7rem);
        line-height: 1.16;
    }

    .shop-subtitle {
        max-width: 620px;
        margin-bottom: 1.1rem;
        color: var(--muted);
    }

    .search-glass {
        padding: 0.3rem;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    html[data-theme="dark"] .search-glass {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(205, 223, 255, 0.16);
    }

    .search-glass .form-control {
        border: none;
        box-shadow: none;
        background: transparent;
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 0 0.9rem;
    }

    .section-title h3 {
        margin: 0;
    }

    .category-chip {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        border-radius: 999px;
        padding: 0.6rem 0.85rem;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.45);
        color: var(--text);
        font-weight: 600;
        transition: transform 0.2s ease, background 0.2s ease;
    }

    html[data-theme="dark"] .category-chip {
        background: rgba(255, 255, 255, 0.06);
    }

    .category-chip:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.7);
        color: var(--text);
    }

    html[data-theme="dark"] .category-chip:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .product-card {
        height: 100%;
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.12);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    html[data-theme="dark"] .product-card {
        background: rgba(20, 26, 36, 0.55);
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 40px rgba(0, 0, 0, 0.18);
    }

    .product-image-wrap {
        height: 205px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.42), rgba(255, 255, 255, 0.12));
        border-bottom: 1px solid var(--border);
    }

    html[data-theme="dark"] .product-image-wrap {
        background: linear-gradient(130deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
    }

    .product-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 1rem;
    }

    .product-name {
        margin: 0;
        font-size: 1.05rem;
        line-height: 1.35;
    }

    .product-sku {
        color: var(--muted);
        font-size: 0.86rem;
        margin-bottom: 0.55rem;
    }

    .product-price {
        margin: 0.2rem 0 0.8rem;
        font-size: 1.3rem;
        font-weight: 700;
    }
</style>

<div class="shop-hero">
    <span class="shop-eyebrow">Minimal shopping experience</span>
    <h1 class="shop-title">Shop smarter with a clean and modern catalog</h1>
    <p class="shop-subtitle">Explore featured products, filter by category, and place orders in a polished interface designed for speed and clarity.</p>

    <form action="/shop/search" method="GET" style="max-width: 560px;">
        <div class="input-group search-glass">
            <input type="text" name="q" class="form-control" placeholder="Search products, SKU, or category..." required>
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
</div>

<div class="section-title">
    <h3>Shop by Category</h3>
</div>
<div class="row mb-4 g-2">
    <?php foreach ($categories as $category): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="/shop/category/<?= $category['id'] ?>" class="category-chip">
                <?= esc($category['name']) ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="section-title">
    <h3>Featured Products</h3>
</div>
<div class="row g-3">
    <?php if (!empty($featuredProducts)): ?>
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="product-image-wrap">
                        <?= $product['image']
                            ? '<img src="/uploads/products/' . esc($product['image']) . '" alt="' . esc($product['name']) . '">'
                            : '<i class="fas fa-box-open" style="font-size: 2.1rem; opacity: 0.5;"></i>' ?>
                    </div>
                    <div class="product-info">
                        <h5 class="product-name"><?= esc($product['name']) ?></h5>
                        <p class="product-price">P<?= number_format($product['price'], 2) ?></p>
                        <div class="d-grid gap-2">
                            <a href="/shop/product/<?= $product['id'] ?>" class="btn btn-outline-primary">View Details</a>
                            <form action="/shop/add-to-cart" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card p-4 text-center">
                <p class="mb-0 text-muted">No products available yet.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
