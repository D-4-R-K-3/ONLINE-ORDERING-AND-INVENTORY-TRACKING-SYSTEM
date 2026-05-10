<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Low Stock Products</h2>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> These products have stock levels at or below their reorder level
    </div>

    <?php if (!empty($products)): ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Reorder Level</th>
                                <th>Reorder Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= esc($product['name']) ?></td>
                                    <td><?= esc($product['sku']) ?></td>
                                    <td><span class="badge bg-danger"><?= $product['quantity_available'] ?></span></td>
                                    <td><?= $product['reorder_level'] ?></td>
                                    <td><?= $product['reorder_quantity'] ?></td>
                                    <td>
                                        <a href="/dashboard/inventory/update/<?= $product['id'] ?>" class="btn btn-sm btn-primary">Update Stock</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> All products have sufficient stock!
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
