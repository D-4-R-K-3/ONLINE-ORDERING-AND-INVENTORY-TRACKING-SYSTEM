<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h2 class="mb-4">Sales Report</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= number_format($stats['total_orders'] ?? 0) ?></h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3>₱<?= number_format($stats['total_revenue'] ?? 0, 0) ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3>₱<?= number_format($stats['average_order_value'] ?? 0, 2) ?></h3>
                <p>Average Order Value</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topProducts ?? [] as $product): ?>
                                    <tr>
                                        <td><?= esc($product['name']) ?></td>
                                        <td><?= $product['total_sold'] ?></td>
                                        <td>₱<?= number_format($product['revenue'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders ?? [] as $order): ?>
                                    <tr>
                                        <td><?= esc($order['order_number']) ?></td>
                                        <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                        <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                        <td><span class="badge bg-info"><?= $order['status'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
