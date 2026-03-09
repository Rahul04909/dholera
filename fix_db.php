<?php
/**
 * Database Migration Script
 * Fixes missing columns in enquiries table
 */
require_once 'database/db_config.php';

try {
    // Check if subject column exists
    $check = $conn->query("SHOW COLUMNS FROM enquiries LIKE 'subject'");
    if (!$check->fetch()) {
        $conn->exec("ALTER TABLE enquiries ADD COLUMN subject VARCHAR(255) DEFAULT 'General Enquiry' AFTER phone");
        echo "Successfully added 'subject' column to enquiries table.";
    } else {
        echo "'subject' column already exists.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
