<?php
/**
 * Dholera SIR - Multi-Modal Connectivity Portal
 * Humanized, Professional, and SEO Optimized
 */
$seo_title = "Connectivity - Dholera SIR | Road, Air, Rail & Sea Infrastructure";
$seo_desc = "Explore the world-class multi-modal connectivity of Dholera SIR. Detailed insights into the Ahmedabad-Dholera Expressway, International Airport, Metro Rail, and Sea Ports.";

require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';

// Asset paths for easy future updates
$img_hero = "https://www.dholerametrocity.com/images/conectivity_dholera_sir_header.jpg";
$img_road = "https://www.dholerametrocity.com/connectivity/Road_Connectivity_dholera_SIR_s.jpg";
$img_air  = "https://www.dholerametrocity.com/connectivity/Air_Connectivity_Dholera_SIR_s.jpg";
$img_rail = "https://www.dholerametrocity.com/connectivity/Rail_Connectivity_Dholera_SIR_s.jpg";
$img_sea  = "https://www.dholerametrocity.com/connectivity/Sea_Connectivity_Dholera_SIR_s.jpg";

// Distance Data from Official Sources
$distances = [
    ['city' => 'Gandhinagar', 'dist' => '140 km'],
    ['city' => 'Ahmedabad', 'dist' => '100 km'],
    ['city' => 'Rajkot', 'dist' => '225 km'],
    ['city' => 'Jamnagar', 'dist' => '315 km'],
    ['city' => 'Surat', 'dist' => '270 km'],
    ['city' => 'Mumbai', 'dist' => '510 km'],
    ['city' => 'Delhi', 'dist' => '815 km'],
];
?>

