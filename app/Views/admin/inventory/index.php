<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inventory</h2>
    </div>

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
                                <td><span class="fw-bold"><?= $item['quantity_available'] ?></span></td>
                                <td><span class="badge bg-<?= $item['quantity_available'] <= $item['reorder_level'] ? 'danger' : 'success' ?>"><?= $item['quantity_available'] <= $item['reorder_level'] ? 'Low Stock' : 'OK' ?></span></td>
                                <td><a href="/dashboard/inventory/update/<?= $item['id'] ?>" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i> Update</a></td>
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