<?php
session_start();
require_once('../includes/db_connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_products.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    
    // Image upload (optional)
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image=? WHERE id=?");
        $stmt->bind_param("ssdssi", $name, $description, $price, $category, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $category, $id);
    }

    $stmt->execute();
    header("Location: view_products.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
</head>
<body>
<div class="profile-box">
    <h2>Edit Product</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
        <p>Current Image: <img src="../uploads/<?= $product['image'] ?>" width="60"></p>
        <input type="file" name="image">
        <button type="submit" class="pay-btn">Update Product</button>
    </form>
    <a href="view_products.php" class="pay-btn">Cancel</a>
</div>
</body>
</html>
