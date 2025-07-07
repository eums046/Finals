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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-dashboard">
    <h2>📦 Product List</h2>

    <a href="add_product.php">➕ Add New Product</a> | 
    <a href="dashboard.php">🔙 Back to Dashboard</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>🆔 ID</th>
                    <th>📷 Image</th>
                    <th>📛 Name</th>
                    <th>📝 Description</th>
                    <th>💵 Price</th>
                    <th>📂 Category</th>
                    <th>⚙️ Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><img src="../uploads/<?= $row['image']; ?>" alt=""></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td>₱<?= number_format($row['price'], 2); ?></td>
                    <td><?= htmlspecialchars($row['category']); ?></td>
                    <td class="actions">
                        <a href="edit_product.php?id=<?= $row['id']; ?>">✏️ Edit</a>
                        <a href="delete_product.php?id=<?= $row['id']; ?>" onclick="return confirm('Delete this product?');">🗑️ Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>
</body>
</html>
