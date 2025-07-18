<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About | OneUnit Left</title>
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
    <div class="about-box">
        <div class="regis-logo">
            <img src="images/black-name.png" alt="Group Logo">
        </div>

 <div class="letter-wrapper">
    <div class="letter-image">
        <div class="animated-mail">
            <div class="back-fold"></div>
            <div class="letter">
                <div class="letter-border"></div>
                <div class="letter-title"></div>
                    <h2>About OneUnit Left</h2>
            </div>
            <div class="top-fold"></div>
            <div class="body"></div>
            <div class="left-fold"></div>
        </div>
        <div class="shadow"></div>
    </div>
</div>

<div class="project-description">
    <p>
        OneUnit Left is a class project designed to showcase our skills in web development using PHP, HTML, and CSS. 
        It features a functioning store, login system, profile page, and other key components of a typical e-commerce website — 
        all built from scratch by students learning full-stack fundamentals.
    </p>
</div>

        <h2>Meet the Team</h2>
        <div class="team-section">
            <div class="team-card">
    <img src="images/shane.jpg" alt="Member 1">
    <div class="overlay">
        <div>
            <strong>Shane Tampipig</strong><br>
            <span>An Animation and Game Development student. Chuchucu.</span>
        </div>
    </div>
</div>
            <div class="team-card">
                <img src="images/member2.jpg" alt="Member 2">
                <div class="overlay">fiel</div>
            </div>
            <div class="team-card">
                <img src="images/jim.jpg" alt="Member 3">
                <div class="overlay">Jim</div>
                <div>
                    <strong>Jim Mañibo </strong><br>
                    <span>An .</span>
                </div>
            </div>
            <div class="team-card">
                <img src="images/member4.jpg" alt="Member 4">
                <div class="overlay">eumi</div>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>OneUnit Left © 2025 | This website is for educational purposes only.</p>
</footer>

</body>
</html>
