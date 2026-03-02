<?php
/**
 * Agent Login Page
 * Dholera Smart City
 */

session_start();

// If already logged in, redirect to agent dashboard
if (isset($_SESSION['agent_id'])) {
    header("Location: index.php");
    exit();
}

require_once '../database/db_config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, full_name, password, status FROM agents WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $agent = $stmt->fetch();

            if ($agent) {
                if ($agent['status'] !== 'active') {
                    $error = "Your account is currently inactive. Please contact administrator.";
                } elseif (password_verify($password, $agent['password'])) {
                    $_SESSION['agent_id'] = $agent['id'];
                    $_SESSION['agent_name'] = $agent['full_name'];
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            error_log("Agent Login Error: " . $e->getMessage());
            $error = "An error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Login | Dholera Smart City</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gold: #b8860b;
            --dark-bg: #111;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: #000 url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 1;
        }

        .login-card {
            position: relative;
            z-index: 2;
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 50px 40px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            border-top: 6px solid var(--primary-gold);
            text-align: center;
        }

        .login-logo {
            margin-bottom: 35px;
        }

        .login-logo img {
            height: 65px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-subtitle {
            color: #718096;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 45px;
            color: var(--primary-gold);
            font-size: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 50px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 15px;
            font-family: 'Outfit', sans-serif;
            transition: all 0.3s;
            box-sizing: border-box;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background-color: var(--primary-gold);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn:hover {
            background-color: #966d09;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(150, 109, 9, 0.3);
        }

        .error-msg {
            background-color: #fff5f5;
            color: #c53030;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 25px;
            border-left: 5px solid #c53030;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-text {
            margin-top: 40px;
            font-size: 13px;
            color: #a0aec0;
        }

        .back-to-site {
            margin-top: 20px;
            display: inline-block;
            color: var(--primary-gold);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-to-site:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-overlay"></div>

<div class="login-card">
    <div class="login-logo">
        <img src="../assets/logo.webp" alt="Dholera Smart City">
    </div>
    
    <h2 class="login-title">Agent Portal</h2>
    <p class="login-subtitle">Sign in to manage your real estate business.</p>

    <?php if ($error): ?>
        <ul class="error-msg" style="list-style: none; padding-left: 15px;">
            <li><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></li>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Email Address</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required autocomplete="email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="login-btn">Secure Login</button>
    </form>

    <a href="../index.php" class="back-to-site"><i class="fas fa-arrow-left"></i> Back to Homepage</a>

    <div class="footer-text">
        &copy; <?php echo date('Y'); ?> Dholera Smart City | Agent Power Panel
    </div>
</div>

</body>
</html>
