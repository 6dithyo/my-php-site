<?php
require 'php/auth.php';
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['dates'=>[], 'weights'=>[]]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT DATE(created_at) as d, MAX(lift_weight) as w
    FROM progress
    WHERE user_id = ?
    GROUP BY DATE(created_at)
    ORDER BY d ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$dates = [];
$weights = [];

while ($row = $res->fetch_assoc()) {
    $dates[] = $row['d'];
    $weights[] = $row['w'];
}

echo json_encode([
    'dates' => $dates,
    'weights' => $weights
]);
