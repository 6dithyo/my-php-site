<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../includes/admin_db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.php");
    exit;
}

$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$password = $_POST['password'];
$height   = $_POST['height'];
$weight   = $_POST['weight'];
// $dob = $_POST['dob']; // Removed
$role     = 'member'; // Always member from public registration
$input_trainer_code = trim($_POST['trainer_code'] ?? '');

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    die("Please fill all required fields.");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$trainer_code = null;
$assigned_trainer_id = null;

if (!empty($input_trainer_code)) {
    // Find trainer by code
    $t_stmt = $conn->prepare("SELECT id FROM users WHERE trainer_code = ? AND role = 'trainer'");
    $t_stmt->bind_param("s", $input_trainer_code);
    $t_stmt->execute();
    $t_result = $t_stmt->get_result();
    
    if ($row = $t_result->fetch_assoc()) {
        $assigned_trainer_id = $row['id'];
    } else {
        // Optional: die("Invalid trainer code"); or just ignore and register without trainer
        // For now, let's ignore invalid code but maybe log it? 
        // Or better: stop registration so they know code was wrong?
        die("Invalid Trainer Code. Please check the code or leave it empty.");
    }
    $t_stmt->close();
}

$stmt = $conn->prepare("
    INSERT INTO users (username, email, password, height, weight, role, trainer_code, assigned_trainer_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssddssi",
    $username,
    $email,
    $hashed,
    $height,
    $weight,
    // $dob, // Removed
    $role,
    $trainer_code,
    $assigned_trainer_id
);

if ($stmt->execute()) {
    header("Location: ../login.php?registered=1");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
exit;
?>
