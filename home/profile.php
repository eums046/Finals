<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | OneUnit Left</title>
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
        <a href="profile.php">👤</a>
    </div>
</nav>

<main>
    <div class="profile-box">
        <div class="regis-logo">
            <img src="images/logogif.gif" alt="Logo">
        </div>

        <?php if (isset($_SESSION["email"])): ?>
            <h2>User Profile</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
            <form method="post" action="logout.php" class="profile-btns">
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            <h2>You are not logged in.</h2>
            <p>Please choose an option to continue</p>
            <div class="profile-btns">
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>OneUnit Left © 2025 | This website is for educational purposes only.</p>
</footer>

</body>

</html>
