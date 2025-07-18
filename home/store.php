<?php 
session_start();
$conn = new mysqli("localhost", "root", "", "oneunit_left");

// Get selected category from URL parameter, default to 'all'
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Prepare the SQL query based on selected category
if ($selected_category === 'all') {
    $query = "SELECT * FROM products ORDER BY name";
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY name");
    $stmt->bind_param("s", $selected_category);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Get all unique categories for the filter buttons
$categories_query = "SELECT DISTINCT category FROM products";
$categories_result = $conn->query($categories_query);
?>

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
        /* Keep all your existing styles */

        /* Add new styles for category filter */
        .category-filter {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #000;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
        }

        .category-btn {
            background: #111;
            color: #fff;
            border: 1px solid #333;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .category-btn:hover {
            background: #333;
        }

        .category-btn.active {
            background: #fff;
            color: #000;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product {
            background-color: #111;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product h3 {
            color: #fff;
            margin: 10px 0;
            font-size: 1.2em;
        }

        .product .description {
            color: #aaa;
            font-size: 0.9em;
            margin: 10px 0;
        }

        .product .price {
            color: #fff;
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0;
        }

        .product .stock {
            color: #aaa;
            font-size: 0.9em;
            margin: 5px 0;
        }

        .product input[type="submit"] {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .product input[type="submit"]:hover {
            background-color: #ddd;
        }

        .category-section h2 {
            color: #fff;
            text-align: center;
            margin: 30px 0;
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
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
            <a href="cart.php">🛒</a>
            <a href="profile.php">👤</a>
        </div>
    </nav>

    <main>
        <div class="category-filter">
            <a href="?category=all" class="category-btn <?php echo $selected_category === 'all' ? 'active' : ''; ?>">
                All Products
            </a>
            <?php while ($category = $categories_result->fetch_assoc()): ?>
                <a href="?category=<?= urlencode($category['category']) ?>"
                   class="category-btn <?php echo $selected_category === $category['category'] ? 'active' : ''; ?>">
                    <?= htmlspecialchars($category['category']) ?>
                </a>
            <?php endwhile; ?>
        </div>

        <h2><?= $selected_category === 'all' ? 'All Products' : htmlspecialchars($selected_category) ?></h2>

        <div class="products">
            <?php
            if ($selected_category === 'all') {
                $result = $conn->query($query);
            }

            while ($product = $result->fetch_assoc()):
            ?>
                <div class="product">
                    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>"
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         onerror="this.src='../images/default-product.jpg'">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                    <p class="price">₱<?= number_format($product['price'], 2) ?></p>
                    <p class="stock">Stock: <?= $product['stock'] ?></p>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="submit" value="Add to Cart">
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>
