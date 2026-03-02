<?php
/**
 * Agent Profile Management
 */
include 'includes/header.php';

$success_msg = "";
$error_msg = "";

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $mobile = trim($_POST['mobile']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $full_address = trim($_POST['full_address']);

    if (empty($full_name) || empty($mobile)) {
        $error_msg = "Full name and mobile are required.";
    } else {
        try {
            // Handle image upload if any
            $profile_image_path = $current_agent['profile_image'];
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['profile_image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $new_name = 'agent_' . time() . '.' . $ext;
                    $upload_dir = '../uploads/agents/';
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $new_name)) {
                        // Delete old image if exists
                        if ($current_agent['profile_image'] && file_exists('../' . $current_agent['profile_image'])) {
                            unlink('../' . $current_agent['profile_image']);
                        }
                        $profile_image_path = 'uploads/agents/' . $new_name;
                    }
                }
            }

            $stmt = $conn->prepare("UPDATE agents SET full_name = ?, mobile = ?, city = ?, state = ?, full_address = ?, profile_image = ? WHERE id = ?");
            $stmt->execute([$full_name, $mobile, $city, $state, $full_address, $profile_image_path, $_SESSION['agent_id']]);
            
            $success_msg = "Profile updated successfully!";
            // Refresh current agent data
            $stmt = $conn->prepare("SELECT * FROM agents WHERE id = ?");
            $stmt->execute([$_SESSION['agent_id']]);
            $current_agent = $stmt->fetch();
        } catch (PDOException $e) {
            $error_msg = "Update Error: " . $e->getMessage();
        }
    }
}

// Handle Password Change
if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (empty($current_pass) || empty($new_pass) || empty($confirm_pass)) {
        $error_msg = "All password fields are required.";
    } elseif ($new_pass !== $confirm_pass) {
        $error_msg = "New password and confirmation do not match.";
    } else {
        try {
            if (password_verify($current_pass, $current_agent['password'])) {
                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE agents SET password = ? WHERE id = ?");
                $stmt->execute([$hashed, $_SESSION['agent_id']]);
                $success_msg = "Password updated successfully!";
            } else {
                $error_msg = "Incorrect current password.";
            }
        } catch (PDOException $e) {
            $error_msg = "Error updating password.";
        }
    }
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1>My Profile Settings</h1>
        <p style="color: #718096; margin-top: 5px;">Manage your account details and security.</p>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #c53030; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #c53030;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .profile-card {
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .profile-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-control[disabled] {
            background: #f7fafc;
            color: #a0aec0;
            cursor: not-allowed;
        }

        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-grid">
        <div class="profile-card">
            <h2><i class="fas fa-user-edit" style="color: var(--primary-gold);"></i> Personal Information</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Professional Email (Non-editable)</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($current_agent['email']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($current_agent['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="tel" name="mobile" class="form-control" value="<?php echo htmlspecialchars($current_agent['mobile']); ?>" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($current_agent['city']); ?>">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($current_agent['state']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Full Address</label>
                    <textarea name="full_address" class="form-control" rows="2"><?php echo htmlspecialchars($current_agent['full_address']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Change Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*">
                </div>
                <button type="submit" name="update_profile" class="btn-gold">Save Changes</button>
            </form>
        </div>

        <div class="profile-card">
            <h2><i class="fas fa-shield-alt" style="color: var(--primary-gold);"></i> Security Settings</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_pass" class="form-control" placeholder="Required to change password" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_pass" class="form-control" placeholder="Create new strong password" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_pass" class="form-control" placeholder="Verify your new password" required>
                </div>
                <button type="submit" name="change_password" class="btn-gold" style="background: #2d3748;">Update Password</button>
            </form>

            <div style="margin-top: 40px; padding: 25px; border-radius: 12px; background: rgba(184, 134, 11, 0.05); border: 1px dashed var(--primary-gold);">
                <h4 style="margin: 0 0 10px 0; font-weight: 800; color: var(--primary-gold);">Professional Tip:</h4>
                <p style="margin: 0; font-size: 14px; color: #4a5568; line-height: 1.6;">A complete profile with a professional photo builds more trust with potential leads. Keep your information updated for better business visibility.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
