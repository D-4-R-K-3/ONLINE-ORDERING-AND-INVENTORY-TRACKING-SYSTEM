<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/shop">Shop</a></li>
            <li class="breadcrumb-item active">Search Results</li>
        </ol>
    </nav>

    <h2 class="mb-4">Search Results <?php if ($keyword): ?> for "<?= esc($keyword) ?>"<?php endif; ?></h2>

    <?php if (!empty($products)): ?>
        <p class="text-muted mb-4">Found <?= count($products) ?> product(s)</p>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <div style="background-color: #f0f0f0; height: 200px; display: flex; align-items: center; justify-content: center;">
                            <?= $product['image'] ? '<img src="/uploads/products/' . esc($product['image']) . '" alt="' . esc($product['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">' : '<i class="fas fa-image" style="font-size: 40px; color: #999;"></i>' ?>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name"><?= esc($product['name']) ?></h5>
                            <p class="product-price">₱<?= number_format($product['price'], 2) ?></p>
                            <div class="d-grid gap-2">
                                <a href="/shop/product/<?= $product['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                <form action="/shop/add-to-cart" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-success w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <p>No products found<?php if ($keyword): ?> for "<?= esc($keyword) ?>"<?php endif; ?></p>
            <a href="/shop" class="btn btn-primary btn-sm mt-2">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
