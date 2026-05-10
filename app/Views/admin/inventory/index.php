<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Inventory Management</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>On Hand</th>
                            <th>Reserved</th>
                            <th>Available</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventory as $item): ?>
                            <tr>
                                <td><?= esc($item['name']) ?></td>
                                <td><?= esc($item['sku']) ?></td>
                                <td><?= $item['quantity_on_hand'] ?></td>
                                <td><?= $item['quantity_reserved'] ?></td>
                                <td><?= $item['quantity_available'] ?></td>
                                <td><?= $item['reorder_level'] ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $item['alert_status'] === 'Normal' ? 'success' : 
                                        ($item['alert_status'] === 'Low Stock' ? 'warning' : 'danger')
                                    ?>">
                                        <?= $item['alert_status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/dashboard/inventory/update/<?= $item['id'] ?>" class="btn btn-sm btn-primary">Update</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- pagination hidden -->
</div>

<?= $this->endSection() ?>
