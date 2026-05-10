<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Order Details - <?= esc($order['order_number']) ?></h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order #:</strong> <?= esc($order['order_number']) ?></p>
                            <p><strong>Date:</strong> <?= date('F d, Y H:i', strtotime($order['order_date'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span class="badge bg-info"><?= $order['status'] ?></span></p>
                            <p><strong>Payment:</strong> <span class="badge bg-<?= $order['payment_status'] === 'Paid' ? 'success' : 'danger' ?>"><?= $order['payment_status'] ?></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?= esc($order['first_name'] . ' ' . $order['last_name']) ?></p>
                    <p><strong>Email:</strong> <?= esc($order['email']) ?></p>
                    <p><strong>Delivery Address:</strong> <?= esc($order['delivery_address']) ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
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
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Total</h5>
                </div>
                <div class="card-body">
                    <p>Subtotal: <strong>₱<?= number_format($order['subtotal'], 2) ?></strong></p>
                    <p>Tax: <strong>₱<?= number_format($order['tax_amount'], 2) ?></strong></p>
                    <p>Shipping: <strong>₱<?= number_format($order['shipping_fee'], 2) ?></strong></p>
                    <hr>
                    <h5>Total: <strong class="text-success">₱<?= number_format($order['total_amount'], 2) ?></strong></h5>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    <a href="/dashboard/order/status/<?= $order['id'] ?>" class="btn btn-primary w-100 mb-2">Update Status</a>
                    <a href="/dashboard/orders" class="btn btn-secondary w-100">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
