<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Update Inventory - <?= esc($product['name']) ?></h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/dashboard/inventory/update/<?= $inventory['id'] ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label"><strong>Product:</strong> <?= esc($product['name']) ?></label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>SKU:</strong> <?= esc($product['sku']) ?></label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Current Stock:</strong></label>
                                <p><?= $inventory['quantity_on_hand'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Available:</strong></label>
                                <p><?= $inventory['quantity_available'] ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="quantity_on_hand" class="form-label">New Quantity On Hand *</label>
                            <input type="number" class="form-control" id="quantity_on_hand" name="quantity_on_hand" required value="<?= $inventory['quantity_on_hand'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="reorder_level" class="form-label">Reorder Level *</label>
                            <input type="number" class="form-control" id="reorder_level" name="reorder_level" required value="<?= $inventory['reorder_level'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="reorder_quantity" class="form-label">Reorder Quantity *</label>
                            <input type="number" class="form-control" id="reorder_quantity" name="reorder_quantity" required value="<?= $inventory['reorder_quantity'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="e.g., Restocking reason"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="/dashboard/inventory" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
