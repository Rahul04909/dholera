<?php
/**
 * Developer Profile & Details Page - Justdial Style Premium Layout
 * Dholera Smart City
 */
require_once __DIR__ . '/database/db_config.php';

// Retrieve and validate the developer slug
$slug = isset($slug) ? $slug : (isset($_GET['slug']) ? trim($_GET['slug']) : '');

// Comprehensive, high-fidelity developer profiles config array
$developer_profiles = [
    '7oak-group' => [
        'name' => '7Oak Group',
        'logo' => '7oak.jpg',
        'tagline' => 'Structured Smart Communal Living',
        'short_desc' => 'Pioneering structured smart residential plotting and premium community townships inside the planned Dholera Greenfield Smart City region.',
        'desc' => '7Oak Group stands as a premier beacon of excellence and transparency in Dholera SIR infrastructure development. Focused on delivering premium land layout plots, wide internal concrete roads, functional green gardens, and gated security systems, 7Oak Group continues to pave the way for sustainable Smart City living. Backed by 100% clear titles, immediate possession frameworks, and comprehensive RERA compliance, they offer highly strategic and secure investments for future-oriented buyers.',
        'experience' => '12+ Years',
        'projects_count' => '14 Completed',
        'area_developed' => '3.5M+ Sq.Ft.',
        'happy_families' => '1,800+',
        'rating' => '4.8',
        'reviews_count' => '142',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Aarav Mehta', 'rating' => 5, 'text' => 'We bought a residential plot with 7Oak Group. The title clearance and legal documentation were handled exceptionally well. Highly recommended!', 'date' => '2026-05-12'],
            ['author' => 'Neha Sharma', 'rating' => 4, 'text' => 'Very satisfied with the customer service and prompt site visits. The development work at their Dholera site is pacing up nicely.', 'date' => '2026-05-02'],
            ['author' => 'Vikram Patel', 'rating' => 5, 'text' => 'Excellent investment opportunity. The 7Oak layout has a grand entrance, wide internal roads, and premium green spaces as promised.', 'date' => '2026-04-18']
        ]
    ],
    'ethereum-infracon' => [
        'name' => 'Ethereum Infracon',
        'logo' => 'ethereum.jpg',
        'tagline' => 'Decentralized Legacy, Concrete Trust',
        'short_desc' => 'Designing future-ready smart utility infrastructure and premium plotted townships equipped with high-end facilities inside Dholera SIR.',
        'desc' => 'Ethereum Infracon has built an unwavering reputation on trust, engineering marvels, and modern civil planning. By focusing heavily on the core activation zones of Dholera Greenfield Smart City, Ethereum Infracon delivers state-of-the-art plotting schemes equipped with underground cabling, high-speed stormwater drainage, separate sewage systems, and seamless highway access. Their professional team ensures client-first processes and reliable legal transparency.',
        'experience' => '9+ Years',
        'projects_count' => '8 Completed',
        'area_developed' => '2.1M+ Sq.Ft.',
        'happy_families' => '1,100+',
        'rating' => '4.7',
        'reviews_count' => '98',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Rohan Joshi', 'rating' => 5, 'text' => 'Ethereum Infracon offers the best strategic locations. The plot prices are reasonable and the future appreciation looks very promising.', 'date' => '2026-05-14'],
            ['author' => 'Anjali Shah', 'rating' => 4, 'text' => 'Seamless transaction and support throughout the registration phase. Their transparent approach makes them stand out.', 'date' => '2026-04-29'],
            ['author' => 'Harsh Vardhan', 'rating' => 5, 'text' => 'Great planning! The underground wiring and stormwater system are premium features rarely found in other standard plots.', 'date' => '2026-04-10']
        ]
    ],
    'gaim-group' => [
        'name' => 'GAIM Group',
        'logo' => 'gaim-1.jpg',
        'tagline' => 'Architecting Mega Industrial Infrastructure',
        'short_desc' => 'Pioneering commercial, manufacturing, and high-yield industrial land plotting projects inside the core economic corridors of Dholera SIR.',
        'desc' => 'GAIM Group is widely recognized as a premier force driving mega industrial land layouts and heavy manufacturing infrastructure in Gujarat. They specialize in catering to foreign and domestic manufacturing firms seeking smart factory zones, logistic depots, and warehouse parks in India\'s manufacturing corridor. GAIM layouts incorporate heavy-vehicle wide arterial roads, optimized high-tension electricity lines, and clear custom clearing guidelines.',
        'experience' => '15+ Years',
        'projects_count' => '22 Completed',
        'area_developed' => '6.8M+ Sq.Ft.',
        'happy_families' => '850+ Corporate Clients',
        'rating' => '4.9',
        'reviews_count' => '186',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Rajesh Singhania', 'rating' => 5, 'text' => 'Highly structured industrial plots. GAIM Group helped us secure legal permissions for warehouse layouts quickly.', 'date' => '2026-05-19'],
            ['author' => 'Amit Trivedi', 'rating' => 5, 'text' => 'Outstanding layout scaling and logistics support. Best partner for manufacturing land parcels inside Dholera SIR.', 'date' => '2026-05-08'],
            ['author' => 'Karan Malhotra', 'rating' => 4, 'text' => 'Robust infrastructure, high power load availability, and great location near the Dedicated Freight Corridor.', 'date' => '2026-04-25']
        ]
    ],
    'gohil-group' => [
        'name' => 'Gohil Group',
        'logo' => 'gohil.jpg',
        'tagline' => 'Generations of Residential Legacy',
        'short_desc' => 'Delivering premium, high-value plotting schemes and family-centric residential townships in Dholera Smart City.',
        'desc' => 'Gohil Group represents generations of real estate trust, quality construction, and family values. Gohil layouts in Dholera focus on modern family living with landscaped children play parks, decorative tree-lined jogging tracks, fully-fenced boundary walls, and active clubhouses. Their projects represent excellent entry points for mid-segment and premium investors looking for stable, long-term capital growth.',
        'experience' => '14+ Years',
        'projects_count' => '11 Completed',
        'area_developed' => '2.8M+ Sq.Ft.',
        'happy_families' => '1,450+',
        'rating' => '4.6',
        'reviews_count' => '104',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Jignesh Gohil', 'rating' => 5, 'text' => 'Very prompt response, honest pricing, and transparent document checks. I am glad I chose Gohil Group for my Dholera plot.', 'date' => '2026-05-11'],
            ['author' => 'Preeti Vyas', 'rating' => 4, 'text' => 'Beautiful gated township layouts with active water connections and green zones. Gohil group has delivered on their timeline.', 'date' => '2026-04-30'],
            ['author' => 'Suresh Nair', 'rating' => 5, 'text' => 'Highly secure gated community plotting scheme. RERA registered and extremely clean title.', 'date' => '2026-04-12']
        ]
    ],
    'gap-group' => [
        'name' => 'GAP Group',
        'logo' => 'gap-group.jpg',
        'tagline' => 'Bridges to Future Real Estate',
        'short_desc' => 'Developing high-end residential, mixed-use, and commercial smart townships inside the heart of Dholera SIR.',
        'desc' => 'GAP Group is a key driver of modern real estate solutions in Western India. Known for introducing state-of-the-art technological features in residential developments, their townships in Dholera boast smart waste disposal networks, Wi-Fi zones, fully-paved walkways, and advanced security. GAP Group is committed to building bridges of trust and sustainability that last for generations.',
        'experience' => '11+ Years',
        'projects_count' => '16 Completed',
        'area_developed' => '4.2M+ Sq.Ft.',
        'happy_families' => '2,200+',
        'rating' => '4.8',
        'reviews_count' => '210',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Manish Kulkarni', 'rating' => 5, 'text' => 'Absolutely professional team. The GAP Group Dholera plots are positioned in prime locations and have very high resale potential.', 'date' => '2026-05-18'],
            ['author' => 'Swati Deshmukh', 'rating' => 5, 'text' => 'GAP Group handles documentation with extreme care. The title report was thoroughly checked by their legal panel.', 'date' => '2026-05-01'],
            ['author' => 'Abhay Patel', 'rating' => 4, 'text' => 'Excellent construction quality of the boundary walls and community clubhouses. The location is very near the Dholera Expressway.', 'date' => '2026-04-15']
        ]
    ],
    'mirrikh-infratech' => [
        'name' => 'Mirrikh Infratech',
        'logo' => 'mirrikh.jpg',
        'tagline' => 'Crafting Dholera\'s Largest Planned Landscapes',
        'short_desc' => 'Leading the land development segment in Dholera SIR with massive plotted townships, grand clubhouses, and premium lifestyle amenities.',
        'desc' => 'Mirrikh Infratech is a premier leader in master-planned plotted land developments inside Dholera SIR. Best known for their mega-scale residential township designs like Mayur Ananta and Mayur Ananta II, Mirrikh Infratech is dedicated to setting new benchmarks for smart and elevated living. Their projects integrate massive lush green lawns, functional multi-purpose clubhouses, advanced security cabins, and top-tier infrastructure while guaranteeing absolute legal clearance, RERA compliance, and immediate possession.',
        'experience' => '10+ Years',
        'projects_count' => '12 Completed',
        'area_developed' => '5.5M+ Sq.Ft.',
        'happy_families' => '2,500+',
        'rating' => '4.9',
        'reviews_count' => '278',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Devendra Rathore', 'rating' => 5, 'text' => 'We invested in Mayur Ananta II. The project layout is magnificent, featuring a grand entrance and high-end infrastructure.', 'date' => '2026-05-22'],
            ['author' => 'Shalini Iyer', 'rating' => 5, 'text' => 'Mirrikh Infratech has the best track record in Dholera. Their legal checks are rock solid and they provide immediate registry.', 'date' => '2026-05-15'],
            ['author' => 'Pankaj Dubey', 'rating' => 4, 'text' => 'Extremely grand plotting layout. Excellent road widths and green zones. Great customer service team.', 'date' => '2026-04-20']
        ]
    ],
    'nestoria-group' => [
        'name' => 'Nestoria Group',
        'logo' => 'nestoria.jpg',
        'tagline' => 'Cozy Homes, Secure Investments',
        'short_desc' => 'Delivering highly secure, gated residential plot layouts and luxury villa schemes inside Dholera SIR.',
        'desc' => 'Nestoria Group is synonymous with high-end gated residential communities. Operating on the core values of architectural integrity, aesthetic elegance, and environmental responsibility, Nestoria creates beautifully integrated landscapes that offer the perfect escape from the bustle, while keeping smart city convenience within instant reach. Their RERA approved villa and plot schemes represent the height of luxury land investments.',
        'experience' => '8+ Years',
        'projects_count' => '7 Completed',
        'area_developed' => '1.9M+ Sq.Ft.',
        'happy_families' => '950+',
        'rating' => '4.7',
        'reviews_count' => '84',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Siddharth Roy', 'rating' => 5, 'text' => 'Nestoria villas are architecturally stunning. Perfect integration of modern design and nature.', 'date' => '2026-05-20'],
            ['author' => 'Kiran Joshi', 'rating' => 4, 'text' => 'Secure boundary walls, gated entries, and fully functional utilities. Very transparent buying process.', 'date' => '2026-05-05'],
            ['author' => 'Nisha Sen', 'rating' => 5, 'text' => 'RERA approved and title clear. Nestoria Group provides excellent support for bank loans as well.', 'date' => '2026-04-14']
        ]
    ],
    'rsc-group' => [
        'name' => 'RSC Group',
        'logo' => 'rsc-group.jpg',
        'tagline' => 'Redefining Smart Civic Infrastructure',
        'short_desc' => 'Constructing premium commercial spaces and heavy civic infrastructure plotting corridors inside Dholera SIR.',
        'desc' => 'RSC Group has emerged as a premium name in building heavy civic-aligned and commercial infrastructure plots. Their commercial layouts inside Dholera Greenfield Smart City accommodate retail zones, business plazas, and private commercial office spaces. RSC designs focus heavily on high footfall optimization, smart traffic flows, structural compliance, and prime main-road access.',
        'experience' => '13+ Years',
        'projects_count' => '15 Completed',
        'area_developed' => '3.8M+ Sq.Ft.',
        'happy_families' => '1,600+ Commercial Partners',
        'rating' => '4.8',
        'reviews_count' => '130',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Narendra Patel', 'rating' => 5, 'text' => 'Outstanding location advantages for commercial shops. RSC Group delivers what they promise.', 'date' => '2026-05-23'],
            ['author' => 'Kunal Sarin', 'rating' => 5, 'text' => 'A highly legal-oriented developer. Title reports are clean and registration was completed without delays.', 'date' => '2026-05-10'],
            ['author' => 'Suresh Bhardwaj', 'rating' => 4, 'text' => 'Perfect highway connectivity, smart structural engineering, and grand plotting designs for commercial use.', 'date' => '2026-04-22']
        ]
    ],
    'scrj-group' => [
        'name' => 'SCRJ Group',
        'logo' => 'scrj.jpg',
        'tagline' => 'Building Trust, Plot by Plot',
        'short_desc' => 'Providing highly affordable, secure, and RERA-approved residential plotting layouts inside Dholera SIR.',
        'desc' => 'SCRJ Group is dedicated to making real estate investments accessible, simple, and secure for everyday families and long-term retail investors. Operating on thin margins and high-volume land development, their layouts offer complete perimeter boundary fencing, active internal road networks, dedicated water tank grids, and simple registry options. SCRJ Group represents the pinnacle of retail plotting trust.',
        'experience' => '7+ Years',
        'projects_count' => '9 Completed',
        'area_developed' => '1.7M+ Sq.Ft.',
        'happy_families' => '1,200+',
        'rating' => '4.5',
        'reviews_count' => '76',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Vivek Saxena', 'rating' => 5, 'text' => 'Highly affordable land plots with secure gated boundaries. Best investment for retail buyers like me.', 'date' => '2026-05-24'],
            ['author' => 'Rita Sharma', 'rating' => 4, 'text' => 'Transparent documentation process. The site visit was well arranged and all queries were cleared.', 'date' => '2026-05-12'],
            ['author' => 'Deepak Rawat', 'rating' => 5, 'text' => 'Excellent possession support. Immediate registry and demarcation done on day one.', 'date' => '2026-04-18']
        ]
    ],
    'seksaria-group' => [
        'name' => 'Seksaria Group',
        'logo' => 'seksaria.jpg',
        'tagline' => 'Luxury Spaces, Timeless Value',
        'short_desc' => 'Crafting luxury villas and ultra-premium plotting schemes with smart utility features in Dholera SIR.',
        'desc' => 'Seksaria Group stands as the pinnacle of elite luxury developments. With a design philosophy centered on classical aesthetics re-imagined for future smart lifestyles, Seksaria offers double-height luxury villas, smart automated private clubhouses, organic farming zones, and private security systems. Seksaria layouts provide timeless capital appreciation and the most exclusive address inside Dholera.',
        'experience' => '16+ Years',
        'projects_count' => '20 Completed',
        'area_developed' => '4.8M+ Sq.Ft.',
        'happy_families' => '1,750+',
        'rating' => '4.9',
        'reviews_count' => '215',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Aditya Birla', 'rating' => 5, 'text' => 'The most elite plotting development inside Dholera SIR. Seksaria stands for high-end luxury and absolute privacy.', 'date' => '2026-05-25'],
            ['author' => 'Meera Nair', 'rating' => 5, 'text' => 'Outstanding villa layouts, roman architectural design, and pristine green spaces. Professional customer service.', 'date' => '2026-05-16'],
            ['author' => 'Sanjay Singhania', 'rating' => 4, 'text' => 'Very clear documents, RERA approved layout, and prompt support for registry transfer.', 'date' => '2026-05-02']
        ]
    ],
    'singhal-group' => [
        'name' => 'Singhal Group',
        'logo' => 'singhal.jpg',
        'tagline' => 'Engineering Smart Plotted Communities',
        'short_desc' => 'Designing smart utility residential plotting townships and infrastructure-grade layouts inside Dholera SIR.',
        'desc' => 'Singhal Group combines heavy civil engineering principles with modern land plotting strategies to construct smart communities in Dholera SIR. Each township features pre-installed high-pressure water grids, structural stormwater channels, pre-allocated telecommunication ducts, and beautiful concrete internal pathways. Singhal Group ensures premium quality and zero legal compromises.',
        'experience' => '10+ Years',
        'projects_count' => '13 Completed',
        'area_developed' => '3.2M+ Sq.Ft.',
        'happy_families' => '1,650+',
        'rating' => '4.7',
        'reviews_count' => '112',
        'phone' => '+91 99999 99999',
        'whatsapp' => '919999999999',
        'reviews' => [
            ['author' => 'Sunil Gupta', 'rating' => 5, 'text' => 'Singhal Group has high engineering standards. The concrete roads and water pipelines are perfectly pre-installed.', 'date' => '2026-05-24'],
            ['author' => 'Dr. Renu Malhotra', 'rating' => 5, 'text' => 'A very supportive sales team. They helped us understand Dholera SIR town planning mapping transparently.', 'date' => '2026-05-13'],
            ['author' => 'Gaurav Aggarwal', 'rating' => 4, 'text' => 'Clean title, secure layouts, and well-managed site visits. Highly reliable partner for investments.', 'date' => '2026-04-28']
        ]
    ]
];

