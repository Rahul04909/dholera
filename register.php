<?php
/**
 * Agent Registration - Step 1
 * Dholera Smart City
 */
require_once 'database/db_config.php';
session_start();

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];
    
    // Basic validation
    if (empty($full_name) || empty($email) || empty($mobile) || empty($password)) {
        $error_msg = "All fields are required.";
    } else {
        // Check if agent already exists
        $stmt = $conn->prepare("SELECT id FROM agents WHERE email = ? OR mobile = ?");
        $stmt->execute([$email, $mobile]);
        if ($stmt->rowCount() > 0) {
            $error_msg = "An account with this email or mobile already exists.";
        } else {
            // Store registration data in session to be finalized after payment
            $_SESSION['reg_data'] = [
                'full_name' => $full_name,
                'email' => $email,
                'mobile' => $mobile,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'country' => trim($_POST['country'] ?: 'India'),
                'state' => trim($_POST['state']),
                'city' => trim($_POST['city']),
                'pincode' => trim($_POST['pincode']),
                'full_address' => trim($_POST['full_address'])
            ];
            
            // Handle Profile Image if uploaded
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowed)) {
                    $new_name = 'reg_' . time() . '.' . $ext;
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/agents/' . $new_name)) {
                        $_SESSION['reg_data']['profile_image'] = 'uploads/agents/' . $new_name;
                    }
                }
            }

            header("Location: select-package.php");
            exit();
        }
    }
}

include 'includes/header.php';
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #111;
        --soft-gray: #f7fafc;
    }

    .reg-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: var(--soft-gray);
    }

    .reg-card {
        background: #fff;
        max-width: 900px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        display: grid;
        grid-template-columns: 350px 1fr;
        overflow: hidden;
    }

    .reg-sidebar {
        background: var(--dark-bg);
        color: #fff;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .reg-sidebar h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--primary-gold);
        line-height: 1.2;
    }

    .reg-sidebar p {
        color: #a0aec0;
        font-size: 15px;
        line-height: 1.6;
    }

    .step-indicator {
        margin-top: 40px;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        opacity: 0.5;
    }

    .step.active { opacity: 1; }

    .step-num {
        width: 30px;
        height: 30px;
        border: 2px solid var(--primary-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: var(--primary-gold);
    }

    .step-text { font-weight: 600; font-size: 14px; }

    .reg-content { padding: 50px; }

    .form-title { font-size: 22px; font-weight: 700; margin-bottom: 30px; color: var(--dark-bg); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    
    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: span 2; }

    label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #4a5568; }
    
    .input-box {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    .input-box:focus { border-color: var(--primary-gold); box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1); }

    .btn-next {
        width: 100%;
        background: var(--primary-gold);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 20px;
    }

    .btn-next:hover { background: #966d09; transform: translateY(-2px); }

    .error-alert {
        background: #fff5f5;
        color: #c53030;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #feb2b2;
    }

    @media (max-width: 768px) {
        .reg-card { grid-template-columns: 1fr; }
        .reg-sidebar { display: none; }
        .reg-content { padding: 30px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: auto; }
    }
</style>

<div class="reg-wrapper">
    <div class="reg-card">
        <div class="reg-sidebar">
            <h2>Join Our Premium Network</h2>
            <p>Become a certified partner agent for Dholera Smart City and unlock exclusive real estate opportunities.</p>
            
            <div class="step-indicator">
                <div class="step active">
                    <div class="step-num">01</div>
                    <div class="step-text">Profile Details</div>
                </div>
                <div class="step">
                    <div class="step-num">02</div>
                    <div class="step-text">Select Package</div>
                </div>
                <div class="step">
                    <div class="step-num">03</div>
                    <div class="step-text">Payment Verification</div>
                </div>
            </div>
        </div>

        <div class="reg-content">
            <h1 class="form-title">Create Your Agent Account</h1>

            <?php if($error_msg): ?>
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" class="input-box" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="input-box" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number *</label>
                        <input type="tel" name="mobile" class="input-box" placeholder="+91 00000 00000" required>
                    </div>
                    <div class="form-group full">
                        <label>Create Password *</label>
                        <input type="password" name="password" class="input-box" placeholder="••••••••" required>
                    </div>

                    <div style="grid-column: span 2; margin: 10px 0; border-bottom: 1px solid #edf2f7;"></div>

                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="input-box" placeholder="e.g. Gujarat">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="input-box" placeholder="e.g. Ahmedabad">
                    </div>
                    <div class="form-group full">
                        <label>Address</label>
                        <input type="text" name="full_address" class="input-box" placeholder="Street, Area details">
                    </div>
                    <div class="form-group full">
                        <label>Profile Photo</label>
                        <input type="file" name="profile_image" class="input-box" accept="image/*" style="padding: 8px;">
                    </div>
                </div>

                <button type="submit" class="btn-next">Next: Choose Your Plan <i class="fas fa-arrow-right" style="margin-left: 10px; font-size: 14px;"></i></button>
            </form>
            
            <p style="text-align: center; margin-top: 25px; font-size: 14px; color: #718096;">
                Already have an account? <a href="agent/login.php" style="color: var(--primary-gold); font-weight: 700; text-decoration: none;">Login here</a>
            </p>
        </div>
    </div>
</div>

<?php include 'includes/main-footer.php'; ?>
