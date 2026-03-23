<?php
/**
 * SMTP Configuration
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

// Check for PHPMailer (usually in vendor or a specific folder)
// I'll assume we might need a simple mail test or the user has PHPMailer.
// For now, I'll implement the config and a "mail()" function test, 
// but I'll recommend using PHPMailer for real SMTP.

$success_msg = "";
$error_msg = "";

// Fetch Config
try {
    $stmt = $conn->query("SELECT * FROM smtp_config LIMIT 1");
    $config = $stmt->fetch();
    
    if (!$config) {
        $conn->query("INSERT INTO smtp_config (smtp_host, smtp_port, smtp_user, smtp_pass, smtp_encryption, from_email, from_name) VALUES ('', '', '', '', 'tls', '', 'Dholera Smart City')");
        $stmt = $conn->query("SELECT * FROM smtp_config LIMIT 1");
        $config = $stmt->fetch();
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_config'])) {
    $smtp_host = trim($_POST['smtp_host']);
    $smtp_port = trim($_POST['smtp_port']);
    $smtp_user = trim($_POST['smtp_user']);
    $smtp_pass = trim($_POST['smtp_pass']);
    $smtp_encryption = $_POST['smtp_encryption'];
    $from_email = trim($_POST['from_email']);
    $from_name = trim($_POST['from_name']);

    try {
        $stmt = $conn->prepare("UPDATE smtp_config SET smtp_host = ?, smtp_port = ?, smtp_user = ?, smtp_pass = ?, smtp_encryption = ?, from_email = ?, from_name = ? WHERE id = ?");
        $stmt->execute([$smtp_host, $smtp_port, $smtp_user, $smtp_pass, $smtp_encryption, $from_email, $from_name, $config['id']]);
        $success_msg = "SMTP configuration updated successfully!";
        
        // Refresh data
        $config['smtp_host'] = $smtp_host;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_encryption'] = $smtp_encryption;
        $config['from_email'] = $from_email;
        $config['from_name'] = $from_name;
    } catch (PDOException $e) {
        $error_msg = "Error: " . $e->getMessage();
    }
}

// Handle Test Email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_test'])) {
    $test_email = trim($_POST['test_email']);
    
    if (empty($test_email)) {
        $error_msg = "Please enter a test email address.";
    } else {
        require '../../vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $config['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['smtp_user'];
            $mail->Password   = $config['smtp_pass'];
            $mail->SMTPSecure = $config['smtp_encryption'] == 'none' ? false : $config['smtp_encryption'];
            $mail->Port       = $config['smtp_port'];

            // Recipients
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($test_email);

            // Content
            $mail->isHTML(true);
            $subject = "Dholera Smart City - SMTP Test Email";
            $mail->Subject = $subject;
            $mail->Body    = "<h2>SMTP Configuration Test</h2><p>This is a test email sent from your Dholera Smart City Admin Panel using <b>PHPMailer</b>.</p><p>If you received this, your SMTP settings are perfectly configured!</p>";

            $mail->send();
            $success_msg = "Test email sent successfully to $test_email via PHPMailer!";
        } catch (Exception $e) {
            $error_msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">SMTP Configuration</h1>
        <p style="color: #666;">Set up your outgoing mail server for notifications and enquiries.</p>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #e53e3e;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px;">
        <!-- Config Form -->
        <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <form method="POST">
                <div style="display: grid; grid-template-columns: 1fr 150px; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">SMTP Host</label>
                        <input type="text" name="smtp_host" class="input-box" value="<?php echo htmlspecialchars($config['smtp_host']); ?>" placeholder="smtp.gmail.com" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">SMTP Port</label>
                        <input type="text" name="smtp_port" class="input-box" value="<?php echo htmlspecialchars($config['smtp_port']); ?>" placeholder="587" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">SMTP Username</label>
                        <input type="text" name="smtp_user" class="input-box" value="<?php echo htmlspecialchars($config['smtp_user']); ?>" placeholder="your-email@gmail.com" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">SMTP Password</label>
                        <input type="password" name="smtp_pass" class="input-box" value="<?php echo htmlspecialchars($config['smtp_pass']); ?>" placeholder="••••••••••••" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Encryption</label>
                    <select name="smtp_encryption" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                        <option value="none" <?php echo $config['smtp_encryption'] == 'none' ? 'selected' : ''; ?>>None</option>
                        <option value="ssl" <?php echo $config['smtp_encryption'] == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                        <option value="tls" <?php echo $config['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">From Email</label>
                        <input type="email" name="from_email" class="input-box" value="<?php echo htmlspecialchars($config['from_email']); ?>" placeholder="noreply@dholera.com" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">From Name</label>
                        <input type="text" name="from_name" class="input-box" value="<?php echo htmlspecialchars($config['from_name']); ?>" placeholder="Dholera Smart City" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                    </div>
                </div>

                <button type="submit" name="update_config" style="background: var(--primary-gold); color: #fff; border: none; padding: 12px 30px; border-radius: 4px; font-weight: 700; cursor: pointer;">
                    Save SMTP Configuration
                </button>
            </form>
        </div>

        <!-- Test Email -->
        <div style="background: var(--dark-bg); color: #fff; padding: 30px; border-radius: 8px; height: fit-content;">
            <h3 style="color: var(--primary-gold); margin-bottom: 15px;">Send Test Email</h3>
            <p style="font-size: 14px; color: #a0aec0; margin-bottom: 25px;">Enter an email address to verify if the server can send emails correctly.</p>
            
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <input type="email" name="test_email" placeholder="recipient@example.com" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 5px; color: #fff;">
                </div>
                <button type="submit" name="send_test" style="width: 100%; background: #fff; color: var(--dark-bg); border: none; padding: 15px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-paper-plane"></i> Send Test Message
                </button>
            </form>

            <div style="margin-top: 25px; padding: 15px; background: rgba(184, 134, 11, 0.1); border-radius: 8px; font-size: 12px; line-height: 1.5; border-left: 3px solid var(--primary-gold);">
                <strong>Note:</strong> Most modern SMTP servers (Google, Outlook) require "App Passwords" or specific security settings to allow connections from PHP.
            </div>
        </div>
    </div>
</div>

</body>
</html>
