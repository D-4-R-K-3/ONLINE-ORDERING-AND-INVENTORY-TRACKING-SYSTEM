<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Inventory Report</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= number_format($stats['total_products'] ?? 0) ?></h3>
                <p>Total Products</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= number_format($stats['total_quantity'] ?? 0) ?></h3>
                <p>Total Units on Hand</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= number_format($stats['available_quantity'] ?? 0) ?></h3>
                <p>Available Units</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= number_format($stats['reserved_quantity'] ?? 0) ?></h3>
                <p>Reserved Units</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Low Stock Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Available</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStock ?? [] as $item): ?>
                                    <tr>
                                        <td><?= esc($item['name']) ?></td>
                                        <td><span class="badge bg-warning"><?= $item['quantity_available'] ?></span></td>
                                        <td><?= $item['reorder_level'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Out of Stock Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($outOfStock)): ?>
                                    <?php foreach ($outOfStock ?? [] as $item): ?>
                                        <tr>
                                            <td><?= esc($item['name']) ?></td>
                                            <td><?= esc($item['sku']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No out of stock products</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
