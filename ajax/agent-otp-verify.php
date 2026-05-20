<?php
/**
 * Agent OTP Verification Handler
 * Dholera Smart City
 */

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$otp = isset($_POST['otp']) ? trim($_POST['otp']) : '';

if (empty($email) || empty($otp)) {
    echo json_encode(['status' => 'error', 'message' => 'Both email and OTP code are required.']);
    exit();
}

try {
    // 1. Fetch agent by email
    $stmt = $conn->prepare("SELECT id, full_name, status, otp_code, otp_expiry FROM agents WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $agent = $stmt->fetch();

    if (!$agent) {
        echo json_encode(['status' => 'error', 'message' => 'This email is not registered.']);
        exit();
    }

    if ($agent['status'] !== 'active') {
        echo json_encode(['status' => 'error', 'message' => 'Your partner account is inactive. Please contact administration.']);
        exit();
    }

    // 2. Validate OTP
    if (empty($agent['otp_code']) || $agent['otp_code'] !== $otp) {
        echo json_encode(['status' => 'error', 'message' => 'The entered OTP code is incorrect. Please try again.']);
        exit();
    }

    // 3. Validate OTP Expiration
    $current_time = date('Y-m-d H:i:s');
    if (empty($agent['otp_expiry']) || $agent['otp_expiry'] < $current_time) {
        echo json_encode(['status' => 'error', 'message' => 'This OTP verification code has expired. Please request a new one.']);
        exit();
    }

    // 4. Success: Set login session
    $_SESSION['agent_id'] = $agent['id'];
    $_SESSION['agent_name'] = $agent['full_name'];

    // 5. Clear the verified OTP from database to prevent replay attacks
    $clear_stmt = $conn->prepare("UPDATE agents SET otp_code = NULL, otp_expiry = NULL WHERE id = :id");
    $clear_stmt->execute(['id' => $agent['id']]);

    // 6. Return response
    echo json_encode([
        'status' => 'success',
        'message' => 'Verification successful! Logging you in...',
        'redirect' => BASE_URL . 'agent/index.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'A database error occurred. Please try again later.'
    ]);
}
