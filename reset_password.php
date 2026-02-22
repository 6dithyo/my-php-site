<?php
require 'db.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Reset link expired or invalid.");
}

$stmt = $conn->prepare(
  "SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("Reset link expired or invalid.");
}
?>
<!DOCTYPE html>
<html>
<body>
<form action="update_password.php" method="POST">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  <input type="password" name="password" placeholder="New password" required>
  <button type="submit">Update Password</button>
</form>
</body>
</html>
