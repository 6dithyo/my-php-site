<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$code = trim($_POST['code'] ?? '');

if (empty($code)) {
    echo json_encode(['success' => false, 'message' => 'Code required']);
    exit;
}

// Find trainer
$stmt = $conn->prepare("SELECT id, username FROM users WHERE trainer_code = ? AND role = 'trainer'");
$stmt->bind_param("s", $code);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $trainer_id = $row['id'];
    $trainer_name = $row['username'];
    
    // Update user
    $update = $conn->prepare("UPDATE users SET assigned_trainer_id = ? WHERE id = ?");
    $update->bind_param("ii", $trainer_id, $user_id);
    
    if ($update->execute()) {
        echo json_encode(['success' => true, 'message' => "Linked to trainer: $trainer_name"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $update->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Trainer Code']);
}
$stmt->close();
?>
