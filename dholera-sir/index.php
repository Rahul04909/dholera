<?php
/**
 * Dholera SIR - Official Information Portal
 * Structured, Humanized, and SEO Optimized
 */
$seo_title = "Dholera SIR | Detailed Overview, Connectivity & Investment Plan";
$seo_desc = "Complete guide to Dholera Special Investment Region (SIR). Explore Town Planning schemes, multi-modal connectivity (Airport, Expressway), and salient features of India's first smart city.";

require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';

// Data for the page (Humanized Content)
$tp_schemes = [
    ['scheme' => 'TP 1', 'area' => '51 sq km', 'focus' => 'Residential & Commercial'],
    ['scheme' => 'TP 2', 'area' => '102 sq km', 'focus' => 'Industrial & Logistics'],
    ['scheme' => 'TP 3', 'area' => '66 sq km', 'focus' => 'Knowledge & IT Hub'],
    ['scheme' => 'TP 4', 'area' => '60 sq km', 'focus' => 'Solar Park & Recreation'],
];

$connectivity_data = [
    ['mode' => 'Road', 'project' => 'Ahmedabad-Dholera Expressway', 'status' => 'Under Construction (110 km)'],
    ['mode' => 'Rail', 'project' => 'Ahmedabad-Dholera Metro Rail', 'status' => 'Proposed with Dedicated Terminal'],
    ['mode' => 'Air', 'project' => 'Dholera International Airport', 'status' => 'Work in Progress (Navagam Village)'],
    ['mode' => 'Sea', 'project' => 'Bhavnagar Port', 'status' => 'Operational (Proximity 40 km)'],
];
?>

