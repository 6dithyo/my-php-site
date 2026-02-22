<?php
require 'db.php';

$token = $_POST['token'] ?? '';
$newPassword = $_POST['password'] ?? '';

if (empty($token) || empty($newPassword)) {
    die("Invalid request");
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password + invalidate token
$stmt = $conn->prepare("
    UPDATE users 
    SET password = ?, reset_token = NULL, reset_expires = NULL
    WHERE reset_token = ? AND reset_expires > NOW()
");

$stmt->bind_param("ss", $hashedPassword, $token);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    die("Reset link expired or invalid");
}

echo "Password reset successful. You can now login.";
