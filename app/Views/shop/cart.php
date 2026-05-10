<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if (!empty($cart)): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($cart as $productId => $item): ?>
                                    <?php $itemTotal = $item['price'] * $item['quantity']; $subtotal += $itemTotal; ?>
                                    <tr>
                                        <td><?= esc($item['name']) ?></td>
                                        <td>₱<?= number_format($item['price'], 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>₱<?= number_format($itemTotal, 2) ?></td>
                                        <td>
                                            <form action="/shop/remove-from-cart" method="POST" style="display: inline;">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="product_id" value="<?= $productId ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <p>Subtotal: <strong>₱<?= number_format($subtotal, 2) ?></strong></p>
                        <p>Tax (12%): <strong>₱<?= number_format($subtotal * 0.12, 2) ?></strong></p>
                        <p>Shipping: <strong>₱5.00</strong></p>
                        <hr>
                        <h5>Total: <strong>₱<?= number_format($subtotal + ($subtotal * 0.12) + 5, 2) ?></strong></h5>
                        <a href="/shop/checkout" class="btn btn-primary w-100 mt-3">Proceed to Checkout</a>
                        <a href="/shop" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Your cart is empty</p>
            <a href="/shop" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
