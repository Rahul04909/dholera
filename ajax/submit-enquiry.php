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
    $subject = trim($_POST['subject'] ?? 'General Enquiry');
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
        // Prevent Duplicate Requests (Check if same enquiry was made in the last 5 minutes)
        $dup_stmt = $conn->prepare("SELECT id FROM enquiries WHERE email = :email AND phone = :phone AND message = :message AND created_at > (NOW() - INTERVAL 5 MINUTE)");
        $dup_stmt->execute(['email' => $email, 'phone' => $phone, 'message' => $message]);
        
        if ($dup_stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'Your enquiry has already been received. Please wait a few minutes before submitting again.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':subject', $subject);
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
