<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "oneunit_left");
$product_id = $_POST['product_id'];
$user_email = $_SESSION['email'];

// Get user ID from email
$user_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$user_stmt->bind_param("s", $user_email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

// Check if product already in cart
$check_stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$check = $check_stmt->get_result();

if ($check->num_rows > 0) {
    // Update quantity
    $update_stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $update_stmt->bind_param("ii", $user_id, $product_id);
    $update_stmt->execute();
} else {
    // Insert new row
    $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $insert_stmt->bind_param("ii", $user_id, $product_id);
    $insert_stmt->execute();
}

header("Location: cart.php");
?>
