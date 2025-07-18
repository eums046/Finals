<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "oneunit_left");

// Check for DB connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION["email"];

// Get user ID from email
$user_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

// Use prepared statement for safety
$stmt = $conn->prepare("
    SELECT p.name, p.price, p.image, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        .product-placeholder {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 200px;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
        }
        .button:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>

<h2>Your Cart</h2>

<?php
$total = 0;
while ($row = $result->fetch_assoc()):
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
?>
    <div class="product-placeholder">
        <img src="<?= $row['image'] ?>" alt="Product" style="width:100px;"><br>
        <strong><?= htmlspecialchars($row['name']) ?></strong><br>
        ₱<?= number_format($row['price'], 2) ?> x <?= $row['quantity'] ?><br>
        <em>Subtotal: ₱<?= number_format($subtotal, 2) ?></em>
    </div>
<?php endwhile; ?>

<h3>Total: ₱<?= number_format($total, 2) ?></h3>

<a href="store.php" class="button">← Back to Store</a>
<a href="payment.php" class="button">🧾 Proceed to Checkout</a>

</body>
</html>
