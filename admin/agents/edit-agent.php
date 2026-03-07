<?php
/**
 * Edit Agent Details
 * Dholera Smart City Admin
 */
session_start();
require_once '../../database/db_config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$agent_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($agent_id <= 0) {
    header("Location: index.php");
    exit();
}

// Fetch existing data
try {
    $stmt = $conn->prepare("SELECT * FROM agents WHERE id = ?");
    $stmt->execute([$agent_id]);
    $agent = $stmt->fetch();
    if (!$agent) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Fetch All Active Projects
try {
    $all_projects_stmt = $conn->query("SELECT id, title FROM projects WHERE status = 'active' ORDER BY title ASC");
    $all_projects = $all_projects_stmt->fetchAll();

    // Fetch Currently Assigned Projects
    $assigned_stmt = $conn->prepare("SELECT project_id FROM agent_projects WHERE agent_id = ?");
    $assigned_stmt->execute([$agent_id]);
    $assigned_project_ids = $assigned_stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $all_projects = [];
    $assigned_project_ids = [];
}

$message = '';
$status = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $country = trim($_POST['country']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $pincode = trim($_POST['pincode']);
    $full_address = trim($_POST['full_address']);
    $password = $_POST['password'];
    $assigned_projects = isset($_POST['assigned_projects']) ? $_POST['assigned_projects'] : [];

    if (empty($full_name) || empty($email) || empty($mobile)) {
        $_SESSION['msg'] = ['status' => 'error', 'text' => 'Required fields are missing.'];
    } else {
        try {
            $check_stmt = $conn->prepare("SELECT id FROM agents WHERE (email = :email OR mobile = :mobile) AND id != :id");
            $check_stmt->execute(['email' => $email, 'mobile' => $mobile, 'id' => $agent_id]);
            if ($check_stmt->rowCount() > 0) {
                $_SESSION['msg'] = ['status' => 'error', 'text' => 'Email or Mobile already used by another agent.'];
            } else {
                $profile_image_path = $agent['profile_image'];
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                    $filename = $_FILES['profile_image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed)) {
                        $new_name = 'agent_' . time() . '.' . $ext;
                        $upload_dir = '../../uploads/agents/';
                        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $new_name)) {
                            if ($agent['profile_image'] && file_exists('../../' . $agent['profile_image'])) {
                                unlink('../../' . $agent['profile_image']);
                            }
                            $profile_image_path = 'uploads/agents/' . $new_name;
                        }
                    }
                }

                $query = "UPDATE agents SET 
                            full_name = :full_name, 
                            email = :email, 
                            mobile = :mobile, 
                            profile_image = :profile_image, 
                            country = :country, 
                            state = :state, 
                            city = :city, 
                            pincode = :pincode, 
                            full_address = :full_address";
                
                $params = [
                    'full_name' => $full_name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'profile_image' => $profile_image_path,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'pincode' => $pincode,
                    'full_address' => $full_address,
                    'id' => $agent_id
                ];

                if (!empty($password)) {
                    $query .= ", password = :password";
                    $params['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $query .= " WHERE id = :id";
                $stmt = $conn->prepare($query);
                $stmt->execute($params);

                // Sync Project Assignments
                // 1. Remove existing ones
                $del_stmt = $conn->prepare("DELETE FROM agent_projects WHERE agent_id = ?");
                $del_stmt->execute([$agent_id]);

                // 2. Add new ones
                if (!empty($assigned_projects)) {
                    $assign_stmt = $conn->prepare("INSERT INTO agent_projects (agent_id, project_id) VALUES (:agent_id, :project_id)");
                    foreach ($assigned_projects as $p_id) {
                        $assign_stmt->execute([
                            'agent_id' => $agent_id,
                            'project_id' => $p_id
                        ]);
                    }
                }

                $_SESSION['msg'] = ['status' => 'success', 'text' => 'Agent details and project assignments updated successfully!'];
                header("Location: edit-agent.php?id=" . $agent_id);
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['msg'] = ['status' => 'error', 'text' => 'Update Error: ' . $e->getMessage()];
        }
    }
}

if (isset($_SESSION['msg'])) {
    $status = $_SESSION['msg']['status'];
    $message = $_SESSION['msg']['text'];
    unset($_SESSION['msg']);
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Edit Agent Info</h1>
        <p style="color: #666;">Updating profile for <?php echo htmlspecialchars($agent['full_name']); ?>.</p>
    </div>

    <?php if ($message): ?>
        <div style="background-color: <?php echo $status === 'success' ? '#f0fff4' : '#fff5f5'; ?>; color: <?php echo $status === 'success' ? '#38a169' : '#c53030'; ?>; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid <?php echo $status === 'success' ? '#38a169' : '#c53030'; ?>;">
            <i class="fas <?php echo $status === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i> <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <style>
        .form-card {
            background: #fff;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .form-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 15px;
            color: #2d3748;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
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
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 15px;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold);
        }

        .btn-update {
            background-color: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-cancel {
            background-color: #f7fafc;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .img-preview-container {
            margin-top: 15px;
            width: 120px;
            height: 120px;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f7fafc;
        }

        .img-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <div class="form-card">
        <form action="edit-agent.php?id=<?php echo $agent_id; ?>" method="POST" enctype="multipart/form-data">
            <h2><i class="fas fa-id-card" style="color: var(--primary-gold);"></i> Personal & Account Info</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name <span style="color:red">*</span></label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($agent['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($agent['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Mobile Number <span style="color:red">*</span></label>
                    <input type="tel" name="mobile" class="form-control" value="<?php echo htmlspecialchars($agent['mobile']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Update Password (Leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control" placeholder="New secure password">
                </div>
                <div class="form-group">
                    <label>New Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="form-group">
                    <div class="img-preview-container">
                        <img id="imgPreview" src="<?php echo $agent['profile_image'] ? '../../'.$agent['profile_image'] : '../../assets/images/placeholder-user.png'; ?>" alt="Preview">
                    </div>
                </div>
            </div>

            <h2 style="margin-top: 20px;"><i class="fas fa-map-marker-alt" style="color: var(--primary-gold);"></i> Address & Location</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($agent['country']); ?>">
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($agent['state']); ?>">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($agent['city']); ?>">
                </div>
                <div class="form-group">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="<?php echo htmlspecialchars($agent['pincode']); ?>">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Full Residential Address</label>
                    <textarea name="full_address" class="form-control" rows="2"><?php echo htmlspecialchars($agent['full_address']); ?></textarea>
                </div>
            </div>

            <h2 style="margin-top: 20px;"><i class="fas fa-tasks" style="color: var(--primary-gold);"></i> Project Assignment</h2>
            <div class="form-grid">
                <div class="form-group" style="grid-column: span 3;">
                    <label>Assign Projects <span style="font-weight: normal; font-size: 12px; color: #718096;">(Hold Ctrl/Cmd to select multiple)</span></label>
                    <select name="assigned_projects[]" class="form-control" multiple style="height: 150px;">
                        <?php foreach ($all_projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>" <?php echo in_array($project['id'], $assigned_project_ids) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($project['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #edf2f7; padding-top: 30px;">
                <button type="submit" class="btn-update">Update Agent Account</button>
                <a href="index.php" class="btn-cancel">Back to Agents List</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
