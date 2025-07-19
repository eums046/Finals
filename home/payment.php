<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db_connection.php';

$email = $_SESSION["email"];
$cart = [];
$total = 0;

// Fetch user id from users table
$user_id = null;
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if ($user_id !== null) {
    // Fetch cart items from the database using user_id
    $stmt = $conn->prepare("SELECT p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment | OneUnit Left</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="payment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header-images">
        <img src="images/white-name.png" alt="Store Name" class="name-img">
    </div>
</header>
<nav>
    <div class="nav-left">
        <a href="index.php">HOME</a>
        <a href="store.php">STORE</a>
        <a href="about.php">ABOUT</a>
    </div>
    <div class="nav-right">
        <a href="cart.php">🛒</a>
        <a href="profile.php">👤</a>
    </div>
</nav>
<main>
<div class="center-container">
    <div class="payment-card">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<div class="success-message">
    <span class="checkmark">&#10003;</span>
    Thank you for your payment!<br>Your order has been placed.
    <a href="store.php" class="pay-btn continue-btn">Continue Shopping</a>
</div>';
    } else {
    ?>
        <div class="section-title">Order Summary</div>
        <div class="cart-summary">
            <ul>
            <?php foreach ($cart as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <li>
                    <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                    <span class="item-qty">x<?= $item['quantity'] ?></span>
                    <span class="item-price">₱<?= number_format($subtotal, 2) ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
            <div class="total-row">
                <span>Total</span>
                <span>₱<?= number_format($total, 2) ?></span>
            </div>
        </div>
        <div class="section-title" style="margin-top:32px;">Payment Details</div>
        <form class="payment-form" method="post">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" required>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
            <label for="payment_method">Payment Method</label>
            <select id="payment_method" name="payment_method" required onchange="showPaymentFields()">
                <option value="credit_card">Credit Card</option>
                <option value="gcash">GCash</option>
                <option value="maya">Maya</option>
            </select>
            <div id="credit_card_fields">
                <label for="cc_number">Credit Card Number</label>
                <input type="text" id="cc_number" name="cc_number" maxlength="19" pattern="[0-9 ]+">
                <label for="cc_expiry">Expiry Date</label>
                <input type="text" id="cc_expiry" name="cc_expiry" placeholder="MM/YY">
                <label for="cc_cvc">CVC</label>
                <input type="text" id="cc_cvc" name="cc_cvc" maxlength="4">
            </div>
            <div id="gcash_fields" style="display:none;">
                <label for="gcash_number">GCash Number</label>
                <input type="text" id="gcash_number" name="gcash_number" maxlength="11" pattern="[0-9]+">
            </div>
            <div id="maya_fields" style="display:none;">
                <label for="maya_number">Maya Number</label>
                <input type="text" id="maya_number" name="maya_number" maxlength="11" pattern="[0-9]+">
            </div>
            <button type="submit" class="pay-btn"><span style="font-size:1.2em;vertical-align:middle;"></span> Pay Now</button>
        </form>
        <script>
        function showPaymentFields() {
            var method = document.getElementById('payment_method').value;
            document.getElementById('credit_card_fields').style.display = (method === 'credit_card') ? 'block' : 'none';
            document.getElementById('gcash_fields').style.display = (method === 'gcash') ? 'block' : 'none';
            document.getElementById('maya_fields').style.display = (method === 'maya') ? 'block' : 'none';
        }
        document.getElementById('payment_method').addEventListener('change', showPaymentFields);
        window.onload = showPaymentFields;
        </script>
    <?php } ?>
    </div>
</div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html> 