<?php
include 'php/db.php';

$token = $_GET['token'] ?? '';

$stmt = $conn->prepare(
  "SELECT id, reset_expires FROM users WHERE reset_token = ?"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("Reset link expired or invalid.");
}

$user = $res->fetch_assoc();

if (strtotime($user['reset_expires']) < time()) {
    die("Reset link expired or invalid.");
}
?>
<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
<form action="php/update_password.php" method="POST">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  <input type="password" name="password" placeholder="New password" required>
  <button type="submit">Update Password</button>
</form>
</body>
</html>
