<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "oneunit_left";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";


    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["email"] = $row["email"];
        header("Location: profile.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | OneUnit Left</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
</head>
<body>
    <header>
        <div class="header-images">
            <img src="images/white-name.png" alt="Store Name" class="name-img">
        </div>
    </header>

    <nav>
        <div class="nav-left">
            <a href="home.php">HOME</a>
            <a href="store.php">STORE</a>
            <a href="about.php">ABOUT</a>
        </div>
        <div class="nav-right">
            <a href="cart.php">🛒</a>
            <a href="profile.php" class="logout-btn">👤</a>
        </div>
    </nav>

    <main>
        <div class="profile-box">
        <div class="regis-logo">
        <img src="images/logogif.gif" alt="OneUnit Left Logo">
        </div>
            <h2>User Login</h2>

        <form method="post" action="login.php">
            <p><input type="email" name="email" placeholder="Email" required></p>
            <p><input type="password" name="password" placeholder="Password" required></p>
            <div class="profile-btns">
                <button type="submit">Login</button>
            </div>
        </form>

        <div class="profile-btns">
            <a href="home.php">Back to Home</a>
        </div>

        <?php if (isset($error)) echo "<p class='error' style='color:red;'>$error</p>"; ?>
        </div>
    </main>

    <footer>
        <p>OneUnit Left © 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>
