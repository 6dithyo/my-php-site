<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$response = [];

// 1. Fetch User Stats (including connected trainer)
$stmt = $conn->prepare("SELECT username, email, height, weight, notes, assigned_trainer_id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $response['user'] = $row;
    // Calculate BMI
    if ($row['height'] > 0) {
        $height_m = $row['height'] / 100;
        $response['user']['bmi'] = round($row['weight'] / ($height_m * $height_m), 1);
    } else {
        $response['user']['bmi'] = 0;
    }
} else {
    $response['error'] = 'User not found';
    echo json_encode($response);
    exit;
}
$stmt->close();

// 2. Fetch Today's Meals
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT id, meal_name, calories, protein, carbs, fat FROM meals WHERE user_id = ? AND DATE(meal_time) = ? ORDER BY meal_time DESC");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
$meals = [];
$total_calories = 0;
while ($row = $result->fetch_assoc()) {
    $meals[] = $row;
    $total_calories += $row['calories'];
}
$response['meals'] = $meals;
$response['total_calories'] = $total_calories;
$stmt->close();

// 3. Fetch Recent Workouts (Last 5)
$stmt = $conn->prepare("SELECT id, workout, sets, reps, lift_weight, date FROM progress WHERE user_id = ? ORDER BY date DESC, created_at DESC LIMIT 5");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$workouts = [];
while ($row = $result->fetch_assoc()) {
    $workouts[] = $row;
}
$response['workouts'] = $workouts;
$stmt->close();

echo json_encode($response);
?>