// Fallback logic if slug not found
if (empty($slug) || !array_key_exists($slug, $developer_profiles)) {
    // Redirect to index page to avoid layout break
    header("Location: index.php");
    exit();
}

$dev_info = $developer_profiles[$slug];

// Dynamically fetch projects developed by this specific developer in the database
// We map projects by searching for the developer's core name inside the project title/about
$core_name = str_replace(' Group', '', str_replace(' Infratech', '', str_replace(' Infracon', '', $dev_info['name'])));
$brand_keyword = '%' . $core_name . '%';

$show_featured_fallback = false;
try {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE status = 'active' AND (title LIKE :brand OR about_project LIKE :brand) ORDER BY created_at DESC");
    $stmt->execute(['brand' => $brand_keyword]);
    $dev_projects = $stmt->fetchAll();
    
    // If no projects found specifically, query recent active projects as a beautiful featured scheme fallback
    if (empty($dev_projects)) {
        $show_featured_fallback = true;
        $stmt_fallback = $conn->prepare("SELECT * FROM projects WHERE status = 'active' ORDER BY created_at DESC LIMIT 4");
        $stmt_fallback->execute();
        $dev_projects = $stmt_fallback->fetchAll();
    }
} catch (PDOException $e) {
    $dev_projects = [];
}

