<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "OneUnitLeft_DB");
$product_id = $_POST['product_id'];
$user_email = $_SESSION['email'];

// Check if product already in cart
$check = $conn->query("SELECT * FROM cart WHERE user_email='$user_email' AND product_id=$product_id");
if ($check->num_rows > 0) {
    // Update quantity
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_email='$user_email' AND product_id=$product_id");
} else {
    // Insert new row
    $conn->query("INSERT INTO cart (user_email, product_id, quantity) VALUES ('$user_email', $product_id, 1)");
}

header("Location: cart.php");
?>
