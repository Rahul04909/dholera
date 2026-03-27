<?php
/**
 * Agent Registration - Step 2 (Select Package)
 * Dholera Smart City
 */
require_once 'database/db_config.php';
session_start();

if (!isset($_SESSION['reg_data'])) {
    header("Location: register.php");
    exit();
}

// Fetch Active Packages
try {
    $stmt = $conn->query("SELECT * FROM agent_packages WHERE status = 'active' ORDER BY price ASC");
    $packages = $stmt->fetchAll();
    
    // Fetch benefits for each package
    foreach ($packages as &$pkg) {
        $b_stmt = $conn->prepare("SELECT benefit_text FROM agent_package_benefits WHERE package_id = ?");
        $b_stmt->execute([$pkg['id']]);
        $pkg['benefits'] = $b_stmt->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include 'includes/header.php';
?>

<style>
    .pkg-wrapper { padding: 80px 20px; background: #f7fafc; min-height: 80vh; }
    .page-title { text-align: center; margin-bottom: 50px; }
    .page-title h1 { font-size: 36px; font-weight: 800; color: #111; margin-bottom: 15px; }
    .page-title p { color: #718096; font-size: 18px; }

    .pricing-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        align-items: start;
    }

    .pricing-card {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        text-align: center;
        border: 2px solid transparent;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .pricing-card:hover { transform: translateY(-10px); border-color: var(--primary-gold); }

    .pkg-icon {
        width: 70px;
        height: 70px;
        background: rgba(184, 134, 11, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: var(--primary-gold);
        font-size: 28px;
    }

    .pkg-name { font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #1a202c; }
    .pkg-price { font-size: 48px; font-weight: 800; color: #111; margin-bottom: 5px; }
    .pkg-price span { font-size: 16px; color: #718096; font-weight: 500; }
    
    .pkg-duration {
        display: inline-block;
        background: #edf2f7;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .benefit-list { list-style: none; text-align: left; margin-bottom: 40px; }
    .benefit-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 15px;
        color: #4a5568;
    }
    .benefit-list li i { color: #38a169; }

    .btn-select {
        display: block;
        width: 100%;
        background: var(--dark-bg);
        color: #fff;
        text-decoration: none;
        padding: 15px;
        border-radius: 10px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-select:hover { background: var(--primary-gold); }

    .featured-pkg { border-color: var(--primary-gold); }
    .featured-pkg::before {
        content: "MOST POPULAR";
        position: absolute;
        top: 20px;
        right: -35px;
        background: var(--primary-gold);
        color: #fff;
        padding: 5px 40px;
        font-size: 10px;
        font-weight: 800;
        transform: rotate(45deg);
    }
</style>

<div class="pkg-wrapper">
    <div class="page-title">
        <p>Step 2 of 3</p>
        <h1>Choose Your Subscription Plan</h1>
        <p>Select a plan that fits your business needs and start growing with us.</p>
    </div>

    <div class="pricing-grid">
        <?php foreach($packages as $index => $pkg): ?>
            <div class="pricing-card <?php echo $index == 1 ? 'featured-pkg' : ''; ?>">
                <div class="pkg-icon">
                    <i class="fas <?php echo $pkg['duration_months'] >= 6 ? 'fa-crown' : 'fa-star'; ?>"></i>
                </div>
                <div class="pkg-name"><?php echo htmlspecialchars($pkg['package_name']); ?></div>
                <div class="pkg-price">₹<?php echo number_format($pkg['price'], 0); ?> <span>/ <?php echo $pkg['duration_months']; ?>mo</span></div>
                <div class="pkg-duration"><?php echo $pkg['duration_months']; ?> Months Validity</div>
                
                <ul class="benefit-list">
                    <?php foreach($pkg['benefits'] as $benefit): ?>
                        <li><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($benefit); ?></li>
                    <?php endforeach; ?>
                    <?php if(empty($pkg['benefits'])): ?>
                        <li><i class="fas fa-check-circle"></i> Complete Portal Access</li>
                        <li><i class="fas fa-check-circle"></i> Lead Generation Support</li>
                    <?php endif; ?>
                </ul>

                <a href="payment.php?pkg_id=<?php echo $pkg['id']; ?>" class="btn-select">Select This Plan</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/main-footer.php'; ?>
