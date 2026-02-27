<?php
/**
 * AJAX Callback Request Handler
 * Dholera Smart City
 */

header('Content-Type: application/json');
require_once '../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['footer_name'] ?? '');
    $email = trim($_POST['footer_email'] ?? '');
    $phone = trim($_POST['footer_number'] ?? '');
    $preferred_time = trim($_POST['callback_time'] ?? '');

    // Basic Validation
    if (empty($name) || empty($email) || empty($phone) || empty($preferred_time)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO callbacks (name, email, phone, preferred_time) VALUES (:name, :email, :phone, :preferred_time)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':preferred_time', $preferred_time);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Your callback request has been sent!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send request.']);
        }
    } catch (PDOException $e) {
        error_log("Callback Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'A technical error occurred.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
