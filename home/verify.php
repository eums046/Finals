<?php
$conn = new mysqli("localhost", "root", "", "oneunit_left");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $conn->real_escape_string($_GET['email']);
    $token = $conn->real_escape_string($_GET['token']);

    $sql = "SELECT * FROM users WHERE email='$email' AND token='$token' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $update = "UPDATE users SET is_verified = 1, token = NULL WHERE email='$email'";
        if ($conn->query($update) === TRUE) {
            echo "<div class='verify-message success'>
                    ✅ Hi, your email has been successfully verified!<br><br>
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

</body>
</html>
