<?php
session_start();
require_once('../includes/db_connection.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
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
    <div class="profile-box">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" class="payment-form">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="pay-btn">Login</button>
        </form>
        <a href="../home/home.php" class="pay-btn" style="margin-top:15px;max-width:250px;">Back to Website Homepage</a>
    </div>
</main>
<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>
