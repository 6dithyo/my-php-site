<?php
require 'auth.php';
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$current_user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    // Fetch messages between current user and another user
    $other_user_id = intval($_GET['other_id']);
    
    $stmt = $conn->prepare("
        SELECT m.*, 
               CASE WHEN m.sender_id = ? THEN 'sent' ELSE 'received' END as type
        FROM messages m
        WHERE (sender_id = ? AND receiver_id = ?) 
           OR (sender_id = ? AND receiver_id = ?)
        ORDER BY created_at ASC
    ");
    $stmt->bind_param("iiiii", $current_user_id, $current_user_id, $other_user_id, $other_user_id, $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    echo json_encode(['messages' => $messages]);

} elseif ($action === 'send' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Send a message
    $receiver_id = intval($_POST['receiver_id']);
    $message = trim($_POST['message']); // No htmlspecialchars here, handle on frontend output
    
    if ($message === '') {
        echo json_encode(['error' => 'empty_message']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $current_user_id, $receiver_id, $message);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['error' => 'db_error']);
    }

} else {
    echo json_encode(['error' => 'invalid_action']);
}
?>
