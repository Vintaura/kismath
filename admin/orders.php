<?php include 'header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<h2 class="mb-4">Orders</h2>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
                while($row = $res->fetch_assoc()):
                ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td>
                        <?php echo htmlspecialchars($row['name']); ?><br>
                        <small class="text-muted"><?php echo htmlspecialchars($row['phone']); ?></small>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                    <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><?php echo strtoupper($row['payment_method']); ?></td>
                    <td>
                        <form action="update_order.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $row['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="shipped" <?php echo $row['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="delivered" <?php echo $row['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#order<?php echo $row['id']; ?>">
                            Details
                        </button>
                    </td>
                </tr>
                <tr class="collapse" id="order<?php echo $row['id']; ?>">
                    <td colspan="7" class="bg-light">
                        <div class="p-3">
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address'] . ', ' . $row['city'] . ' - ' . $row['pincode']); ?></p>
                            <h6>Items:</h6>
                            <ul>
                                <?php
                                $oid = $row['id'];
                                $items = $conn->query("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $oid");
                                while($item = $items->fetch_assoc()):
                                ?>
                                <li><?php echo htmlspecialchars($item['name']); ?> (Qty: <?php echo $item['quantity']; ?>) - ₹<?php echo number_format($item['price'], 2); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
