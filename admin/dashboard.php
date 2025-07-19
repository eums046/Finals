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
    <style>
        .profile-box {
            background: rgba(255,255,255,0.98);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            border: 1.5px solid #e0e0e0;
            padding: 40px 32px 32px 32px;
            margin: 40px auto;
            max-width: 500px;
            text-align: center;
        }
        .profile-box h2 {
            color: #111;
            margin-bottom: 18px;
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .welcome-card {
            margin-bottom: 24px;
            background: #f7f7fa;
            border-radius: 10px;
            padding: 12px 0;
            color: #232526;
            font-weight: 500;
            font-size: 1.08rem;
        }
        .profile-btns {
            margin-bottom: 18px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pay-btn.small-btn {
            padding: 10px 0;
            font-size: 1.05rem;
            border-radius: 16px;
            width: 180px;
            margin: 10px auto 0 auto;
            background: linear-gradient(90deg, #232526 0%, #414345 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            display: inline-block;
            letter-spacing: 0.5px;
            text-align: center;
            border: none;
        }
        .pay-btn.small-btn.logout {
            background: linear-gradient(90deg, #c0392b 0%, #8e2323 100%);
        }
        .pay-btn.small-btn:hover {
            background: linear-gradient(90deg, #414345 0%, #232526 100%);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
            transform: translateY(-2px) scale(1.03);
        }
        .pay-btn.small-btn.logout:hover {
            background: linear-gradient(90deg, #8e2323 0%, #c0392b 100%);
        }
        @media (max-width: 700px) {
            .profile-box {
                padding: 16px 4vw;
                max-width: 98vw;
            }
            .pay-btn.small-btn {
                width: 100%;
            }
        }
    </style>
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
        <p class="welcome-card">
            Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>!
        </p>
        <div class="profile-btns">
            <a href="../home/index.php" class="pay-btn small-btn">Homepage</a>
            <a href="add_product.php" class="pay-btn small-btn">Add Product</a>
            <a href="view_products.php" class="pay-btn small-btn">View Products</a>
            <a href="admin_logout.php" class="pay-btn small-btn logout">Logout</a>
        </div>
    </div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>
