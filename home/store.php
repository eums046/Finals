<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OneUnit Left - Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">   
    <style>
        html {
            scroll-behavior: smooth;
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
            <a href="home.php">HOME</a>
            <a href="store.php">STORE</a>
            <a href="about.php">ABOUT</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION["email"])): ?>
                <a href="cart.php">🛒</a>
            <?php else: ?>
                <a href="profile.php" onclick="alert('Please log in to access your cart.');">🛒</a>
            <?php endif; ?>

            <a href="profile.php">👤</a>
        </div>
    </nav>

    <main>
    <div class="category-buttons">
        <a href="#category1" class="circle-btn">
        <img src="images/cpu.jpg" alt="CPU">
        <span class="circle-label">CPU</span>
        </a>
        <a href="#category2" class="circle-btn">
        <img src="images/gpu.png" alt="GPU">
        <span class="circle-label">GPU</span>
        </a>
        <a href="#category3" class="circle-btn">
        <img src="images/ram.png" alt="RAM">
        <span class="circle-label">RAM</span>
        </a>
    </div>


        <section id="category1" class="category-section">
            <h2>CPU</h2>
            <div class="product-placeholder">
                <p>Intel i5</p>
            </div>
            <div class="product-placeholder">
                <p>AMD Ryzen 5</p>
            </div>
        </section>

        <section id="category2" class="category-section">
            <h2>GPU</h2>
            <div class="product-placeholder">
                <p>NVIDIA RTX 3060</p>
            </div>
            <div class="product-placeholder">
                <p>AMD Radeon RX 6600</p>
            </div>
        </section>

        <section id="category3" class="category-section">
            <h2>RAM</h2>
            <div class="product-placeholder">
                <p>8GB DDR4</p>
            </div>
            <div class="product-placeholder">
                <p>16GB DDR4</p>
            </div>
        </section>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "oneunit_left");
$result = $conn->query("SELECT * FROM products");
?>

<h2>Available Products</h2>
<div class="products">
<?php while ($row = $result->fetch_assoc()) { ?>
    <div class="product">
        <img src="images/<?php echo htmlspecialchars(basename($row['image'])); ?>" width="150">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>₱<?php echo number_format($row['price'], 2); ?></p>
        <form action="add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="submit" value="Add to Cart">
        </form>
    </div>
<?php } ?>
</div>