<?php
/**
 * Frontend Header
 * Dholera Smart City
 */
require_once 'database/db_config.php';

try {
    $stmt_projects = $conn->prepare("SELECT id, title FROM projects WHERE status = 'active' ORDER BY created_at DESC");
    $stmt_projects->execute();
    $header_projects = $stmt_projects->fetchAll();
} catch (PDOException $e) {
    $header_projects = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dholera Greenfield Smart City</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gold: #b8860b;
            --dark-gold: #916a09;
            --white: #ffffff;
            --black: #000000;
            --translucent-white: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f4f4f4;
        }

        header {
            background-color: var(--primary-gold);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo img {
            height: 60px;
            width: auto;
        }

        /* Desktop Navigation */
        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
            align-items: center;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--white);
            font-weight: 600;
            font-size: 17px;
            text-transform: capitalize;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 10px 0;
        }

        nav ul li a:hover {
            color: #f0c040;
        }

        /* Dropdown Styling - Simple Professional List */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffff;
            min-width: 280px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 4px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 100;
            display: block !important; /* Force block to override nav ul flex */
            margin: 0;
            list-style: none;
        }

        nav ul li:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li {
            width: 100% !important;
            display: block !important;
            margin: 0 !important;
        }

        .dropdown-menu li a {
            color: #333 !important;
            padding: 12px 25px !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            display: block !important;
            transition: all 0.2s ease;
            text-transform: none !important;
        }

        .dropdown-menu li a:hover {
            background: #f8f9fa;
            color: var(--primary-gold) !important;
            padding-left: 30px !important;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
        }

        /* Mobile Sidebar */
        .nav-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100vh;
            background: #fff;
            z-index: 1001;
            padding: 60px 0;
            transition: 0.4s ease-in-out;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .nav-overlay.active {
            right: 0;
        }

        .nav-overlay ul {
            list-style: none;
        }

        .nav-overlay ul li a {
            color: #333;
            text-decoration: none;
            font-size: 17px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
        }

        .mobile-dropdown {
            background: #f9f9f9;
            display: none;
            list-style: none;
        }

        .mobile-dropdown li a {
            padding-left: 40px !important;
            font-size: 15px !important;
            font-weight: 400 !important;
        }

        .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #333;
            font-size: 28px;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            nav ul { display: none; }
            .mobile-toggle { display: block; }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <a href="index.php" class="logo">
            <img src="assets/logo.webp" alt="Dholera Logo">
        </a>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <!-- <li><a href="index.php#overview">Overview</a></li> -->
                <li class="has-dropdown">
                    <a href="#">Projects <i class="fas fa-chevron-down" style="font-size: 12px;"></i></a>
                    <ul class="dropdown-menu">
                        <?php if (empty($header_projects)): ?>
                            <li><a href="#">No Projects Found</a></li>
                        <?php else: ?>
                            <?php foreach ($header_projects as $proj): ?>
                                <li><a href="project-details.php?id=<?php echo $proj['id']; ?>"><?php echo htmlspecialchars($proj['title']); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
        </nav>

        <div class="mobile-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<!-- Mobile Overlay -->
<div class="nav-overlay" id="navOverlay">
    <div class="close-menu" id="menuClose">
        <i class="fas fa-times"></i>
    </div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#overview">Overview</a></li>
        <li>
            <a href="#" class="mobile-dropdown-toggle">Projects <i class="fas fa-plus"></i></a>
            <ul class="mobile-dropdown">
                <?php foreach ($header_projects as $proj): ?>
                    <li><a href="project-details.php?id=<?php echo $proj['id']; ?>"><?php echo htmlspecialchars($proj['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li><a href="index.php#highlights">Highlights</a></li>
        <li><a href="index.php#floor-plans">Floor Plans</a></li>
    </ul>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const navOverlay = document.getElementById('navOverlay');
    const menuClose = document.getElementById('menuClose');
    const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
    const mobileDropdown = document.querySelector('.mobile-dropdown');

    menuToggle.addEventListener('click', () => {
        navOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    menuClose.addEventListener('click', () => {
        navOverlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    });

    if (mobileDropdownToggle) {
        mobileDropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const isVisible = mobileDropdown.style.display === 'block';
            mobileDropdown.style.display = isVisible ? 'none' : 'block';
            mobileDropdownToggle.querySelector('i').classList.toggle('fa-plus');
            mobileDropdownToggle.querySelector('i').classList.toggle('fa-minus');
        });
    }
</script>
