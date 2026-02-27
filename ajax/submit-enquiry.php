<?php
/**
 * AJAX Enquiry Submission Handler
 * Dholera Smart City
 */

header('Content-Type: application/json');
require_once '../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['number'] ?? ''); // Form uses 'number' as name
    $message = trim($_POST['comments'] ?? ''); // Form uses 'comments' as name

    // Basic Validation
    if (empty($name) || empty($email) || empty($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $message);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Your enquiry has been submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit enquiry. Please try again.']);
        }
    } catch (PDOException $e) {
        error_log("Enquiry Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'A technical error occurred. Please try again later.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
