<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4">Update Order Status - <?= esc($order['order_number']) ?></h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/dashboard/order/status/<?= $order['id'] ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="status" class="form-label">Order Status *</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= $order['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Processing" <?= $order['status'] === 'Processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="Shipped" <?= $order['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="Delivered" <?= $order['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status *</label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="Unpaid" <?= $order['payment_status'] === 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                <option value="Paid" <?= $order['payment_status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="Refunded" <?= $order['payment_status'] === 'Refunded' ? 'selected' : '' ?>>Refunded</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"><?= esc($order['notes'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="/dashboard/order/<?= $order['id'] ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
