<?php
// Our Projects Component - Redesigned & Size Optimized
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
        padding: 40px 20px 0;
        margin: 40px 1% 60px;
        position: relative;
        overflow: visible;
        font-family: 'Outfit', sans-serif;
    }

    /* Stylized Background Overlay - Banner Style */
    .projects-banner {
        background: linear-gradient(135deg, #a7ffeb 0%, #e0f2f1 100%);
        border-radius: 20px;
        padding: 40px 50px 80px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 0;
    }

    .projects-title-group {
        text-align: left;
    }

    .projects-title-group h2 {
        font-size: 30px;
        color: #1c335a;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .projects-title-group p {
        font-size: 15px;
        color: #555;
        font-weight: 500;
    }

    .btn-see-all {
        background: #fff;
        color: #1c335a;
        padding: 8px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .btn-see-all:hover {
        background: #1c335a;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Slider Layout */
    .projects-slider-container {
        position: relative;
        overflow: hidden;
        margin-top: -60px; /* Overlap with banner */
        padding: 20px 0;
        z-index: 1;
    }

    .projects-slider-wrapper {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 20px;
    }

    /* Project Card - Smaller Size */
    .project-card {
        min-width: calc(25% - 15px); /* 4 items on desktop */
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .project-img-wrapper {
        position: relative;
        height: 180px; /* Reduced height */
        overflow: hidden;
        margin: 10px;
        border-radius: 15px;
    }

    .project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .project-badge-logo {
        position: absolute;
        bottom: 10px;
        left: 10px;
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        z-index: 2;
    }

    .project-badge-logo img {
        width: 100%;
        height: auto;
    }

    .project-badge-status {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.9);
        color: #1c335a;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        backdrop-filter: blur(5px);
    }

    .project-content {
        padding: 0 18px 18px;
        text-align: left;
    }

    .project-title {
        font-size: 17px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .project-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #777;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .project-location i {
        color: #1c335a;
    }

    .project-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .project-rating {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: 12px;
        font-weight: 700;
        color: #1c335a;
    }

    .project-rating i {
        color: #ffb400;
    }

    .project-price-tag {
        background: #f3f4f6;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #4b5563;
    }

    /* Navigation Buttons */
    .proj-nav-btn {
        position: absolute;
        top: 60%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        background: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: #1c335a;
    }

    .proj-nav-btn.prev { left: -5px; }
    .proj-nav-btn.next { right: -5px; }

    /* Mobile View */
    @media (max-width: 1100px) {
        .project-card {
            min-width: calc(33.333% - 15px);
        }
    }

    @media (max-width: 768px) {
        .project-card {
            min-width: calc(50% - 12px);
        }
    }

    @media (max-width: 600px) {
        .projects-section {
            padding: 20px 10px 0;
        }
        .projects-banner {
            padding: 30px 20px 60px;
        }
        .projects-title-group h2 {
            font-size: 24px;
        }
        .project-card {
            min-width: calc(80% - 10px);
        }
        .project-img-wrapper {
            height: 150px;
        }
        .proj-nav-btn {
            display: none;
        }
    }
</style>

<section class="projects-section" id="projects">
    <div class="projects-banner">
        <div class="projects-title-group">
            <h2>Our Projects</h2>
            <p>Explore premium real estate in Dholera</p>
        </div>
        <a href="#all-projects" class="btn-see-all">See All</a>
    </div>

    <div class="projects-slider-container">
        <div class="projects-slider-wrapper" id="proj-slider-wrapper">
            <?php if (!empty($all_projects)): ?>
                <?php foreach ($all_projects as $index => $project): 
                    $rating = 4 . "." . rand(5, 9);
                    $reviews = rand(10, 50);
                ?>
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
                            <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <div class="project-location">
                                <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i> <?php echo htmlspecialchars($project['location']); ?>
                            </div>
                            
                            <div class="project-stats">
                                <div class="project-rating">
                                    <i class="fas fa-star" style="font-size: 10px;"></i> <?php echo $rating; ?>
                                </div>
                                <div class="project-price-tag">
                                    ₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?>
                                </div>
                            </div>
                            
                            <a href="<?php echo BASE_URL; ?>project/<?php echo $project['slug'] ? $project['slug'] : $project['id']; ?>" style="text-decoration: none; display: block; margin-top: 12px;">
                                <div style="color: #1c335a; font-weight: 700; font-size: 13px; text-align: center; border: 1px solid #eee; padding: 6px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='#1c335a'; this.style.color='#fff'" onmouseout="this.style.background='transparent'; this.style.color='#1c335a'">
                                    Details <i class="fas fa-arrow-right" style="font-size: 10px; margin-left: 4px;"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="width: 100%; text-align: center; padding: 40px; background: #fff; border-radius: 20px;">
                    <p style="color: #666;">New projects arriving soon!</p>
                </div>
            <?php endif; ?>
        </div>

        <button class="proj-nav-btn prev" id="proj-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="proj-nav-btn next" id="proj-next"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>

<script>
    (function() {
        const projWrapper = document.getElementById('proj-slider-wrapper');
        const projPrev = document.getElementById('proj-prev');
        const projNext = document.getElementById('proj-next');
        
        let projIndex = 0;

        function getVisibleProjItems() {
            if (window.innerWidth <= 600) return 1.25;
            if (window.innerWidth <= 768) return 2;
            if (window.innerWidth <= 1100) return 3;
            return 4; // 4 ON DESKTOP
        }

        function updateProjSlider() {
            const items = projWrapper.querySelectorAll('.project-card');
            if (items.length === 0) return;
            
            const gap = 20; // Updated gap
            const itemWidth = items[0].offsetWidth + gap;
            projWrapper.style.transform = `translateX(-${projIndex * itemWidth}px)`;
        }

        projNext.addEventListener('click', () => {
            const visible = getVisibleProjItems();
            const total = projWrapper.querySelectorAll('.project-card').length;
            if (projIndex < total - Math.floor(visible)) {
                projIndex++;
            } else {
                projIndex = 0;
            }
            updateProjSlider();
        });

        projPrev.addEventListener('click', () => {
            if (projIndex > 0) {
                projIndex--;
            } else {
                const visible = getVisibleProjItems();
                const total = projWrapper.querySelectorAll('.project-card').length;
                projIndex = total - Math.floor(visible);
            }
            updateProjSlider();
        });

        let projAutoSlide = setInterval(() => {
            projNext.click();
        }, 4500);

        projWrapper.addEventListener('mouseenter', () => clearInterval(projAutoSlide));
        projWrapper.addEventListener('mouseleave', () => {
            projAutoSlide = setInterval(() => {
                projNext.click();
            }, 4500);
        });

        window.addEventListener('resize', () => {
            projIndex = 0;
            updateProjSlider();
        });

        setTimeout(updateProjSlider, 100);
    })();
</script>
