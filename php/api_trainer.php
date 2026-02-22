<?php
require 'auth.php';
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'trainer') {
    echo json_encode(['error' => 'access_denied']);
    exit;
}

$trainer_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

if ($action === 'get_members') {
    // List all members linked to this trainer
    $stmt = $conn->prepare("
        SELECT id, username, email, height, weight, dob 
        FROM users 
        WHERE assigned_trainer_id = ?
    ");
    $stmt->bind_param("i", $trainer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    echo json_encode(['members' => $members]);

} elseif ($action === 'get_member_stats') {
    $member_id = intval($_GET['member_id']);
    
    // basic fetch of recent logs
    $stats = [];
    
    // Recent Meals
    $m_stmt = $conn->prepare("SELECT * FROM meals WHERE user_id = ? ORDER BY meal_time DESC LIMIT 5");
    $m_stmt->bind_param("i", $member_id);
    $m_stmt->execute();
    $m_res = $m_stmt->get_result();
    $stats['meals'] = $m_res->fetch_all(MYSQLI_ASSOC);
    
    // Recent Workouts
    $w_stmt = $conn->prepare("SELECT * FROM progress WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
    $w_stmt->bind_param("i", $member_id);
    $w_stmt->execute();
    $w_res = $w_stmt->get_result();
    $stats['workouts'] = $w_res->fetch_all(MYSQLI_ASSOC);

    echo json_encode($stats);
}
?>
