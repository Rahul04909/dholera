<?php
/**
 * Agent Registration - Step 3 (Payment)
 * Dholera Smart City
 */
require_once 'database/db_config.php';
session_start();

if (!isset($_SESSION['reg_data']) || !isset($_GET['pkg_id'])) {
    header("Location: register.php");
    exit();
}

$pkg_id = (int)$_GET['pkg_id'];

// Fetch Package Details
try {
    $stmt = $conn->prepare("SELECT * FROM agent_packages WHERE id = ?");
    $stmt->execute([$pkg_id]);
    $package = $stmt->fetch();
    
    if(!$package) die("Invalid Package");

    // Fetch Razorpay Config
    $rzp_stmt = $conn->query("SELECT key_id, key_secret FROM razorpay_config WHERE status = 'active' LIMIT 1");
    $rzp_config = $rzp_stmt->fetch();
    
    if(!$rzp_config || empty($rzp_config['key_id'])) {
        die("Payment gateway not configured. Please contact support.");
    }

} catch (PDOException $e) {
    die("Database Error");
}

$_SESSION['reg_data']['package_id'] = $pkg_id;
$_SESSION['reg_data']['amount'] = $package['price'];

include 'includes/header.php';
?>

<style>
    .pay-wrapper { padding: 100px 20px; background: #fff; min-height: 70vh; text-align: center; }
    .pay-container { max-width: 600px; margin: 0 auto; background: #f8fafc; padding: 50px; border-radius: 20px; border: 1px solid #edf2f7; }
    .confirm-title { font-size: 24px; font-weight: 800; margin-bottom: 30px; }
    .summary-box { background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 30px; text-align: left; box-shadow: 0 5px 15px rgba(0,0,0,0.02); }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #4a5568; }
    .summary-row.total { border-top: 1px solid #edf2f7; padding-top: 15px; margin-top: 15px; font-weight: 800; font-size: 20px; color: #111; }
    .btn-pay { width: 100%; background: var(--primary-gold); color: #fff; border: none; padding: 18px; border-radius: 10px; font-size: 18px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-pay:hover { background: #966d09; transform: scale(1.02); }
</style>

<div class="pay-wrapper">
    <div class="pay-container">
        <p style="color:var(--primary-gold); font-weight:700; margin-bottom:10px;">Step 3 of 3</p>
        <h1 class="confirm-title">Confirm Your Subscription</h1>
        
        <div class="summary-box">
            <div class="summary-row">
                <span>Agent Name</span>
                <strong><?php echo htmlspecialchars($_SESSION['reg_data']['full_name']); ?></strong>
            </div>
            <div class="summary-row">
                <span>Selected Plan</span>
                <strong><?php echo htmlspecialchars($package['package_name']); ?></strong>
            </div>
            <div class="summary-row">
                <span>Duration</span>
                <strong><?php echo $package['duration_months']; ?> Months</strong>
            </div>
            <div class="summary-row total">
                <span>Total Payable</span>
                <span>₹<?php echo number_format($package['price'], 2); ?></span>
            </div>
        </div>

        <button id="rzp-button" class="btn-pay">Pay & Complete Registration</button>
        <p style="margin-top: 20px; font-size: 13px; color: #718096;"><i class="fas fa-lock"></i> Secure encrypted payment via Razorpay</p>
    </div>
</div>

<form action="complete-registration.php" method="POST" id="pay-success-form">
    <input type="hidden" name="payment_id" id="razorpay_payment_id">
    <input type="hidden" name="order_id" id="razorpay_order_id">
</form>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "<?php echo $rzp_config['key_id']; ?>",
        "amount": "<?php echo $package['price'] * 100; ?>", 
        "currency": "INR",
        "name": "Dholera Smart City",
        "description": "Agent Subscription - <?php echo $package['package_name']; ?>",
        "image": "<?php echo BASE_URL; ?>assets/logo.webp",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('pay-success-form').submit();
        },
        "prefill": {
            "name": "<?php echo $_SESSION['reg_data']['full_name']; ?>",
            "email": "<?php echo $_SESSION['reg_data']['email']; ?>",
            "contact": "<?php echo $_SESSION['reg_data']['mobile']; ?>"
        },
        "theme": { "color": "#b8860b" }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>

<?php include 'includes/main-footer.php'; ?>
