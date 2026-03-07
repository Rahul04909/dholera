<?php
/**
 * Agent Header
 * Dholera Smart City Agent Panel
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auth check
if (!isset($_SESSION['agent_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../database/db_config.php';

// Fetch current agent details
try {
    $agent_id = $_SESSION['agent_id'];
    $stmt = $conn->prepare("SELECT * FROM agents WHERE id = ?");
    $stmt->execute([$agent_id]);
    $current_agent = $stmt->fetch();
    
    // Debug session (Temporary)
    file_put_contents('../debug_session.txt', date('Y-m-d H:i:s') . " - Page: " . $_SERVER['PHP_SELF'] . " | Agent ID: " . $agent_id . "\n", FILE_APPEND);
} catch (PDOException $e) {
    error_log("Header Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard | Dholera Smart City</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gold: #b8860b;
            --dark-bg: #111;
            --sidebar-width: 260px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background-color: #f4f7f6;
            color: #2d3748;
        }

        /* Header */
        .agent-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: var(--header-height);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 1000;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-area img {
            height: 40px;
        }

        .logo-text {
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 1px;
            color: var(--dark-bg);
        }

        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            text-decoration: none;
            color: #4a5568;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--primary-gold);
        }

        .view-site {
            background: var(--dark-bg);
            color: #fff;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13px;
        }

        .view-site:hover {
            background: var(--primary-gold);
            color: #fff;
        }

        /* Sidebar */
        .agent-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--dark-bg);
            color: #fff;
            padding: 30px 0;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 5px;
        }

        .sidebar-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: #cbd5e0;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .sidebar-item a:hover, .sidebar-item.active a {
            background-color: rgba(184, 134, 11, 0.1);
            color: var(--primary-gold);
            border-left: 4px solid var(--primary-gold);
        }

        .sidebar-item i {
            width: 20px;
            font-size: 18px;
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 40px;
            min-height: calc(100vh - var(--header-height));
        }

        /* Responsive */
        @media (max-width: 992px) {
            .agent-sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }

        /* UI Components */
        .dashboard-welcome h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
        }
        
        .btn-gold {
            background: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-gold:hover {
            background: #966d09;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<header class="agent-header">
    <div class="logo-area">
        <img src="<?php echo BASE_URL; ?>assets/logo.webp" alt="Dholera Logo">
        <span class="logo-text">AGENT PANEL</span>
    </div>

    <ul class="nav-links">
        <li>
            <a href="<?php echo BASE_URL; ?>index.php" class="view-site" target="_blank">
                <i class="fas fa-external-link-alt"></i> Visit Website
            </a>
        </li>
        <li style="display:flex; align-items:center; gap:10px;">
            <div style="text-align: right;">
                <div style="font-weight:700; font-size:14px;"><?php echo htmlspecialchars($current_agent['full_name']); ?></div>
                <div style="font-size:11px; color:#718096;">Agent #<?php echo str_pad($current_agent['id'], 4, '0', STR_PAD_LEFT); ?></div>
            </div>
            <img src="<?php echo $current_agent['profile_image'] ? BASE_URL.$current_agent['profile_image'] : BASE_URL.'assets/images/placeholder-user.png'; ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0;">
        </li>
    </ul>
</header>

<aside class="agent-sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <a href="index.php"><i class="fas fa-th-large"></i> Dashboard View</a>
        </li>
        <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : ''; ?>">
            <a href="leads.php"><i class="fas fa-users"></i> My Leads</a>
        </li>
        <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'site-visits.php' ? 'active' : ''; ?>">
            <a href="site-visits.php"><i class="fas fa-calendar-alt"></i> Site Visit Requests</a>
        </li>
        <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : ''; ?>">
            <a href="#"><i class="fas fa-building"></i> Browse Projects</a>
        </li>
        <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <a href="profile.php"><i class="fas fa-user-circle"></i> My Account</a>
        </li>
        <li class="sidebar-item">
            <a href="logout.php" style="color: #e53e3e;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</aside>
