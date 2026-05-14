<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="my-4">My Orders</h2>

    <!-- Existing customer orders table/list content would go here, displaying $orders -->

    <?php if (isset($pager) && $pager->getPageCount('my_orders') > 1): ?>
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
            <?php for ($i = 1; $i <= $pager->getPageCount('my_orders'); $i++): ?>
                <a href="<?= $pager->getPageURI($i, 'my_orders') ?>" class="btn <?= ($pager->getCurrentPage('my_orders') == $i) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>