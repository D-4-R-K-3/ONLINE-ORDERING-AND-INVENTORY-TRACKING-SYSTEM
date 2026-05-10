<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Edit Product</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/dashboard/product/edit/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                        <?= esc($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= esc($product['name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control" id="sku" name="sku" required value="<?= esc($product['sku']) ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required value="<?= $product['price'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cost" class="form-label">Cost</label>
                                <input type="number" class="form-control" id="cost" name="cost" step="0.01" value="<?= $product['cost'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= esc($product['description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <?php if ($product['image']): ?>
                                <div class="mb-2">
                                    <img src="<?= esc(product_image_url($product['image'])) ?>" style="max-height: 150px; max-width: 150px;">
                                    <p class="text-muted small">Current image</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Available" <?= $product['status'] === 'Available' ? 'selected' : '' ?>>Available</option>
                                <option value="Discontinued" <?= $product['status'] === 'Discontinued' ? 'selected' : '' ?>>Discontinued</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="/dashboard/products" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
