<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("sql107.infinityfree.com", "if0_39501475", "2FaKH0u92yc", "if0_39501475_oneunit_left");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullname = mysqli_real_escape_string($conn, $_POST["full_name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm = $_POST["confirm_password"];
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $contact = mysqli_real_escape_string($conn, $_POST["contact_number"]);


    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};:"\\\\|,.<>\/?]{8,}$/', $password)) {
    echo "<script>alert('Password must be at least 8 characters and include at least one letter and one number.'); window.history.back();</script>";
    exit;
    } elseif ($password != $confirm) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    else {
        $sql = "INSERT INTO users (full_name, email, password, address, contact_number)
                VALUES ('$fullname', '$email', '$password', '$address', '$contact')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! You may now log in.');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    
    if ($password != $confirm) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $sql = "INSERT INTO users (full_name, email, password, address, contact_number)
                VALUES ('$fullname', '$email', '$password', '$address', '$contact')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! You may now log in.');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | OneUnit Left</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="profile.php" class="logout-btn">👤</a>
        </div>
    </nav>

<main>
    <div class="profile-box">
        <div class="regis-logo">
        <img src="images/logogif.gif" alt="OneUnit Left Logo">
        </div>
        <h2>Register</h2>
        <form method="post" action="">
            <p><input type="text" name="full_name" class="profile-input" placeholder="Complete Name" required></p>
            <p><input type="email" name="email" class="profile-input" placeholder="Email Address" required></p>
            <p><input type="password" name="password" class="profile-input" placeholder="Password" required
            pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};:'\\|,.<>\/?]{8,}"
            title="Password must be at least 8 characters long and include at least one letter and one number."></p>
            <p><input type="password" name="confirm_password" class="profile-input" placeholder="Confirm Password" required
            pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};:'\\|,.<>\/?]{8,}"></p>
            <p><input type="text" name="address" class="profile-input" placeholder="Complete Address" required></p>
            <p><input type="text" name="contact_number" class="profile-input" placeholder="Contact Number" required></p>
            <div class="profile-btns">
                <button type="submit">Register</button>
            </div>
        </form>
        <div class="profile-btns">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</main>


    <footer>
        <p>OneUnit Left © 2025 | This website is for educational purposes only.</p>
    </footer>
</body>
</html>