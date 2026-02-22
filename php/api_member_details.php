<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'])) { // Trainer's ID
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$trainer_id = $_SESSION['user_id'];
$member_id = $_GET['member_id'] ?? 0;

if (!$member_id) {
    echo json_encode(['error' => 'Member ID required']);
    exit;
}

// Verify this member belongs to this trainer
$check = $conn->prepare("SELECT id, username, height, weight, notes FROM users WHERE id = ? AND assigned_trainer_id = ?");
$check->bind_param("ii", $member_id, $trainer_id);
$check->execute();
$res = $check->get_result();
$member = $res->fetch_assoc();

if (!$member) {
    echo json_encode(['error' => 'Member not found or not assigned to you']);
    exit;
}

$response = ['member' => $member];

// Fetch Member's Recent Meals
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT * FROM meals WHERE user_id = ? ORDER BY meal_time DESC LIMIT 20");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$meals = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$response['meals'] = $meals;

// Fetch Member's Recent Workouts
$stmt = $conn->prepare("SELECT * FROM progress WHERE user_id = ? ORDER BY date DESC LIMIT 20");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$workouts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$response['workouts'] = $workouts;

echo json_encode($response);
?>
