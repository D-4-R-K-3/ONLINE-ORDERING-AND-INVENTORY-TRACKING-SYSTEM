<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Orders Management</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?= esc($order['order_number']) ?></strong></td>
                                <td><?= esc($order['first_name'] . ' ' . $order['last_name']) ?></td>
                                <td><?= esc($order['email']) ?></td>
                                <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td><span class="badge bg-info"><?= $order['status'] ?></span></td>
                                <td><span class="badge bg-<?= $order['payment_status'] === 'Paid' ? 'success' : 'danger' ?>"><?= $order['payment_status'] ?></span></td>
                                <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                <td>
                                    <a href="/dashboard/order/<?= $order['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                    <a href="/dashboard/order/status/<?= $order['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
            <?php for ($i = 1; $i <= $pager->getPageCount(); $i++): ?>
                <a href="<?= $pager->getPageURI($i) ?>" class="btn <?= ($pager->getCurrentPage() == $i) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
