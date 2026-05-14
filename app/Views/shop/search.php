<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="my-4">Search Results for "<?= esc($keyword) ?>"</h2>

    <?php if (empty($products)): ?>
        <p>No products found matching your search criteria.</p>
    <?php else: ?>
        <!-- Existing search results grid/list content would go here, displaying $products -->

        <?php if (isset($pager) && $pager->getPageCount('search_results') > 1): ?>
            <div class="d-flex justify-content-center flex-wrap gap-2 mt-5">
                <?php for ($i = 1; $i <= $pager->getPageCount('search_results'); $i++): ?>
                    <a href="<?= $pager->getPageURI($i, 'search_results') ?>" class="btn <?= ($pager->getCurrentPage('search_results') == $i) ? 'btn-primary' : 'btn-outline-primary' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>