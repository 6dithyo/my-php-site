<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Add Workout
    $workout = $_POST['workout'] ?? '';
    $sets = $_POST['sets'] ?? 0;
    $reps = $_POST['reps'] ?? 0;
    $weight = $_POST['weight'] ?? 0;
    // For simplicity, using current date if not provided
    $date = date('Y-m-d'); 

    if (empty($workout)) {
        echo json_encode(['success' => false, 'message' => 'Workout name required']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO progress (user_id, workout, sets, reps, lift_weight, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isiids", $user_id, $workout, $sets, $reps, $weight, $date);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $conn->insert_id, 'message' => 'Workout added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $stmt->close();

} elseif ($method === 'DELETE') {
    // Delete Workout - Read raw input for DELETE
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'] ?? 0;

    if (!$id) {
        $id = $_GET['id'] ?? 0; // Fallback to GET if convenient
    }

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM progress WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        if ($stmt->execute()) {
             echo json_encode(['success' => true, 'message' => 'Workout deleted']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
