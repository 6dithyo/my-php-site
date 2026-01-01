<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT meal_name, calories, meal_time
    FROM meals
    WHERE user_id = ? AND DATE(meal_time) = CURDATE()
    ORDER BY meal_time DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$meals = [];
$total = 0;

while ($row = $res->fetch_assoc()) {
    $meals[] = $row;
    $total += $row['calories'];
}

echo json_encode([
    'total_calories' => $total,
    'meals' => $meals
]);
