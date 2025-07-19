<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OneUnit Left - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External Styles -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  

    <!-- Internal CSS for Admin Button (hidden by default) -->
    <style>
        .admin-btn {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            background-color: #222;
            color: white;
            padding: 10px 20px;
            border: 1px solid white;
            border-radius: 25px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        footer:hover .admin-btn {
            opacity: 1;
            pointer-events: auto;
        }

        .admin-btn:hover {
            background-color: #444;
            transform: scale(1.05);
        }

        .admin-btn:visited {
            color: white;
        }

        .admin-footer {
            text-align: center;
            margin-top: 10px;
        }
    </style>
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
        <div class="admin-footer">
            <a href="../admin/admin_login.php" class="admin-btn">Admin Panel</a>
        </div>
    </footer>
</body>
</html>
