<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $status = $conn->real_escape_string($_POST['status']);
    
    $conn->query("UPDATE orders SET status = '$status' WHERE id = $id");
}

header("Location: orders.php");
exit;
?>
