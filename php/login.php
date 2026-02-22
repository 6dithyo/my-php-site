<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    header("Location: ../login.php?err=empty");
    exit;
}

$stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    header("Location: ../login.php?err=noemail");
    exit;
}

$user = $res->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    header("Location: ../login.php?err=wrongpass");
    exit;
}

// success — set session securely
session_regenerate_id(true);
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'] ?? 'member';

if (isset($user['role']) && $user['role'] === 'trainer') {
    header("Location: ../trainer_dashboard.php");
} else {
    header("Location: ../dashboard.php");
}
exit;
?>
