<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>

        <div class="admin-actions">
            <a href="/Finals/home/home.php" class="back-button">← Back to Homepage</a>
            <a href="add_product.php">Add New Product</a><br><br>
            <a href="view_products.php">View All Products</a><br><br>
            <a href="admin_logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
