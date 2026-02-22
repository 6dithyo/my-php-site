<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../includes/admin_db.php";

$result = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");

if ($result->num_rows === 0) {
    $sql = "
        ALTER TABLE users
        ADD COLUMN role ENUM('member','trainer')
        NOT NULL DEFAULT 'member'
    ";

    if ($conn->query($sql)) {
        echo "✅ Role column added successfully.";
    } else {
        echo "❌ Error adding role column: " . $conn->error;
    }
} else {
    echo "ℹ️ Role column already exists.";
}
