<?php
/**
 * Finalize Registration & Send Welcome Email
 * Dholera Smart City
 */
require_once 'database/db_config.php';
require_once 'vendor/autoload.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['reg_data']) || !isset($_POST['payment_id'])) {
    header("Location: register.php");
    exit();
}

$data = $_SESSION['reg_data'];
$payment_id = $_POST['payment_id'];

try {
    $conn->beginTransaction();

    // 1. Fetch Package for Duration
    $stmt_pkg = $conn->prepare("SELECT duration_months FROM agent_packages WHERE id = ?");
    $stmt_pkg->execute([$data['package_id']]);
    $pkg = $stmt_pkg->fetch();
    
    $expiry_date = date('Y-m-d H:i:s', strtotime("+{$pkg['duration_months']} months"));

    // 2. Insert Agent
    $stmt = $conn->prepare("INSERT INTO agents (full_name, email, mobile, profile_image, country, state, city, pincode, full_address, password, package_id, package_expiry, status, registration_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', 'active')");
    
    $stmt->execute([
        $data['full_name'],
        $data['email'],
        $data['mobile'],
        $data['profile_image'] ?? NULL,
        $data['country'],
        $data['state'],
        $data['city'],
        $data['pincode'],
        $data['full_address'],
        $data['password'],
        $data['package_id'],
        $expiry_date
    ]);

    $agent_id = $conn->lastInsertId();

    // 3. Record Payment (Optional, could add a payments table here later)

    $conn->commit();

    // 4. Send Welcome Email
    $smtp_stmt = $conn->query("SELECT * FROM smtp_config LIMIT 1");
    $smtp = $smtp_stmt->fetch();

    if ($smtp && !empty($smtp['smtp_host'])) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $smtp['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtp['smtp_user'];
            $mail->Password   = $smtp['smtp_pass'];
            $mail->SMTPSecure = $smtp['smtp_encryption'] == 'none' ? false : $smtp['smtp_encryption'];
            $mail->Port       = $smtp['smtp_port'];

            $mail->setFrom($smtp['from_email'], $smtp['from_name']);
            $mail->addAddress($data['email'], $data['full_name']);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Dholera Smart City - Agent Partnership';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;'>
                    <h2 style='color: #b8860b;'>Congratulations, {$data['full_name']}!</h2>
                    <p>Welcome to the Dholera Smart City premium agent network. Your account is now active and your subscription is verified.</p>
                    <div style='background: #f7fafc; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                        <h3 style='margin-top: 0;'>Account Details:</h3>
                        <p><strong>Username/Email:</strong> {$data['email']}</p>
                        <p><strong>Package Expiry:</strong> " . date('d M, Y', strtotime($expiry_date)) . "</p>
                    </div>
                    <p>You can now log in to your dashboard to access exclusive leads and project details.</p>
                    <a href='".BASE_URL."agent/login.php' style='display: inline-block; background: #b8860b; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Go to Dashboard</a>
                    <p style='margin-top: 30px; font-size: 12px; color: #777;'>Best Regards,<br>Team Dholera Smart City</p>
                </div>";

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop the flow
        }
    }

    // Clean session
    unset($_SESSION['reg_data']);

} catch (PDOException $e) {
    $conn->rollBack();
    die("Database Error: " . $e->getMessage());
}

include 'includes/header.php';
?>

<div style="padding: 120px 20px; text-align: center; background: #f7fafc; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 60px; border-radius: 20px; max-width: 600px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
        <div style="width: 80px; height: 80px; background: #c6f6d5; color: #38a169; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 40px;">
            <i class="fas fa-check"></i>
        </div>
        <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 15px;">Registration Successful!</h1>
        <p style="color: #718096; line-height: 1.6; font-size: 18px; margin-bottom: 40px;">
            Welcome aboard, <strong><?php echo htmlspecialchars($data['full_name']); ?></strong>! Your premium agent account is now active. A welcome email has been sent to your registered address.
        </p>
        <a href="agent/login.php" style="display: block; background: var(--dark-bg); color: #fff; padding: 18px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 18px; transition: 0.3s;">
            Login to Agent Dashboard <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
        </a>
    </div>
</div>

<?php include 'includes/main-footer.php'; ?>
