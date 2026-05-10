<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-shell {
        max-width: 1240px;
        margin: 0 auto;
    }

    .dashboard-title {
        margin-bottom: 1.1rem;
    }

    .metric-card {
        height: 100%;
        padding: 1.05rem 1.05rem 1rem;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .metric-icon {
        font-size: 1.7rem;
        opacity: 0.92;
        line-height: 1;
    }

    .metric-value {
        margin: 0;
        font-size: clamp(1.6rem, 2.6vw, 2rem);
        line-height: 1.15;
        word-break: break-word;
    }

    .metric-label {
        margin: 0;
        color: var(--muted);
        font-size: 1rem;
    }

    .dashboard-card-title {
        margin: 0;
        font-size: 1.45rem;
    }

    .dashboard-table {
        margin-bottom: 0.2rem;
    }

    .dashboard-table td,
    .dashboard-table th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .stock-item-title {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.25;
        word-break: break-word;
    }

    .recent-activity-section {
        margin-top: 1.25rem;
    }

    @media (max-width: 767.98px) {
        .dashboard-title {
            margin-bottom: 0.8rem;
        }

        .metric-card {
            padding: 0.95rem;
        }
    }
</style>

<div class="container-fluid dashboard-shell">
    <h2 class="dashboard-title">Admin Dashboard</h2>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card metric-card">
                <i class="fas fa-shopping-cart metric-icon"></i>
                <h3 class="metric-value"><?= number_format($orderStats['total_orders'] ?? 0) ?></h3>
                <p class="metric-label">Total Orders</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card metric-card">
                <i class="fas fa-dollar-sign metric-icon"></i>
                <h3 class="metric-value">₱<?= number_format($orderStats['total_revenue'] ?? 0, 2) ?></h3>
                <p class="metric-label">Total Revenue</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card metric-card">
                <i class="fas fa-boxes metric-icon"></i>
                <h3 class="metric-value"><?= number_format($totalProducts ?? 0) ?></h3>
                <p class="metric-label">Products</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card metric-card">
                <i class="fas fa-triangle-exclamation metric-icon"></i>
                <h3 class="metric-value"><?= count($lowStockProducts ?? []) ?></h3>
                <p class="metric-label">Low Stock Items</p>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="dashboard-card-title">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover dashboard-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders ?? [] as $order): ?>
                                    <tr>
                                        <td><?= esc($order['order_number']) ?></td>
                                        <td><?= esc($order['email'] ?? 'N/A') ?></td>
                                        <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                        <td><span class="badge bg-info"><?= $order['status'] ?></span></td>
                                        <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="/dashboard/orders" class="btn btn-sm btn-primary">View All Orders</a>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="dashboard-card-title">Low Stock Alert</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <?php if (!empty($lowStockProducts)): ?>
                        <div class="list-group">
                            <?php foreach ($lowStockProducts as $product): ?>
                                <a href="/dashboard/inventory/update/<?= $product['id'] ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="stock-item-title"><?= esc($product['name']) ?></h6>
                                        <span class="badge bg-warning"><?= $product['quantity_available'] ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">All products have sufficient stock</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card recent-activity-section">
        <div class="card-header">
            <h5 class="dashboard-card-title">Recent Inventory Activity</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Action</th>
                            <th>Change</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>User</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentActivity ?? [] as $activity): ?>
                            <tr>
                                <td><?= esc($activity['name']) ?></td>
                                <td><?= esc($activity['transaction_type']) ?></td>
                                <td><?= $activity['quantity_change'] ?></td>
                                <td><?= $activity['quantity_before'] ?></td>
                                <td><?= $activity['quantity_after'] ?></td>
                                <td><?= esc($activity['first_name'] . ' ' . $activity['last_name']) ?></td>
                                <td><?= date('M d, Y H:i', strtotime($activity['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
