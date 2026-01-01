<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $height = floatval($_POST['height']);
    $weight = floatval($_POST['weight']);
    $dob = $_POST['dob'];

    $stmt = $conn->prepare("UPDATE users SET height=?, weight=?, dob=? WHERE id=?");
    $stmt->bind_param("ddsi", $height, $weight, $dob, $_SESSION['user_id']);
    $stmt->execute();
    echo "<script>alert('Profile updated!'); window.location='../dashboard.php';</script>";
    exit;
}
?>