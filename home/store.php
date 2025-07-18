<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OneUnit Left - Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">   
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
            <a href="#category-cpu" class="circle-btn">
                <img src="images/cpu.jpg" alt="CPU">
                <span class="circle-label">CPU</span>
            </a>
            <a href="#category-gpu" class="circle-btn">
                <img src="images/gpu.png" alt="GPU">
                <span class="circle-label">GPU</span>
            </a>
            <a href="#category-ram" class="circle-btn">
                <img src="images/ram.png" alt="RAM">
                <span class="circle-label">RAM</span>
            </a>
        </div>

        <?php
        $conn = new mysqli("localhost", "root", "", "oneunit_left");
        $categories = ["CPU", "GPU", "RAM"];

        foreach ($categories as $category):
            $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
            <section class="category-section" id="category-<?php echo strtolower($category); ?>">
                <h2><?php echo htmlspecialchars($category); ?></h2>

                <?php if ($result->num_rows > 0): ?>
                    <div class="products">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="product">
                                <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" width="150">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p>₱<?php echo number_format($row['price'], 2); ?></p>
                                <form action="add_to_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" value="Add to Cart">
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>
