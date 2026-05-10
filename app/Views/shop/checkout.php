<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Checkout</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Delivery Address</h5>
                </div>
                <div class="card-body">
                    <form action="/shop/process-order" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">Complete Address *</label>
                            <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required><?= old('delivery_address') ?></textarea>
                            <?php if (session('errors') && isset(session('errors')['delivery_address'])): ?>
                                <small class="text-danger"><?= session('errors')['delivery_address'] ?></small>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-lg btn-success w-100">
                            <i class="fas fa-credit-card"></i> Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm">
                            <tbody>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($cart as $item): ?>
                                    <?php $itemTotal = $item['price'] * $item['quantity']; $subtotal += $itemTotal; ?>
                                    <tr>
                                        <td><?= esc($item['name']) ?></td>
                                        <td class="text-right">₱<?= number_format($itemTotal, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <p class="mb-2">Subtotal: ₱<?= number_format($subtotal, 2) ?></p>
                    <p class="mb-2">Tax (12%): ₱<?= number_format($subtotal * 0.12, 2) ?></p>
                    <p class="mb-3">Shipping: ₱5.00</p>
                    <h5 class="text-success">Total: ₱<?= number_format($subtotal + ($subtotal * 0.12) + 5, 2) ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
