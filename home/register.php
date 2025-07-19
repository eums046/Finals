<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

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

    // Password validation
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};:"\\\\|,.<>\/?]{8,}$/', $password)) {
        echo "<script>alert('Password must be at least 8 characters and include at least one letter and one number.'); window.history.back();</script>";
        exit;
    } elseif ($password != $confirm) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    // Hash password and generate token
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(16));

    // Insert user into database
    $sql = "INSERT INTO users (full_name, email, password, address, contact_number, token, is_verified)
            VALUES ('$fullname', '$email', '$hashed_password', '$address', '$contact', '$token', 0)";

    if ($conn->query($sql) === TRUE) {
        $verify_link = "https://oneunitleft.rf.gd/home/verify.php?email=" . urlencode($email) . "&token=" . urlencode($token);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Username = '928249001@smtp-brevo.com';
            $mail->Password = 'qLEc01xnHf2MFO7N';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('928249001@smtp-brevo.com', 'OneUnit Left');
            $mail->addAddress($email);
            $mail->Subject = 'Verify your OneUnit Left account';
            $mail->Body = "Hi $fullname,\n\nPlease click the link below to verify your OneUnit Left account:\n\n$verify_link\n\nThank you!";

            $mail->send();
            echo "<script>alert('Registration successful! Please check your email to verify your account.'); window.location.href='login.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Registered, but verification email failed: " . $mail->ErrorInfo . "'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
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