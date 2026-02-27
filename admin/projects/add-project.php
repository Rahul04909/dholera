<?php
/**
 * Add New Project
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_project'])) {
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

    try {
        $conn->beginTransaction();

        // Handle Main File Uploads
        $featured_image = "";
        if (!empty($_FILES['featured_image']['name'])) {
            $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $featured_image = "uploads/projects/" . time() . "_feat." . $ext;
            move_uploaded_file($_FILES['featured_image']['tmp_name'], "../../" . $featured_image);
        }

        $brochure_pdf = "";
        if (!empty($_FILES['brochure_pdf']['name'])) {
            $ext = pathinfo($_FILES['brochure_pdf']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'pdf') {
                $brochure_pdf = "uploads/projects/brochures/" . time() . "_brochure." . $ext;
                move_uploaded_file($_FILES['brochure_pdf']['tmp_name'], "../../" . $brochure_pdf);
            }
        }

        $site_plan_image = "";
        if (!empty($_FILES['site_plan_image']['name'])) {
            $ext = pathinfo($_FILES['site_plan_image']['name'], PATHINFO_EXTENSION);
            $site_plan_image = "uploads/projects/" . time() . "_plan." . $ext;
            move_uploaded_file($_FILES['site_plan_image']['tmp_name'], "../../" . $site_plan_image);
        }

        // Insert Project
        $stmt = $conn->prepare("INSERT INTO projects (title, label, project_type, legitimate, location, google_map_url, about_project, featured_image, brochure_pdf, site_plan_image, plot_size_from, plot_size_to, total_units, price_range) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $label, $project_type, $legitimate, $location, $google_map_url, $about_project, $featured_image, $brochure_pdf, $site_plan_image, $plot_size_from, $plot_size_to, $total_units, $price_range]);
        
        $project_id = $conn->lastInsertId();

        // Handle Project Slides (Multiple)
        if (!empty($_FILES['project_slides']['name'][0])) {
            foreach ($_FILES['project_slides']['tmp_name'] as $key => $tmp_name) {
                $ext = pathinfo($_FILES['project_slides']['name'][$key], PATHINFO_EXTENSION);
                $slide_path = "uploads/projects/slides/" . time() . "_slide_$key." . $ext;
                if (move_uploaded_file($tmp_name, "../../" . $slide_path)) {
                    $conn->prepare("INSERT INTO project_slides (project_id, image_path, order_index) VALUES (?, ?, ?)")->execute([$project_id, $slide_path, $key]);
                }
            }
        }

        // Handle Amenities (Dynamic)
        if (isset($_POST['amenity_name'])) {
            foreach ($_POST['amenity_name'] as $key => $name) {
                if (!empty($name)) {
                    $icon_type = 'icon_class';
                    $icon_path = $_POST['amenity_icon'][$key] ?? '';
                    
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

        // Handle Nearbys
        if (isset($_POST['nearby_name'])) {
            foreach ($_POST['nearby_name'] as $key => $name) {
                if (!empty($name)) {
                    $distance = $_POST['nearby_distance'][$key] ?? '';
                    $conn->prepare("INSERT INTO project_nearbys (project_id, name, distance) VALUES (?, ?, ?)")->execute([$project_id, $name, $distance]);
                }
            }
        }

        $conn->commit();
        $success_msg = "Project added successfully!";
    } catch (Exception $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="margin-bottom: 30px;">
        <a href="index.php" style="color: var(--primary-gold); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Projects</a>
        <h1 style="font-size: 28px; font-weight: 700; margin-top: 10px;">Add New Project</h1>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <!-- Load Summernote Assets From Vendor -->
    <link href="../../vendor/summernote/summernote-lite.min.css" rel="stylesheet">
    <script src="../../vendor/summernote/summernote-lite.min.js"></script>

    <form method="POST" enctype="multipart/form-data" class="add-project-form">
        <style>
            .form-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
            .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f7fafc; padding-bottom: 10px; color: #2d3748; display: flex; align-items: center; gap: 10px; }
            .section-title i { color: var(--primary-gold); }
            .grid-form { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
            .form-group { margin-bottom: 20px; }
            .form-group.full { grid-column: span 3; }
            label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #4a5568; }
            .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; outline: none; }
            .dynamic-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 10px; align-items: end; }
            .add-btn { background: #edf2f7; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600; margin-top: 10px; }
            .save-btn { background: var(--primary-gold); color: #fff; border: none; padding: 15px 40px; border-radius: 4px; font-size: 16px; font-weight: 700; cursor: pointer; float: right; margin-top: 20px; }
        </style>

        <!-- Basic Details -->
        <div class="form-card">
            <div class="section-title"><i class="fas fa-info-circle"></i> Basic Information</div>
            <div class="grid-form">
                <div class="form-group full">
                    <label>Project Title</label>
                    <input type="text" name="title" class="input-box" placeholder="e.g., Dholera Smart Enclave" required>
                </div>
                <div class="form-group">
                    <label>Project Label</label>
                    <input type="text" name="label" class="input-box" placeholder="e.g., Luxury Living">
                </div>
                <div class="form-group">
                    <label>Project Type</label>
                    <input type="text" name="project_type" class="input-box" placeholder="e.g., Residential Plots">
                </div>
                <div class="form-group">
                    <label>Legitimate</label>
                    <input type="text" name="legitimate" class="input-box" placeholder="e.g., RERA Approved">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="input-box" placeholder="e.g., Dholera, Gujarat">
                </div>
                <div class="form-group full">
                    <label>Google Map URL</label>
                    <input type="url" name="google_map_url" class="input-box" placeholder="Paste embed or link URL">
                </div>
                <div class="form-group full">
                    <label>About Project</label>
                    <textarea id="summernote" name="about_project"></textarea>
                </div>
            </div>
        </div>

        <!-- Files & Assets -->
        <div class="form-card">
            <div class="section-title"><i class="fas fa-file-upload"></i> Project Assets</div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Featured Image</label>
                    <input type="file" name="featured_image" class="input-box" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>Project Brochure (PDF, Max 50MB)</label>
                    <input type="file" name="brochure_pdf" class="input-box" accept="application/pdf">
                </div>
                <div class="form-group">
                    <label>Site Plan Image</label>
                    <input type="file" name="site_plan_image" class="input-box" accept="image/*">
                </div>
                <div class="form-group full">
                    <label>Project Gallery Slides (Multiple Images)</label>
                    <input type="file" name="project_slides[]" class="input-box" accept="image/*" multiple>
                </div>
            </div>
        </div>

        <!-- Stats & Pricing -->
        <div class="form-card">
            <div class="section-title"><i class="fas fa-chart-bar"></i> Specifications & Pricing</div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Plot Size From (Sq. Ft.)</label>
                    <input type="text" name="plot_size_from" class="input-box" placeholder="e.g., 1500">
                </div>
                <div class="form-group">
                    <label>Plot Size To (Sq. Ft.)</label>
                    <input type="text" name="plot_size_to" class="input-box" placeholder="e.g., 5000">
                </div>
                <div class="form-group">
                    <label>Total Units</label>
                    <input type="text" name="total_units" class="input-box" placeholder="e.g., 200 Units">
                </div>
                <div class="form-group">
                    <label>Price Range (INR)</label>
                    <input type="text" name="price_range" class="input-box" placeholder="e.g., 15L - 45L">
                </div>
            </div>
        </div>

        <!-- Dynamic Amenities & Nearbys -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div class="form-card">
                <div class="section-title"><i class="fas fa-concierge-bell"></i> Amenities</div>
                <div id="amenity-container">
                    <div class="dynamic-row">
                        <div style="flex:1">
                            <label>Amenity Name</label>
                            <input type="text" name="amenity_name[]" class="input-box" placeholder="Club House">
                        </div>
                        <div style="flex:1">
                            <label>Icon Class / Upload</label>
                            <input type="text" name="amenity_icon[]" class="input-box" placeholder="fas fa-home">
                        </div>
                        <button type="button" class="btn-delete" style="border:none; background:none; padding-bottom:12px;"><i class="fas fa-times-circle"></i></button>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="addAmenityRow()"><i class="fas fa-plus"></i> Add Amenity</button>
            </div>

            <div class="form-card">
                <div class="section-title"><i class="fas fa-map-marked-alt"></i> Nearby Places</div>
                <div id="nearby-container">
                    <div class="dynamic-row">
                        <div style="flex:1">
                            <label>Place Name</label>
                            <input type="text" name="nearby_name[]" class="input-box" placeholder="Airport">
                        </div>
                        <div style="flex:1">
                            <label>Distance</label>
                            <input type="text" name="nearby_distance[]" class="input-box" placeholder="10 Mins">
                        </div>
                        <button type="button" class="btn-delete" style="border:none; background:none; padding-bottom:12px;"><i class="fas fa-times-circle"></i></button>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="addNearbyRow()"><i class="fas fa-plus"></i> Add Nearby</button>
            </div>
        </div>

        <button type="submit" name="add_project" class="save-btn shadow">Save Project</button>
        <div style="clear:both;"></div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            placeholder: 'Tell us more about this project...',
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
                <div style="flex:1"><input type="text" name="amenity_name[]" class="input-box" placeholder="Name"></div>
                <div style="flex:1"><input type="text" name="amenity_icon[]" class="input-box" placeholder="Icon Class"></div>
                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px;"><i class="fas fa-times-circle"></i></button>
            </div>
        `);
    }

    function addNearbyRow() {
        $('#nearby-container').append(`
            <div class="dynamic-row">
                <div style="flex:1"><input type="text" name="nearby_name[]" class="input-box" placeholder="Place"></div>
                <div style="flex:1"><input type="text" name="nearby_distance[]" class="input-box" placeholder="Distance"></div>
                <button type="button" class="btn-delete" onclick="$(this).parent().remove()" style="border:none; background:none; padding-bottom:12px;"><i class="fas fa-times-circle"></i></button>
            </div>
        `);
    }
</script>

</body>
</html>
