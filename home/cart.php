<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "OneUnitLeft_DB");
$email = $_SESSION["email"];

$sql = "SELECT p.name, p.price, p.image, c.quantity
        FROM cart c JOIN products p ON c.product_id = p.id
        WHERE c.user_email = '$email'";

$result = $conn->query($sql);
?>

<h2>Your Cart</h2>
<?php $total = 0; ?>
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-placeholder">
        <img src="<?= $row['image'] ?>" style="width:100px;"><br>
        <strong><?= $row['name'] ?></strong><br>
        ₱<?= $row['price'] ?> x <?= $row['quantity'] ?><br>
        <?php $total += $row['price'] * $row['quantity']; ?>
    </div>
<?php endwhile; ?>

<h3>Total: ₱<?= number_format($total, 2) ?></h3>
