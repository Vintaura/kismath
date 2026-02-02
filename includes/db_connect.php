<?php
// Check for environment variables (Cloud/Vercel) or use default (Local/XAMPP)
$host = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: ''; 
$database = getenv('DB_NAME') ?: 'kismath_db';
$port = getenv('DB_PORT') ?: 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    // Show a user-friendly error on production, detailed on local
    if (getenv('DB_HOST')) {
        die("Database Connection Error. Please check configuration.");
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
}

// Helper function to handle image URLs (local uploads vs external placeholders)
function get_image_url($img) {
    if (empty($img)) return 'https://placehold.co/300x300'; // Default fallback
    if (strpos($img, 'http') === 0) return $img; // External URL
    return 'assets/uploads/' . $img; // Local upload
}
?>
