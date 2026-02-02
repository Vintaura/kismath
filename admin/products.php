<?php include 'header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Products</h2>
    <a href="add_product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td>
                        <?php 
                        $imgSrc = get_image_url($row['image']); 
                        if(strpos($imgSrc, 'http') !== 0) $imgSrc = '../' . $imgSrc;
                        ?>
                        <img src="<?php echo $imgSrc; ?>" width="50" height="50" class="rounded object-fit-cover">
                    </td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
