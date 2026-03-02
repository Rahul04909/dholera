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
                header("Location: add-agent.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['msg'] = ['status' => 'error', 'text' => 'Internal Error: ' . $e->getMessage()];
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
        <h1 style="font-size: 28px; font-weight: 700;">Add New Agent</h1>
        <p style="color: #666;">Create a new real estate agent profile.</p>
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
        <form action="add-agent.php" method="POST" enctype="multipart/form-data">
            <h2><i class="fas fa-id-card" style="color: var(--primary-gold);"></i> Personal & Account Info</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name <span style="color:red">*</span></label>
                    <input type="text" name="full_name" class="form-control" placeholder="Agent Full Name" required>
                </div>
                <div class="form-group">
                    <label>Email Address <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label>Mobile Number <span style="color:red">*</span></label>
                    <input type="tel" name="mobile" class="form-control" placeholder="+91 00000 00000" required>
                </div>
                <div class="form-group">
                    <label>Login Password <span style="color:red">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Create secure password" required>
                </div>
                <div class="form-group">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="form-group">
                    <div class="img-preview-container">
                        <img id="imgPreview" src="../../assets/images/placeholder-user.png" alt="Preview">
                    </div>
                </div>
            </div>

            <h2 style="margin-top: 20px;"><i class="fas fa-map-marker-alt" style="color: var(--primary-gold);"></i> Address & Location</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="India">
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" placeholder="State">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="City">
                </div>
                <div class="form-group">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" placeholder="000000">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Full Residential Address</label>
                    <textarea name="full_address" class="form-control" rows="2" placeholder="Street, Landmark, Area..."></textarea>
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #edf2f7; padding-top: 30px;">
                <button type="submit" class="btn-update">Create Agent Account</button>
                <a href="index.php" class="btn-cancel">Cancel & Go Back</a>
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
