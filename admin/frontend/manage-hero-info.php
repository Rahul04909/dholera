<?php
/**
 * Manage Hero Info Bar
 * Dholera Smart City Frontend Management
 */
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$success_msg = "";
$error_msg = "";

// 1. Handle Stats Update
if (isset($_POST['update_stats'])) {
    try {
        $conn->beginTransaction();
        foreach ($_POST['stats'] as $id => $stat) {
            $stmt = $conn->prepare("UPDATE hero_info_stats SET icon = ?, label = ?, value = ? WHERE id = ?");
            $stmt->execute([$stat['icon'], $stat['label'], $stat['value'], $id]);
        }
        $conn->commit();
        $success_msg = "Statistics updated successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error updating stats: " . $e->getMessage();
    }
}

// 2. Handle Brochure Settings Update
if (isset($_POST['update_brochure'])) {
    $brochure_text = trim($_POST['brochure_text']);
    $brochure_icon = trim($_POST['brochure_icon']);
    
    try {
        $conn->beginTransaction();
        
        // Update Text & Icon
        $stmt = $conn->prepare("REPLACE INTO hero_info_settings (setting_key, setting_value) VALUES ('brochure_text', ?), ('brochure_icon', ?)");
        $stmt->execute([$brochure_text, $brochure_icon]);

        // Handle File Upload
        if (isset($_FILES['brochure_file']) && $_FILES['brochure_file']['error'] === 0) {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png'];
            $filename = $_FILES['brochure_file']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_name = 'brochure_' . time() . '.' . $ext;
                $upload_path = 'uploads/docs/' . $new_name;
                $abs_upload_path = '../../' . $upload_path;
                
                if (!is_dir('../../uploads/docs')) {
                    mkdir('../../uploads/docs', 0777, true);
                }

                if (move_uploaded_file($_FILES['brochure_file']['tmp_name'], $abs_upload_path)) {
                    $stmt = $conn->prepare("REPLACE INTO hero_info_settings (setting_key, setting_value) VALUES ('brochure_file', ?)");
                    $stmt->execute([$upload_path]);
                }
            }
        }
        
        $conn->commit();
        $success_msg = "Brochure settings updated!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error updating brochure: " . $e->getMessage();
    }
}

// Fetch Current Data
try {
    $stats = $conn->query("SELECT * FROM hero_info_stats ORDER BY sort_order ASC")->fetchAll();
    $settings_raw = $conn->query("SELECT * FROM hero_info_settings")->fetchAll();
    $settings = [];
    foreach ($settings_raw as $s) {
        $settings[$s['setting_key']] = $s['setting_value'];
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Hero Info Bar</h1>
            <p style="color: #666;">Update the high-level statistics and brochure link shown below the hero slider.</p>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php" target="_blank" class="view-site" style="text-decoration:none;">View Live Site</a>
    </div>

    <?php if ($success_msg): ?>
        <div style="background-color: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background-color: #fff5f5; color: #c53030; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #c53030;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .mgmt-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .mgmt-card h2 {
            font-size: 20px;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: var(--primary-gold);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
        .stat-item-form {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #4a5568;
        }
        .input-group input, .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-family: inherit;
        }
        .btn-update {
            background: var(--dark-bg);
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-update:hover {
            background: var(--primary-gold);
        }
    </style>

    <div class="mgmt-card">
        <h2><i class="fas fa-chart-line"></i> Statistics (4 Items)</h2>
        <form method="POST">
            <div class="stats-grid">
                <?php foreach ($stats as $stat): ?>
                    <div class="stat-item-form">
                        <div style="font-weight: 800; margin-bottom: 15px; color: #3182ce;">Item #<?php echo $stat['sort_order']; ?></div>
                        <div class="input-group">
                            <label>Icon Class (FontAwesome)</label>
                            <input type="text" name="stats[<?php echo $stat['id']; ?>][icon]" value="<?php echo htmlspecialchars($stat['icon']); ?>">
                        </div>
                        <div class="input-group">
                            <label>Label Text</label>
                            <input type="text" name="stats[<?php echo $stat['id']; ?>][label]" value="<?php echo htmlspecialchars($stat['label']); ?>">
                        </div>
                        <div class="input-group">
                            <label>Value Text</label>
                            <input type="text" name="stats[<?php echo $stat['id']; ?>][value]" value="<?php echo htmlspecialchars($stat['value']); ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" name="update_stats" class="btn-update">Update Statistics</button>
            </div>
        </form>
    </div>

    <div class="mgmt-card">
        <h2><i class="fas fa-file-pdf"></i> Brochure Settings</h2>
        <form method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                <div>
                    <div class="input-group">
                        <label>Button Text</label>
                        <input type="text" name="brochure_text" value="<?php echo htmlspecialchars($settings['brochure_text'] ?? ''); ?>">
                    </div>
                    <div class="input-group">
                        <label>Icon Class (FontAwesome)</label>
                        <input type="text" name="brochure_icon" value="<?php echo htmlspecialchars($settings['brochure_icon'] ?? ''); ?>">
                    </div>
                </div>
                <div>
                    <div class="input-group">
                        <label>Upload New Boruchre (PDF/Image)</label>
                        <input type="file" name="brochure_file">
                    </div>
                    <div style="background: #edf2f7; padding:15px; border-radius:4px; font-size:13px; color:#4a5568;">
                        <strong>Current File:</strong> <br>
                        <?php if (isset($settings['brochure_file']) && $settings['brochure_file'] != '#'): ?>
                            <a href="<?php echo BASE_URL . $settings['brochure_file']; ?>" target="_blank" style="color:#3182ce; overflow-wrap: break-word;"><?php echo $settings['brochure_file']; ?></a>
                        <?php else: ?>
                            <span style="color:#a0aec0;">No file uploaded</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" name="update_brochure" class="btn-update">Save Brochure Settings</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
