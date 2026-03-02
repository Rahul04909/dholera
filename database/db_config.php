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

    // Dynamic Base Path / URL detection
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host_url = $_SERVER['HTTP_HOST'];
    
    // Physical root of the project
    $project_root = str_replace('\\', '/', dirname(__DIR__));
    
    // Physical path of the current script
    $current_script_phys = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
    
    // Web path of the current script
    $current_script_web = $_SERVER['SCRIPT_NAME'];
    
    // Relative path of the current script from project root
    // (We add a slash to project_root to ensure we target the boundary)
    $relative_path = str_replace($project_root . '/', '', $current_script_phys);
    
    // The difference between current script's web path and its relative path from root is our BASE_DIR
    $base_dir = str_replace($relative_path, '', $current_script_web);
    
    // Cleanup base_dir
    $base_dir = rtrim($base_dir, '/');
    if ($base_dir == '/') $base_dir = '';
    
    define('BASE_URL', $protocol . "://" . $host_url . $base_dir . "/");
    define('ROOT_PATH', $project_root . "/");

} catch(PDOException $e) {
    // Handle connection errors
    error_log("Connection failed: " . $e->getMessage());
    die("A technical error occurred. Please try again later.");
}
?>
