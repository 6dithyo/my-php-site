<?php
include 'db.php';
if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $note = trim($_POST['note']);
    $stmt = $conn->prepare("UPDATE users SET notes=? WHERE id=?");
    $stmt->bind_param("si", $note, $_SESSION['user_id']);
    $stmt->execute();
    echo "<script>alert('Note saved!'); window.location='../dashboard.php';</script>";
    exit;
}
?>