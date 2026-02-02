<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php
$id = $_GET['id'] ?? 0;
// Prevent SQL Injection
$id = (int)$id;

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "<div class='container py-5 text-center'><h2>Product not found</h2><a href='shop.php' class='btn btn-primary-custom mt-3'>Back to Shop</a></div>";
    include 'includes/footer.php';
    exit;
}

// Parse weights if they exist
$weights = !empty($product['weight_options']) ? explode(',', $product['weight_options']) : ['Standard'];
?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
            <div class="glass-panel p-3">
                <img src="<?php echo get_image_url($product['image']); ?>" class="img-fluid rounded w-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            <h2 class="text-primary mb-4">₹<?php echo number_format($product['price'], 2); ?></h2>
            
            <p class="lead mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <?php if(!empty($product['ingredients'])): ?>
            <div class="mb-4">
                <h5>Ingredients:</h5>
                <p class="text-muted"><?php echo htmlspecialchars($product['ingredients']); ?></p>
            </div>
            <?php endif; ?>

            <form action="cart_actions.php" method="POST">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Weight:</label>
                    <select name="weight" class="form-select w-50" required>
                        <?php foreach($weights as $weight): ?>
                            <option value="<?php echo trim($weight); ?>"><?php echo trim($weight); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Quantity:</label>
                    <div class="input-group w-50">
                        <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('qty').stepDown()">-</button>
                        <input type="number" name="quantity" id="qty" class="form-control text-center" value="1" min="1" max="100">
                        <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('qty').stepUp()">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-lg w-100"><i class="fas fa-shopping-cart me-2"></i> Add to Cart</button>
            </form>
            
            <div class="mt-4">
                <p><i class="fas fa-check-circle text-success me-2"></i>In Stock</p>
                <p><i class="fas fa-truck text-primary me-2"></i>Delivery available all over India</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
