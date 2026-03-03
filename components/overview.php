<?php
/**
 * Overview Component
 * Dholera Smart City
 */
require_once 'database/db_config.php';

try {
    $overview_stmt = $conn->query("SELECT * FROM site_overview WHERE id = 1");
    $overview_data = $overview_stmt->fetch();
} catch (PDOException $e) {
    $overview_data = null;
}
?>
<style>
    .overview-section {
        padding: 80px 20px;
        background: #fff;
        position: relative;
        overflow: hidden;
        font-family: 'Outfit', sans-serif;
    }

    .overview-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.92);
        z-index: 0;
    }

    .blueprint-overlay {
        position: absolute;
        width: 300px;
        opacity: 0.1;
        z-index: 1;
        pointer-events: none;
    }

    .blueprint-left {
        top: 50px;
        left: -50px;
        transform: rotate(-15deg);
    }

    .blueprint-right {
        bottom: -50px;
        right: -50px;
        transform: rotate(15deg);
    }

    .overview-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 50px;
        position: relative;
        z-index: 2;
    }

    .overview-content {
        flex: 1;
    }

    .overview-header {
        margin-bottom: 30px;
    }

    .overview-header h2 {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary-gold, #b8860b);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .overview-header h2::after {
        content: "";
        height: 2px;
        width: 100px;
        background: var(--primary-gold, #b8860b);
    }

    .overview-subtitle {
        font-size: 22px;
        font-weight: 700;
        color: #1a4a7c;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .overview-text {
        font-size: 15px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 30px;
    }

    .btn-brochure {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
        padding: 12px 25px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-brochure:hover {
        background-color: #966d09;
        transform: translateY(-2px);
    }

    .overview-image-wrapper {
        flex: 1;
        position: relative;
        padding: 15px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 4px;
    }

    .overview-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 2px;
    }

    .overview-image-wrapper::before {
        content: "";
        position: absolute;
        top: -10px;
        right: -10px;
        width: 100px;
        height: 100px;
        border-top: 5px solid var(--primary-gold, #b8860b);
        border-right: 5px solid var(--primary-gold, #b8860b);
        z-index: -1;
    }

    @media (max-width: 992px) {
        .overview-container { flex-direction: column; text-align: center; gap: 40px; }
        .overview-header h2 { justify-content: center; }
        .overview-header h2::after { display: none; }
        .overview-image-wrapper { max-width: 500px; margin: 0 auto; }
    }

    @media (max-width: 600px) {
        .overview-section { padding: 60px 15px; }
        .overview-header h2 { font-size: 26px; }
        .overview-subtitle { font-size: 18px; }
        .overview-text { font-size: 14px; text-align: left; }
    }
</style>

<section class="overview-section" id="overview">
    <?php if ($overview_data): ?>
        <img src="<?php echo BASE_URL . $overview_data['image_path']; ?>" class="blueprint-overlay blueprint-left" alt="">
        <img src="<?php echo BASE_URL . $overview_data['image_path']; ?>" class="blueprint-overlay blueprint-right" alt="">

        <div class="overview-container">
            <div class="overview-content">
                <div class="overview-header">
                    <h2><?php echo htmlspecialchars($overview_data['title']); ?></h2>
                </div>
                
                <h3 class="overview-subtitle"><?php echo htmlspecialchars($overview_data['subtitle']); ?></h3>
                
                <div class="overview-text">
                    <?php echo $overview_data['content']; ?>
                </div>

                <a href="<?php echo BASE_URL; ?>#siteVisitForm" class="btn-brochure">Plan a Visit <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="overview-image-wrapper">
                <img src="<?php echo BASE_URL . $overview_data['image_path']; ?>" alt="<?php echo htmlspecialchars($overview_data['title']); ?>" class="overview-image">
            </div>
        </div>
    <?php endif; ?>
</section>
