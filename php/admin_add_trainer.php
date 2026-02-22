<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../includes/admin_auth.php"; // Presumed auth check
include "../includes/admin_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if ($username && $email && $password) {
        // Check if email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        
        if ($check->num_rows > 0) {
            header("Location: ../admin/admin_dashboard.php?error=Email already exists");
            exit;
        }
        $check->close();

        // Create Trainer
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $role = 'trainer';
        $trainer_code = strtoupper(substr(md5(uniqid($email, true)), 0, 6));

        // Default stats for trainer (optional, using 0/0)
        $height = 0; $weight = 0; $dob = date('Y-m-d');

        $stmt = $conn->prepare("
            INSERT INTO users (username, email, password, height, weight, dob, role, trainer_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssddsss", $username, $email, $hashed, $height, $weight, $dob, $role, $trainer_code);
        
        if ($stmt->execute()) {
             header("Location: ../admin/admin_dashboard.php?success=Trainer added. Code: $trainer_code");
        } else {
             header("Location: ../admin/admin_dashboard.php?error=Database error");
        }
        $stmt->close();
    } else {
        header("Location: ../admin/admin_dashboard.php?error=Missing fields");
    }
} else {
    header("Location: ../admin/admin_dashboard.php");
}
?>
