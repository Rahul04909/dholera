<?php
/**
 * Highlights Component
 * Dholera Smart City
 */
require_once 'database/db_config.php';

try {
    $highlights_settings = $conn->query("SELECT * FROM site_highlights_settings WHERE id = 1")->fetch();
    $highlights_items = $conn->query("SELECT * FROM site_highlights_items ORDER BY sort_order ASC")->fetchAll();
} catch (PDOException $e) {
    $highlights_settings = null;
    $highlights_items = [];
}
?>
<style>
    .highlights-section {
        display: flex;
        background-color: var(--primary-gold, #b8860b);
        min-height: 500px;
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
    }

    .highlights-content {
        flex: 1;
        padding: 60px 40px;
        position: relative;
        background-image: radial-gradient(rgba(0,0,0,0.1) 2px, transparent 2px);
        background-size: 30px 30px;
    }

    .highlights-header {
        margin-bottom: 40px;
    }

    .highlights-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .highlights-header h2::after {
        content: "";
        height: 2px;
        width: 150px;
        background: rgba(255,255,255,0.6);
    }

    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 800px;
    }

    .highlight-card {
        background: #fff;
        padding: 20px 25px;
        position: relative;
        border-radius: 4px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        min-height: 100px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .highlight-card:hover {
        transform: translateY(-5px);
    }

    .highlight-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        background: #e0e0e0;
        clip-path: polygon(100% 0, 100% 100%, 0 100%);
        opacity: 0.5;
    }

    .highlight-text {
        font-size: 15px;
        font-weight: 500;
        color: #333;
        line-height: 1.4;
        z-index: 1;
    }

    .highlight-number {
        position: absolute;
        bottom: 5px;
        right: 8px;
        font-size: 20px;
        font-weight: 800;
        color: rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    .highlights-image-side {
        flex: 1;
        background: url('<?php echo $highlights_settings['side_image'] ?? ''; ?>') no-repeat center center;
        background-size: cover;
        min-height: 400px;
    }

    @media (max-width: 1200px) {
        .highlights-content { padding: 40px 20px; }
        .highlights-header h2 { font-size: 28px; }
    }

    @media (max-width: 992px) {
        .highlights-section { flex-direction: column; }
        .highlights-image-side { order: 2; height: 400px; }
        .highlights-content { order: 1; }
    }

    @media (max-width: 600px) {
        .highlights-grid { grid-template-columns: 1fr; }
        .highlights-header h2::after { width: 80px; }
        .highlight-card { padding: 15px 20px; }
    }
</style>

<section class="highlights-section">
    <div class="highlights-content">
        <div class="highlights-header">
            <h2><?php echo htmlspecialchars($highlights_settings['title'] ?? 'Highlights'); ?></h2>
        </div>

        <div class="highlights-grid">
            <?php foreach ($highlights_items as $index => $item): ?>
                <div class="highlight-card">
                    <div class="highlight-text"><?php echo htmlspecialchars($item['text']); ?></div>
                    <div class="highlight-number"><?php echo $index + 1; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="highlights-image-side"></div>
</section>
