<?php
include 'db.php';

$token = $_POST['token'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare(
  "SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("Reset link expired or invalid.");
}

$user = $res->fetch_assoc();

$update = $conn->prepare(
  "UPDATE users 
   SET password=?, reset_token=NULL, reset_expires=NULL 
   WHERE id=?"
);
$update->bind_param("si", $password, $user['id']);
$update->execute();

echo "Password updated successfully. <a href='../login.php'>Login</a>";
