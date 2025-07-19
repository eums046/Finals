<?php
$conn = new mysqli("sql107.infinityfree.com", "if0_39501475", "2FaKH0u92yc", "if0_39501475_oneunit_left");

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
            echo "<div class='verify-message success'>
                    ✅ Email verified successfully!<br><br>
                    You can now 
                    <a href='login.php' class='verify-btn'>log in</a>
                  </div>";
        } else {
            echo "<div class='verify-message error'>❌ Something went wrong. Please try again later.</div>";
        }
    } else {
        echo "<div class='verify-message error'>❌ Invalid or expired verification link.</div>";
    }
} else {
    echo "<div class='verify-message error'>⚠️ Missing verification data.</div>";
}
?>
