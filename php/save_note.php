<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$notes = $_POST['notes'] ?? '';

$stmt = $conn->prepare("UPDATE users SET notes = ? WHERE id = ?");
$stmt->bind_param("si", $notes, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Note saved']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
$stmt->close();
?>
