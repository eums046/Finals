<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "OneUnitLeft_DB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION["email"];

$sql = "SELECT p.name, p.price, p.image, c.quantity
        FROM cart c JOIN products p ON c.product_id = p.id
        WHERE c.user_email = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <style>
        .product-placeholder {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            text-align: center;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h2>Your Cart</h2>
    <?php $total = 0; ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product-placeholder">
            <img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image"><br>
            <strong><?= htmlspecialchars($row['name']) ?></strong><br>
            ₱<?= number_format($row['price'], 2) ?> x <?= (int)$row['quantity'] ?><br>
            <?php $total += $row['price'] * $row['quantity']; ?>
        </div>
    <?php endwhile; ?>

    <h3>Total: ₱<?= number_format($total, 2) ?></h3>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>