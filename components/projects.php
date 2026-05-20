<?php
// Our Projects Component - Synchronized Styling & Performance
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
        padding: 30px 25px 0;
        margin: 40px 2% 60px;
        position: relative;
        overflow: visible;
        z-index: 1;
        font-family: 'Outfit', sans-serif;
    }

    /* Stylized Background Overlay - Matching Developers exactly */
    .projects-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #fdfbf7 0%, #f5eedc 100%);
        border-radius: 20px;
        border: 1px solid rgba(184, 134, 11, 0.1);
        z-index: -1;
    }

    /* Decorative Dashed Lines */
    .projects-section::before {
        content: '';
        position: absolute;
        top: -50px;
        right: 5%;
        width: 250px;
        height: 250px;
        border: 2px dashed rgba(0,0,0,0.05);
        border-radius: 50%;
        z-index: 0;
    }

    .projects-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
        padding: 0 15px;
    }

    .projects-title-group h2 {
        font-size: 32px;
        color: #1c335a;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .projects-title-group p {
        font-family: 'Inter', sans-serif;
        font-size: 15px;
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
    }

    /* Slider Layout */
    .projects-slider-container {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        z-index: 1;
    }

    .projects-slider-wrapper {
        display: flex;
        transition: transform 0.5s ease-in-out;
        gap: 20px;
    }

    /* Enhanced Project Card - Housing & Square Yards style */
    .project-card {
        min-width: calc(25% - 15px); /* 4 items on desktop */
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
        height: 200px;
        overflow: hidden;
        margin: 0;
        border-radius: 0;
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
        padding: 20px 18px;
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
        margin-bottom: 8px;
    }

    .project-title {
        font-size: 18px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 6px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 46px; /* Symmetrical grid alignment */
    }

    .project-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #718096;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .project-location i {
        color: var(--primary-color);
    }

    /* Price and Specs Row */
    .project-price-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
        margin-bottom: 12px;
    }

    .price-value {
        font-size: 18px;
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
        gap: 10px;
        margin-bottom: 18px;
    }

    .spec-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 12px;
        color: #4a5568;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .spec-item i {
        color: #1c335a;
    }

    /* Dual CTA Buttons */
    .project-cta-row {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 10px;
        margin-top: auto;
    }

    .cta-btn {
        padding: 10px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
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

    /* Navigation Buttons */
    .proj-nav-btn {
        position: absolute;
        top: 50%;
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: #1c335a;
        transition: all 0.3s ease;
    }

    .proj-nav-btn:hover {
        background: #1c335a;
        color: #fff;
    }

    .proj-nav-btn.prev { left: -15px; }
    .proj-nav-btn.next { right: -15px; }

    /* Mobile View */
    @media (max-width: 768px) {
        .projects-section {
            padding: 20px 15px 0;
            margin: 15px 1.5% 40px;
        }

        .projects-section::after {
            height: 180px;
        }

        .project-card {
            min-width: calc(85% - 10px);
        }

        .projects-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .proj-nav-btn {
            display: none;
        }
    }
</style>

<section class="projects-section" id="projects">
    <div class="projects-header">
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
                                <a href="#siteVisitForm" class="cta-btn cta-primary">
                                    Inquire <i class="fas fa-arrow-right" style="font-size: 10px; margin-left: 6px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
            if (window.innerWidth <= 768) return 1.25;
            if (window.innerWidth <= 1024) return 3;
            return 4;
        }

        function updateProjSlider() {
            const items = projWrapper.querySelectorAll('.project-card');
            if (items.length === 0) return;
            
            const gap = 20;
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

        // Professional Touch Swiping Gestures for Mobile (Housing/Square Yards Style)
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        projWrapper.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            clearInterval(projAutoSlide);
        }, { passive: true });

        projWrapper.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        }, { passive: true });

        projWrapper.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - currentX;
            if (Math.abs(diffX) > 50) { // threshold of 50px swipe
                if (diffX > 0) {
                    projNext.click();
                } else {
                    projPrev.click();
                }
            }
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
