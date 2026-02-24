<?php
$host = "sql100.infinityfree.com";  // Use your hostname
$user = "if0_40804252";             // Your DB username
$pass = "yourpassword";
$db   = "if0_40804252_db";     // Your full DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>