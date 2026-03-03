<?php
/**
 * Manage Site Overview
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

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_overview'])) {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    
    try {
        $conn->beginTransaction();
        
        // Update Text Fields
        $stmt = $conn->prepare("UPDATE site_overview SET title = ?, subtitle = ?, content = ? WHERE id = 1");
        $stmt->execute([$title, $subtitle, $content]);

        // Handle Image Upload
        if (isset($_FILES['overview_image']) && $_FILES['overview_image']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'png'];
            $filename = $_FILES['overview_image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_name = 'overview_' . time() . '.' . $ext;
                $upload_path = 'uploads/frontend/' . $new_name;
                $abs_upload_path = '../../' . $upload_path;
                
                if (!is_dir('../../uploads/frontend')) {
                    mkdir('../../uploads/frontend', 0777, true);
                }

                if (move_uploaded_file($_FILES['overview_image']['tmp_name'], $abs_upload_path)) {
                    $stmt = $conn->prepare("UPDATE site_overview SET image_path = ? WHERE id = 1");
                    $stmt->execute([$upload_path]);
                }
            }
        }
        
        $conn->commit();
        $success_msg = "Overview content updated successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

// Fetch Current Data
try {
    $overview = $conn->query("SELECT * FROM site_overview WHERE id = 1")->fetch();
    if (!$overview) {
        // Fallback or seed if table is empty
        $conn->query("INSERT INTO site_overview (id, title, subtitle, content, image_path) VALUES (1, 'Overview', '', '', '')");
        $overview = $conn->query("SELECT * FROM site_overview WHERE id = 1")->fetch();
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Site Overview</h1>
            <p style="color: #666;">Modify the main overview section content using the rich text editor.</p>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php#overview" target="_blank" class="view-site" style="text-decoration:none;">Preview Section</a>
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

    <!-- Summernote CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
        .mgmt-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d3748;
        }
        .input-box {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-family: inherit;
        }
        .btn-save {
            background: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 15px 40px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-save:hover {
            background: var(--dark-bg);
            transform: translateY(-2px);
        }
        .image-preview {
            width: 100%;
            max-width: 400px;
            height: 250px;
            border: 1px solid #edf2f7;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 10px;
            background: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>

    <form method="POST" enctype="multipart/form-data">
        <div class="mgmt-card">
            <div class="form-group">
                <label>Section Title</label>
                <input type="text" name="title" class="input-box" value="<?php echo htmlspecialchars($overview['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Section Subtitle / Headline</label>
                <input type="text" name="subtitle" class="input-box" value="<?php echo htmlspecialchars($overview['subtitle']); ?>" required>
            </div>

            <div class="form-group">
                <label>Main Content (Overview Details)</label>
                <textarea id="summernote" name="content"><?php echo $overview['content']; ?></textarea>
            </div>
        </div>

        <div class="mgmt-card">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div class="form-group">
                    <label>Overview Image</label>
                    <input type="file" name="overview_image" class="input-box" accept="image/*">
                    <p style="font-size: 12px; color: #718096; margin-top: 5px;">Best size: 800x600px or similar aspect ratio.</p>
                </div>
                <div>
                    <label>Current Image Preview</label>
                    <div class="image-preview">
                        <?php if ($overview['image_path']): ?>
                            <img src="<?php echo BASE_URL . $overview['image_path']; ?>" alt="Overview image">
                        <?php else: ?>
                            <span style="color: #a0aec0;">No image uploaded</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-bottom: 50px;">
            <button type="submit" name="update_overview" class="btn-save shadow">Update Overview Section</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 350,
            placeholder: 'Write the city overview details here...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

</body>
</html>
