<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("sql107.infinityfree.com", "if0_39501475", "2FaKH0u92yc", "if0_39501475_oneunit_left");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION["email"];
$user_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

$stmt = $conn->prepare("
    SELECT p.id, p.name, p.price, p.image, c.quantity
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
    <title>OneUnit Left - Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Roboto Condensed', sans-serif;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .cart-item {
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-5px);
        }

        .cart-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 15px 0;
        }

        .quantity-btn {
            background: #fff;
            color: #000;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #ddd;
            transform: scale(1.05);
        }

        .cart-total {
            background: #111;
            border: 1px solid #333;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: right;
        }

        .total-amount {
            font-size: 1.5em;
            color: #fff;
            font-weight: bold;
        }

        .cart-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .cart-button {
            padding: 12px 30px;
            background: #fff;
            color: #000;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cart-button:hover {
            background: #ddd;
            transform: scale(1.05);
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            margin: 40px auto;
            max-width: 600px;
        }

        .empty-cart p {
            font-size: 1.4em;
            color: #fff;
            margin-bottom: 25px;
        }

        .product-name {
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0;
            color: #fff;
        }

        .price {
            color: #fff;
            font-size: 1.1em;
            margin: 8px 0;
        }

        .subtotal {
            color: #fff;
            font-weight: bold;
            margin-top: 15px;
            font-size: 1.1em;
        }

        h2 {
            text-align: center;
            font-size: 2em;
            margin: 30px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .quantity-display {
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
        }

        nav {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
        }

        footer {
            margin-top: 50px;
            border-top: 1px solid #333;
        }
    </style>
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
        <div class="cart-container">
            <h2>Your Shopping Cart</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="cart-items">
                    <?php
                    $total = 0;
                    while ($row = $result->fetch_assoc()):
                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                    ?>
                        <div class="cart-item">
                            <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                            <div class="product-name"><?= htmlspecialchars($row['name']) ?></div>
                            <div class="price">₱<?= number_format($row['price'], 2) ?></div>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(<?= $row['id'] ?>, 'decrease')">-</button>
                                <span class="quantity-display"><?= $row['quantity'] ?></span>
                                <button class="quantity-btn" onclick="updateQuantity(<?= $row['id'] ?>, 'increase')">+</button>
                            </div>
                            <div class="subtotal">Subtotal: ₱<?= number_format($subtotal, 2) ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="cart-total">
                    <div class="total-amount">Total: ₱<?= number_format($total, 2) ?></div>
                </div>

                <div class="cart-buttons">
                    <a href="store.php" class="cart-button">Continue Shopping</a>
                    <a href="payment.php" class="cart-button">Checkout</a>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <a href="store.php" class="cart-button">Go Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>

    <script>
    function updateQuantity(productId, action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                location.reload();
            }
        };
        xhr.send(`product_id=${productId}&action=${action}`);
    }
    </script>
</body>
</html>
