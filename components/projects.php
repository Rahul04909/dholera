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
/* ... existing styles ... */
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
