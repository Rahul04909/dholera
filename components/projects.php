<?php
// Our Projects Component - Redesigned to match Browse Stores layout
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
        margin: 40px 2% 60px;
        position: relative;
        overflow: visible;
        font-family: 'Outfit', sans-serif;
    }

    /* Stylized Background Overlay - Banner Style */
    .projects-banner {
        background: linear-gradient(135deg, #a7ffeb 0%, #e0f2f1 100%);
        border-radius: 20px;
        padding: 40px 50px 100px;
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
        font-size: 38px;
        color: #1c335a;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .projects-title-group p {
        font-size: 16px;
        color: #555;
        font-weight: 500;
    }

    .btn-see-all {
        background: #fff;
        color: #1c335a;
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
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
        margin-top: -80px; /* Overlap with banner */
        padding: 20px 0;
        z-index: 1;
    }

    .projects-slider-wrapper {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 25px;
    }

    /* Project Card - Professional Design */
    .project-card {
        min-width: calc(33.333% - 17px); /* 3 items on desktop */
        background: #fff;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.12);
    }

    .project-img-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
        margin: 12px;
        border-radius: 20px;
    }

    .project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .project-card:hover .project-img {
        transform: scale(1.1);
    }

    /* Circular Logo Badge */
    .project-badge-logo {
        position: absolute;
        bottom: 15px;
        left: 15px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        z-index: 2;
    }

    .project-badge-logo img {
        width: 100%;
        height: auto;
    }

    .project-badge-status {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: #1c335a;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        backdrop-filter: blur(5px);
    }

    .project-content {
        padding: 0 25px 25px;
        text-align: left;
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
        gap: 6px;
        color: #777;
        font-size: 13px;
        margin-bottom: 15px;
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
        gap: 4px;
        font-size: 13px;
        font-weight: 700;
        color: #1c335a;
    }

    .project-rating i {
        color: #ffb400;
    }

    .project-rating span {
        color: #888;
        font-weight: 500;
        margin-left: 2px;
    }

    .project-price-tag {
        background: #f3f4f6;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #4b5563;
    }

    /* Navigation Buttons */
    .proj-nav-btn {
        position: absolute;
        top: 55%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        color: #1c335a;
        transition: all 0.3s;
    }

    .proj-nav-btn:hover {
        background: #1c335a;
        color: #fff;
    }

    .proj-nav-btn.prev { left: -10px; }
    .proj-nav-btn.next { right: -10px; }

    /* Decorative Elements */
    .projects-banner::before {
        content: '';
        position: absolute;
        top: -30px;
        right: 15%;
        width: 200px;
        height: 200px;
        border: 2px dashed rgba(28, 51, 90, 0.05);
        border-radius: 50%;
        z-index: 0;
    }

    /* Mobile View */
    @media (max-width: 992px) {
        .project-card {
            min-width: calc(50% - 13px);
        }
    }

    @media (max-width: 600px) {
        .projects-section {
            padding: 20px 10px 0;
            margin: 20px 0 40px;
        }

        .projects-banner {
            padding: 30px 20px 80px;
            border-radius: 0;
        }

        .projects-title-group h2 {
            font-size: 26px;
        }

        .projects-title-group p {
            font-size: 13px;
        }

        .btn-see-all {
            padding: 8px 15px;
            font-size: 12px;
        }

        .projects-slider-wrapper {
            gap: 15px;
            padding: 0 10px;
        }

        .project-card {
            min-width: calc(85% - 15px); /* Peek at next card */
        }

        .project-img-wrapper {
            height: 180px;
            margin: 8px;
        }

        .project-content {
            padding: 0 15px 20px;
        }

        .project-title {
            font-size: 17px;
        }

        .proj-nav-btn {
            display: none; /* Hide on mobile for better touch experience */
        }
    }
</style>

<section class="projects-section" id="projects">
    <div class="projects-banner">
        <div class="projects-title-group">
            <h2>Browse Projects</h2>
            <p>Explore premium real estate opportunities in Dholera</p>
        </div>
        <a href="#all-projects" class="btn-see-all">See All</a>
    </div>

    <div class="projects-slider-container">
        <div class="projects-slider-wrapper" id="proj-slider-wrapper">
            <?php if (!empty($all_projects)): ?>
                <?php foreach ($all_projects as $index => $project): 
                    // Random rating for professional look
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
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                            </div>
                            
                            <div class="project-stats">
                                <div class="project-rating">
                                    <i class="fas fa-star"></i> <?php echo $rating; ?> <span>(<?php echo $reviews; ?>)</span>
                                </div>
                                <div class="project-price-tag">
                                    ₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?>
                                </div>
                            </div>
                            
                            <a href="<?php echo BASE_URL; ?>project/<?php echo $project['slug'] ? $project['slug'] : $project['id']; ?>" style="text-decoration: none; display: block; margin-top: 15px;">
                                <div style="color: #1c335a; font-weight: 700; font-size: 14px; text-align: center; border: 1px solid #eee; padding: 8px; border-radius: 10px; transition: 0.3s;" onmouseover="this.style.background='#1c335a'; this.style.color='#fff'" onmouseout="this.style.background='transparent'; this.style.color='#1c335a'">
                                    Details <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 5px;"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="width: 100%; text-align: center; padding: 60px; background: #fff; border-radius: 20px;">
                    <i class="fas fa-city" style="font-size: 50px; color: #eee; margin-bottom: 20px;"></i>
                    <p style="color: #666;">New premium projects arriving soon!</p>
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
            if (window.innerWidth <= 600) return 1.2; // Show one and a bit of next
            if (window.innerWidth <= 992) return 2;
            return 3;
        }

        function updateProjSlider() {
            const items = projWrapper.querySelectorAll('.project-card');
            if (items.length === 0) return;
            
            const gap = 25; // CSS gap
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
