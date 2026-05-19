<?php
/**
 * All Projects Listing Page
 * Dholera Smart City Portal
 */
require_once 'database/db_config.php';

// Fetch all active projects
try {
    $stmt = $conn->query("SELECT * FROM projects WHERE status = 'active' ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $projects = [];
}

// SEO Meta Data
$seo_title = "Residential & Commercial Projects in Dholera SIR - Active Listings";
$seo_desc = "Explore verified real estate projects, residential plots, and commercial lands in Dholera Smart City. Direct developer prices, RERA approved sites with planned visits.";
$seo_keywords = "Dholera SIR Projects, Residential Plots Dholera, Commercial Land Dholera, Dholera Smart City Real Estate";

include 'includes/header.php';
?>

<style>
    /* Premium Page Hero */
    .projects-page-hero {
        background: linear-gradient(rgba(28, 51, 90, 0.9), rgba(28, 51, 90, 0.85)), url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        width: 100%;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        padding: 50px 20px;
    }

    .projects-page-hero h1 {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .projects-page-hero p {
        font-size: 16px;
        max-width: 600px;
        opacity: 0.9;
        font-family: 'Inter', sans-serif;
    }

    /* Grid Layout Container */
    .projects-grid-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    /* Reuse our premium Housing/Square Yards styles */
    .project-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(28, 51, 90, 0.12);
        border-color: rgba(184, 134, 11, 0.3);
    }

    .project-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        margin: 0;
    }

    .project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img {
        transform: scale(1.08);
    }

    .project-badge-logo {
        position: absolute;
        bottom: -15px;
        right: 15px;
        width: 42px;
        height: 42px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 2;
        border: 2px solid #fff;
    }

    .project-badge-logo img {
        width: 100%;
        height: auto;
    }

    .project-badge-status {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-color);
        color: #fff;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(184, 134, 11, 0.3);
    }

    .project-content {
        padding: 24px 20px;
        text-align: left;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .project-verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #2e7d32;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .project-title {
        font-size: 20px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .project-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #718096;
        font-size: 13.5px;
        margin-bottom: 18px;
    }

    .project-location i {
        color: var(--primary-color);
    }

    .project-price-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid #f1f5f9;
        padding-top: 18px;
        margin-bottom: 15px;
    }

    .price-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary-color);
    }

    .price-sub {
        font-size: 11px;
        color: #a0aec0;
        text-transform: uppercase;
        font-weight: 600;
    }

    .project-specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 22px;
    }

    .spec-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12.5px;
        color: #4a5568;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .spec-item i {
        color: #1c335a;
    }

    .project-cta-row {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 12px;
        margin-top: auto;
    }

    .cta-btn {
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13.5px;
        text-align: center;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .cta-secondary {
        background: transparent;
        color: #1c335a;
        border: 1.5px solid #edf2f7;
    }

    .cta-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .cta-primary {
        background: #1c335a;
        color: #fff;
        border: 1.5px solid #1c335a;
    }

    .cta-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .projects-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
    }

    @media (max-width: 768px) {
        .projects-page-hero h1 {
            font-size: 30px;
        }
        .projects-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .projects-page-hero {
            padding: 40px 15px;
            min-height: 200px;
        }
    }
</style>

<main>
    <!-- Page Hero -->
    <section class="projects-page-hero">
        <h1>Our Exclusive Projects</h1>
        <p>Premium residential, commercial, and industrial plots inside the high-tech corridors of Dholera SIR.</p>
    </section>

    <!-- Grid Container -->
    <div class="projects-grid-container">
        <?php if (!empty($projects)): ?>
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-img-wrapper">
                            <?php if ($project['featured_image']): ?>
                                <img src="<?php echo BASE_URL . $project['featured_image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="project-img" loading="lazy">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" class="project-img" loading="lazy">
                            <?php endif; ?>
                            
                            <div class="project-badge-logo">
                                <img src="<?php echo BASE_URL; ?>assets/logo.webp" alt="Dholera Logo">
                            </div>
                            
                            <span class="project-badge-status"><?php echo htmlspecialchars($project['label'] ?: 'Featured'); ?></span>
                        </div>
                        
                        <div class="project-content">
                            <div class="project-verified-badge">
                                <i class="fa-solid fa-circle-check"></i> RERA Approved
                            </div>
                            
                            <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            
                            <div class="project-location">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                            </div>

                            <div class="project-specs-grid">
                                <div class="spec-item">
                                    <i class="fa-solid fa-chart-area"></i> Plots & Land
                                </div>
                                <div class="spec-item">
                                    <i class="fa-solid fa-shield-halved"></i> 100% Safe
                                </div>
                            </div>
                            
                            <div class="project-price-row">
                                <span class="price-value">₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?></span>
                                <span class="price-sub">Est. Price</span>
                            </div>
                            
                            <div class="project-cta-row">
                                <a href="<?php echo BASE_URL; ?>project/<?php echo $project['slug'] ? $project['slug'] : $project['id']; ?>" class="cta-btn cta-secondary">
                                    Details
                                </a>
                                <a href="<?php echo BASE_URL; ?>contact.php" class="cta-btn cta-primary">
                                    Inquire <i class="fas fa-arrow-right" style="font-size: 10px; margin-left: 6px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-building-circle-exclamation"></i>
                <h3>No Projects Found</h3>
                <p>We are currently updating our portfolio. Please check back shortly or contact our support team.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
