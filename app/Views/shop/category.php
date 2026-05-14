<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="my-4">Category: <?= esc($category['name']) ?></h2>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="<?= product_image_url($product['image']) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-truncate"><?= esc($product['name']) ?></h5>
                        <p class="card-text text-primary fw-bold">₱<?= number_format($product['price'], 2) ?></p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-grid">
                        <a href="/shop/product/<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($pager) && $pager->getPageCount('category_products') > 1): ?>
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
            <?php for ($i = 1; $i <= $pager->getPageCount('category_products'); $i++): ?>
                <a href="<?= $pager->getPageURI($i, 'category_products') ?>" class="btn <?= ($pager->getCurrentPage('category_products') == $i) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>