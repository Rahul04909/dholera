<?php
/**
 * Admin Profile Page
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../database/db_config.php';

$success_msg = "";
$error_msg = "";

$admin_id = $_SESSION['admin_id'];

// Fetch current admin details
try {
    $stmt = $conn->prepare("SELECT username, email, full_name FROM admins WHERE id = :id");
    $stmt->bindParam(':id', $admin_id);
    $stmt->execute();
    $admin = $stmt->fetch();
} catch (PDOException $e) {
    die("Error fetching profile: " . $e->getMessage());
}

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    if (empty($full_name) || empty($email)) {
        $error_msg = "Full name and email are required.";
    } else {
        try {
            $update_stmt = $conn->prepare("UPDATE admins SET full_name = :full_name, email = :email WHERE id = :id");
            $update_stmt->bindParam(':full_name', $full_name);
            $update_stmt->bindParam(':email', $email);
            $update_stmt->bindParam(':id', $admin_id);
            $update_stmt->execute();
            
            $success_msg = "Profile updated successfully!";
            // Refresh admin data
            $admin['full_name'] = $full_name;
            $admin['email'] = $email;
        } catch (PDOException $e) {
            $error_msg = "Error updating profile: " . $e->getMessage();
        }
    }
}

// Handle Password Change
if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if (empty($current_pass) || empty($new_pass) || empty($confirm_pass)) {
        $error_msg = "All password fields are required.";
    } elseif ($new_pass !== $confirm_pass) {
        $error_msg = "New password and confirmation do not match.";
    } else {
        try {
            // Verify current password
            $check_stmt = $conn->prepare("SELECT password FROM admins WHERE id = :id");
            $check_stmt->bindParam(':id', $admin_id);
            $check_stmt->execute();
            $row = $check_stmt->fetch();

            if (password_verify($current_pass, $row['password'])) {
                $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $pass_stmt = $conn->prepare("UPDATE admins SET password = :password WHERE id = :id");
                $pass_stmt->bindParam(':password', $hashed_pass);
                $pass_stmt->bindParam(':id', $admin_id);
                $pass_stmt->execute();
                
                $success_msg = "Password changed successfully!";
            } else {
                $error_msg = "Incorrect current password.";
            }
        } catch (PDOException $e) {
            $error_msg = "Error changing password: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Account Profile</h1>
        <p style="color: #666;">Manage your personal information and security settings.</p>
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
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .profile-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 15px;
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

        .form-control:disabled {
            background-color: #f7fafc;
            color: #a0aec0;
        }

        .btn-update {
            background-color: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-update:hover {
            background-color: #966d09;
        }

        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-grid">
        <!-- Account Info -->
        <div class="profile-card">
            <h2><i class="fas fa-user-edit" style="color: var(--primary-gold);"></i> Account Information</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Username (Non-editable)</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($admin['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>
                <button type="submit" name="update_profile" class="btn-update">Update Information</button>
            </form>
        </div>

        <!-- Security -->
        <div class="profile-card">
            <h2><i class="fas fa-shield-alt" style="color: var(--primary-gold);"></i> Security Settings</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Re-type new password" required>
                </div>
                <button type="submit" name="change_password" class="btn-update">Change Password</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
