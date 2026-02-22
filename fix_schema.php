<?php
mysqli_report(MYSQLI_REPORT_ALL); // Enable exception reporting
$conn = new mysqli("localhost", "root", "", "fitnesss");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully.<br>";

// 1. Add Role
try {
    $conn->query("ALTER TABLE users ADD COLUMN role ENUM('member', 'trainer') DEFAULT 'member'");
    echo "Added 'role' column.<br>";
} catch (Exception $e) {
    echo "Column 'role' likely exists or error: " . $e->getMessage() . "<br>";
}

// 2. Add Trainer Code
try {
    $conn->query("ALTER TABLE users ADD COLUMN trainer_code VARCHAR(10) UNIQUE");
    echo "Added 'trainer_code' column.<br>";
} catch (Exception $e) {
    echo "Column 'trainer_code' likely exists or error: " . $e->getMessage() . "<br>";
}

// 3. Add Assigned Trainer ID
try {
    $conn->query("ALTER TABLE users ADD COLUMN assigned_trainer_id INT");
    echo "Added 'assigned_trainer_id' column.<br>";
} catch (Exception $e) {
    echo "Column 'assigned_trainer_id' likely exists or error: " . $e->getMessage() . "<br>";
}

// 4. Add FK
try {
    $conn->query("ALTER TABLE users ADD CONSTRAINT fk_assigned_trainer FOREIGN KEY (assigned_trainer_id) REFERENCES users(id) ON DELETE SET NULL");
    echo "Added Foreign Key.<br>";
} catch (Exception $e) {
    echo "FK likely exists or error: " . $e->getMessage() . "<br>";
}

echo "Database updated. You can delete this file now.";
?>
