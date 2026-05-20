<?php
/**
 * Agent OTP Request Handler
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

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter your email address.']);
    exit();
}

try {
    // 1. Verify that agent exists and is active
    $stmt = $conn->prepare("SELECT id, full_name, status FROM agents WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $agent = $stmt->fetch();

    if (!$agent) {
        echo json_encode(['status' => 'error', 'message' => 'This email is not registered as a partner agent.']);
        exit();
    }

    if ($agent['status'] !== 'active') {
        echo json_encode(['status' => 'error', 'message' => 'Your partner account is currently inactive. Please contact administration.']);
        exit();
    }

    // 2. Generate a secure 6-digit OTP
    $otp_code = (string)rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // 3. Save OTP in the database
    $update_stmt = $conn->prepare("UPDATE agents SET otp_code = :otp_code, otp_expiry = :otp_expiry WHERE id = :id");
    $update_stmt->execute([
        'otp_code' => $otp_code,
        'otp_expiry' => $otp_expiry,
        'id' => $agent['id']
    ]);

    // 4. Log OTP to debug file for local development & manual verification
    $debug_file = ROOT_PATH . 'debug_otp.txt';
    $log_entry = "[" . date('Y-m-d H:i:s') . "] Agent ID: " . $agent['id'] . " | Name: " . $agent['full_name'] . " | Email: $email | OTP: $otp_code | Expiry: $otp_expiry\n";
    file_put_contents($debug_file, $log_entry, FILE_APPEND);

    // 5. Retrieve SMTP configuration
    $smtp_stmt = $conn->query("SELECT * FROM smtp_config LIMIT 1");
    $smtp_config = $smtp_stmt->fetch();

    $mail_sent = false;
    $mail_error = '';

    // Check if SMTP settings are fully defined
    if ($smtp_config && !empty($smtp_config['smtp_host']) && !empty($smtp_config['smtp_user'])) {
        try {
            require_once __DIR__ . '/../vendor/autoload.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host       = $smtp_config['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtp_config['smtp_user'];
            $mail->Password   = $smtp_config['smtp_pass'];
            $mail->SMTPSecure = $smtp_config['smtp_encryption'] == 'none' ? false : $smtp_config['smtp_encryption'];
            $mail->Port       = $smtp_config['smtp_port'];

            // Recipients
            $mail->setFrom($smtp_config['from_email'], $smtp_config['from_name']);
            $mail->addAddress($email, $agent['full_name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Partner Portal Login Verification OTP - Dholera Smart City";
            
            // Premium email design body
            $mail->Body = "
            <div style='font-family: \"Outfit\", Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                <div style='text-align: center; margin-bottom: 25px;'>
                    <h2 style='color: #b8860b; font-size: 24px; font-weight: 800; text-transform: uppercase; margin: 0;'>Dholera Smart City</h2>
                    <p style='color: #718096; font-size: 14px; margin-top: 5px;'>Partner Network Panel</p>
                </div>
                <div style='border-top: 3px solid #b8860b; padding-top: 25px; color: #2d3748;'>
                    <p style='font-size: 16px; margin-bottom: 15px;'>Hello <b>" . htmlspecialchars($agent['full_name']) . "</b>,</p>
                    <p style='font-size: 15px; line-height: 1.6; color: #4a5568;'>You requested to sign in to your Partner Dashboard. Please use the following secure 6-digit One-Time Password (OTP) to verify your identity.</p>
                    
                    <div style='background-color: #f7fafc; border: 1px dashed #cbd5e0; border-radius: 8px; padding: 20px; text-align: center; margin: 25px 0;'>
                        <span style='font-size: 32px; font-weight: 800; letter-spacing: 5px; color: #1a202c;'>" . $otp_code . "</span>
                        <div style='font-size: 12px; color: #a0aec0; margin-top: 10px; text-transform: uppercase; font-weight: bold;'>Expires in 10 minutes</div>
                    </div>
                    
                    <p style='font-size: 13px; color: #e53e3e; line-height: 1.5; font-style: italic;'>If you did not initiate this request, please ignore this email. Do not share this OTP with anyone for account security.</p>
                </div>
                <div style='margin-top: 35px; padding-top: 20px; border-top: 1px solid #edf2f7; text-align: center; font-size: 12px; color: #a0aec0;'>
                    &copy; " . date('Y') . " Dholera Smart City | Partner Power Panel
                </div>
            </div>
            ";

            $mail->send();
            $mail_sent = true;
        } catch (Exception $e) {
            $mail_error = 'PHPMailer Error: ' . $mail->ErrorInfo;
        }
    }

    // If SMTP wasn't configured or failed, try standard PHP mail()
    if (!$mail_sent) {
        $subject = "Partner Portal Login Verification OTP - Dholera Smart City";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Dholera Smart City <noreply@dholerabyus.in>' . "\r\n";
        
        $body = "
        <div style='font-family: Arial, sans-serif; max-width: 500px; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
            <h2 style='color: #b8860b;'>Dholera Smart City Partner Login</h2>
            <p>Hello " . htmlspecialchars($agent['full_name']) . ",</p>
            <p>Your 6-digit OTP verification code is:</p>
            <h1 style='background: #f4f4f4; padding: 15px; text-align: center; letter-spacing: 5px; color: #333; font-size: 32px; border-radius: 5px;'>" . $otp_code . "</h1>
            <p style='color: #666; font-size: 12px;'>This OTP code will expire in 10 minutes.</p>
        </div>
        ";
        
        if (@mail($email, $subject, $body, $headers)) {
            $mail_sent = true;
        } else {
            $mail_error = empty($mail_error) ? 'Standard PHP mail() failed.' : $mail_error;
        }
    }

    // 6. Return response
    // For local environment, always succeed if we successfully logged to debug_otp.txt
    $is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    
    if ($mail_sent) {
        echo json_encode([
            'status' => 'success',
            'message' => 'OTP verification code has been sent to ' . htmlspecialchars($email) . '.'
        ]);
    } elseif ($is_local) {
        echo json_encode([
            'status' => 'success',
            'message' => 'OTP generated! (Local environment: please check root debug_otp.txt for code)',
            'debug_otp' => true
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to send OTP email. Please try again. ' . (empty($mail_error) ? '' : '(' . $mail_error . ')')
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'A database error occurred. Please try again later.'
    ]);
}
