<?php
/**
 * Add Agent Package
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_package'])) {
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $duration_months = $_POST['duration_months'];
    $status = $_POST['status'];
    $benefits = $_POST['benefits'] ?? [];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO agent_packages (package_name, price, duration_months, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$package_name, $price, $duration_months, $status]);
        
        $package_id = $conn->lastInsertId();

        if (!empty($benefits)) {
            $benefit_stmt = $conn->prepare("INSERT INTO agent_package_benefits (package_id, benefit_text) VALUES (?, ?)");
            foreach ($benefits as $benefit) {
                if (!empty(trim($benefit))) {
                    $benefit_stmt->execute([$package_id, trim($benefit)]);
                }
            }
        }

        $conn->commit();
        $success_msg = "Package added successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <a href="index.php" style="color: var(--primary-gold); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Packages</a>
        <h1 style="font-size: 28px; font-weight: 700; margin-top: 10px;">Add New Package</h1>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $success_msg; ?></div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <form method="POST">
        <style>
            .form-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
            .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f7fafc; padding-bottom: 10px; }
            .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            .form-group { margin-bottom: 20px; }
            label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #4a5568; }
            .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; outline: none; }
            .benefit-row { display: flex; gap: 10px; margin-bottom: 10px; }
            .add-btn { background: #edf2f7; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600; margin-top: 10px; }
            .save-btn { background: var(--primary-gold); color: #fff; border: none; padding: 15px 40px; border-radius: 4px; font-size: 16px; font-weight: 700; cursor: pointer; float: right; margin-top: 20px; }
        </style>

        <div class="form-card">
            <div class="section-title">Package Details</div>
            <div class="grid-form">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Package Name</label>
                    <input type="text" name="package_name" class="input-box" placeholder="e.g. Premium Agent Plan" required>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="input-box" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Duration (Months)</label>
                    <select name="duration_months" class="input-box" required>
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="input-box">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="section-title">Package Benefits</div>
            <div id="benefits-container">
                <div class="benefit-row">
                    <input type="text" name="benefits[]" class="input-box" placeholder="e.g. Unlimited Lead Access">
                    <button type="button" class="btn-delete" style="border:none; background:none; cursor: pointer;" onclick="$(this).parent().remove()"><i class="fas fa-times-circle" style="color: #e53e3e; font-size: 20px; margin-top: 10px;"></i></button>
                </div>
            </div>
            <button type="button" class="add-btn" onclick="addBenefitRow()"><i class="fas fa-plus"></i> Add Benefit</button>
        </div>

        <button type="submit" name="add_package" class="save-btn">Create Package</button>
        <div style="clear:both;"></div>
    </form>
</div>

<script>
    function addBenefitRow() {
        $('#benefits-container').append(`
            <div class="benefit-row">
                <input type="text" name="benefits[]" class="input-box" placeholder="Enter Benefit">
                <button type="button" class="btn-delete" style="border:none; background:none; cursor: pointer;" onclick="$(this).parent().remove()"><i class="fas fa-times-circle" style="color: #e53e3e; font-size: 20px; margin-top: 10px;"></i></button>
            </div>
        `);
    }
</script>

</body>
</html>
