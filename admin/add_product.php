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

        if (move_uploaded_file($image_tmp, $target)) {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $name, $desc, $price, $category, $new_filename);
            if ($stmt->execute()) {
                $message = "✅ Product added successfully!";
            } else {
                $message = "❌ Database error.";
            }
        } else {
            $message = "❌ Failed to upload image.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-dashboard">
        <h2>Add New Product</h2>
        <?php if ($message): ?><p class="message"><?php echo $message; ?></p><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="price" placeholder="Price" required>
            <input type="text" name="category" placeholder="Category" required>
            <input type="file" name="image" required>
            <button type="submit">Add Product</button>
        </form>
        <br>
        <a href="dashboard.php">🔙 Back to Dashboard</a>
    </div>
</body>
</html>
