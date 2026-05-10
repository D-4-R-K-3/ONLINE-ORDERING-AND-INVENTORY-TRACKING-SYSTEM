<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/shop">Shop</a></li>
            <li class="breadcrumb-item"><a href="/shop/category/<?= $product['category_id'] ?>"><?= esc($product['category_name']) ?></a></li>
            <li class="breadcrumb-item active"><?= esc($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div style="background-color: #f0f0f0; height: 400px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                <?= $product['image'] ? '<img src="/uploads/products/' . esc($product['image']) . '" alt="' . esc($product['name']) . '" style="width: 100%; height: 100%; object-fit: contain;">' : '<i class="fas fa-image" style="font-size: 80px; color: #999;"></i>' ?>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2><?= esc($product['name']) ?></h2>
            <p class="text-muted">Category: <?= esc($product['category_name']) ?></p>

            <div class="my-4">
                <p class="lead">
                    <strong>Price:</strong> <span class="text-success" style="font-size: 28px;">₱<?= number_format($product['price'], 2) ?></span>
                </p>
            </div>

            <!-- Description -->
            <?php if ($product['description']): ?>
                <div class="mb-4">
                    <h5>Description</h5>
                    <p><?= esc($product['description']) ?></p>
                </div>
            <?php endif; ?>

            <!-- Availability -->
            <div class="mb-4">
                <h5>Availability</h5>
                <?php if ($inventory && $inventory['quantity_available'] > 0): ?>
                    <span class="badge bg-success">In Stock (<?= $inventory['quantity_available'] ?> available)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Out of Stock</span>
                <?php endif; ?>
            </div>

            <!-- Add to Cart Form -->
            <?php if ($product['status'] === 'Available' && $inventory && $inventory['quantity_available'] > 0): ?>
                <form action="/shop/add-to-cart" method="POST" class="mb-4">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= $inventory['quantity_available'] ?>" required>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="btn btn-lg btn-success w-100">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
            <?php endif; ?>

            <a href="/shop" class="btn btn-outline-secondary">Continue Shopping</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
