<?php
$conn = new mysqli("localhost", "root", "", "kenko_life");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
