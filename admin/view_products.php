<?php
session_start();
require_once('../includes/db_connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
</head>
<body>
<header>
    <div class="header-images">
        <img src="../home/images/white-name.png" alt="Store Name" class="name-img">
    </div>
</header>
<nav>
    <div class="nav-left">
        <a href="../home/index.php">HOME</a>
        <a href="../home/store.php">STORE</a>
        <a href="../home/about.php">ABOUT</a>
    </div>
    <div class="nav-right">
        <a href="../home/profile.php">👤</a>
    </div>
</nav>
<main>
    <div class="profile-box" style="max-width:1200px;">
        <h2>Product List</h2>
        <div class="profile-btns">
            <a href="add_product.php" class="pay-btn">Add New Product</a>
            <a href="dashboard.php" class="pay-btn">Back to Dashboard</a>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <div style="overflow-x:auto;">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><img src="../uploads/<?= $row['image']; ?>" alt="" style="max-width:60px;max-height:60px;"></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td>₱<?= number_format($row['price'], 2); ?></td>
                        <td><?= htmlspecialchars($row['category']); ?></td>
                        <td class="actions" style="min-width:140px;">
                            <a href="edit_product.php?id=<?= $row['id']; ?>" class="pay-btn">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id']; ?>" class="pay-btn" style="background:#c0392b;" onclick="return confirm('Delete this product?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>