<style>
    .conn-hero {
        background: url('<?php echo $img_hero; ?>') no-repeat center center;
        background-size: cover;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .conn-hero::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .conn-hero-text {
        position: relative;
        z-index: 1;
        text-align: center;
        color: #fff;
    }

    .conn-hero-text h1 {
        font-size: 42px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .conn-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .conn-intro {
        text-align: center;
        max-width: 900px;
        margin: 0 auto 60px;
    }

    .conn-intro h2 {
        font-size: 32px;
        color: var(--secondary-color);
        margin-bottom: 20px;
    }

    .conn-intro p {
        font-size: 18px;
        line-height: 1.8;
        color: #666;
    }

    /* Connectivity Grid Layout */
    .connectivity-block {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        margin-bottom: 80px;
        align-items: flex-start;
    }

    .connectivity-block:nth-child(even) {
        direction: rtl;
    }

    .connectivity-block:nth-child(even) .conn-text {
        direction: ltr;
    }

    .conn-image {
        border: 1px solid #ddd;
        padding: 10px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .conn-image img {
        width: 100%;
        display: block;
        border-radius: 4px;
    }

    .conn-text h3 {
        font-size: 26px;
        color: var(--secondary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 10px;
    }

    .conn-text h3 i {
        color: var(--primary-color);
    }

    .conn-text p {
        font-size: 16px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 20px;
    }

    /* Table Styling */
    .dist-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }

    .dist-table th {
        background: #f8f9fa;
        text-align: left;
        padding: 10px 15px;
        border: 1px solid #eee;
        color: var(--secondary-color);
    }

    .dist-table td {
        padding: 10px 15px;
        border: 1px solid #eee;
        color: #666;
    }

    .dist-table tr:hover {
        background: #fff9ed;
    }

    /* Summary Bar */
    .conn-summary-bar {
        background: var(--secondary-color);
        color: #fff;
        padding: 40px 20px;
        border-radius: 12px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        text-align: center;
        margin-bottom: 60px;
    }

    .summary-item i {
        font-size: 30px;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .summary-item h4 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .summary-item span {
        font-size: 13px;
        opacity: 0.8;
    }

    @media (max-width: 992px) {
        .connectivity-block {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .connectivity-block:nth-child(even) {
            direction: ltr;
        }
        .conn-summary-bar {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .conn-hero h1 {
            font-size: 28px;
        }
    }
</style>

<!-- Hero Section -->
<section class="conn-hero"></section>

<div class="conn-container">
    <!-- Page Header (Moved from Hero) -->
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 36px; color: var(--secondary-color); font-weight: 800; text-transform: uppercase; margin-bottom: 5px;">Connectivity - Dholera SIR</h1>
        <p style="font-size: 18px; color: var(--primary-color); font-weight: 600;">Connecting the Future of Industrial Growth to the World</p>
    </div>

    <!-- Intro -->
    <div class="conn-intro">
        <h2>Multi-Modal Connectivity Hub</h2>
        <p>Dholera Special Investment Region (SIR) is being developed as a global trading and manufacturing hub, supported by world-class infrastructure. Its strategic location offers seamless connectivity via Road, Rail, Air, and Sea, making it a prime destination for global investors.</p>
    </div>

    <!-- Summary Bar -->
    <div class="conn-summary-bar">
        <div class="summary-item">
            <i class="fa-solid fa-road"></i>
            <h4>110 KM</h4>
            <span>Expressway Length</span>
        </div>
        <div class="summary-item">
            <i class="fa-solid fa-plane"></i>
            <h4>1426 Hectares</h4>
            <span>International Airport</span>
        </div>
        <div class="summary-item">
            <i class="fa-solid fa-train"></i>
            <h4>Metro Link</h4>
            <span>Ahmedabad to SIR</span>
        </div>
        <div class="summary-item">
            <i class="fa-solid fa-anchor"></i>
            <h4>40 KM</h4>
            <span>Nearest Sea Port</span>
        </div>
    </div>

    <!-- Road Connectivity -->
    <section class="connectivity-block" id="road">
        <div class="conn-image">
            <img src="<?php echo $img_road; ?>" alt="Road Connectivity Dholera SIR">
        </div>
        <div class="conn-text">
            <h3><i class="fa-solid fa-car-side"></i> Road Connectivity</h3>
            <p>Dholera is connected to Ahmedabad by a 6-lane access-controlled Expressway (extendable to 10 lanes). This 110km long project will reduce the travel time from Ahmedabad to Dholera to less than 60 minutes.</p>
            <p>The region is also integrated with the Central Spine Road and the Coastal Road projects, ensuring efficient logistics movement within the state of Gujarat and across the DMIC corridor.</p>
            <table class="dist-table">
                <thead>
                    <tr>
                        <th>Major City</th>
                        <th>Distance from SIR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ahmedabad</td><td>100 KM</td></tr>
                    <tr><td>Bhavnagar</td><td>40 KM</td></tr>
                    <tr><td>Vadodara</td><td>150 KM</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Air Connectivity -->
    <section class="connectivity-block" id="air">
        <div class="conn-image">
            <img src="<?php echo $img_air; ?>" alt="Air Connectivity Dholera SIR">
        </div>
        <div class="conn-text">
            <h3><i class="fa-solid fa-plane-up"></i> Air Connectivity</h3>
            <p>The Dholera International Airport is located near Navagam village in Dholera Taluka. Spread across 1426 hectares, it will serve as the secondary airport for Ahmedabad and the primary aviation hub for the Special Investment Region.</p>
            <p>Designed to handle both passenger and cargo traffic, it will feature two runways and world-class logistics facilities to support export-oriented industries.</p>
            <table class="dist-table">
                <thead>
                    <tr>
                        <th>City Name</th>
                        <th>Aerial Distance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($distances as $d): ?>
                    <tr>
                        <td><?php echo $d['city']; ?></td>
                        <td><?php echo $d['dist']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Rail Connectivity -->
    <section class="connectivity-block" id="rail">
        <div class="conn-image">
            <img src="<?php echo $img_rail; ?>" alt="Rail Connectivity Dholera SIR">
        </div>
        <div class="conn-text">
            <h3><i class="fa-solid fa-train-subway"></i> Rail & Metro Connectivity</h3>
            <p>Dholera SIR will be connected to Ahmedabad via a High-Speed Metro Rail. This project is part of the integrated transport network designed to facilitate daily commuting for professionals and residents.</p>
            <p>Furthermore, Dholera is strategically positioned near the Dedicated Freight Corridor (DFC), providing massive logistics advantages for manufacturing units by connecting them to major ports and northern India hubs.</p>
        </div>
    </section>

    <!-- Sea Connectivity -->
    <section class="connectivity-block" id="sea">
        <div class="conn-image">
            <img src="<?php echo $img_sea; ?>" alt="Sea Connectivity Dholera SIR">
        </div>
        <div class="conn-text">
            <h3><i class="fa-solid fa-ship"></i> Sea Port Connectivity</h3>
            <p>Proximity to operational ports is a key driver for Dholera's industrial success. The Bhavnagar Port is just 40km away, while the world-class Pipavav Port is located at a distance of 160km.</p>
            <p>These ports provide direct access to international shipping routes, enabling industries in Dholera SIR to export products globally with minimal logistics costs.</p>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
