<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$email = trim($_POST['email']);

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("If this email exists, a reset link has been sent.");
}

$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", time() + 3600);

$update = $conn->prepare(
    "UPDATE users SET reset_token=?, reset_expires=? WHERE email=?"
);
$update->bind_param("sss", $token, $expires, $email);
$update->execute();

$resetLink = "http://localhost/fitness_tracker/php/reset_password.php?token=$token";

echo "Reset link (localhost): <br><a href='$resetLink'>$resetLink</a>";
?>