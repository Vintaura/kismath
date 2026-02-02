<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'add') {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $weight = $_POST['weight'] ?? 'Standard';
    
    // Check if item already exists in cart with same weight
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id && $item['weight'] == $weight) {
            $_SESSION['cart'][$key]['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'quantity' => $quantity,
            'weight' => $weight
        ];
    }
    
    header('Location: cart.php');
    exit;
}

if ($action == 'remove') {
    $index = $_GET['index'];
    if(isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        // Re-index array
        $_SESSION['cart'] = array_values($_SESSION['cart']); 
    }
    header('Location: cart.php');
    exit;
}

if ($action == 'update') {
    $index = $_POST['index'];
    $quantity = (int)$_POST['quantity'];
    if($quantity > 0 && isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
    header('Location: cart.php');
    exit;
}

header('Location: shop.php');
?>
