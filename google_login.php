<?php
session_start();
include 'includes/db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['credential'])) {
    echo json_encode(['success' => false, 'message' => 'No credential provided']);
    exit;
}

$id_token = $data['credential'];

// Verify the token using Google's API integration (Lite version without composer)
$url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
$response = file_get_contents($url);

if ($response === FALSE) {
    echo json_encode(['success' => false, 'message' => 'Invalid token']);
    exit;
}

$payload = json_decode($response, true);

if (isset($payload['email'])) {
    $email = $conn->real_escape_string($payload['email']);
    $name = $conn->real_escape_string($payload['name']);
    $google_id = $conn->real_escape_string($payload['sub']);
    $picture = $conn->real_escape_string($payload['picture']);

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, log them in
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
        echo json_encode(['success' => true, 'redirect' => 'index.php']);
    } else {
        // Auto-register
        // Generate a random password since they logged in via Google
        $random_pass = bin2hex(random_bytes(8));
        $hashed_pass = password_hash($random_pass, PASSWORD_DEFAULT);
        
        $insert = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_pass', 'user')";
        
        if ($conn->query($insert) === TRUE) {
            $new_user_id = $conn->insert_id;
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = 'user';
            
            echo json_encode(['success' => true, 'redirect' => 'index.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Could not verify identity']);
}
?>
