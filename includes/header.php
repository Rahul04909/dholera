<?php
/**
 * Professional Frontend Header
 * Dholera By Us - Smart City
 */
require_once __DIR__ . '/../database/db_config.php';

// Fetch projects for header
try {
    $stmt_projects = $conn->prepare("SELECT id, title, slug FROM projects WHERE status = 'active' ORDER BY created_at DESC");
    $stmt_projects->execute();
    $header_projects = $stmt_projects->fetchAll();
} catch (PDOException $e) {
    $header_projects = [];
}

// SEO Defaults
$seo_title = isset($seo_title) ? $seo_title : "Dholera Smart City | Portfolio, Real Estate Digital Marketing & IT Services";
$seo_desc = isset($seo_desc) ? $seo_desc : "Dholera Greenfield Smart City - India's First Platinum-rated Greenfield Smart City. We provide real estate digital marketing, IT services, verified lead generation, and planned site visits.";
$seo_keywords = isset($seo_keywords) ? $seo_keywords : "Dholera Smart City, Real Estate Digital Marketing, IT Services, Plot for Sale in Dholera, Dholera SIR, Smart City Gujarat, Real Estate Leads";
$seo_image = isset($seo_image) ? $seo_image : BASE_URL . "assets/logo.webp";
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo_title; ?></title>
    <meta name="description" content="<?php echo $seo_desc; ?>">
    <meta name="keywords" content="<?php echo $seo_keywords; ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="<?php echo BASE_URL; ?>assets/logo.webp">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/logo.webp">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $current_url; ?>">
    <meta property="og:title" content="<?php echo $seo_title; ?>">
    <meta property="og:description" content="<?php echo $seo_desc; ?>">
    <meta property="og:image" content="<?php echo $seo_image; ?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #b8860b;
            /* Gold */
            --secondary-color: #1c335a;
            /* Navy Blue */
            --text-color: #333;
            --light-grey: #f8f9fa;
            --border-color: #dee2e6;
            --white: #ffffff;
            --font-main: 'Outfit', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            background-color: #f4f4f4;
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 8px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            position: relative;
            z-index: 1001;
        }

        .top-bar-left,
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-bar a {
            color: var(--white);
            text-decoration: none;
        }

        .top-bar-right .offer-tag {
            color: #ffc107;
            font-weight: bold;
        }

        .grab-now {
            text-decoration: underline !important;
            font-weight: bold;
        }

        /* Main Header */
        .main-header {
            padding: 15px 5%;
            display: flex;
            align-items: center;
            gap: 20px;
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        .header-search-container {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-grow: 1;
        }

        .search-bar {
            position: relative;
            flex-grow: 1;
            max-width: 500px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 25px;
            background: #f1f3f5;
            outline: none;
            font-family: inherit;
        }

        .search-bar .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .header-links {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .header-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }

        .header-links a:not(:last-child)::after {
            content: '|';
            color: #ddd;
            margin: 0 12px;
            font-weight: 300;
            font-size: 14px;
        }

        .header-links a:hover {
            color: var(--primary-color);
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-auth {
            padding: 8px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-signup {
            background: var(--primary-color);
            color: #fff;
        }

        .btn-signup:hover {
            background: #916a09;
            border-color: #916a09;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.3);
            transform: translateY(-2px);
        }

        .btn-login {
            background: transparent;
            color: var(--primary-color);
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
            transform: translateY(-2px);
        }

        /* Navigation Bar - Centered Menu */
        .nav-bar {
            padding: 10px 5%;
            background: var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
        }

        .nav-menu li a {
            text-decoration: none;
            color: #444;
            font-size: 14px;
            font-weight: 600;
            padding: 0 25px;
            transition: color 0.3s;
            white-space: nowrap;
        }

        .nav-menu li a:hover {
            color: var(--primary-color);
        }

        /* Dropdown Base Styling */
        .nav-menu li.has-dropdown {
            position: relative;
        }

        .nav-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            min-width: 250px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
            z-index: 1002;
            list-style: none;
        }

        .nav-menu li:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown li {
            width: 100%;
        }

        .nav-dropdown li a {
            padding: 10px 20px !important;
            display: block !important;
            font-weight: 500 !important;
            font-size: 14px !important;
        }

        .mobile-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--secondary-color);
        }

        /* Sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: var(--white);
            z-index: 2001;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
        }

        .mobile-sidebar.open {
            left: 0;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .close-sidebar {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-color);
            cursor: pointer;
        }

        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .sidebar-section {
            margin-bottom: 30px;
        }

        .sidebar-section h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .sidebar-section ul {
            list-style: none;
        }

        .sidebar-section ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            font-size: 15px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .sidebar-section ul li a i {
            width: 20px;
            color: var(--primary-color);
            font-size: 16px;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 1200px) {

            .header-links,
            .auth-buttons,
            .top-bar-right {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .main-header {
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                justify-content: center;
                padding: 5px;
            }

            .top-bar-left span {
                display: none;
            }

            .header-search-container,
            .nav-bar {
                display: none;
            }

            .logo img {
                height: 35px;
            }
        }
    </style>
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <span><i class="fa-solid fa-phone"></i> Contact for Site Visit :</span>
            <a href="tel:+918059982049"><img src="https://flagcdn.com/w20/in.png" alt="IN" width="16"> +91 80599
                82049</a>
        </div>
        <div class="top-bar-right">
            <span><i class="fa-solid fa-bullhorn"></i> <span class="offer-tag">Live Update</span> - Greenfield Smart
                City Development | Ends in : <span id="timer">09h 08m 01s</span></span>
            <a href="<?php echo BASE_URL; ?>contact.php" class="grab-now">BOOK VISIT</a>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="logo">
            <a href="<?php echo BASE_URL; ?>index.php">
                <img src="<?php echo BASE_URL; ?>assets/dholera-logo.png" alt="Dholera By Us Logo">
            </a>
        </div>

        <div class="header-search-container">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Search projects, plots, amenities...">
            </div>
        </div>

        <div class="header-links">
            <a href="<?php echo BASE_URL; ?>about.php">About Us</a>
            <a href="<?php echo BASE_URL; ?>index.php#projects">Our Projects</a>
            <a href="<?php echo BASE_URL; ?>contact.php">Contact</a>
        </div>

        <div class="auth-buttons">
            <!-- <a href="<?php echo BASE_URL; ?>register.php" class="btn-auth btn-signup">Register</a> -->
            <a href="<?php echo BASE_URL; ?>admin/login.php" class="btn-auth btn-login">Partners</a>
        </div>

        <div class="mobile-toggle" id="mobile-menu-btn">
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <!-- Navigation Bar - Centered Menus -->
    <nav class="nav-bar">
        <ul class="nav-menu">
            <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
            <li class="has-dropdown">
                <a href="#">Exclusive Projects <i class="fa-solid fa-caret-down"></i></a>
                <ul class="nav-dropdown">
                    <?php if (empty($header_projects)): ?>
                        <li><a href="#">No Active Projects</a></li>
                    <?php else: ?>
                        <?php foreach ($header_projects as $proj): ?>
                            <li><a
                                    href="<?php echo BASE_URL; ?>project/<?php echo $proj['slug'] ? $proj['slug'] : $proj['id']; ?>"><?php echo htmlspecialchars($proj['title']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="has-dropdown">
                <a href="<?php echo BASE_URL; ?>dholera-sir/">Dholera SIR <i class="fa-solid fa-caret-down"></i></a>
                <ul class="nav-dropdown">
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/index.php">SIR Overview</a></li>
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/connectivity.php">Connectivity</a></li>
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/projects-status.php">Projects Status</a></li>
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/#development">Development Plan</a></li>
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/#why-dholera">Why Invest in Dholera?</a></li>
                </ul>
            </li>
            <li><a href="<?php echo BASE_URL; ?>contact.php">Site Visit</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#developers">Developers</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#floor-plans">Floor Plans</a></li>
        </ul>
    </nav>

    <!-- Mobile Sidebar -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <aside class="mobile-sidebar" id="mobile-sidebar">
        <div class="sidebar-header">
            <img src="<?php echo BASE_URL; ?>assets/logo.webp" alt="Dholera Logo" height="35">
            <button class="close-sidebar" id="close-sidebar"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h4>Main Menu</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>index.php"><i class="fa-solid fa-house"></i> Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php#projects"><i class="fa-solid fa-building"></i>
                            Projects</a></li>
                    <li><a href="<?php echo BASE_URL; ?>dholera-sir/"><i class="fa-solid fa-city"></i> Dholera SIR</a>
                    </li>
                    <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fa-solid fa-info-circle"></i> About Us</a>
                    </li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-section">
                <h4>Smart City Info</h4>
                <ul>
                    <li><a href="#"><i class="fa-solid fa-map"></i> Location Map</a></li>
                    <li><a href="#"><i class="fa-solid fa-file-pdf"></i> Download Brochure</a></li>
                    <li><a href="#"><i class="fa-solid fa-video"></i> Drone View</a></li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <a href="<?php echo BASE_URL; ?>register.php" class="btn-auth btn-signup">Register Now</a>
                <a href="<?php echo BASE_URL; ?>admin/login.php" class="btn-auth btn-login">Admin Login</a>
            </div>
        </div>
    </aside>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleSidebar);
        if (closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);

        // Timer Logic
        let hours = 9, minutes = 8, seconds = 1;
        const timerEl = document.getElementById('timer');
        if (timerEl) {
            setInterval(() => {
                seconds--;
                if (seconds < 0) {
                    seconds = 59;
                    minutes--;
                }
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                }
                timerEl.innerText = `${hours.toString().padStart(2, '0')}h ${minutes.toString().padStart(2, '0')}m ${seconds.toString().padStart(2, '0')}s`;
            }, 1000);
        }
    </script>