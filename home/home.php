<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OneUnit Left - Home</title>
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

    <main class="landing-main">
        <section class="landing-banner">
            <div class="banner-text">
                <h1>OneUnit Left</h1>
                <p>hindi ko pa alam ano ilalagay. vid or animation</p>
                <a href="store.php" class="cta-button">Shop Now</a>
                <a href="profile.php" class="cta-button">Join Us</a>
            </div>
        </section>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>