<style>
    /* Hero Style Consistent with other SIR pages */
    .sir-hero-simple {
        background: linear-gradient(rgba(28, 51, 90, 0.8), rgba(28, 51, 90, 0.8)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        width: 100%;
        aspect-ratio: 21 / 5;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .sir-hero-simple h1 {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .sir-container {
        max-width: 1200px;
        margin: 50px auto;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
        padding: 0 20px;
    }

    /* Sidebar Navigation */
    .sir-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sir-nav-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .sir-nav-title {
        background: var(--secondary-color);
        color: #fff;
        padding: 15px 20px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .sir-nav-list {
        list-style: none;
    }

    .sir-nav-list li a {
        display: block;
        padding: 12px 20px;
        color: #444;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
    }

    .sir-nav-list li a:hover {
        background: #f9f9f9;
        color: var(--primary-color);
        padding-left: 25px;
    }

    /* Main Content Area */
    .sir-main-content {
        background: #fff;
        padding: 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .sir-page-header {
        border-bottom: 3px solid var(--primary-color);
        margin-bottom: 30px;
        padding-bottom: 15px;
    }

    .sir-page-header h1 {
        font-size: 32px;
        color: var(--secondary-color);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .sir-breadcrumb {
        font-size: 13px;
        color: #888;
        margin-bottom: 5px;
    }

    .sir-article-section {
        margin-bottom: 50px;
    }

    .sir-article-section h2 {
        font-size: 24px;
        color: var(--secondary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sir-article-section h2 i {
        color: var(--primary-color);
    }

    .sir-article-section p {
        font-size: 16px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 20px;
    }

    /* Content Lists */
    .content-list {
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .content-list li {
        position: relative;
        padding-left: 25px;
        font-size: 15px;
        color: #555;
    }

    .content-list li::before {
        content: "\f058";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: var(--primary-color);
    }

    /* Professional Tables */
    .sir-table-container {
        overflow-x: auto;
        margin: 25px 0;
    }

    .sir-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    .sir-table th {
        background: #f8f9fa;
        text-align: left;
        padding: 12px 15px;
        border: 1px solid #eee;
        color: var(--secondary-color);
        font-weight: 700;
    }

    .sir-table td {
        padding: 12px 15px;
        border: 1px solid #eee;
        color: #444;
    }

    .sir-table tr:hover {
        background: #fffcf5;
    }

    /* Info Blocks */
    .info-block {
        background: #f8f9fa;
        border-left: 5px solid var(--secondary-color);
        padding: 25px;
        border-radius: 4px;
        margin: 30px 0;
    }

    .info-block h4 {
        margin-bottom: 10px;
        color: var(--secondary-color);
        font-weight: 700;
    }

    @media (max-width: 992px) {
        .sir-container {
            grid-template-columns: 1fr;
        }
        .sir-sidebar {
            display: none;
        }
        .content-list {
            grid-template-columns: 1fr;
        }
        .sir-hero-simple h1 {
            font-size: 26px;
        }
    }
</style>

<section class="sir-hero-simple">
    <h1>Dholera Special Investment Region</h1>
    <p>Official Overview of India's First Platinum-Rated Smart City</p>
</section>

<div class="sir-container">
    <!-- Sidebar -->
    <aside class="sir-sidebar">
        <div class="sir-nav-box">
            <div class="sir-nav-title">Quick Navigation</div>
            <ul class="sir-nav-list">
                <li><a href="#overview">SIR Overview</a></li>
                <li><a href="#salient-features">Salient Features</a></li>
                <li><a href="#connectivity">Connectivity Map</a></li>
                <li><a href="#town-planning">Town Planning</a></li>
                <li><a href="#why-invest">Why Invest?</a></li>
            </ul>
        </div>

        <div class="info-block" style="margin-top: 30px; border-left-color: var(--primary-color);">
            <h4>Download Center</h4>
            <p style="font-size: 13px; color: #666;">Get official brochures and master plans of Dholera SIR.</p>
            <a href="#" class="btn-auth btn-signup" style="width: 100%; font-size: 13px; text-align: center; display: block; margin-top: 15px;">Download Brochure</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="sir-main-content">
        <header class="sir-page-header">
            <div class="sir-breadcrumb">Home > Dholera SIR > Official Overview</div>
            <h1>The Largest Greenfield Industrial Hub</h1>
            <p style="color: #666; font-style: italic;">A Flagship Project of the Delhi-Mumbai Industrial Corridor (DMIC)</p>
        </header>

        <section class="sir-article-section" id="overview">
            <h2><i class="fa-solid fa-circle-info"></i> Project Overview</h2>
            <p>Dholera Special Investment Region (SIR) is being developed as a global manufacturing and trading hub, strategically located 100 km south of Ahmedabad. Spread over 920 sq km, it is the first platinum-rated greenfield smart city in India, designed to rival global business centers like Singapore and Dubai.</p>
            <p>The project is part of the Delhi-Mumbai Industrial Corridor (DMIC) and aims to provide high-end infrastructure, sustainable living, and world-class logistics for industries across the globe.</p>
        </section>

        <section class="sir-article-section" id="salient-features">
            <h2><i class="fa-solid fa-star"></i> Salient Features</h2>
            <ul class="content-list">
                <li>Linear Mega-City Planning</li>
                <li>24x7 Smart Water Management</li>
                <li>Uninterrupted Power Supply</li>
                <li>ICT Enabled Governance</li>
                <li>Zero Waste Discharge Policy</li>
                <li>Integrated Transit System</li>
                <li>40% Open Green Spaces</li>
                <li>Single Window Clearances</li>
            </ul>
        </section>

        <section class="sir-article-section" id="connectivity">
            <h2><i class="fa-solid fa-truck-fast"></i> Multi-Modal Connectivity</h2>
            <p>Dholera SIR is designed for global accessibility. The infrastructure integrates road, rail, air, and sea connectivity to ensure seamless movement of industrial cargo and passengers.</p>
            
            <div class="sir-table-container">
                <table class="sir-table">
                    <thead>
                        <tr>
                            <th>Connectivity Mode</th>
                            <th>Project Name</th>
                            <th>Current Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($connectivity_data as $conn): ?>
                        <tr>
                            <td><strong><?php echo $conn['mode']; ?></strong></td>
                            <td><?php echo $conn['project']; ?></td>
                            <td><?php echo $conn['status']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="sir-article-section" id="town-planning">
            <h2><i class="fa-solid fa-map"></i> Town Planning Schemes</h2>
            <p>The entire region is divided into 6 Town Planning (TP) schemes. This structured approach ensures that basic infrastructure is completed before actual construction begins.</p>
            
            <div class="sir-table-container">
                <table class="sir-table">
                    <thead>
                        <tr>
                            <th>TP Scheme</th>
                            <th>Total Area</th>
                            <th>Primary Focus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tp_schemes as $tp): ?>
                        <tr>
                            <td><?php echo $tp['scheme']; ?></td>
                            <td><?php echo $tp['area']; ?></td>
                            <td><?php echo $tp['focus']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="info-block">
            <h4>Activation Area (22.5 Sq Km)</h4>
            <p>The Activation Area is the core of Dholera SIR where infrastructure development is in the most advanced stage. It includes the administrative ABCD Building, solar parks, and premium industrial clusters.</p>
        </div>

        <section class="sir-article-section" id="why-invest">
            <h2><i class="fa-solid fa-chart-line"></i> Why Invest in Dholera?</h2>
            <p>Investing in Dholera SIR is considered a generational opportunity due to the massive government backing and strategic importance for India's industrial growth.</p>
            <ul class="content-list">
                <li>High ROI potential in early stages</li>
                <li>Strategic location for manufacturing</li>
                <li>Presence of major anchor industries</li>
                <li>Proximity to world-class ports</li>
                <li>100% transparent land ownership</li>
                <li>Planned residential zones for 2M people</li>
            </ul>
        </section>
    </main>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
