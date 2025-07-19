<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OneUnit Left - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="index.php">HOME</a>
            <a href="store.php">STORE</a>
            <a href="about.php">ABOUT</a>
        </div>
        <div class="nav-right">
            <a href="cart.php">🛒</a>
             <a href="profile.php">👤</a>
             <a href="../admin/admin_login.php" class="admin-link">Admin Panel</a>
        </div>
    </nav>

    <main class="landing-main">
        <section class="landing-banner">
            <div class="banner-text">
                <h1>OneUnit Left</h1>

                <video width="420" height="340" autoplay muted loop playsinline>
                    <source src="images/homevideo.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                 <div class="cta-buttons">
                    <a href="store.php" class="cta-button">Shop Now</a>
                    <a href="profile.php" class="cta-button">Join Us</a>
                </div>
            </div>

        </section>
    </main>

    <footer>
        <p>OneUnit Left &copy; 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>
