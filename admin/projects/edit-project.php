<?php
/**
 * Edit Project
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$project_id = (int)$_GET['id'];
$success_msg = "";
$error_msg = "";

// Fetch Project Data
try {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
    
    if (!$project) die("Project not found.");

    // Fetch Slides
    $slides = $conn->prepare("SELECT * FROM project_slides WHERE project_id = ? ORDER BY order_index ASC");
    $slides->execute([$project_id]);
    $current_slides = $slides->fetchAll();

    // Fetch Amenities
    $amen_stmt = $conn->prepare("SELECT * FROM project_amenities WHERE project_id = ?");
    $amen_stmt->execute([$project_id]);
    $current_amenities = $amen_stmt->fetchAll();

    // Fetch Nearbys
    $near_stmt = $conn->prepare("SELECT * FROM project_nearbys WHERE project_id = ?");
    $near_stmt->execute([$project_id]);
    $current_nearbys = $near_stmt->fetchAll();

} catch (PDOException $e) {
    die($e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_project'])) {
    // Logic similar to add-project but with UPDATE and file cleanup...
    // For brevity in first pass, implementing core fields
    $title = $_POST['title'];
    $label = $_POST['label'];
    $price = $_POST['price_range'];
    $about = $_POST['about_project'];

    try {
        $stmt = $conn->prepare("UPDATE projects SET title = ?, label = ?, price_range = ?, about_project = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $label, $price, $about, $_POST['status'], $project_id]);
        $success_msg = "Project updated successfully!";
        // Refresh data
        $project['title'] = $title;
        $project['label'] = $label;
        $project['price_range'] = $price;
        $project['about_project'] = $about;
        $project['status'] = $_POST['status'];
    } catch (Exception $e) { $error_msg = $e->getMessage(); }
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <a href="index.php" style="color: var(--primary-gold); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Projects</a>
        <h1 style="font-size: 28px; font-weight: 700; margin-top: 10px;">Edit Project: <?php echo htmlspecialchars($project['title']); ?></h1>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $success_msg; ?></div>
    <?php endif; ?>

    <link href="../../vendor/summernote/summernote/dist/summernote-lite.css" rel="stylesheet">
    <script src="../../vendor/summernote/summernote/dist/summernote-lite.js"></script>

    <form method="POST" enctype="multipart/form-data">
        <style>
            .form-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
            .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f7fafc; padding-bottom: 10px; }
            .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; }
            .save-btn { background: var(--primary-gold); color: #fff; border: none; padding: 15px 40px; border-radius: 4px; font-weight: 700; cursor: pointer; float: right; }
        </style>

        <div class="form-card">
            <div class="section-title">Quick Edit</div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="input-box" value="<?php echo htmlspecialchars($project['title']); ?>">
                </div>
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="label" class="input-box" value="<?php echo htmlspecialchars($project['label']); ?>">
                </div>
                <div class="form-group">
                    <label>Price Range</label>
                    <input type="text" name="price_range" class="input-box" value="<?php echo htmlspecialchars($project['price_range']); ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="input-box">
                        <option value="active" <?php if($project['status']=='active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if($project['status']=='inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:20px;">
                <label>About Project</label>
                <textarea id="summernote" name="about_project"><?php echo $project['about_project']; ?></textarea>
            </div>
        </div>

        <button type="submit" name="update_project" class="save-btn">Update Project</button>
        <div style="clear:both;"></div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({ height: 300 });
    });
</script>
</body>
</html>
