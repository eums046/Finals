<?php
$conn = new mysqli("localhost", "root", "", "oneunit_left");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $sql = "SELECT * FROM users WHERE email='$email' AND token='$token' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $update = "UPDATE users SET is_verified = 1, token = NULL WHERE email='$email'";
        if ($conn->query($update) === TRUE) {
            echo "<h2>Email verified successfully! You can now <a href='login.php'>log in</a>.</h2>";
        } else {
            echo "<h2>Something went wrong. Please try again later.</h2>";
        }
    } else {
        echo "<h2>Invalid or expired verification link.</h2>";
    }
} else {
    echo "<h2>Missing verification data.</h2>";
}
?>
