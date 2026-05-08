<?php
/**
 * Dholera SIR Information Page
 * High-end SEO Optimized & Well Designed
 */
$seo_title = "Dholera SIR - India's First Greenfield Smart City | Dholera By Us";
$seo_desc = "Discover Dholera SIR, India's first platinum-rated greenfield smart city. Explore connectivity, development plans, and investment opportunities in the largest industrial hub.";
require_once '../database/db_config.php';
require_once '../includes/header.php';
?>

<style>
    :root {
        --sir-gold: #b8860b;
        --sir-navy: #1c335a;
        --sir-light: #f8f9fa;
    }

    .sir-hero {
        background: linear-gradient(rgba(28, 51, 90, 0.8), rgba(28, 51, 90, 0.8)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        padding: 100px 5%;
        text-align: center;
        color: #fff;
    }

    .sir-hero h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .sir-hero p {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto 30px;
        line-height: 1.6;
        opacity: 0.9;
    }

    .sir-quick-nav {
        background: var(--sir-navy);
        padding: 15px 5%;
        position: sticky;
        top: 80px;
        z-index: 999;
        display: flex;
        justify-content: center;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .sir-quick-nav a {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        padding: 10px 15px;
        border-radius: 4px;
        transition: 0.3s;
    }

    .sir-quick-nav a:hover {
        background: var(--sir-gold);
    }

    .sir-section {
        padding: 80px 10%;
    }

    .sir-section:nth-child(even) {
        background: #fff;
    }

    .sir-section:nth-child(odd) {
        background: var(--sir-light);
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 36px;
        color: var(--sir-navy);
        font-weight: 800;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--sir-gold);
        border-radius: 2px;
    }

    .sir-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .sir-content h3 {
        font-size: 28px;
        color: var(--sir-navy);
        margin-bottom: 20px;
        font-weight: 700;
    }

    .sir-content p {
        font-size: 16px;
        color: #555;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .sir-list {
        list-style: none;
    }

    .sir-list li {
        margin-bottom: 12px;
        position: relative;
        padding-left: 30px;
        font-size: 15px;
        color: #444;
    }

    .sir-list li i {
        position: absolute;
        left: 0;
        top: 4px;
        color: var(--sir-gold);
        font-size: 18px;
    }

    .sir-image-box {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .sir-image-box img {
        width: 100%;
        display: block;
        transition: 0.5s;
    }

    .sir-image-box:hover img {
        transform: scale(1.05);
    }

    /* Connectivity Grid */
    .connectivity-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .conn-card {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-top: 5px solid var(--sir-gold);
        transition: 0.3s;
    }

    .conn-card:hover {
        transform: translateY(-10px);
    }

    .conn-card i {
        font-size: 40px;
        color: var(--sir-navy);
        margin-bottom: 20px;
    }

    .conn-card h4 {
        font-size: 20px;
        margin-bottom: 15px;
        color: var(--sir-navy);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sir-grid {
            grid-template-columns: 1fr;
        }
        .sir-quick-nav {
            display: none;
        }
        .sir-hero h1 {
            font-size: 32px;
        }
        .connectivity-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Hero Section -->
<section class="sir-hero">
    <h1>Dholera SIR - Smart City of India</h1>
    <p>Developing India's First Platinum-Rated Greenfield Smart City & Largest Industrial Hub of the Future.</p>
    <div style="display: flex; justify-content: center; gap: 15px;">
        <a href="#overview" class="btn-auth btn-signup">Explore More</a>
        <a href="#connectivity" class="btn-auth btn-login" style="border-color: #fff; color: #fff;">View Connectivity</a>
    </div>
</section>

<!-- Quick Navigation -->
<div class="sir-quick-nav">
    <a href="#overview">Overview</a>
    <a href="#salient-features">Salient Features</a>
    <a href="#connectivity">Connectivity</a>
    <a href="#development">Development Plan</a>
    <a href="#why-dholera">Why Invest?</a>
</div>

<!-- Overview Section -->
<section class="sir-section" id="overview">
    <div class="sir-grid">
        <div class="sir-content">
            <div class="section-title" style="text-align: left;">
                <h2>Dholera SIR Overview</h2>
            </div>
            <p>Dholera Special Investment Region (SIR) is a major project under the Delhi-Mumbai Industrial Corridor (DMIC). It is being developed as a global manufacturing and trading hub over 920 sq km.</p>
            <ul class="sir-list">
                <li><i class="fa-solid fa-check-circle"></i> India's First Platinum-rated Greenfield Smart City.</li>
                <li><i class="fa-solid fa-check-circle"></i> Strategic location between Ahmedabad, Vadodara, and Bhavnagar.</li>
                <li><i class="fa-solid fa-check-circle"></i> Total Project Area: 920 Sq. Km with Activation Area of 22.5 Sq. Km.</li>
                <li><i class="fa-solid fa-check-circle"></i> Integrated with dedicated Freight Corridor and Smart Infrastructure.</li>
            </ul>
        </div>
        <div class="sir-image-box">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dholera Overview">
        </div>
    </div>
</section>

<!-- Video Placeholders -->
<section class="sir-section" style="background: #fff;">
    <div class="section-title">
        <h2>Visual Tour</h2>
    </div>
    <div class="sir-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
        <div class="sir-image-box" style="position: relative;">
            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Video 1">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 50px; color: #fff; cursor: pointer;"><i class="fa-solid fa-play-circle"></i></div>
        </div>
        <div class="sir-image-box" style="position: relative;">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Video 2">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 50px; color: #fff; cursor: pointer;"><i class="fa-solid fa-play-circle"></i></div>
        </div>
        <div class="sir-image-box" style="position: relative;">
            <img src="https://images.unsplash.com/photo-1542744094-24638eff58bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Video 3">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 50px; color: #fff; cursor: pointer;"><i class="fa-solid fa-play-circle"></i></div>
        </div>
    </div>
</section>

<!-- Salient Features -->
<section class="sir-section" id="salient-features">
    <div class="section-title">
        <h2>Salient Features</h2>
    </div>
    <div class="sir-grid">
        <div class="sir-image-box">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Salient Features">
        </div>
        <div class="sir-content">
            <ul class="sir-list">
                <li><i class="fa-solid fa-bolt"></i> 24x7 Uninterrupted Power & Water Supply.</li>
                <li><i class="fa-solid fa-network-wired"></i> World-class ICT Infrastructure (Internet of Things).</li>
                <li><i class="fa-solid fa-recycle"></i> 100% Waste Recycling & Management.</li>
                <li><i class="fa-solid fa-road"></i> Linear Mega-City with Smart Transportation.</li>
                <li><i class="fa-solid fa-leaf"></i> 40% Open Green Space for Sustainable Living.</li>
                <li><i class="fa-solid fa-shield-halved"></i> High-level Security with Command & Control Center.</li>
            </ul>
        </div>
    </div>
</section>

<!-- Connectivity Section -->
<section class="sir-section" id="connectivity">
    <div class="section-title">
        <h2>Multi-Modal Connectivity</h2>
    </div>
    <div class="sir-grid">
        <div class="sir-content">
            <h3>Connecting Dholera to the World</h3>
            <p>Dholera SIR is designed with superior connectivity, ensuring seamless transport for people and goods via road, rail, air, and sea.</p>
            <div class="connectivity-grid">
                <div class="conn-card">
                    <i class="fa-solid fa-plane-up"></i>
                    <h4>Dholera Intl. Airport</h4>
                    <p>Strategically located to serve the SIR and surrounding regions as a global aviation hub.</p>
                </div>
                <div class="conn-card">
                    <i class="fa-solid fa-train"></i>
                    <h4>Metro & High-Speed Rail</h4>
                    <p>Direct metro link from Ahmedabad to Dholera SIR with a dedicated terminal.</p>
                </div>
                <div class="conn-card">
                    <i class="fa-solid fa-road"></i>
                    <h4>6-Lane Expressway</h4>
                    <p>Direct connectivity to Ahmedabad via a state-of-the-art 110km expressway.</p>
                </div>
                <div class="conn-card">
                    <i class="fa-solid fa-anchor"></i>
                    <h4>Sea Port Connectivity</h4>
                    <p>Proximity to world-class ports like Pipavav and Bhavnagar for global trade.</p>
                </div>
            </div>
        </div>
        <div class="sir-image-box">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Connectivity">
        </div>
    </div>
</section>

<!-- Development Plan Section -->
<section class="sir-section" id="development">
    <div class="sir-grid">
        <div class="sir-image-box">
            <img src="https://images.unsplash.com/photo-1503387762-592dea58ef23?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Development Plan">
        </div>
        <div class="sir-content">
            <div class="section-title" style="text-align: left;">
                <h2>Development Plan</h2>
            </div>
            <p>The Dholera SIR development plan is divided into distinct Town Planning (TP) schemes, ensuring organized growth and world-class infrastructure in every phase.</p>
            <ul class="sir-list">
                <li><i class="fa-solid fa-map-location-dot"></i> TP1 & TP2: Initial phases focusing on residential and industrial clusters.</li>
                <li><i class="fa-solid fa-city"></i> Activation Area: 22.5 sq. km area being developed with core infrastructure.</li>
                <li><i class="fa-solid fa-industry"></i> Industrial Clusters: Dedicated zones for Electronics, Aviation, and Auto industries.</li>
                <li><i class="fa-solid fa-tree"></i> Green Belts: Extensive green zones integrated into the urban design.</li>
            </ul>
        </div>
    </div>
</section>

<!-- Why Dholera? -->
<section class="sir-section" id="why-dholera" style="background: var(--sir-navy); color: #fff;">
    <div class="section-title">
        <h2 style="color: #fff;">Why Invest in Dholera SIR?</h2>
    </div>
    <div class="sir-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <div style="text-align: center; padding: 20px;">
            <i class="fa-solid fa-arrow-trend-up" style="font-size: 50px; color: var(--sir-gold); margin-bottom: 20px;"></i>
            <h4>High ROI</h4>
            <p style="color: #ccc; font-size: 14px;">Early investment in a global city ensures maximum appreciation.</p>
        </div>
        <div style="text-align: center; padding: 20px;">
            <i class="fa-solid fa-industry" style="font-size: 50px; color: var(--sir-gold); margin-bottom: 20px;"></i>
            <h4>Industrial Hub</h4>
            <p style="color: #ccc; font-size: 14px;">Home to Fortune 500 companies and global manufacturing units.</p>
        </div>
        <div style="text-align: center; padding: 20px;">
            <i class="fa-solid fa-users-gear" style="font-size: 50px; color: var(--sir-gold); margin-bottom: 20px;"></i>
            <h4>Smart Governance</h4>
            <p style="color: #ccc; font-size: 14px;">Single-window clearance and ease of doing business.</p>
        </div>
        <div style="text-align: center; padding: 20px;">
            <i class="fa-solid fa-earth-asia" style="font-size: 50px; color: var(--sir-gold); margin-bottom: 20px;"></i>
            <h4>Future Ready</h4>
            <p style="color: #ccc; font-size: 14px;">Designed to sustain for generations with futuristic infra.</p>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
