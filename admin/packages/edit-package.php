<?php
/**
 * Edit Agent Package
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$id = (int)$_GET['id'];
$success_msg = "";
$error_msg = "";

// Fetch Package
try {
    $stmt = $conn->prepare("SELECT * FROM agent_packages WHERE id = ?");
    $stmt->execute([$id]);
    $package = $stmt->fetch();
    
    if (!$package) die("Package not found.");

    // Fetch Benefits
    $benefit_stmt = $conn->prepare("SELECT * FROM agent_package_benefits WHERE package_id = ?");
    $benefit_stmt->execute([$id]);
    $benefits_list = $benefit_stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_package'])) {
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $duration_months = $_POST['duration_months'];
    $status = $_POST['status'];
    $benefits = $_POST['benefits'] ?? [];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE agent_packages SET package_name = ?, price = ?, duration_months = ?, status = ? WHERE id = ?");
        $stmt->execute([$package_name, $price, $duration_months, $status, $id]);

        // Re-sync Benefits (Simple delete and re-insert)
        $conn->prepare("DELETE FROM agent_package_benefits WHERE package_id = ?")->execute([$id]);
        
        if (!empty($benefits)) {
            $benefit_stmt = $conn->prepare("INSERT INTO agent_package_benefits (package_id, benefit_text) VALUES (?, ?)");
            foreach ($benefits as $benefit) {
                if (!empty(trim($benefit))) {
                    $benefit_stmt->execute([$id, trim($benefit)]);
                }
            }
        }

        $conn->commit();
        $success_msg = "Package updated successfully!";
        
        // Refresh data
        $stmt->execute([$package_name, $price, $duration_months, $status, $id]); // Re-fetch logic below
        header("Location: edit-package.php?id=$id&success=1");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

if (isset($_GET['success'])) $success_msg = "Package updated successfully!";

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <a href="index.php" style="color: var(--primary-gold); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Packages</a>
        <h1 style="font-size: 28px; font-weight: 700; margin-top: 10px;">Edit Package: <?php echo htmlspecialchars($package['package_name']); ?></h1>
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
                    <input type="text" name="package_name" class="input-box" value="<?php echo htmlspecialchars($package['package_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="input-box" value="<?php echo $package['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Duration (Months)</label>
                    <select name="duration_months" class="input-box" required>
                        <option value="1" <?php if($package['duration_months'] == '1') echo 'selected'; ?>>1 Month</option>
                        <option value="3" <?php if($package['duration_months'] == '3') echo 'selected'; ?>>3 Months</option>
                        <option value="6" <?php if($package['duration_months'] == '6') echo 'selected'; ?>>6 Months</option>
                        <option value="12" <?php if($package['duration_months'] == '12') echo 'selected'; ?>>12 Months</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="input-box">
                        <option value="active" <?php if($package['status'] == 'active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if($package['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="section-title">Package Benefits</div>
            <div id="benefits-container">
                <?php if(!empty($benefits_list)): ?>
                    <?php foreach($benefits_list as $benefit): ?>
                        <div class="benefit-row">
                            <input type="text" name="benefits[]" class="input-box" value="<?php echo htmlspecialchars($benefit['benefit_text']); ?>">
                            <button type="button" class="btn-delete" style="border:none; background:none; cursor: pointer;" onclick="$(this).parent().remove()"><i class="fas fa-times-circle" style="color: #e53e3e; font-size: 20px; margin-top: 10px;"></i></button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="benefit-row">
                        <input type="text" name="benefits[]" class="input-box" placeholder="e.g. Unlimited Lead Access">
                        <button type="button" class="btn-delete" style="border:none; background:none; cursor: pointer;" onclick="$(this).parent().remove()"><i class="fas fa-times-circle" style="color: #e53e3e; font-size: 20px; margin-top: 10px;"></i></button>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" class="add-btn" onclick="addBenefitRow()"><i class="fas fa-plus"></i> Add Benefit</button>
        </div>

        <button type="submit" name="update_package" class="save-btn">Update Package</button>
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
