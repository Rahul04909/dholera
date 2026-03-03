<?php
/**
 * Manage Site Highlights
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

// Handle Settings Update
if (isset($_POST['update_settings'])) {
    $title = $_POST['title'];
    
    try {
        $conn->beginTransaction();
        
        $stmt = $conn->prepare("UPDATE site_highlights_settings SET title = ? WHERE id = 1");
        $stmt->execute([$title]);

        // Handle Side Image Upload
        if (isset($_FILES['side_image']) && $_FILES['side_image']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['side_image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_name = 'highlights_side_' . time() . '.' . $ext;
                $upload_path = 'uploads/frontend/' . $new_name;
                $abs_upload_path = '../../' . $upload_path;
                
                if (!is_dir('../../uploads/frontend')) {
                    mkdir('../../uploads/frontend', 0777, true);
                }

                if (move_uploaded_file($_FILES['side_image']['tmp_name'], $abs_upload_path)) {
                    $stmt = $conn->prepare("UPDATE site_highlights_settings SET side_image = ? WHERE id = 1");
                    $stmt->execute([BASE_URL . $upload_path]);
                }
            }
        }
        
        $conn->commit();
        $success_msg = "Section settings updated!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

// Handle Items Update
if (isset($_POST['update_items'])) {
    try {
        $conn->beginTransaction();
        foreach ($_POST['items'] as $id => $text) {
            $stmt = $conn->prepare("UPDATE site_highlights_items SET text = ? WHERE id = ?");
            $stmt->execute([$text, $id]);
        }
        $conn->commit();
        $success_msg = "Highlights items updated successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

// Fetch Current Data
try {
    $settings = $conn->query("SELECT * FROM site_highlights_settings WHERE id = 1")->fetch();
    $items = $conn->query("SELECT * FROM site_highlights_items ORDER BY sort_order ASC")->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Site Highlights</h1>
            <p style="color: #666;">Update the section title, side image, and individual highlight points.</p>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php" target="_blank" class="view-site" style="text-decoration:none;">View Site</a>
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
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px; color: #4a5568; }
        .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .items-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .item-row { background: #f8fafc; padding: 20px; border-radius: 6px; border: 1px solid #edf2f7; }
        .btn-update { background: var(--primary-gold); color: #fff; border: none; padding: 12px 25px; border-radius: 4px; font-weight: 700; cursor: pointer; }
    </style>

    <div class="mgmt-card">
        <h2 style="font-size: 20px; color: var(--primary-gold); margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Section Settings</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid-2">
                <div>
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" name="title" class="input-box" value="<?php echo htmlspecialchars($settings['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Side Decorative Image</label>
                        <input type="file" name="side_image" class="input-box" accept="image/*">
                        <p style="font-size: 12px; color: #718096; margin-top: 5px;">This image appears on the right side of the highlights.</p>
                    </div>
                    <button type="submit" name="update_settings" class="btn-update">Update Settings</button>
                </div>
                <div>
                    <label>Current Side Image</label>
                    <div style="width: 100%; height: 200px; border: 1px solid #eee; border-radius: 6px; overflow: hidden; background: #f7fafc; display: flex; align-items: center; justify-content: center;">
                        <img src="<?php echo $settings['side_image']; ?>" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="mgmt-card">
        <h2 style="font-size: 20px; color: var(--primary-gold); margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Highlights Points (8 Items)</h2>
        <form method="POST">
            <div class="items-grid">
                <?php foreach ($items as $index => $item): ?>
                    <div class="item-row">
                        <div style="font-weight: 800; margin-bottom: 10px; color: #3182ce;">Item #<?php echo $index + 1; ?></div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Description Text</label>
                            <textarea name="items[<?php echo $item['id']; ?>]" class="input-box" rows="2" required><?php echo htmlspecialchars($item['text']); ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" name="update_items" class="btn-update">Update Highlights Items</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
