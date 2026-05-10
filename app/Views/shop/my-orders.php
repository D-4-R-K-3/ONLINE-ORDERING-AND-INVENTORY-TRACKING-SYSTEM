<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">My Orders</h2>

    <?php if (!empty($orders)): ?>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?= esc($order['order_number']) ?></strong></td>
                                <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                <td><?= $order['total_items'] ?></td>
                                <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <?php
                                        $statusClass = [
                                            'Pending' => 'warning',
                                            'Confirmed' => 'info',
                                            'Processing' => 'info',
                                            'Shipped' => 'primary',
                                            'Delivered' => 'success',
                                            'Cancelled' => 'danger'
                                        ];
                                        $class = $statusClass[$order['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $class ?>"><?= $order['status'] ?></span>
                                </td>
                                <td>
                                    <a href="/shop/order/<?= $order['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>No orders yet</p>
            <a href="/shop" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
