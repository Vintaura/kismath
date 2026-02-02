<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kismath Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: white; box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .nav-link { color: #333; padding: 15px 20px; }
        .nav-link:hover, .nav-link.active { background: var(--primary-color); color: white !important; }
        .nav-link i { width: 25px; }
    </style>
</head>
<body>

<!-- Mobile Header for Admin -->
<div class="admin-mobile-header bg-white p-3 shadow-sm align-items-center justify-content-between mb-4 d-md-none">
    <span class="fs-4 fw-bold text-primary">Kismath Admin</span>
    <button class="btn btn-outline-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3" id="adminSidebar" style="width: 250px;">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none d-none d-md-flex">
            <span class="fs-4 fw-bold text-primary">Kismath Admin</span>
        </a>
        <div class="d-md-none d-flex justify-content-end mb-3">
             <button class="btn btn-sm btn-light" id="sidebarClose"><i class="fas fa-times"></i></button>
        </div>
        <hr class="d-none d-md-block">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="products.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li>
                <a href="orders.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li>
                <a href="../index.php" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Visit Site
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?php echo $_SESSION['user_name']; ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
    
    <div class="flex-grow-1 p-4">
