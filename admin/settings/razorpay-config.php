<?php
/**
 * Razorpay Configuration
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$success_msg = "";
$error_msg = "";

// Fetch Config
try {
    $stmt = $conn->query("SELECT * FROM razorpay_config LIMIT 1");
    $config = $stmt->fetch();
    
    // Auto-insert if empty (fail-safe)
    if (!$config) {
        $conn->query("INSERT INTO razorpay_config (key_id, key_secret, mode, status) VALUES ('', '', 'test', 'inactive')");
        $stmt = $conn->query("SELECT * FROM razorpay_config LIMIT 1");
        $config = $stmt->fetch();
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_config'])) {
    $key_id = trim($_POST['key_id']);
    $key_secret = trim($_POST['key_secret']);
    $mode = $_POST['mode'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("UPDATE razorpay_config SET key_id = ?, key_secret = ?, mode = ?, status = ? WHERE id = ?");
        $stmt->execute([$key_id, $key_secret, $mode, $status, $config['id']]);
        $success_msg = "Razorpay configuration updated successfully!";
        
        // Refresh data
        $config['key_id'] = $key_id;
        $config['key_secret'] = $key_secret;
        $config['mode'] = $mode;
        $config['status'] = $status;
    } catch (PDOException $e) {
        $error_msg = "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Razorpay Configuration</h1>
        <p style="color: #666;">Set up your Razorpay API keys for live and test payments.</p>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px;">
        <!-- Config Form -->
        <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <form method="POST">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Key ID</label>
                    <input type="text" name="key_id" class="input-box" value="<?php echo htmlspecialchars($config['key_id']); ?>" placeholder="rzp_test_..." required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Key Secret</label>
                    <input type="password" name="key_secret" class="input-box" value="<?php echo htmlspecialchars($config['key_secret']); ?>" placeholder="••••••••••••" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Gateway Mode</label>
                        <select name="mode" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                            <option value="test" <?php echo $config['mode'] == 'test' ? 'selected' : ''; ?>>Test Mode</option>
                            <option value="live" <?php echo $config['mode'] == 'live' ? 'selected' : ''; ?>>Live Mode</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Status</label>
                        <select name="status" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:5px;">
                            <option value="active" <?php echo $config['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $config['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="update_config" style="background: var(--primary-gold); color: #fff; border: none; padding: 12px 30px; border-radius: 4px; font-weight: 700; cursor: pointer;">
                    Save Configuration
                </button>
            </form>
        </div>

        <!-- Connection Test -->
        <div style="background: var(--dark-bg); color: #fff; padding: 30px; border-radius: 8px; height: fit-content;">
            <h3 style="color: var(--primary-gold); margin-bottom: 15px;">Test Payment Gateway</h3>
            <p style="font-size: 14px; color: #a0aec0; margin-bottom: 25px;">Click the button below to verify if your Razorpay integration is working correctly. This will trigger a ₹1.00 test transaction.</p>
            
            <?php if($config['key_id']): ?>
                <button id="rzp-test-btn" style="width: 100%; background: #fff; color: var(--dark-bg); border: none; padding: 15px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-credit-card"></i> Test Live Payment
                </button>
            <?php else: ?>
                <div style="padding: 15px; background: rgba(229, 62, 62, 0.1); border-radius: 8px; border-left: 4px solid #e53e3e; color: #feb2b2; font-size: 13px;">
                    Please enter and save your Key ID first to enable testing.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if($config['key_id']): ?>
<!-- Razorpay Checkout JS -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('rzp-test-btn').onclick = function(e){
        var options = {
            "key": "<?php echo $config['key_id']; ?>",
            "amount": "100", // 100 paise = 1 INR
            "currency": "INR",
            "name": "Dholera Smart City",
            "description": "Integration Test Payment",
            "image": "<?php echo BASE_URL; ?>assets/logo.webp",
            "handler": function (response){
                alert("Payment Successful!\nPayment ID: " + response.razorpay_payment_id);
            },
            "prefill": {
                "name": "Admin Tester",
                "email": "admin@dholerasmartcity.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#b8860b"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response){
            alert("Payment Failed: " + response.error.description);
        });
        rzp1.open();
        e.preventDefault();
    }
</script>
<?php endif; ?>

</body>
</html>
