<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminlogin.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
    <style>
        .admin-login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            flex-direction: column;
        }

        .admin-login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .admin-login-box h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 25px;
            color: #111;
        }

        .admin-login-box .alert {
            background: #ffe5e5;
            color: #b30000;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }

        .admin-login-box button {
            margin-top: 10px;
        }

        .admin-login-box a {
            text-align: center;
            display: block;
            margin-top: 15px;
            color: #333;
        }

        .admin-login-box form {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 0;
        }

        .admin-input {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
            display: block;
            margin: 0 0 14px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .admin-login-box {
                padding: 24px 16px;
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

<main class="admin-login-wrapper">
    <div class="admin-login-box">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Admin Username" required class="admin-input">
            <input type="password" name="password" placeholder="Password" required class="admin-input">
            <button type="submit" class="pay-btn">Login</button>
        </form>
        <a href="../home/index.php" class="pay-btn">← Back to Homepage</a>
    </div>
</main>

<footer>
    <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
</footer>
</body>
</html>