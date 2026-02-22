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
    // Add Meal
    $meal = $_POST['meal'] ?? '';
    $calories = $_POST['calories'] ?? 0;
    $protein = $_POST['protein'] ?? 0;
    $carbs = $_POST['carbs'] ?? 0;
    $fat = $_POST['fat'] ?? 0;

    if (empty($meal) || empty($calories)) {
         echo json_encode(['success' => false, 'message' => 'Meal name and calories required']);
         exit;
    }

    $stmt = $conn->prepare("INSERT INTO meals (user_id, meal_name, calories, protein, carbs, fat, meal_time) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isiddd", $user_id, $meal, $calories, $protein, $carbs, $fat);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $conn->insert_id, 'message' => 'Meal added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $stmt->close();

} elseif ($method === 'DELETE') {
    // Delete Meal
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'] ?? 0;
     if (!$id) {
        $id = $_GET['id'] ?? 0; // Fallback
    }

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM meals WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Meal deleted']);
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
