<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // or your MySQL password
$db   = 'oneunit_left';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
