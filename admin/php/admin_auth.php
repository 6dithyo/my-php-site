<?php
session_start();
// Adjust path if needed
include "../../includes/admin_db.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Check if it's Login or Register
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // --- REGISTRATION ---
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $trainer_code = trim($_POST['trainer_code'] ?? '');
        
        // Validation
        if (empty($username) || empty($email) || empty($password) || empty($trainer_code)) {
            header("Location: ../admin_register.php?err=empty");
            exit;
        }

        // Check if code exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE trainer_code = ?");
        $stmt->bind_param("s", $trainer_code);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            header("Location: ../admin_register.php?err=code_taken");
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $role = 'trainer';

        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, trainer_code) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed, $role, $trainer_code);
        
        if ($stmt->execute()) {
            header("Location: ../admin_login.php?registered=1");
        } else {
            header("Location: ../admin_register.php?err=db");
        }

    } else {
        // --- LOGIN ---
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role IN ('trainer', 'admin')");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                // Redirect to admin dashboard
                header("Location: ../admin_dashboard.php");
                exit;
            }
        }
        
        header("Location: ../admin_login.php?err=invalid");
        exit;
    }
}
?>
