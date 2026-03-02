<?php
/**
 * Add New Agent
 * Dholera Smart City Admin
 */
session_start();
require_once '../../database/db_config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$message = '';
$status = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $country = trim($_POST['country'] ?: 'India');
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $pincode = trim($_POST['pincode']);
    $full_address = trim($_POST['full_address']);
    $password = $_POST['password'];

    // Validation
    if (empty($full_name) || empty($email) || empty($mobile) || empty($password)) {
        $_SESSION['msg'] = ['status' => 'error', 'text' => 'Required fields are missing.'];
    } else {
        try {
            // Check for duplicates
            $check_stmt = $conn->prepare("SELECT id FROM agents WHERE email = :email OR mobile = :mobile");
            $check_stmt->execute(['email' => $email, 'mobile' => $mobile]);
            if ($check_stmt->rowCount() > 0) {
                $_SESSION['msg'] = ['status' => 'error', 'text' => 'Agent with this email or mobile already exists.'];
            } else {
                // Handle Profile Image Upload
                $profile_image_path = '';
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                    $filename = $_FILES['profile_image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed)) {
                        $new_name = 'agent_' . time() . '.' . $ext;
                        $upload_dir = '../../uploads/agents/';
                        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $new_name)) {
                            $profile_image_path = 'uploads/agents/' . $new_name;
                        }
                    }
                }

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO agents (full_name, email, mobile, profile_image, country, state, city, pincode, full_address, password) 
                                        VALUES (:full_name, :email, :mobile, :profile_image, :country, :state, :city, :pincode, :full_address, :password)");
                
                $stmt->execute([
                    'full_name' => $full_name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'profile_image' => $profile_image_path,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'pincode' => $pincode,
                    'full_address' => $full_address,
                    'password' => $hashed_password
                ]);

                $_SESSION['msg'] = ['status' => 'success', 'text' => 'Agent created successfully!'];
                // PRG Pattern: Redirect to prevent duplicates on refresh
                header("Location: add-agent.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['msg'] = ['status' => 'error', 'text' => 'Internal Error: ' . $e->getMessage()];
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
                    <h4>Add New Agent</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Agents</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Agent</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Agent Details</h4>
                    </div>
                    <div class="card-body">
                        <?php if($message): ?>
                            <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                                <?php echo $message; ?>
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        <?php endif; ?>

                        <div class="basic-form">
                            <form action="add-agent.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="mobile" class="form-control" placeholder="Enter Mobile" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Profile Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="profile_image" class="custom-file-input" id="imgInput" accept="image/*" onchange="previewImage(this)">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <div class="mt-3">
                                            <img id="imgPreview" src="../../assets/images/placeholder-user.png" alt="Preview" style="max-width: 150px; border-radius: 10px; display: none; border: 1px solid #ddd; padding: 5px;">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" placeholder="Create Password" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control" value="India">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" placeholder="Enter State">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" class="form-control" placeholder="Enter Pincode">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Full Address</label>
                                    <textarea name="full_address" class="form-control" rows="3" placeholder="Enter Full Address"></textarea>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary px-5">Save Agent profile</button>
                                    <a href="index.php" class="btn btn-light ml-2">Cancel</a>
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
