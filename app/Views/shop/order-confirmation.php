<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="text-center mb-4">
        <i class="fas fa-check-circle" style="font-size: 60px; color: #51cf66;"></i>
        <h2 class="mt-3">Order Confirmed!</h2>
        <p class="text-muted">Thank you for your purchase</p>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Order Number:</strong><br><?= esc($order['order_number']) ?></p>
                            <p><strong>Order Date:</strong><br><?= date('F d, Y', strtotime($order['order_date'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong><br><span class="badge bg-warning">Pending</span></p>
                            <p><strong>Payment Status:</strong><br><span class="badge bg-danger">Unpaid</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Delivery Address</h5>
                </div>
                <div class="card-body">
                    <p><?= esc($order['delivery_address']) ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= esc($item['name']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>₱<?= number_format($item['unit_price'], 2) ?></td>
                                    <td>₱<?= number_format($item['total_price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Subtotal: ₱<?= number_format($order['subtotal'], 2) ?></p>
                            <p>Tax: ₱<?= number_format($order['tax_amount'], 2) ?></p>
                            <p>Shipping: ₱<?= number_format($order['shipping_fee'], 2) ?></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5>Total: ₱<?= number_format($order['total_amount'], 2) ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="/shop/my-orders" class="btn btn-primary">View Order History</a>
                <a href="/shop" class="btn btn-outline-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
