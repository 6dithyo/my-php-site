<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require "php/db.php"; 

echo "<h1>Starting Schema Migration...</h1>";

try {
    // 1. Add 'role' column
    // We check if it exists first or just try to add it. 
    // Easier to just try to add and catch error, or strict "ADD COLUMN IF NOT EXISTS" if MySQL version supports it (8.0+).
    // For compatibility, we'll run queries that might fail if column exists, so we wrap them.
    
    $queries = [
        "ALTER TABLE users ADD COLUMN role ENUM('member', 'trainer', 'admin') DEFAULT 'member'",
        "ALTER TABLE users ADD COLUMN trainer_code VARCHAR(50) UNIQUE DEFAULT NULL",
        "ALTER TABLE users ADD COLUMN assigned_trainer_id INT DEFAULT NULL",
        "ALTER TABLE users ADD CONSTRAINT fk_assigned_trainer FOREIGN KEY (assigned_trainer_id) REFERENCES users(id) ON DELETE SET NULL",
        "ALTER TABLE users MODIFY COLUMN dob DATE NULL" // Make DOB optional
    ];

    foreach ($queries as $q) {
        try {
            $conn->query($q);
            echo "<p style='color:green'>Success: $q</p>";
        } catch (mysqli_sql_exception $e) {
            // Ignore "Duplicate column name" errors
            if ($e->getCode() == 1060) {
                echo "<p style='color:orange'>Skipped (Exists): $q</p>";
            } else {
                echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
            }
        }
    }

} catch (Exception $e) {
    echo "<h2>Fatal Error: " . $e->getMessage() . "</h2>";
}

echo "<h2>Migration Finished.</h2>";
?>
