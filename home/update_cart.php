<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["email"])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "oneunit_left");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$email = $_SESSION["email"];
$user_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

$product_id = $_POST['product_id'];
$action = $_POST['action'];

// Get current quantity
$stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();
$current_quantity = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_quantity = $row['quantity'];
}

$new_quantity = $current_quantity;

switch ($action) {
    case 'increase':
        $new_quantity = $current_quantity + 1;
        break;
    case 'decrease':
        $new_quantity = max(0, $current_quantity - 1);
        break;
    case 'remove':
        $new_quantity = 0;
        break;
}

if ($new_quantity == 0) {
    // Remove item from cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    
    echo json_encode(['success' => true, 'quantity' => 0, 'message' => 'Item removed from cart']);
} else {
    // Update quantity
    if ($current_quantity == 0) {
        // Insert new item
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $new_quantity);
    } else {
        // Update existing item
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'quantity' => $new_quantity, 'message' => 'Cart updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
    }
}

$conn->close();
?>
