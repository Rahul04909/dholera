<?php
/**
 * About Us Page
 * Dholera Smart City
 */
require_once 'database/db_config.php';
include 'includes/header.php';
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #0b1622;
        --text-dark: #2d3748;
        --text-muted: #718096;
        --section-bg: #f8fafc;
    }

    body {
        background-color: #fff;
        color: var(--text-dark);
        line-height: 1.6;
        font-family: 'Outfit', sans-serif;
    }

    /* About Hero */
    .about-hero {
        position: relative;
        height: 450px;
        background: url('assets/about-hero.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        margin-bottom: 60px;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(11, 22, 34, 0.8), rgba(11, 22, 34, 0.4));
    }

    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-content h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .hero-content p {
        font-size: 18px;
        opacity: 0.9;
        font-weight: 400;
    }

    /* Section Styling */
    .about-section {
        padding: 80px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: var(--dark-bg);
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }

    .section-header h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-gold);
    }

    /* Grid Layouts */
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .content-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    /* Info Cards */
    .info-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .info-card {
        background: #fff;
        padding: 40px 30px;
        border-radius: 20px;
        text-align: center;
        border: 1px solid #edf2f7;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-gold);
        box-shadow: 0 15px 35px rgba(184, 134, 11, 0.1);
    }

    .info-card i {
        font-size: 40px;
        color: var(--primary-gold);
        margin-bottom: 20px;
    }

    .info-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark-bg);
    }

    .info-card p {
        font-size: 15px;
        color: var(--text-muted);
    }

    /* Vision Mission */
    .vision-mission-section {
        background: var(--section-bg);
    }

    .vm-box {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .vm-box h3 {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-gold);
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .about-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .hero-content h1 {
            font-size: 36px;
        }
        .info-cards-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .info-cards-grid {
            grid-template-columns: 1fr;
        }
        .hero-content h1 {
            font-size: 28px;
        }
        .section-header h2 {
            font-size: 28px;
        }
    }
</style>

<main>
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="hero-content">
            <h1>India's First Greenfield Smart City</h1>
            <p>Dholera SIR is a vision of a futuristic, efficient, and sustainable urban ecosystem, built from the ground up to redefine modern living.</p>
        </div>
    </div>

    <!-- Overview Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="content-text">
                    <div style="color: var(--primary-gold); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px;">The Future is Here</div>
                    <h2 style="font-size: 36px; font-weight: 800; color: var(--dark-bg); margin-bottom: 20px; line-height: 1.2;">Redefining the Urban Landscape of Gujarat</h2>
                    <p style="margin-bottom: 20px;">Dholera Special Investment Region (SIR) is a major project under the Delhi-Mumbai Industrial Corridor (DMIC). It is India's first Platinum-rated Greenfield Smart City, designed with state-of-the-art infrastructure and digital governance.</p>
                    <p>Encompassing a total area of 920 sq. km, Dholera is strategically located 100 km south of Ahmedabad. It is poised to become a global hub for manufacturing, logistics, and residential excellence, offering an unparalleled quality of life.</p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                        <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold);"></i> RERA Approved
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold);"></i> DMIC Project
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold);"></i> Smart Governance
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold);"></i> Platinum Rated
                        </div>
                    </div>
                </div>
                <div class="content-image">
                    <img src="assets/overview.webp" alt="Dholera Smart City Overview">
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="about-section vision-mission-section">
        <div class="container">
            <div class="about-grid">
                <div class="vm-box">
                    <h3><i class="fas fa-eye"></i> Our Vision</h3>
                    <p>To create a world-class, self-sustaining urban center that integrates cutting-edge technology with sustainable practices, becoming a beacon of prosperity and modern living for generations to come.</p>
                </div>
                <div class="vm-box">
                    <h3><i class="fas fa-rocket"></i> Our Mission</h3>
                    <p>To provide high-quality residential, commercial, and industrial plots that offer immense value and growth potential. We aim to facilitate smooth investments and build a community based on transparency and excellence.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Pillars -->
    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <h2>Strategic Pillars of Dholera</h2>
                <p>Built on the foundation of efficiency, connectivity, and sustainability.</p>
            </div>

            <div class="info-cards-grid">
                <div class="info-card">
                    <i class="fas fa-road"></i>
                    <h3>Connectivity</h3>
                    <p>Proximity to the Ahmedabad-Dholera Expressway and the upcoming International Airport ensures seamless global and local access.</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-leaf"></i>
                    <h3>Sustainability</h3>
                    <p>Designed as a sustainable ecosystem with dedicated green zones, water recycling, and renewable energy integration.</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-microchip"></i>
                    <h3>Smart Infrastructure</h3>
                    <p>Fiber-optic connectivity, automated waste management, and real-time city monitoring for an efficient lifestyle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Invest -->
    <section class="about-section" style="background: var(--dark-bg); color: #fff;">
        <div class="container">
            <div class="about-grid">
                <div class="content-image">
                    <img src="assets/about-hero.png" alt="Investment Opportunities">
                </div>
                <div class="content-text">
                    <h2 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 25px;">Why Invest in Dholera?</h2>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                            <i class="fas fa-chart-line" style="color: var(--primary-gold); font-size: 20px; margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-size: 18px; margin-bottom: 5px;">Exponential Growth</h4>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px;">As India's first smart city, the appreciation potential for real estate is unparalleled in the country.</p>
                            </div>
                        </li>
                        <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                            <i class="fas fa-shield-alt" style="color: var(--primary-gold); font-size: 20px; margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-size: 18px; margin-bottom: 5px;">Legal & Transparent</h4>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px;">All our projects are RERA approved with clear titles, ensuring a safe haven for your investments.</p>
                            </div>
                        </li>
                        <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                            <i class="fas fa-industry" style="color: var(--primary-gold); font-size: 20px; margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-size: 18px; margin-bottom: 5px;">Industrial Hub</h4>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px;">Home to major industries, creating massive employment and driving residential demand.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/main-footer.php'; ?>
