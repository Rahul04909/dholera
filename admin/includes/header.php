<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Dholera Smart City</title>
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
            --text-gray: #a0aec0;
            --light-gray: #f7fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        /* Header Style */
        .admin-header {
            height: var(--header-height);
            background-color: var(--dark-bg);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
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
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
            cursor: pointer;
            padding: 10px 0;
        }

        .nav-link:hover, .nav-item:hover .nav-link {
            color: var(--primary-gold);
        }

        /* Dropdown Style */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            border-radius: 4px;
            list-style: none;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1001;
            border-top: 3px solid var(--primary-gold);
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s, color 0.3s;
        }

        .dropdown-menu li a:hover {
            background-color: var(--light-gray);
            color: var(--primary-gold);
        }

        .dropdown-menu li:not(:last-child) {
            border-bottom: 1px solid #edf2f7;
        }

        .view-site {
            background-color: var(--primary-gold);
            color: #fff !important;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 14px !important;
        }

        .view-site:hover {
            background-color: #966d09;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 1px solid rgba(255,255,255,0.1);
            padding-left: 25px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--primary-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        /* Sidebar Style */
        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-bg);
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            padding-top: 30px;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }

        .sidebar-item.active a, .sidebar-item a:hover {
            background-color: rgba(184, 134, 11, 0.1);
            color: var(--primary-gold);
            border-left: 4px solid var(--primary-gold);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 40px;
            min-height: calc(100vh - var(--header-height));
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<header class="admin-header">
    <div class="logo-area">
        <img src="../assets/logo.webp" alt="Dholera Smart City Logo">
        <span class="logo-text"></span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="../index.php" class="nav-link view-site" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Site
            </a>
        </li>
        <li class="nav-item">
            <span class="nav-link">Projects <i class="fas fa-chevron-down" style="font-size: 10px;"></i></span>
            <ul class="dropdown-menu">
                <li><a href="#"><i class="fas fa-list-ul"></i> All Projects</a></li>
                <li><a href="#"><i class="fas fa-plus"></i> Add New Project</a></li>
                <li><a href="#"><i class="fas fa-star"></i> Featured Items</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <span class="nav-link">Enquiries <i class="fas fa-chevron-down" style="font-size: 10px;"></i></span>
            <ul class="dropdown-menu">
                <li><a href="#"><i class="fas fa-envelope"></i> Contact Leads</a></li>
                <li><a href="#"><i class="fas fa-file-pdf"></i> Brochure Requests</a></li>
                <li><a href="#"><i class="fas fa-calendar-alt"></i> Site Visit Requests</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <div class="user-profile">
                <div class="user-avatar">AD</div>
                <span class="nav-link">Admin <i class="fas fa-chevron-down" style="font-size: 10px;"></i></span>
                <ul class="dropdown-menu" style="left: auto; right: 0;">
                    <li><a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><hr style="border: none; border-top: 1px solid #eee;"></li>
                    <li><a href="logout.php" style="color: #e53e3e;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </li>
    </ul>
</header>

<aside class="admin-sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item active">
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="#"><i class="fas fa-building"></i> Properties</a>
        </li>
        <li class="sidebar-item">
            <a href="#"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="sidebar-item">
            <a href="#"><i class="fas fa-images"></i> Media Library</a>
        </li>
        <li class="sidebar-item">
            <a href="#"><i class="fas fa-chart-line"></i> Analytics</a>
        </li>
        <li class="sidebar-item">
            <a href="#"><i class="fas fa-tools"></i> Configuration</a>
        </li>
    </ul>
</aside>
