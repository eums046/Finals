<?php
session_start();
require_once('../includes/db_connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    $stock = intval($_POST['stock']);

    // Upload Settings
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];

    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($file_type, $allowed_types)) {
        $message = "Only JPG, JPEG, and PNG files are allowed.";
    } elseif ($file_size > $max_size) {
        $message = "File is too large. Max size is 2MB.";
    } else {
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_filename = uniqid("prod_", true) . "." . $ext;
        $target = "../uploads/" . $new_filename;

        if (!move_uploaded_file($image_tmp, $target)) {
            $message = "❌ Failed to upload image. Error code: " . $_FILES['image']['error'];
        } else {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssi", $name, $desc, $price, $category, $new_filename, $stock);
            if ($stmt->execute()) {
                $message = "✅ Product added successfully!";
            } else {
                $message = "❌ Database error.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
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
        <h2>Add New Product</h2>
        <?php if ($message): ?>
            <div class="alert<?php echo strpos($message, 'success') !== false ? ' success' : ''; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="payment-form">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="price" placeholder="Price" required>
            <input type="number" name="stock" placeholder="Stock Quantity" min="0" required>
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="CPU">CPU</option>
                <option value="GPU">GPU</option>
                <option value="RAM">RAM</option>
            </select>
            <input type="file" name="image" required>
            <button type="submit" class="pay-btn">Add Product</button>
        </form>
        <a href="dashboard.php" class="pay-btn" style="max-width:250px;">Back to Dashboard</a>
    </div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>
