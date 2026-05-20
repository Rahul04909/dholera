<?php
/**
 * DB Migration Script
 * Adds OTP columns to the agents table safely
 */

$host = 'localhost';
$db_name = 'mineib_i1_dholera';
$username = 'mineib_i1_mineib';
$password = 'Rd14072003@./';

try {
    echo "Connecting to database...\n";
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Add otp_code column
    try {
        $conn->exec("ALTER TABLE `agents` ADD COLUMN `otp_code` VARCHAR(10) DEFAULT NULL AFTER `password`");
        echo "Column 'otp_code' added successfully.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "Column 'otp_code' already exists. Skipping.\n";
        } else {
            throw $e;
        }
    }
    
    // Add otp_expiry column
    try {
        $conn->exec("ALTER TABLE `agents` ADD COLUMN `otp_expiry` DATETIME DEFAULT NULL AFTER `otp_code`");
        echo "Column 'otp_expiry' added successfully.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "Column 'otp_expiry' already exists. Skipping.\n";
        } else {
            throw $e;
        }
    }
    
    echo "SUCCESS: Database migration completed!\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
