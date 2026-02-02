<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container py-5">
    <h2 class="section-title">Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="text-center py-5 glass-panel">
            <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added any authentic delights yet.</p>
            <a href="shop.php" class="btn btn-primary-custom mt-3">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-panel p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Weight</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($_SESSION['cart'] as $index => $item):
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                                    $stmt->bind_param("i", $item['id']);
                                    $stmt->execute();
                                    $product = $stmt->get_result()->fetch_assoc();
                                    
                                    if(!$product) continue;
                                    
                                    $subtotal = $product['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo get_image_url($product['image']); ?>" class="img-fluid rounded me-3" style="width: 60px;">
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($product['name']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['weight']); ?></td>
                                    <td>₹<?php echo number_format($product['price'], 2); ?></td>
                                    <td>
                                        <form action="cart_actions.php" method="POST" class="d-flex" style="width: 100px;">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" class="form-control form-control-sm text-center" min="1" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold">₹<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <a href="cart_actions.php?action=remove&index=<?php echo $index; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="glass-panel p-4">
                    <h4 class="mb-3">Cart Summary</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>₹<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-primary">₹<?php echo number_format($total, 2); ?></span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary-custom w-100 py-2">Proceed to Checkout</a>
                    <a href="shop.php" class="btn btn-outline-custom w-100 py-2 mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
