<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .category-shell {
        max-width: 1220px;
        margin: 0 auto;
    }

    .category-product-card {
        height: 100%;
        border-radius: 18px;
        overflow: hidden;
    }

    .category-image-wrap {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.45), rgba(255, 255, 255, 0.12));
        height: 210px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid var(--border);
    }

    html[data-theme="dark"] .category-image-wrap {
        background: linear-gradient(130deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
    }

    .category-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-product-info {
        padding: 0.95rem;
    }

    .category-product-name {
        margin: 0;
        font-size: 1.02rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        min-height: 2.75rem;
    }

    .category-meta {
        color: var(--muted);
        font-size: 0.84rem;
        margin-top: 0.35rem;
        margin-bottom: 0.3rem;
        word-break: break-all;
    }

    .category-price {
        margin: 0.3rem 0 0.85rem;
        font-size: 1.26rem;
        font-weight: 700;
    }
</style>

<div class="container category-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/shop">Shop</a></li>
            <li class="breadcrumb-item active"><?= esc($category['name']) ?></li>
        </ol>
    </nav>

    <h2 class="mb-4"><?= esc($category['name']) ?></h2>
    <?php if ($category['description']): ?>
        <p class="text-muted mb-4"><?= esc($category['description']) ?></p>
    <?php endif; ?>

    <!-- Products -->
    <?php if (!empty($products)): ?>
        <div class="row g-3">
            <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card category-product-card">
                        <div class="category-image-wrap">
                            <?= $product['image'] ? '<img src="/uploads/products/' . esc($product['image']) . '" alt="' . esc($product['name']) . '">' : '<i class="fas fa-image" style="font-size: 40px; color: #999;"></i>' ?>
                        </div>
                        <div class="category-product-info">
                            <h5 class="category-product-name"><?= esc($product['name']) ?></h5>
                            <p class="category-price">₱<?= number_format($product['price'], 2) ?></p>
                            <div class="d-grid gap-2">
                                <a href="/shop/product/<?= $product['id'] ?>" class="btn btn-primary">View</a>
                                <form action="/shop/add-to-cart" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-outline-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No products in this category</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
