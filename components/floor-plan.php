<?php
/**
 * Floor Plan Component
 * Dholera Smart City
 */
require_once 'database/db_config.php';

try {
    $plan_settings = $conn->query("SELECT * FROM floor_plan_settings WHERE id = 1")->fetch();
    $all_plans = $conn->query("SELECT * FROM floor_plans ORDER BY sort_order ASC")->fetchAll();
    
    $floor_plans_data = [];
    foreach ($all_plans as $p) {
        $stmt_specs = $conn->prepare("SELECT * FROM floor_plan_specs WHERE plan_id = ? ORDER BY sort_order ASC");
        $stmt_specs->execute([$p['id']]);
        $p['specs'] = $stmt_specs->fetchAll();
        $floor_plans_data[] = $p;
    }
} catch (PDOException $e) {
    $plan_settings = null;
    $floor_plans_data = [];
}
?>
<style>
    .floor-plan-section {
        padding: 80px 20px;
        background-color: #f8fbff;
        font-family: 'Outfit', sans-serif;
    }

    .floor-plan-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .floor-plan-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .sketch-title {
        display: inline-block;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-gold, #b8860b);
        text-transform: uppercase;
        letter-spacing: 2px;
        border-left: 4px solid var(--primary-gold, #b8860b);
        border-top: 4px solid var(--primary-gold, #b8860b);
        padding: 5px 15px;
        margin-bottom: 15px;
    }

    .plan-main-title {
        font-size: 42px;
        font-weight: 800;
        color: #0d2c44;
        margin: 0;
    }

    .floor-tabs-nav {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        border: 1px solid var(--primary-gold, #b8860b);
        border-radius: 4px;
        overflow: hidden;
    }

    .floor-tab-btn {
        flex: 1;
        padding: 15px 20px;
        background: transparent;
        border: none;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
        border-right: 1px solid var(--primary-gold, #b8860b);
        white-space: nowrap;
    }

    .floor-tab-btn:last-child {
        border-right: none;
    }

    .floor-tab-btn.active {
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
    }

    .floor-tab-content {
        display: none;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        animation: fadeIn 0.5s ease;
    }

    .floor-tab-content.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .floor-info-side {
        flex: 1;
        padding: 50px;
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
    }

    .floor-type-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .floor-desc {
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 35px;
        opacity: 0.9;
    }

    .specs-table {
        width: 100%;
        border-collapse: collapse;
    }

    .specs-table tr {
        border-bottom: 1px dashed rgba(255,255,255,0.3);
    }

    .specs-table tr:last-child {
        border-bottom: none;
    }

    .specs-table td {
        padding: 15px 0;
        font-size: 16px;
    }

    .spec-label {
        font-weight: 400;
        opacity: 0.8;
    }

    .spec-value {
        text-align: right;
        font-weight: 700;
    }

    .floor-image-side {
        flex: 1.2;
        background-color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    .floor-plan-img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
    }

    @media (max-width: 992px) {
        .floor-tab-content.active { flex-direction: column; }
        .floor-info-side { padding: 40px 30px; }
    }

    @media (max-width: 768px) {
        .floor-tabs-nav { overflow-x: auto; justify-content: flex-start; }
        .floor-tab-btn { padding: 12px 25px; }
        .plan-main-title { font-size: 32px; }
    }

    @media (max-width: 480px) {
        .floor-info-side { padding: 30px 20px; }
        .floor-type-title { font-size: 26px; }
        .specs-table td { font-size: 14px; }
    }
</style>

<section class="floor-plan-section" id="floor-plans">
    <div class="floor-plan-container">
        <!-- Header -->
        <div class="floor-plan-header">
            <div class="sketch-title"><?php echo htmlspecialchars($plan_settings['sketch_title'] ?? 'Apartments Sketch'); ?></div>
            <h2 class="plan-main-title"><?php echo htmlspecialchars($plan_settings['main_title'] ?? 'Apartments Plan'); ?></h2>
        </div>

        <!-- Tabs Navigation -->
        <div class="floor-tabs-nav">
            <?php foreach ($floor_plans_data as $index => $p): ?>
                <button class="floor-tab-btn <?php echo ($index === 0) ? 'active' : ''; ?>" onclick="switchTab(event, 'plan-<?php echo $p['id']; ?>')">
                    <?php echo htmlspecialchars($p['tab_title']); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Tab Contents -->
        <?php foreach ($floor_plans_data as $index => $p): ?>
            <div id="plan-<?php echo $p['id']; ?>" class="floor-tab-content <?php echo ($index === 0) ? 'active' : ''; ?>">
                <div class="floor-info-side">
                    <h3 class="floor-type-title"><?php echo htmlspecialchars($p['plan_title']); ?></h3>
                    <p class="floor-desc"><?php echo htmlspecialchars($p['plan_desc']); ?></p>
                    <table class="specs-table">
                        <?php foreach ($p['specs'] as $spec): ?>
                            <tr>
                                <td class="spec-label"><?php echo htmlspecialchars($spec['label']); ?></td>
                                <td class="spec-value"><?php echo htmlspecialchars($spec['value']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="floor-image-side">
                    <img src="<?php echo strpos($p['image_path'], 'http') === 0 ? $p['image_path'] : BASE_URL . $p['image_path']; ?>" alt="<?php echo htmlspecialchars($p['plan_title']); ?>" class="floor-plan-img">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    function switchTab(evt, tabId) {
        const contents = document.querySelectorAll('.floor-tab-content');
        contents.forEach(content => content.classList.remove('active'));
        const buttons = document.querySelectorAll('.floor-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }
</script>
