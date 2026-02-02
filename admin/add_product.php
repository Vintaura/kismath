<?php include 'header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $conn->real_escape_string($_POST['description']);
    $ingredients = $conn->real_escape_string($_POST['ingredients']);
    $weight_options = $conn->real_escape_string($_POST['weight_options']);
    
    // Image Upload
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = "../assets/uploads/";
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $file_name;
        }
    }

    $sql = "INSERT INTO products (name, category_id, price, stock, description, ingredients, weight_options, image) 
            VALUES ('$name', '$category_id', '$price', '$stock', '$description', '$ingredients', '$weight_options', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product added successfully'); window.location.href='products.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<h2 class="mb-4">Add Product</h2>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php
                        $cats = $conn->query("SELECT * FROM categories");
                        while($c = $cats->fetch_assoc()):
                        ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" class="form-control" value="100" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Weight Options (comma separated, e.g. 250g, 500g)</label>
                    <input type="text" name="weight_options" class="form-control" value="250g, 500g, 1kg">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Product</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
