<?php
/**
 * Database Configuration
 * Dholera Smart City Project
 */

// Database Credentials
$host = 'localhost'; // Usually localhost on WAMP/cPanel
$db_name = 'jhdindus_dholera';
$username = 'jhdindus_dholera';
$password = 'Rd14072003@./';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Handle connection errors
    error_log("Connection failed: " . $e->getMessage());
    die("A technical error occurred. Please try again later.");
}
?>
