<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/shop/my-orders">My Orders</a></li>
            <li class="breadcrumb-item active"><?= esc($order['order_number']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
                            <p><strong>Order Date:</strong> <?= date('F d, Y H:i', strtotime($order['order_date'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Customer:</strong> <?= esc($order['first_name'] . ' ' . $order['last_name']) ?></p>
                            <p><strong>Email:</strong> <?= esc($order['email']) ?></p>
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
                    <h5>Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Status:</strong><br>
                                <span class="badge bg-<?= ['Pending' => 'warning', 'Confirmed' => 'info', 'Processing' => 'info', 'Shipped' => 'primary', 'Delivered' => 'success', 'Cancelled' => 'danger'][$order['status']] ?? 'secondary' ?>">
                                    <?= $order['status'] ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Status:</strong><br>
                                <span class="badge bg-<?= $order['payment_status'] === 'Paid' ? 'success' : ($order['payment_status'] === 'Unpaid' ? 'danger' : 'warning') ?>">
                                    <?= $order['payment_status'] ?>
                                </span>
                            </p>
                        </div>
                    </div>
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

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">Subtotal: <br><strong>₱<?= number_format($order['subtotal'], 2) ?></strong></p>
                    <p class="mb-2">Tax (12%): <br><strong>₱<?= number_format($order['tax_amount'], 2) ?></strong></p>
                    <p class="mb-3">Shipping: <br><strong>₱<?= number_format($order['shipping_fee'], 2) ?></strong></p>
                    <hr>
                    <h5>Total Amount: <br><strong class="text-success">₱<?= number_format($order['total_amount'], 2) ?></strong></h5>
                </div>
            </div>
        </div>
    </div>

    <a href="/shop/my-orders" class="btn btn-secondary mt-3">Back to Orders</a>
</div>

<?= $this->endSection() ?>
