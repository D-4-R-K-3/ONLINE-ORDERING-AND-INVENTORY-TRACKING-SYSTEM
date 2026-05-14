<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Low Stock Products</h2>
    </div>

    <!-- Existing low stock products table/list content would go here, displaying $products -->

    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
            <?php for ($i = 1; $i <= $pager->getPageCount(); $i++): ?>
                <a href="<?= $pager->getPageURI($i) ?>" class="btn <?= ($pager->getCurrentPage() == $i) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>