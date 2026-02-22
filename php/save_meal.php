<?php
require 'php/auth.php';
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$meal = trim($_POST['meal_name'] ?? '');
$cal  = (int)($_POST['calories'] ?? 0);
$pro  = (float)($_POST['protein'] ?? 0);
$carb = (float)($_POST['carbs'] ?? 0);
$fat  = (float)($_POST['fat'] ?? 0);

if ($meal === '' || $cal <= 0) {
    echo json_encode(['error' => 'invalid_input']);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO meals (user_id, meal_name, calories, protein, carbs, fat)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("isiddd", $user_id, $meal, $cal, $pro, $carb, $fat);
$stmt->execute();

echo json_encode(['success' => true]);
