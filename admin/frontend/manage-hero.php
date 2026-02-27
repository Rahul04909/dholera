<?php
/**
 * Manage Hero Slides
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

// Ensure upload directory exists
$upload_dir = "../../assets/hero/uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Add Slide
if (isset($_POST['add_slide'])) {
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $order_index = (int)$_POST['order_index'];

    if (isset($_FILES['slide_image']) && $_FILES['slide_image']['error'] == 0) {
        $file_name = $_FILES['slide_image']['name'];
        $file_tmp = $_FILES['slide_image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_ext, $allowed)) {
            $new_file_name = uniqid('hero_') . '.' . $file_ext;
            $target_file = $upload_dir . $new_file_name;
            $relative_path = "assets/hero/uploads/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_file)) {
                try {
                    $stmt = $conn->prepare("INSERT INTO hero_slides (title, subtitle, image_path, order_index) VALUES (:title, :subtitle, :image_path, :order_index)");
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':subtitle', $subtitle);
                    $stmt->bindParam(':image_path', $relative_path);
                    $stmt->bindParam(':order_index', $order_index);
                    $stmt->execute();
                    $success_msg = "Slide added successfully!";
                } catch (PDOException $e) {
                    $error_msg = "Database error: " . $e->getMessage();
                }
            } else {
                $error_msg = "Failed to upload image.";
            }
        } else {
            $error_msg = "Invalid file type. Only JPG, PNG, WEBP allowed.";
        }
    } else {
        $error_msg = "Please select an image.";
    }
}

// Handle Delete Slide
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        // Get image path to delete file
        $stmt = $conn->prepare("SELECT image_path FROM hero_slides WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $slide = $stmt->fetch();

        if ($slide) {
            $file_path = "../../" . $slide['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $del_stmt = $conn->prepare("DELETE FROM hero_slides WHERE id = :id");
            $del_stmt->bindParam(':id', $id);
            $del_stmt->execute();
            $success_msg = "Slide deleted successfully!";
        }
    } catch (PDOException $e) {
        $error_msg = "Error deleting slide: " . $e->getMessage();
    }
}

// Fetch existing slides
try {
    $stmt = $conn->query("SELECT * FROM hero_slides ORDER BY order_index ASC");
    $slides = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching slides: " . $e->getMessage());
}

// Reuse Admin Header
// Since this is in admin/frontend/ we need to be careful with header paths
// I'll define a variable to adjust paths in header if needed, or just rely on relative links
include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Manage Hero Slides</h1>
        <p style="color: #666;">Add or remove dynamic banners for the homepage slider.</p>
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
        .hero-admin-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .manage-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .manage-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-family: 'Outfit', sans-serif;
        }

        .upload-info {
            font-size: 12px;
            color: #718096;
            margin-top: 5px;
        }

        .btn-primary {
            background-color: var(--primary-gold, #b8860b);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }

        .slide-list-table {
            width: 100%;
            border-collapse: collapse;
        }

        .slide-list-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            color: #718096;
            font-size: 14px;
        }

        .slide-list-table td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
        }

        .thumb-img {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .btn-delete {
            color: #e53e3e;
            cursor: pointer;
            text-decoration: none;
            font-size: 18px;
        }

        @media (max-width: 992px) {
            .hero-admin-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="hero-admin-grid">
        <!-- Add Form -->
        <div class="manage-card">
            <h2>Add New Slide</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Slide Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Dholera Smart City">
                </div>
                <div class="form-group">
                    <label>Slide Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" placeholder="e.g., India's First Platinum Rated Smart City">
                </div>
                <div class="form-group">
                    <label>Order Index</label>
                    <input type="number" name="order_index" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <label>Slide Image</label>
                    <input type="file" name="slide_image" class="form-control" accept="image/*" required>
                    <p class="upload-info">Recommended size: 1920x1080px (Max 2MB)</p>
                </div>
                <button type="submit" name="add_slide" class="btn-primary">Add Slide</button>
            </form>
        </div>

        <!-- List -->
        <div class="manage-card">
            <h2>Existing Slides</h2>
            <div style="overflow-x: auto;">
                <table class="slide-list-table">
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Details</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($slides) > 0): ?>
                            <?php foreach ($slides as $slide): ?>
                                <tr>
                                    <td>
                                        <img src="../../<?php echo htmlspecialchars($slide['image_path']); ?>" class="thumb-img">
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;"><?php echo htmlspecialchars($slide['title']); ?></div>
                                        <div style="font-size: 13px; color: #718096;"><?php echo htmlspecialchars($slide['subtitle']); ?></div>
                                    </td>
                                    <td><?php echo $slide['order_index']; ?></td>
                                    <td>
                                        <a href="?delete=<?php echo $slide['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this slide?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: #718096; padding: 40px;">No slides added yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
