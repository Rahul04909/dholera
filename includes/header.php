<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dholera Greenfield Smart City</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Hamburger Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gold: #b8860b; /* A rich gold as seen in the image */
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
            transition: all 0.3s ease;
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
            overflow: hidden;
            max-width: fit-content;
        }

        .logo img {
            height: 60px;
            width: auto;
            display: block;
            /* Slightly clip the right side if there's a stray pixel/line in the image */
            margin-right: -1px; 
            user-select: none;
            -webkit-user-drag: none;
        }

        /* Desktop Navigation */
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--white);
            font-weight: 600; /* Made slightly bolder */
            font-size: 18px; /* Increased font size as requested */
            text-transform: capitalize;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }

        nav ul li a:hover {
            color: #f0c040; /* Lighter gold on hover */
            transform: translateY(-2px);
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
        }

        /* Mobile Navigation Overlay */
        .nav-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            height: 100vh;
            background: var(--primary-gold);
            z-index: 1001;
            padding: 60px 20px;
            transition: 0.4s ease-in-out;
            box-shadow: -5px 0 15px rgba(0,0,0,0.3);
        }

        .nav-overlay.active {
            right: 0;
        }

        .nav-overlay ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .nav-overlay ul li a {
            color: var(--white);
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            display: block;
            border-bottom: 1px solid var(--translucent-white);
            padding-bottom: 10px;
        }

        .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--white);
            font-size: 30px;
            cursor: pointer;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            nav ul {
                display: none;
            }
            .mobile-toggle {
                display: block;
            }
            .logo img {
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                height: 40px;
            }
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
                <li><a href="#home">Home</a></li>
                <li><a href="#overview">Overview</a></li>
                <li><a href="#highlights">Highlights</a></li>
                <li><a href="#price-list">Price List</a></li>
                <li><a href="#amenities">Amenities</a></li>
                <li><a href="#floor-plans">Floor Plans</a></li>
                <li><a href="#location-map">Location Map</a></li>
                <li><a href="#gallery">Gallery</a></li>
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
        <li><a href="#home">Home</a></li>
        <li><a href="#overview">Overview</a></li>
        <li><a href="#highlights">Highlights</a></li>
        <li><a href="#price-list">Price List</a></li>
        <li><a href="#amenities">Amenities</a></li>
        <li><a href="#floor-plans">Floor Plans</a></li>
        <li><a href="#location-map">Location Map</a></li>
        <li><a href="#gallery">Gallery</a></li>
    </ul>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const navOverlay = document.getElementById('navOverlay');
    const menuClose = document.getElementById('menuClose');

    menuToggle.addEventListener('click', () => {
        navOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
    });

    menuClose.addEventListener('click', () => {
        navOverlay.classList.remove('active');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    });

    // Close menu when a link is clicked
    const navLinks = document.querySelectorAll('.nav-overlay ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    });
</script>
