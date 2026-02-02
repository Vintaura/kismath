<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php
$category_filter = $_GET['category'] ?? '';
$sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id";

if (!empty($category_filter)) {
    $safe_cat = $conn->real_escape_string($category_filter);
    // Find category ID first or join. Since I stored category names in links, let's join.
    // Wait, the link sends 'Pickles', so I can filter by category name from the join.
    $sql .= " WHERE c.name = '$safe_cat'";
}

$sql .= " ORDER BY p.id DESC";

$result = $conn->query($sql);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><?php echo $category_filter ? htmlspecialchars($category_filter) : 'All Products'; ?></h2>
        
        <div class="dropdown">
            <button class="btn btn-outline-custom dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Filter by Category
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="shop.php">All</a></li>
                <?php
                $cat_sql = "SELECT * FROM categories";
                $cat_res = $conn->query($cat_sql);
                while($c = $cat_res->fetch_assoc()) {
                    echo '<li><a class="dropdown-item" href="shop.php?category='.urlencode($c['name']).'">'.$c['name'].'</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="row g-4">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 product-card">
                        <div class="product-img-wrapper">
                             <img src="<?php echo get_image_url($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <div class="card-body text-center">
                            <span class="badge bg-secondary mb-2"><?php echo htmlspecialchars($row['category_name'] ?? 'General'); ?></span>
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="text-muted small"><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></p>
                            <div class="price-tag mb-3">₹<?php echo number_format($row['price'], 2); ?></div>
                            <div class="d-grid gap-2">
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-custom">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h3>No products found in this category.</h3><a href="shop.php" class="btn btn-primary-custom mt-3">View All Products</a></div>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
