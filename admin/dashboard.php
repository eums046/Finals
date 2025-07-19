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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
</head>
<body class="admin-body">
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
    <div class="profile-box">
        <h2>Admin Dashboard</h2>
        <p style="margin-bottom:24px;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>!</p>
        <div class="profile-btns">
            <a href="../home/index.php" class="pay-btn">Back to Homepage</a>
            <a href="add_product.php" class="pay-btn">Add New Product</a>
            <a href="view_products.php" class="pay-btn">View All Products</a>
            <a href="admin_logout.php" class="pay-btn">Logout</a>
        </div>
    </div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>
