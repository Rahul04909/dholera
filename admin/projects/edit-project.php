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

// Handle Slide Deletion
if (isset($_GET['delete_slide'])) {
    $slide_id = (int)$_GET['delete_slide'];
    try {
        $slide_stmt = $conn->prepare("SELECT image_path FROM project_slides WHERE id = ? AND project_id = ?");
        $slide_stmt->execute([$slide_id, $project_id]);
        $slide_data = $slide_stmt->fetch();
        if ($slide_data) {
            if (file_exists("../../" . $slide_data['image_path'])) {
                unlink("../../" . $slide_data['image_path']);
            }
            $conn->prepare("DELETE FROM project_slides WHERE id = ?")->execute([$slide_id]);
            $success_msg = "Slide deleted successfully!";
        }
    } catch (PDOException $e) {
        $error_msg = "Error deleting slide: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_project'])) {
    $title = $_POST['title'];
    $label = $_POST['label'];
    $project_type = $_POST['project_type'];
    $legitimate = $_POST['legitimate'];
    $location = $_POST['location'];
    $google_map_url = $_POST['google_map_url'];
    $about_project = $_POST['about_project'];
    $plot_size_from = $_POST['plot_size_from'];
    $plot_size_to = $_POST['plot_size_to'];
    $total_units = $_POST['total_units'];
    $price_range = $_POST['price_range'];
    $status = $_POST['status'];

    try {
        $conn->beginTransaction();

        // Update Main Fields
        $stmt = $conn->prepare("UPDATE projects SET title = ?, label = ?, project_type = ?, legitimate = ?, location = ?, google_map_url = ?, about_project = ?, plot_size_from = ?, plot_size_to = ?, total_units = ?, price_range = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $label, $project_type, $legitimate, $location, $google_map_url, $about_project, $plot_size_from, $plot_size_to, $total_units, $price_range, $status, $project_id]);

        // Handle File Updates
        if (!empty($_FILES['featured_image']['name'])) {
            $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $featured_image = "uploads/projects/" . time() . "_feat." . $ext;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], "../../" . $featured_image)) {
                $conn->prepare("UPDATE projects SET featured_image = ? WHERE id = ?")->execute([$featured_image, $project_id]);
            }
        }

        if (!empty($_FILES['brochure_pdf']['name'])) {
            $ext = pathinfo($_FILES['brochure_pdf']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'pdf') {
                $brochure_pdf = "uploads/projects/brochures/" . time() . "_brochure." . $ext;
                if (move_uploaded_file($_FILES['brochure_pdf']['tmp_name'], "../../" . $brochure_pdf)) {
                    $conn->prepare("UPDATE projects SET brochure_pdf = ? WHERE id = ?")->execute([$brochure_pdf, $project_id]);
                }
            }
        }

        if (!empty($_FILES['site_plan_image']['name'])) {
            $ext = pathinfo($_FILES['site_plan_image']['name'], PATHINFO_EXTENSION);
            $site_plan_image = "uploads/projects/" . time() . "_plan." . $ext;
            if (move_uploaded_file($_FILES['site_plan_image']['tmp_name'], "../../" . $site_plan_image)) {
                $conn->prepare("UPDATE projects SET site_plan_image = ? WHERE id = ?")->execute([$site_plan_image, $project_id]);
            }
        }

        // Handle Project Slides (Append new ones)
        if (!empty($_FILES['project_slides']['name'][0])) {
            foreach ($_FILES['project_slides']['tmp_name'] as $key => $tmp_name) {
                if (!empty($tmp_name)) {
                    $ext = pathinfo($_FILES['project_slides']['name'][$key], PATHINFO_EXTENSION);
                    $slide_path = "uploads/projects/slides/" . time() . "_slide_$key." . $ext;
                    if (move_uploaded_file($tmp_name, "../../" . $slide_path)) {
                        $conn->prepare("INSERT INTO project_slides (project_id, image_path, order_index) VALUES (?, ?, ?)")->execute([$project_id, $slide_path, 100]);
                    }
                }
            }
        }

        // Handle Amenities (Re-sync)
        if (isset($_POST['amenity_name'])) {
            // First clear existing - but we need to track images to not lose them if not re-uploaded
            // For simplicity in re-sync, we usually delete all and re-insert. 
            // Better: get existing icon_paths first.
            $stmt_old = $conn->prepare("SELECT name, icon_path FROM project_amenities WHERE project_id = ?");
            $stmt_old->execute([$project_id]);
            $old_amenities = $stmt_old->fetchAll(PDO::FETCH_KEY_PAIR);

            $conn->prepare("DELETE FROM project_amenities WHERE project_id = ?")->execute([$project_id]);
            
            foreach ($_POST['amenity_name'] as $key => $name) {
                if (!empty($name)) {
                    $icon_path = $_POST['existing_amenity_icon'][$key] ?? '';
                    $icon_type = 'icon_class';
                    if (!empty($icon_path)) $icon_type = 'image';

                    if (!empty($_FILES['amenity_image']['name'][$key])) {
                        $ext = pathinfo($_FILES['amenity_image']['name'][$key], PATHINFO_EXTENSION);
                        $icon_path = "uploads/projects/amenities/" . time() . "_amenity_$key." . $ext;
                        move_uploaded_file($_FILES['amenity_image']['tmp_name'][$key], "../../" . $icon_path);
                        $icon_type = 'image';
                    }
                    
                    $conn->prepare("INSERT INTO project_amenities (project_id, name, icon_path, icon_type) VALUES (?, ?, ?, ?)")->execute([$project_id, $name, $icon_path, $icon_type]);
                }
            }
        }

        // Handle Nearbys (Re-sync)
        if (isset($_POST['nearby_name'])) {
            $conn->prepare("DELETE FROM project_nearbys WHERE project_id = ?")->execute([$project_id]);
            foreach ($_POST['nearby_name'] as $key => $name) {
                if (!empty($name)) {
                    $distance = $_POST['nearby_distance'][$key] ?? '';
                    $conn->prepare("INSERT INTO project_nearbys (project_id, name, distance) VALUES (?, ?, ?)")->execute([$project_id, $name, $distance]);
                }
            }
        }

        $conn->commit();
        $success_msg = "Project updated successfully!";
        
        // Refresh project data
        $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);
        $project = $stmt->fetch();

        // Refresh Amenities & Nearbys
        $amen_stmt = $conn->prepare("SELECT * FROM project_amenities WHERE project_id = ?");
        $amen_stmt->execute([$project_id]);
        $current_amenities = $amen_stmt->fetchAll();

        $near_stmt = $conn->prepare("SELECT * FROM project_nearbys WHERE project_id = ?");
        $near_stmt->execute([$project_id]);
        $current_nearbys = $near_stmt->fetchAll();

        $slides = $conn->prepare("SELECT * FROM project_slides WHERE project_id = ? ORDER BY order_index ASC");
        $slides->execute([$project_id]);
        $current_slides = $slides->fetchAll();

    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $error_msg = "Error: " . $e->getMessage();
    }
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
    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <form method="POST" enctype="multipart/form-data">
        <style>
            .form-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
            .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f7fafc; padding-bottom: 10px; }
            .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; }
            .save-btn { background: var(--primary-gold); color: #fff; border: none; padding: 15px 40px; border-radius: 4px; font-weight: 700; cursor: pointer; float: right; }
        </style>

        <div class="form-card">
            <div class="section-title">Project Details</div>
            <div class="grid-form">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Title</label>
                    <input type="text" name="title" class="input-box" value="<?php echo htmlspecialchars($project['title']); ?>">
                </div>
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="label" class="input-box" value="<?php echo htmlspecialchars($project['label']); ?>">
                </div>
                <div class="form-group">
                    <label>Project Type</label>
                    <input type="text" name="project_type" class="input-box" value="<?php echo htmlspecialchars($project['project_type']); ?>">
                </div>
                <div class="form-group">
                    <label>Legitimate</label>
                    <input type="text" name="legitimate" class="input-box" value="<?php echo htmlspecialchars($project['legitimate']); ?>">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="input-box" value="<?php echo htmlspecialchars($project['location']); ?>">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Google Map URL</label>
                    <input type="url" name="google_map_url" class="input-box" value="<?php echo htmlspecialchars($project['google_map_url']); ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="input-box">
                        <option value="active" <?php if($project['status']=='active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if($project['status']=='inactive') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Plot Size From</label>
                    <input type="text" name="plot_size_from" class="input-box" value="<?php echo htmlspecialchars($project['plot_size_from']); ?>">
                </div>
                <div class="form-group">
                    <label>Plot Size To</label>
                    <input type="text" name="plot_size_to" class="input-box" value="<?php echo htmlspecialchars($project['plot_size_to']); ?>">
                </div>
                <div class="form-group">
                    <label>Total Units</label>
                    <input type="text" name="total_units" class="input-box" value="<?php echo htmlspecialchars($project['total_units']); ?>">
                </div>
                <div class="form-group">
                    <label>Price Range</label>
                    <input type="text" name="price_range" class="input-box" value="<?php echo htmlspecialchars($project['price_range']); ?>">
                </div>
            </div>

            <div style="margin-top:20px;">
                <label>About Project</label>
                <textarea id="summernote" name="about_project"><?php echo $project['about_project']; ?></textarea>
            </div>
        </div>

        <div class="form-card">
            <div class="section-title">Project Assets</div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Featured Image</label>
                    <?php if($project['featured_image']): ?>
                        <img src="<?php echo BASE_URL . $project['featured_image']; ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; border: 1px solid #eee;">
                    <?php endif; ?>
                    <input type="file" name="featured_image" class="input-box" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Site Plan Image</label>
                    <?php if($project['site_plan_image']): ?>
                        <img src="<?php echo BASE_URL . $project['site_plan_image']; ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; border: 1px solid #eee;">
                    <?php endif; ?>
                    <input type="file" name="site_plan_image" class="input-box" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Brochure (PDF)</label>
                    <?php if($project['brochure_pdf']): ?>
                        <div style="padding: 10px; background: #f7fafc; border-radius: 4px; margin-bottom: 10px; font-size: 13px;">
                            <i class="fas fa-file-pdf" style="color: #e53e3e;"></i> Current: <?php echo basename($project['brochure_pdf']); ?>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="brochure_pdf" class="input-box" accept="application/pdf">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Manage Gallery Slides</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <?php foreach($current_slides as $slide): ?>
                            <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #edf2f7; background: #fff;">
                                <img src="<?php echo BASE_URL . $slide['image_path']; ?>" style="width: 100%; height: 100px; object-fit: cover;">
                                <a href="?id=<?php echo $project_id; ?>&delete_slide=<?php echo $slide['id']; ?>" onclick="return confirm('Delete this slide?')" style="position: absolute; top: 5px; right: 5px; background: rgba(229, 62, 62, 0.9); color: #fff; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none;">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <?php if(empty($current_slides)): ?>
                            <p style="font-size: 13px; color: #a0aec0; grid-column: 1/-1; text-align: center;">No slides uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Add More Gallery Slides</label>
                    <input type="file" name="project_slides[]" class="input-box" accept="image/*" multiple>
                </div>
            </div>
        </div>

        <!-- Dynamic Amenities & Nearbys -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div class="form-card">
                <div class="section-title"><i class="fas fa-concierge-bell"></i> Amenities</div>
                <div id="amenity-container">
                    <?php if (!empty($current_amenities)): ?>
                        <?php foreach ($current_amenities as $key => $amenity): ?>
                            <div class="dynamic-row">
                                <div style="flex:1">
                                    <label>Amenity Name</label>
                                    <input type="text" name="amenity_name[]" class="input-box" value="<?php echo htmlspecialchars($amenity['name']); ?>">
                                </div>
                                <div style="flex:1">
                                    <label>Icon Image</label>
                                    <?php if($amenity['icon_type'] == 'image' && $amenity['icon_path']): ?>
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                            <img src="<?php echo BASE_URL . $amenity['icon_path']; ?>" style="width: 30px; height: 30px; object-fit: contain;">
                                            <input type="hidden" name="existing_amenity_icon[]" value="<?php echo $amenity['icon_path']; ?>">
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="existing_amenity_icon[]" value="">
                                    <?php endif; ?>
                                    <input type="file" name="amenity_image[]" class="input-box" accept="image/*">
                                </div>
                                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="dynamic-row">
                            <div style="flex:1">
                                <label>Amenity Name</label>
                                <input type="text" name="amenity_name[]" class="input-box" placeholder="Club House">
                            </div>
                            <div style="flex:1">
                                <label>Amenity Icon Image</label>
                                <input type="file" name="amenity_image[]" class="input-box" accept="image/*">
                                <input type="hidden" name="existing_amenity_icon[]" value="">
                            </div>
                            <button type="button" class="btn-delete" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-btn" onclick="addAmenityRow()"><i class="fas fa-plus"></i> Add Amenity</button>
            </div>

            <div class="form-card">
                <div class="section-title"><i class="fas fa-map-marked-alt"></i> Nearby Places</div>
                <div id="nearby-container">
                    <?php if (!empty($current_nearbys)): ?>
                        <?php foreach ($current_nearbys as $nearby): ?>
                            <div class="dynamic-row">
                                <div style="flex:1">
                                    <label>Place Name</label>
                                    <input type="text" name="nearby_name[]" class="input-box" value="<?php echo htmlspecialchars($nearby['name']); ?>">
                                </div>
                                <div style="flex:1">
                                    <label>Distance</label>
                                    <input type="text" name="nearby_distance[]" class="input-box" value="<?php echo htmlspecialchars($nearby['distance']); ?>">
                                </div>
                                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="dynamic-row">
                            <div style="flex:1">
                                <label>Place Name</label>
                                <input type="text" name="nearby_name[]" class="input-box" placeholder="Airport">
                            </div>
                            <div style="flex:1">
                                <label>Distance</label>
                                <input type="text" name="nearby_distance[]" class="input-box" placeholder="10 Mins">
                            </div>
                            <button type="button" class="btn-delete" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-btn" onclick="addNearbyRow()"><i class="fas fa-plus"></i> Add Nearby</button>
            </div>
        </div>

        <button type="submit" name="update_project" class="save-btn">Update Project</button>
        <div style="clear:both;"></div>
    </form>
</div>

<style>
    .dynamic-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 15px; align-items: end; }
    .add-btn { background: #edf2f7; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600; margin-top: 10px; }
    .save-btn { background: var(--primary-gold); color: #fff; border: none; padding: 15px 40px; border-radius: 4px; font-weight: 700; cursor: pointer; float: right; margin-top: 20px; transition: 0.3s; }
    .save-btn:hover { background: #966d09; }
    .input-box:focus { border-color: var(--primary-gold); outline: none; }
    .btn-delete:hover i { color: #c53030 !important; }
</style>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
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

    function addAmenityRow() {
        $('#amenity-container').append(`
            <div class="dynamic-row">
                <div style="flex:1"><input type="text" name="amenity_name[]" class="input-box" placeholder="Amenity Name"></div>
                <div style="flex:1">
                    <input type="file" name="amenity_image[]" class="input-box" accept="image/*">
                    <input type="hidden" name="existing_amenity_icon[]" value="">
                </div>
                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
            </div>
        `);
    }

    function addNearbyRow() {
        $('#nearby-container').append(`
            <div class="dynamic-row">
                <div style="flex:1"><input type="text" name="nearby_name[]" class="input-box" placeholder="Place"></div>
                <div style="flex:1"><input type="text" name="nearby_distance[]" class="input-box" placeholder="Distance"></div>
                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px; cursor: pointer;"><i class="fas fa-times-circle" style="color: #e53e3e;"></i></button>
            </div>
        `);
    }
</script>
</body>
</html>
