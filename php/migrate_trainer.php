<?php
require_once 'db.php';

// Add role column
$sql1 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('member', 'trainer') DEFAULT 'member'";
if ($conn->query($sql1) === TRUE) {
    echo "Column 'role' added successfully or already exists.<br>";
} else {
    echo "Error adding 'role' column: " . $conn->error . "<br>";
}

// Add trainer_code column
$sql2 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS trainer_code VARCHAR(10) UNIQUE";
if ($conn->query($sql2) === TRUE) {
    echo "Column 'trainer_code' added successfully or already exists.<br>";
} else {
    echo "Error adding 'trainer_code' column: " . $conn->error . "<br>";
}

// Add assigned_trainer_id column
$sql3 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS assigned_trainer_id INT";
if ($conn->query($sql3) === TRUE) {
    echo "Column 'assigned_trainer_id' added successfully or already exists.<br>";
} else {
    echo "Error adding 'assigned_trainer_id' column: " . $conn->error . "<br>";
}

// Add Foreign Key
$sql4 = "ALTER TABLE users ADD CONSTRAINT fk_assigned_trainer FOREIGN KEY (assigned_trainer_id) REFERENCES users(id) ON DELETE SET NULL";
// Wrap in try-catch or check if exists to avoid error if FK already exists, but for simple script execution just running it.
if ($conn->query($sql4) === TRUE) {
     echo "Foreign key added successfully.<br>";
} else {
     echo "Error adding foreign key (might already exist): " . $conn->error . "<br>";
}

echo "Migration completed.";
?>
