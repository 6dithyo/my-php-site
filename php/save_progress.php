<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$user_id = $_SESSION['user_id'];

$workout = trim($_POST['workout'] ?? '');
$sets = (int)($_POST['sets'] ?? 0);
$reps = (int)($_POST['reps'] ?? 0);
$weight = (float)($_POST['lift_weight'] ?? 0);

if ($workout === '' || $sets <= 0 || $reps <= 0) {
    die("Invalid input");
}

$stmt = $conn->prepare("
    INSERT INTO progress (user_id, workout, sets, reps, lift_weight)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("isiii", $user_id, $workout, $sets, $reps, $weight);
$stmt->execute();

/* Redirect BACK to dashboard */
header("Location: ../dashboard.php");
exit;
