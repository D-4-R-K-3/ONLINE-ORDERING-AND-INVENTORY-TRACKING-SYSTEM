<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <a href="/dashboard/product/add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= esc($product['name']) ?></td>
                                <td><?= esc($product['sku']) ?></td>
                                <td><?= $product['category_id'] ?></td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td><span class="badge bg-<?= $product['status'] === 'Available' ? 'success' : 'danger' ?>"><?= $product['status'] ?></span></td>
                                <td>
                                    <a href="/dashboard/product/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/dashboard/product/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