// SEO Meta variables
$seo_title = htmlspecialchars($dev_info['name']) . " | Verified Developer in Dholera SIR | Portfolios & Reviews";
$seo_desc = htmlspecialchars($dev_info['short_desc']) . " Explore active plotting schemes, verified RERA certificates, customer reviews, and contact credentials.";
$seo_keywords = htmlspecialchars($dev_info['name']) . ", Dholera Developer, Dholera SIR Plots, Verified Builder Dholera, Real Estate Gujarat";

// Include site header
include __DIR__ . '/includes/header.php';
?>

<style>
    /* Premium Justdial-Style Scoped Style Sheet */
    :root {
        --dev-gold: #b8860b;
        --dev-navy: #1c335a;
        --dev-light-gold: #fdfbf7;
        --dev-bg: #f8fafc;
        --dev-border: #e2e8f0;
    }

    body {
        background-color: var(--dev-bg);
    }

    .dev-profile-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 20px;
        font-family: 'Outfit', sans-serif;
    }

    /* 1. Header Banner & Profile Section */
    .dev-profile-card {
        background: #fff;
        border: 1px solid var(--dev-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.04);
        overflow: hidden;
        margin-bottom: 35px;
        position: relative;
    }

    .dev-profile-cover {
        height: 180px;
        background: linear-gradient(135deg, var(--dev-navy) 0%, #0d1e3a 100%);
        position: relative;
        overflow: hidden;
    }

    /* Gold/Champagne Glow */
    .dev-profile-cover::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(184, 134, 11, 0.15) 0%, transparent 70%);
        top: -100px;
        right: -50px;
        border-radius: 50%;
    }

    .dev-profile-details-row {
        padding: 30px 40px;
        display: flex;
        align-items: flex-end;
        position: relative;
        margin-top: 0;
        z-index: 5;
        gap: 30px;
        text-align: left;
    }

    .dev-profile-logo-wrapper {
        width: 140px;
        height: 140px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(28, 51, 90, 0.08);
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        flex-shrink: 0;
        margin-top: -85px;
    }

    .dev-profile-logo-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 10px;
    }

    .dev-profile-header-info {
        flex-grow: 1;
        padding-bottom: 10px;
    }

    .dev-verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e6f4ea;
        color: #137333;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 50px;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .dev-verified-badge i {
        font-size: 13px;
    }

    .dev-profile-name {
        font-size: 32px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dev-tagline {
        font-size: 16px;
        color: #718096;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        margin: 0 0 15px 0;
    }

    /* Rating Display */
    .dev-rating-stars-strip {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14.5px;
        font-family: 'Inter', sans-serif;
        color: #4a5568;
        font-weight: 600;
    }

    .dev-rating-score-badge {
        background: var(--dev-gold);
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dev-stars {
        color: #ffb300;
        display: flex;
        gap: 3px;
    }

    /* Stats strip */
    .dev-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid var(--dev-border);
        background: var(--dev-light-gold);
        padding: 22px 40px;
        gap: 20px;
        text-align: left;
    }

    .dev-stat-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .dev-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--dev-navy);
    }

    .dev-stat-label {
        font-size: 12px;
        color: #718096;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* 2. Main Two-Column Layout Grid */
    .dev-main-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 35px;
        align-items: start;
    }

    .dev-left-column {
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    .dev-profile-block {
        background: #fff;
        border: 1px solid var(--dev-border);
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.03);
        text-align: left;
    }

    .dev-profile-block h3 {
        font-size: 22px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0 0 18px 0;
        border-bottom: 2px solid var(--dev-light-gold);
        padding-bottom: 12px;
        position: relative;
    }

    .dev-profile-block h3::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: var(--dev-gold);
    }

    /* Description */
    .dev-description {
        font-family: 'Inter', sans-serif;
        font-size: 15.5px;
        line-height: 1.7;
        color: #4a5568;
    }

    .dev-description p {
        margin-bottom: 15px;
    }

    /* Projects Grid Section */
    .dev-projects-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .fallback-alert {
        grid-column: 1/-1;
        background: rgba(184, 134, 11, 0.05);
        border-left: 4px solid var(--dev-gold);
        padding: 14px 20px;
        border-radius: 8px;
        font-size: 14px;
        color: #856404;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }

    .dev-project-card {
        background: #fff;
        border: 1px solid var(--dev-border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.35s ease;
        box-shadow: 0 6px 20px rgba(28, 51, 90, 0.03);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .dev-project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(28, 51, 90, 0.1);
        border-color: rgba(184, 134, 11, 0.25);
    }

    .dev-proj-img-wrapper {
        height: 170px;
        position: relative;
        overflow: hidden;
    }

    .dev-proj-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .dev-project-card:hover .dev-proj-img {
        transform: scale(1.06);
    }

    .dev-proj-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--dev-navy);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 5px;
        letter-spacing: 0.5px;
    }

    .dev-proj-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .dev-proj-title {
        font-size: 16.5px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0 0 6px 0;
        line-height: 1.4;
    }

    .dev-proj-loc {
        font-size: 12.5px;
        color: #718096;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dev-proj-loc i {
        color: var(--dev-gold);
    }

    .dev-proj-price-row {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
    }

    .dev-proj-price {
        font-size: 16px;
        font-weight: 800;
        color: var(--dev-gold);
    }

    .dev-proj-btn {
        background: var(--dev-navy);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .dev-proj-btn:hover {
        background: var(--dev-gold);
    }

    /* 3. Right-Column Sticky Actions Sidebar */
    .dev-right-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
        position: sticky;
        top: 20px;
    }

    .dev-sidebar-block {
        background: #fff;
        border: 1px solid var(--dev-border);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.03);
        text-align: left;
    }

    .enquiry-form-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0 0 18px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .enquiry-form-title i {
        color: var(--dev-gold);
    }

    .dev-form-group {
        margin-bottom: 18px;
    }

    .dev-form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dev-form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #edf2f7;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        background: #f7fafc;
        color: #2d3748;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .dev-form-control:focus {
        border-color: var(--dev-gold);
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
    }

    .dev-btn-submit {
        width: 100%;
        padding: 13px;
        background: var(--dev-navy);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .dev-btn-submit:hover {
        background: var(--dev-gold);
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }

    .dev-btn-submit:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
    }

    .form-alert {
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 15px;
        display: none;
        align-items: center;
        gap: 8px;
    }

    .form-alert.success {
        background: #f0fff4;
        color: #38a169;
        border-left: 4px solid #38a169;
        display: flex;
    }

    .form-alert.error {
        background: #fff5f5;
        color: #c53030;
        border-left: 4px solid #c53030;
        display: flex;
    }

    /* Loader Spinner */
    .dev-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.8s linear infinite;
        display: none;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Social Links & Quick Contact Triggers */
    .dev-contact-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 22px;
    }

    .dev-action-btn {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-sizing: border-box;
        transition: all 0.3s;
    }

    .dev-action-whatsapp {
        background: #25d366;
        color: #fff;
    }

    .dev-action-whatsapp:hover {
        background: #128c7e;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    }

    .dev-action-phone {
        background: #fff;
        color: var(--dev-navy);
        border: 1.5px solid var(--dev-border);
    }

    .dev-action-phone:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Social Icons Row */
    .dev-social-row {
        display: flex;
        justify-content: center;
        gap: 12px;
        border-top: 1.5px solid #f1f5f9;
        padding-top: 20px;
    }

    .dev-social-icon {
        width: 36px;
        height: 36px;
        background: #f1f5f9;
        color: var(--dev-navy);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .dev-social-icon:hover {
        background: var(--dev-gold);
        color: #fff;
        transform: translateY(-2px);
    }

    /* 4. Ratings & Review Section */
    .dev-rating-summary-box {
        display: flex;
        align-items: center;
        gap: 40px;
        background: var(--dev-light-gold);
        border-radius: 12px;
        padding: 25px 30px;
        margin-bottom: 30px;
        border: 1px solid rgba(184, 134, 11, 0.1);
    }

    .dev-large-rating-num {
        font-size: 48px;
        font-weight: 800;
        color: var(--dev-navy);
        line-height: 1;
        margin-bottom: 5px;
    }

    .dev-rating-breakdown {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .rating-bar-row {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: #718096;
        font-weight: 700;
    }

    .rating-progress-bg {
        flex-grow: 1;
        height: 6px;
        background: #edf2f7;
        border-radius: 10px;
        overflow: hidden;
    }

    .rating-progress-bar {
        height: 100%;
        background: #ffb300;
        border-radius: 10px;
    }

    .dev-review-actions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .dev-review-actions-header h4 {
        font-size: 18px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0;
    }

    .btn-write-review {
        background: #fff;
        color: var(--dev-gold);
        border: 1.5px solid var(--dev-gold);
        font-weight: 700;
        font-size: 13.5px;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-write-review:hover {
        background: var(--dev-gold);
        color: #fff;
        box-shadow: 0 4px 10px rgba(184, 134, 11, 0.15);
    }

    /* Review items List */
    .dev-reviews-feed {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .dev-review-item {
        border-bottom: 1.5px solid #f1f5f9;
        padding-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .dev-review-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .dev-review-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dev-review-author {
        font-weight: 700;
        font-size: 14.5px;
        color: var(--dev-navy);
    }

    .dev-review-date {
        font-size: 12px;
        color: #a0aec0;
        font-family: 'Inter', sans-serif;
    }

    .dev-review-text {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        line-height: 1.6;
        color: #4a5568;
    }

    /* 5. Review Submission Modal styles */
    .review-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 22, 34, 0.7);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .review-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .review-modal-card {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        padding: 30px;
        position: relative;
        text-align: center;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        box-sizing: border-box;
    }

    .review-modal-overlay.active .review-modal-card {
        transform: translateY(0);
    }

    .review-close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #edf2f7;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #718096;
        font-size: 12px;
        transition: all 0.2s;
    }

    .review-close-btn:hover {
        background: rgba(229, 62, 62, 0.1);
        color: #e53e3e;
    }

    .review-modal-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--dev-navy);
        margin: 0 0 10px 0;
    }

    .stars-rating-selector {
        display: flex;
        justify-content: center;
        gap: 8px;
        font-size: 32px;
        color: #cbd5e0;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .stars-rating-selector i.active {
        color: #ffb300;
    }

    @media (max-width: 991px) {
        .dev-main-grid {
            grid-template-columns: 1fr;
        }

        .dev-right-column {
            position: relative;
            top: 0;
        }

        .dev-profile-details-row {
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: -60px;
            padding: 20px;
        }

        .dev-profile-logo-wrapper {
            margin-top: 0;
        }

        .dev-profile-header-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .dev-profile-name {
            font-size: 26px;
        }

        .dev-stats-row {
            grid-template-columns: repeat(2, 1fr);
            padding: 20px;
            gap: 15px;
        }
    }

    @media (max-width: 576px) {
        .dev-projects-grid {
            grid-template-columns: 1fr;
        }

        .dev-rating-summary-box {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>

<div class="dev-profile-container">

    <!-- 1. Header Profile Box -->
    <div class="dev-profile-card">
        <div class="dev-profile-cover"></div>
        
        <div class="dev-profile-details-row">
            <div class="dev-profile-logo-wrapper">
                <img src="<?php echo BASE_URL; ?>assets/images/developers/<?php echo $dev_info['logo']; ?>" alt="<?php echo htmlspecialchars($dev_info['name']); ?>">
            </div>
            
            <div class="dev-profile-header-info">
                <div class="dev-verified-badge">
                    <i class="fa-solid fa-circle-check"></i> Verified Partner Developer
                </div>
                
                <h1 class="dev-profile-name"><?php echo htmlspecialchars($dev_info['name']); ?></h1>
                <p class="dev-tagline"><?php echo htmlspecialchars($dev_info['tagline']); ?></p>
                
                <div class="dev-rating-stars-strip">
                    <span class="dev-rating-score-badge">
                        <?php echo $dev_info['rating']; ?> <i class="fas fa-star" style="font-size: 10px;"></i>
                    </span>
                    <div class="dev-stars">
                        <?php 
                        $score = round($dev_info['rating']);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $score) {
                                echo '<i class="fas fa-star"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <span>(<?php echo $dev_info['reviews_count']; ?> customer reviews)</span>
                </div>
            </div>
        </div>

        <!-- Float Stats Strip -->
        <div class="dev-stats-row">
            <div class="dev-stat-item">
                <span class="dev-stat-value"><?php echo $dev_info['experience']; ?></span>
                <span class="dev-stat-label">Market Presence</span>
            </div>
            <div class="dev-stat-item">
                <span class="dev-stat-value"><?php echo $dev_info['projects_count']; ?></span>
                <span class="dev-stat-label">Townships Built</span>
            </div>
            <div class="dev-stat-item">
                <span class="dev-stat-value"><?php echo $dev_info['area_developed']; ?></span>
                <span class="dev-stat-label">Developed Area</span>
            </div>
            <div class="dev-stat-item">
                <span class="dev-stat-value"><?php echo $dev_info['happy_families']; ?></span>
                <span class="dev-stat-label">Delighted Clients</span>
            </div>
        </div>
    </div>

    <!-- 2. Two Column Workspace Layout Grid -->
    <div class="dev-main-grid">
        
        <!-- Left Content Column -->
        <div class="dev-left-column">
            
            <!-- Block A: Corporate Profile -->
            <div class="dev-profile-block">
                <h3>Corporate Overview</h3>
                <div class="dev-description">
                    <p><strong><?php echo htmlspecialchars($dev_info['name']); ?></strong> is widely acknowledged as one of Western India's premier development firms, committed to redefining structural transparency and engineering quality in Dholera Greenfield Smart City.</p>
                    <p><?php echo htmlspecialchars($dev_info['desc']); ?></p>
                </div>
            </div>

            <!-- Block B: Dynamic Projects -->
            <div class="dev-profile-block">
                <h3>Active Plotted Townships</h3>
                
                <div class="dev-projects-grid">
                    <?php if ($show_featured_fallback): ?>
                        <div class="fallback-alert">
                            <i class="fa-solid fa-circle-info"></i> Note: Showing recommended featured projects in Dholera SIR.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($dev_projects)): ?>
                        <?php foreach ($dev_projects as $project): ?>
                            <div class="dev-project-card">
                                <div class="dev-proj-img-wrapper">
                                    <?php if ($project['featured_image']): ?>
                                        <img src="<?php echo BASE_URL . $project['featured_image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="dev-proj-img" loading="lazy">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" class="dev-proj-img" loading="lazy">
                                    <?php endif; ?>
                                    <span class="dev-proj-badge"><?php echo htmlspecialchars($project['project_type'] ?: 'Premium plots'); ?></span>
                                </div>
                                <div class="dev-proj-content">
                                    <h4 class="dev-proj-title"><?php echo htmlspecialchars($project['title']); ?></h4>
                                    <div class="dev-proj-loc">
                                        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                                    </div>
                                    <div class="dev-proj-price-row">
                                        <span class="dev-proj-price">₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?></span>
                                        <a href="<?php echo BASE_URL; ?>project/<?php echo $project['slug'] ?: $project['id']; ?>" class="dev-proj-btn">
                                            View Layout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1/-1; color: #718096; text-align: center;">No projects currently available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Block C: Professional Ratings & Reviews -->
            <div class="dev-profile-block">
                <div class="dev-review-actions-header">
                    <h4>Customer Ratings & Feedback</h4>
                    <button type="button" class="btn-write-review" id="btnOpenReviewModal">Write a Review</button>
                </div>

                <!-- Justdial Score Summary Box -->
                <div class="dev-rating-summary-box">
                    <div style="text-align: center; flex-shrink: 0;">
                        <div class="dev-large-rating-num"><?php echo $dev_info['rating']; ?></div>
                        <div class="dev-stars" style="justify-content: center; margin-bottom: 5px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div style="font-size: 12px; color: #718096; font-weight: 700;">Average Rating</div>
                    </div>

                    <div class="dev-rating-breakdown">
                        <div class="rating-bar-row">
                            <span style="width: 40px;">5 Stars</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-bar" style="width: 82%;"></div>
                            </div>
                            <span style="width: 25px; text-align: right;">82%</span>
                        </div>
                        <div class="rating-bar-row">
                            <span style="width: 40px;">4 Stars</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-bar" style="width: 12%;"></div>
                            </div>
                            <span style="width: 25px; text-align: right;">12%</span>
                        </div>
                        <div class="rating-bar-row">
                            <span style="width: 40px;">3 Stars</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-bar" style="width: 4%;"></div>
                            </div>
                            <span style="width: 25px; text-align: right;">4%</span>
                        </div>
                        <div class="rating-bar-row">
                            <span style="width: 40px;">2 Stars</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-bar" style="width: 1%;"></div>
                            </div>
                            <span style="width: 25px; text-align: right;">1%</span>
                        </div>
                        <div class="rating-bar-row">
                            <span style="width: 40px;">1 Star</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-bar" style="width: 1%;"></div>
                            </div>
                            <span style="width: 25px; text-align: right;">1%</span>
                        </div>
                    </div>
                </div>

                <!-- Reviews Feed -->
                <div class="dev-reviews-feed" id="devReviewsFeed">
                    <?php foreach ($dev_info['reviews'] as $review): ?>
                        <div class="dev-review-item">
                            <div class="dev-review-meta">
                                <span class="dev-review-author"><?php echo htmlspecialchars($review['author']); ?></span>
                                <span class="dev-review-date"><?php echo htmlspecialchars($review['date']); ?></span>
                            </div>
                            <div class="dev-stars" style="font-size: 11px; margin-bottom: 5px;">
                                <?php 
                                for ($star = 1; $star <= 5; $star++) {
                                    if ($star <= $review['rating']) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <p class="dev-review-text"><?php echo htmlspecialchars($review['text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>

        <!-- Right Sidebar Sticky Column -->
        <div class="dev-right-column">
            
            <!-- Sticky Block A: Inquire Action Form -->
            <div class="dev-sidebar-block">
                <h4 class="enquiry-form-title">
                    <i class="fa-solid fa-paper-plane"></i> Quick Enquiry
                </h4>

                <div class="form-alert" id="enquiryAlertBox"></div>

                <form id="devProfileEnquiryForm">
                    <input type="hidden" name="subject" value="Enquiry for <?php echo htmlspecialchars($dev_info['name']); ?>">
                    
                    <div class="dev-form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="dev-form-control" placeholder="Enter full name" required>
                    </div>

                    <div class="dev-form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="dev-form-control" placeholder="name@domain.com" required>
                    </div>

                    <div class="dev-form-group">
                        <label>Mobile Number</label>
                        <input type="tel" name="number" class="dev-form-control" placeholder="10-digit phone number" required pattern="[0-9]{10}">
                    </div>

                    <div class="dev-form-group">
                        <label>Comments / Requirements</label>
                        <textarea name="comments" class="dev-form-control" placeholder="I am interested in learning more about plotted layouts..." rows="4" required></textarea>
                    </div>

                    <button type="submit" class="dev-btn-submit" id="btnSubmitEnquiry">
                        <span class="dev-spinner" id="btnSubmitSpinner"></span>
                        <span id="btnSubmitText">Send Inquiry</span>
                    </button>
                </form>
            </div>

            <!-- Sticky Block B: Social Media & Contacts -->
            <div class="dev-sidebar-block">
                <h4 class="enquiry-form-title">
                    <i class="fa-solid fa-address-book"></i> Connect Directly
                </h4>
                
                <div class="dev-contact-actions">
                    <a href="https://wa.me/<?php echo $dev_info['whatsapp']; ?>?text=Hello,%20I%20am%20interested%20in%20plots%20by%20<?php echo urlencode($dev_info['name']); ?>." target="_blank" class="dev-action-btn dev-action-whatsapp">
                        <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> WhatsApp Chat
                    </a>
                    
                    <a href="tel:<?php echo $dev_info['phone']; ?>" class="dev-action-btn dev-action-phone">
                        <i class="fa-solid fa-phone" style="font-size: 13px;"></i> Call Developer
                    </a>
                </div>

                <div class="dev-social-row">
                    <a href="https://facebook.com" class="dev-social-icon" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://linkedin.com" class="dev-social-icon" target="_blank" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://instagram.com" class="dev-social-icon" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://youtube.com" class="dev-social-icon" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- 5. Ratings Submission Popup Modal (Interactive DOM feedback) -->
<div class="review-modal-overlay" id="reviewModalOverlay">
    <div class="review-modal-card">
        <button class="review-close-btn" id="btnCloseReviewModal"><i class="fa-solid fa-xmark"></i></button>
        <h3 class="review-modal-title">Share Your Experience</h3>
        <p style="font-size: 13.5px; color: #718096; margin-bottom: 20px; font-family: 'Inter', sans-serif;">Rate your interaction with <?php echo htmlspecialchars($dev_info['name']); ?></p>

        <form id="devSubmissionReviewForm">
            <div class="stars-rating-selector" id="modalStarsRating">
                <i class="fas fa-star" data-rating="1"></i>
                <i class="fas fa-star" data-rating="2"></i>
                <i class="fas fa-star" data-rating="3"></i>
                <i class="fas fa-star" data-rating="4"></i>
                <i class="fas fa-star" data-rating="5"></i>
            </div>
            <input type="hidden" id="selectedStarRating" value="5">

            <div class="dev-form-group" style="text-align: left;">
                <label>Your Name</label>
                <input type="text" id="reviewAuthorName" class="dev-form-control" placeholder="Enter name" required autocomplete="name">
            </div>

            <div class="dev-form-group" style="text-align: left;">
                <label>Your Review</label>
                <textarea id="reviewMessage" class="dev-form-control" placeholder="Type review here..." rows="4" required></textarea>
            </div>

            <button type="submit" class="dev-btn-submit" style="margin-top: 10px;">
                Submit Review
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // A. AJAX Enquiry submission
        const enquiryForm = document.getElementById('devProfileEnquiryForm');
        const alertBox = document.getElementById('enquiryAlertBox');
        const btnSubmit = document.getElementById('btnSubmitEnquiry');
        const submitSpinner = document.getElementById('btnSubmitSpinner');
        const submitText = document.getElementById('btnSubmitText');

        enquiryForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Hide alerts & enable loader spinner state
            alertBox.style.display = 'none';
            alertBox.className = 'form-alert';
            btnSubmit.disabled = true;
            submitSpinner.style.display = 'inline-block';
            submitText.innerText = 'Sending...';

            const formData = new FormData(enquiryForm);

            fetch('<?php echo BASE_URL; ?>ajax/submit-enquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.className = 'form-alert success';
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
                    alertBox.style.display = 'flex';
                    enquiryForm.reset();
                } else {
                    alertBox.className = 'form-alert error';
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + data.message;
                    alertBox.style.display = 'flex';
                }
            })
            .catch(err => {
                console.error(err);
                alertBox.className = 'form-alert error';
                alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> A connection error occurred. Please try again.';
                alertBox.style.display = 'flex';
            })
            .finally(() => {
                btnSubmit.disabled = false;
                submitSpinner.style.display = 'none';
                submitText.innerText = 'Send Inquiry';
            });
        });

        // B. Ratings Submission Popup Modal Dialog flows
        const modalOverlay = document.getElementById('reviewModalOverlay');
        const btnOpen = document.getElementById('btnOpenReviewModal');
        const btnClose = document.getElementById('btnCloseReviewModal');
        const reviewForm = document.getElementById('devSubmissionReviewForm');
        const starsSelector = document.getElementById('modalStarsRating');
        const selectedRatingInput = document.getElementById('selectedStarRating');
        
        // Feed target
        const reviewsFeed = document.getElementById('devReviewsFeed');

        // Modal triggers
        btnOpen.addEventListener('click', () => {
            modalOverlay.classList.add('active');
            reviewForm.reset();
            resetModalStars(5);
        });

        btnClose.addEventListener('click', () => {
            modalOverlay.classList.remove('active');
        });

        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });

        // Stars hover selection interaction
        const stars = starsSelector.querySelectorAll('i');
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const val = parseInt(star.getAttribute('data-rating'));
                selectedRatingInput.value = val;
                resetModalStars(val);
            });
        });

        function resetModalStars(rating) {
            stars.forEach(star => {
                const starVal = parseInt(star.getAttribute('data-rating'));
                if (starVal <= rating) {
                    star.className = 'fas fa-star active';
                } else {
                    star.className = 'fas fa-star';
                }
            });
        }

        // Ratings submissions appending to feed dynamically
        reviewForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const ratingValue = parseInt(selectedRatingInput.value);
            const authorVal = document.getElementById('reviewAuthorName').value.trim();
            const messageVal = document.getElementById('reviewMessage').value.trim();

            if (!authorVal || !messageVal) return;

            // Generate modern dynamic date
            const dateOptions = { year: 'numeric', month: '2-digit', day: '2-digit' };
            const today = new Date().toLocaleDateString('zh-Hans-CN', dateOptions).replace(/\//g, '-');

            // Generate stars HTML
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= ratingValue) {
                    starsHtml += '<i class="fas fa-star"></i>';
                } else {
                    starsHtml += '<i class="far fa-star"></i>';
                }
            }

            // Create new Review DOM Node element
            const newReview = document.createElement('div');
            newReview.className = 'dev-review-item';
            newReview.style.animation = 'slideFadeIn 0.5s ease forwards';
            newReview.innerHTML = `
                <div class="dev-review-meta">
                    <span class="dev-review-author">${escapeHtml(authorVal)}</span>
                    <span class="dev-review-date">${today}</span>
                </div>
                <div class="dev-stars" style="font-size: 11px; margin-bottom: 5px;">
                    ${starsHtml}
                </div>
                <p class="dev-review-text">${escapeHtml(messageVal)}</p>
            `;

            // Prepend new review at the very top of reviews lists
            reviewsFeed.insertBefore(newReview, reviewsFeed.firstChild);

            // Close review modal popup cleanly
            modalOverlay.classList.remove('active');
        });

        function escapeHtml(str) {
            return str
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
</script>

<?php
// Include site footer
include __DIR__ . '/includes/footer.php';
?>
