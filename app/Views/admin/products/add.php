<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Add New Product</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/dashboard/product/add" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= old('name') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control" id="sku" name="sku" required value="<?= old('sku') ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required value="<?= old('price') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cost" class="form-label">Cost</label>
                                <input type="number" class="form-control" id="cost" name="cost" step="0.01" value="<?= old('cost') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Available">Available</option>
                                <option value="Discontinued">Discontinued</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <a href="/dashboard/products" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
