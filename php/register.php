<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];
    $height = floatval($_POST['height']);
    $weight = floatval($_POST['weight']);
    $dob = $_POST['dob'];

    // Check for existing email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location='../register.php';</script>";
        exit;
    }
    $check->close();

    $hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, height, weight, dob, notes) VALUES (?, ?, ?, ?, ?, ?, '')");
    $stmt->bind_param("sssdds", $username, $email, $hashed, $height, $weight, $dob);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>