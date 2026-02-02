<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kismath - Traditional Taste</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Kismath</a>
        
        <!-- Actions (Cart & User) - Visible on Mobile & Desktop -->
        <div class="d-flex align-items-center order-lg-last">
            <a href="cart.php" class="btn btn-outline-custom position-relative me-2 border-0">
                <i class="fas fa-shopping-cart fa-lg"></i>
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                        <?php echo count($_SESSION['cart']); ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="dropdown d-none d-lg-block">
                    <button class="btn btn-primary-custom dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <li><a class="dropdown-item" href="admin/index.php">Admin Panel</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="my_orders.php">My Orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <!-- Mobile User Icon (Simple Link) -->
                <a href="my_orders.php" class="btn btn-outline-custom border-0 d-lg-none me-2">
                     <i class="fas fa-user fa-lg"></i>
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary-custom d-none d-lg-block">Login</a>
                <a href="login.php" class="btn btn-outline-custom border-0 d-lg-none"><i class="fas fa-sign-in-alt fa-lg"></i></a>
            <?php endif; ?>

            <!-- Toggler -->
            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Offcanvas Menu (Links) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Kismath</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home me-2"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php"><i class="fas fa-store me-2"></i> Shop</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span><i class="fas fa-th-large me-2"></i> Categories</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="shop.php?category=Pickles">Pickles</a></li>
                            <li><a class="dropdown-item" href="shop.php?category=Spice Powders">Spice Powders</a></li>
                            <li><a class="dropdown-item" href="shop.php?category=Masalas">Masalas</a></li>
                            <li><a class="dropdown-item" href="shop.php?category=Combos">Combos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php"><i class="fas fa-envelope me-2"></i> Contact</a>
                    </li>
                </ul>
            </div>
            
            <!-- Mobile Menu Footer Fixed Bottom -->
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="offcanvas-footer p-3 border-top d-lg-none header-footer-actions">
                <a class="btn btn-outline-danger w-100 rounded-pill py-2 fw-bold" href="logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
