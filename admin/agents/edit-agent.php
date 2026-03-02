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
    $password = $_POST['password']; // New password if changing

    if (empty($full_name) || empty($email) || empty($mobile)) {
        $_SESSION['msg'] = ['status' => 'error', 'text' => 'Required fields are missing.'];
    } else {
        try {
            // Check for duplicates (excluding current agent)
            $check_stmt = $conn->prepare("SELECT id FROM agents WHERE (email = :email OR mobile = :mobile) AND id != :id");
            $check_stmt->execute(['email' => $email, 'mobile' => $mobile, 'id' => $agent_id]);
            if ($check_stmt->rowCount() > 0) {
                $_SESSION['msg'] = ['status' => 'error', 'text' => 'Email or Mobile already used by another agent.'];
            } else {
                // Update Logic
                $profile_image_path = $agent['profile_image'];
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                    $filename = $_FILES['profile_image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed)) {
                        $new_name = 'agent_' . time() . '.' . $ext;
                        $upload_dir = '../../uploads/agents/';
                        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $new_name)) {
                            // Delete old image
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

                // Update password if provided
                if (!empty($password)) {
                    $query .= ", password = :password";
                    $params['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $query .= " WHERE id = :id";
                $stmt = $conn->prepare($query);
                $stmt->execute($params);

                $_SESSION['msg'] = ['status' => 'success', 'text' => 'Agent details updated successfully!'];
                header("Location: edit-agent.php?id=" . $agent_id);
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['msg'] = ['status' => 'error', 'text' => 'Update Error: ' . $e->getMessage()];
        }
    }
}

// Get message from session if redirected
if (isset($_SESSION['msg'])) {
    $status = $_SESSION['msg']['status'];
    $message = $_SESSION['msg']['text'];
    unset($_SESSION['msg']);
}

include '../includes/header.php';
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Edit Agent Details</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Agents</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Agent</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-headers">
                        <h4 class="card-title p-4">Modify Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if($message): ?>
                            <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                                <?php echo $message; ?>
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        <?php endif; ?>

                        <div class="basic-form">
                            <form action="edit-agent.php?id=<?php echo $agent_id; ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($agent['full_name']); ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($agent['email']); ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="mobile" class="form-control" value="<?php echo htmlspecialchars($agent['mobile']); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Profile Image (Leave blank to keep current)</label>
                                        <div class="custom-file">
                                            <input type="file" name="profile_image" class="custom-file-input" id="imgInput" accept="image/*" onchange="previewImage(this)">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <div class="mt-3">
                                            <img id="imgPreview" src="<?php echo $agent['profile_image'] ? '../../'.$agent['profile_image'] : '../../assets/images/placeholder-user.png'; ?>" alt="Preview" style="max-width: 150px; border-radius: 10px; border: 1px solid #ddd; padding: 5px;">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>New Password (Leave blank to keep old password)</label>
                                        <input type="password" name="password" class="form-control" placeholder="Update Password">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($agent['country']); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($agent['state']); ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($agent['city']); ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" class="form-control" value="<?php echo htmlspecialchars($agent['pincode']); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Full Address</label>
                                    <textarea name="full_address" class="form-control" rows="3"><?php echo htmlspecialchars($agent['full_address']); ?></textarea>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary px-5">Update Agent</button>
                                    <a href="index.php" class="btn btn-light ml-2">Back to List</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
            
            // Update label
            let fileName = input.files[0].name;
            input.nextElementSibling.innerText = fileName;
        }
    }
</script>

<?php include '../footer.php'; ?>
