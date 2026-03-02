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

    // Dynamic Base Path / URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host_url = $_SERVER['HTTP_HOST'];
    $script_name = $_SERVER['SCRIPT_NAME'];
    $base_dir = str_replace('\\', '/', dirname(dirname($script_name)));
    if ($base_dir == '/') $base_dir = '';
    
    define('BASE_URL', $protocol . "://" . $host_url . $base_dir . "/");
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . $base_dir . "/");

} catch(PDOException $e) {
    // Handle connection errors
    error_log("Connection failed: " . $e->getMessage());
    die("A technical error occurred. Please try again later.");
}
?>
