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
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
    <div class="header-images">
        <img src="../home/images/white-name.png" alt="Store Name" class="name-img">
    </div>
</header>
<nav>
    <div class="nav-left">
        <a href="../home/home.php">HOME</a>
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
<style>
.profile-box {
    background: rgba(255,255,255,0.98);
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.13);
    padding: 32px 24px;
    margin: 40px auto;
    max-width: 1200px;
}
.profile-box h2 {
    color: #111;
    margin-bottom: 18px;
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 1px;
}
.profile-btns {
    margin-bottom: 18px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
}
.pay-btn {
    font-size: 1em;
    padding: 10px 22px;
    border-radius: 20px;
    background: linear-gradient(90deg, #222, #444 80%);
    color: #fff !important;
    border: none;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: inline-block;
}
.pay-btn:hover, .pay-btn:active {
    background: linear-gradient(90deg, #444, #222 80%);
    color: #fff !important;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.13);
}
.product-table {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18);
    overflow: hidden;
    margin-bottom: 20px;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.product-table th, .product-table td {
    border: 1px solid #d0d0d0;
    padding: 14px 12px;
    text-align: left;
    background: transparent;
    color: #222;
    font-size: 1.05em;
}
.product-table th {
    background: #222;
    color: #fff;
    font-weight: 700;
    letter-spacing: 1px;
}
.product-table tr:nth-child(even) td {
    background: #f4f4f4;
}
.product-table tr:nth-child(odd) td {
    background: #fafbfc;
}
.product-table tr:hover td {
    background: #e0e7ef;
    color: #111;
}
.actions .pay-btn {
    margin: 0 2px 4px 0;
    min-width: 70px;
    text-align: center;
    font-size: 1em;
    padding: 7px 16px;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}
.actions .pay-btn:last-child {
    background: #c0392b !important;
    color: #fff !important;
}
@media (max-width: 700px) {
    .profile-box {
        padding: 16px 4vw;
        max-width: 98vw;
    }
    .product-table th, .product-table td {
        font-size: 0.95em;
        padding: 8px 4px;
    }
}
</style>
</body>
</html>
