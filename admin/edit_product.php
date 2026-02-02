<?php include 'header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<?php
$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $conn->real_escape_string($_POST['description']);
    $ingredients = $conn->real_escape_string($_POST['ingredients']);
    $weight_options = $conn->real_escape_string($_POST['weight_options']);
    
    $sql = "UPDATE products SET name='$name', category_id='$category_id', price='$price', stock='$stock', description='$description', ingredients='$ingredients', weight_options='$weight_options' WHERE id=$id";
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = "../assets/uploads/";
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE products SET name='$name', category_id='$category_id', price='$price', stock='$stock', description='$description', ingredients='$ingredients', weight_options='$weight_options', image='$file_name' WHERE id=$id";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product updated successfully'); window.location.href='products.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
?>

<h2 class="mb-4">Edit Product</h2>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php
                        $cats = $conn->query("SELECT * FROM categories");
                        while($c = $cats->fetch_assoc()):
                        ?>
                        <option value="<?php echo $c['id']; ?>" <?php echo $product['category_id'] == $c['id'] ? 'selected' : ''; ?>><?php echo $c['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Other fields similar to add... -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Weight Options</label>
                    <input type="text" name="weight_options" class="form-control" value="<?php echo htmlspecialchars($product['weight_options']); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" class="form-control" rows="2"><?php echo htmlspecialchars($product['ingredients']); ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Change Image (Leave empty to keep current)</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
