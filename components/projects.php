<?php
// Our Projects Component
require_once 'database/db_config.php';

try {
    $stmt = $conn->query("SELECT * FROM projects WHERE status = 'active' ORDER BY created_at DESC");
    $all_projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $all_projects = [];
}
?>
<style>
    .projects-section {
        padding: 80px 20px;
        background-color: #f9f9f9;
        font-family: 'Outfit', sans-serif;
    }

    .projects-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .projects-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .projects-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: #222;
        text-transform: uppercase;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }

    .projects-header h2::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-gold, #b8860b);
        border-radius: 2px;
    }

    .projects-header p {
        color: #666;
        margin-top: 20px;
        font-size: 18px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .project-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: var(--primary-gold, #b8860b);
    }

    .project-img-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img {
        transform: scale(1.1);
    }

    .project-status {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-gold, #b8860b);
        color: #fff;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .project-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .project-title {
        font-size: 22px;
        font-weight: 700;
        color: #222;
        margin-bottom: 10px;
        transition: color 0.3s;
    }

    .project-card:hover .project-title {
        color: var(--primary-gold, #b8860b);
    }

    .project-location {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .project-location i {
        color: var(--primary-gold, #b8860b);
    }

    .project-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }

    .project-price {
        display: flex;
        flex-direction: column;
    }

    .price-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
    }

    .price-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-gold, #b8860b);
    }

    .btn-project {
        background: #222;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .project-card:hover .btn-project {
        background: var(--primary-gold, #b8860b);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .projects-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .projects-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 columns for mobile as requested */
            gap: 15px;
        }
        .projects-header h2 {
            font-size: 26px;
        }
        .projects-header p {
            font-size: 14px;
        }
        .project-img-wrapper {
            height: 140px; /* Reduced height for 2-column grid */
        }
        .project-content {
            padding: 15px;
        }
        .project-title {
            font-size: 16px;
        }
        .project-location {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .price-value {
            font-size: 14px;
        }
        .btn-project {
            padding: 8px 12px;
            font-size: 12px;
        }
    }

</style>

<section class="projects-section" id="projects">
    <div class="projects-container">
        <div class="projects-header">
            <h2>Our Projects</h2>
            <p>Discover Our Exclusive Real Estate Projects In Dholera Smart City</p>
        </div>

        <div class="projects-grid">
            <?php if (!empty($all_projects)): ?>
                <?php foreach ($all_projects as $project): ?>
                    <div class="project-card">
                        <div class="project-img-wrapper">
                            <?php if ($project['featured_image']): ?>
                                <img src="<?php echo BASE_URL . $project['featured_image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="project-img">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" class="project-img">
                            <?php endif; ?>
                            <span class="project-status"><?php echo htmlspecialchars($project['label'] ?: 'Featured'); ?></span>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <div class="project-location">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                            </div>
                            <div class="project-footer">
                                <div class="project-price">
                                    <span class="price-label">Starting From</span>
                                    <span class="price-value">₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?>*</span>
                                </div>
                                <a href="project-details.php?id=<?php echo $project['id']; ?>" class="btn-project">View Project</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Static Fallback if no projects exist -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-building" style="font-size: 40px; margin-bottom: 20px; color: #ccc;"></i>
                    <p>New projects coming soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
