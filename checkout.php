<?php 
include 'includes/header.php';
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to checkout'); window.location.href='login.php';</script>";
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "<script>window.location.href='shop.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $payment_method = $_POST['payment_method'];
    
    // Calculate total layout again for security
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $start_price = $conn->query("SELECT price FROM products WHERE id=".$item['id'])->fetch_assoc()['price'];
        $total_amount += $start_price * $item['quantity'];
    }
    
    $sql = "INSERT INTO orders (user_id, name, phone, address, city, pincode, total_amount, payment_method) 
            VALUES ('$user_id', '$name', '$phone', '$address', '$city', '$pincode', '$total_amount', '$payment_method')";
            
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        
        // Initialize WhatsApp Message
        $wa_msg = "*New Order Placed!* \n";
        $wa_msg .= "Order ID: #$order_id \n";
        $wa_msg .= "Name: $name \n";
        $wa_msg .= "Phone: $phone \n";
        $wa_msg .= "Address: $address, $city - $pincode \n\n";
        $wa_msg .= "*Items:* \n";

        // Insert Order Items
        foreach ($_SESSION['cart'] as $item) {
            $p_data = $conn->query("SELECT name, price FROM products WHERE id=".$item['id'])->fetch_assoc();
            $price = $p_data['price'];
            $qty = $item['quantity'];
            $pid = $item['id'];
            $p_name = $p_data['name'];
            
            // Append to WhatsApp Message
            $wa_msg .= "- $p_name (x$qty): ₹" . ($price * $qty) . " \n";

            $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$pid', '$qty', '$price')");
        }
        
        $wa_msg .= "\n*Total Amount: ₹$total_amount* \n";
        $wa_msg .= "Payment Mode: " . strtoupper($payment_method);
        
        // Clear Cart
        unset($_SESSION['cart']);
        
        // URL Encode the message
        $wa_link = "https://wa.me/918590627723?text=" . urlencode($wa_msg);
        
        echo "<script>
            alert('Order placed successfully! Redirecting to WhatsApp to complete your order...');
            window.location.href = '$wa_link';
        </script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="container py-5">
    <h2 class="section-title">Checkout</h2>
    <form method="POST">
        <div class="row g-5">
            <div class="col-md-7">
                <div class="glass-panel p-4">
                    <h4 class="mb-3">Billing Details</h4>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="glass-panel p-4">
                    <h4 class="mb-3">Your Order</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <?php 
                        $total = 0;
                        foreach($_SESSION['cart'] as $item):
                            $p = $conn->query("SELECT name, price FROM products WHERE id=".$item['id'])->fetch_assoc();
                            $sub = $p['price'] * $item['quantity'];
                            $total += $sub;
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm bg-transparent">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($p['name']); ?></h6>
                                <small class="text-muted">Qty: <?php echo $item['quantity']; ?> | <?php echo $item['weight']; ?></small>
                            </div>
                            <span class="text-muted">₹<?php echo number_format($sub, 2); ?></span>
                        </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-transparent fw-bold border-top">
                            <span>Total (INR)</span>
                            <span>₹<?php echo number_format($total, 2); ?></span>
                        </li>
                    </ul>

                    <h4 class="mb-3">Payment Method</h4>
                    <div class="my-3">
                        <div class="form-check">
                            <input id="cod" name="payment_method" type="radio" class="form-check-input" value="cod" checked required>
                            <label class="form-check-label" for="cod">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input id="upi" name="payment_method" type="radio" class="form-check-input" value="upi" required>
                            <label class="form-check-label" for="upi">UPI (GPay/PhonePe)</label>
                        </div>
                        <div class="form-check">
                            <input id="card" name="payment_method" type="radio" class="form-check-input" value="card" required>
                            <label class="form-check-label" for="card">Credit/Debit Card</label>
                        </div>
                    </div>

                    <button class="btn btn-primary-custom w-100 btn-lg" type="submit">Place Order</button>
                    <small class="text-muted mt-2 d-block text-center">By placing an order, you agree to our terms.</small>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
