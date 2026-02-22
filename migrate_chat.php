<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require "php/db.php"; 

echo "<h1>Starting Chat Schema Migration...</h1>";

try {
    $queries = [
        "CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
        )"
    ];

    foreach ($queries as $q) {
        $conn->query($q);
        echo "<p style='color:green'>Success: Table 'messages' created/checked.</p>";
    }

} catch (Exception $e) {
    echo "<h2>Fatal Error: " . $e->getMessage() . "</h2>";
}

echo "<h2>Migration Finished.</h2>";
?>
