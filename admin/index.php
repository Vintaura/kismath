<?php include 'header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<h2 class="mb-4">Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Orders</h6>
                    <h3>
                        <?php echo $conn->query("SELECT count(*) as c FROM orders")->fetch_assoc()['c']; ?>
                    </h3>
                </div>
                <i class="fas fa-shopping-bag fa-2x text-primary p-3 bg-light rounded-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Products</h6>
                    <h3>
                        <?php echo $conn->query("SELECT count(*) as c FROM products")->fetch_assoc()['c']; ?>
                    </h3>
                </div>
                <i class="fas fa-box fa-2x text-warning p-3 bg-light rounded-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Users</h6>
                    <h3>
                        <?php echo $conn->query("SELECT count(*) as c FROM users WHERE role='user'")->fetch_assoc()['c']; ?>
                    </h3>
                </div>
                <i class="fas fa-users fa-2x text-success p-3 bg-light rounded-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
                while($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><span class="badge bg-secondary"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
