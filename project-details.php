<?php
/**
 * Project Details Page
 * Dholera Smart City
 */
require_once 'database/db_config.php';

// Get Project ID from URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($project_id <= 0) {
    header("Location: index.php");
    exit();
}

try {
    // 1. Fetch Main Project Details
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id AND status = 'active'");
    $stmt->execute(['id' => $project_id]);
    $project = $stmt->fetch();

    if (!$project) {
        header("Location: index.php");
        exit();
    }

    // 2. Fetch Project Slides
    $slide_stmt = $conn->prepare("SELECT * FROM project_slides WHERE project_id = :id ORDER BY order_index ASC");
    $slide_stmt->execute(['id' => $project_id]);
    $slides = $slide_stmt->fetchAll();

    // 3. Fetch Amenities
    $amenity_stmt = $conn->prepare("SELECT * FROM project_amenities WHERE project_id = :id");
    $amenity_stmt->execute(['id' => $project_id]);
    $amenities = $amenity_stmt->fetchAll();

    // 4. Fetch Nearbys
    $nearby_stmt = $conn->prepare("SELECT * FROM project_nearbys WHERE project_id = :id");
    $nearby_stmt->execute(['id' => $project_id]);
    $nearbys = $nearby_stmt->fetchAll();

} catch (PDOException $e) {
    die("Error fetching project data: " . $e->getMessage());
}

include 'includes/header.php';
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #111;
        --text-dark: #2d3748;
        --text-muted: #718096;
        --section-bg: #f8fafc;
    }

    body {
        background-color: #fff;
        color: var(--text-dark);
        line-height: 1.6;
    }

    .project-detail-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        overflow-x: hidden;
    }

    /* Hero Section */
    .detail-hero {
        position: relative;
        height: 500px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 60px 40px 40px;
        color: #fff;
    }

    .hero-badges {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }

    .badge-gold {
        background: var(--primary-gold);
        color: #fff;
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .project-main-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .project-main-loc {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        opacity: 0.9;
    }

    /* Main Grid Layout */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 40px;
        align-items: start;
    }

    /* Content Cards */
    .content-card {
        background: #fff;
        border-radius: 15px;
        padding: 35px;
        margin-bottom: 40px;
        border: 1px solid #edf2f7;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: var(--dark-bg);
    }

    .section-title i {
        color: var(--primary-gold);
        font-size: 20px;
    }

    .key-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-item {
        background: var(--section-bg);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark-bg);
    }

    /* Gallery Slider */
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .gallery-item {
        height: 120px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Amenities */
    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .amenity-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .amenity-card:hover {
        border-color: var(--primary-gold);
        background: rgba(184, 134, 11, 0.05);
    }

    .amenity-icon {
        display: none;
    }

    /* Sticky Sidebar Form */
    .sidebar-form {
        position: sticky;
        top: 100px;
        background: var(--dark-bg);
        color: #fff;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .sidebar-form h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--primary-gold);
    }

    .form-desc {
        font-size: 14px;
        color: #a0aec0;
        margin-bottom: 25px;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-group input, .input-group select, .input-group textarea {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 12px 15px;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
    }

    .input-group input:focus {
        border-color: var(--primary-gold);
        background: rgba(255,255,255,0.08);
    }

    .submit-visit-btn {
        width: 100%;
        background: var(--primary-gold);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.3s;
    }

    .submit-visit-btn:hover {
        background: #966d09;
    }

    .price-box {
        background: rgba(184, 134, 11, 0.1);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid rgba(184, 134, 11, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-amount {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary-gold);
    }

    /* Floor Plan / Site Plan */
    .site-plan-wrapper {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        padding: 20px;
        background: #fff;
    }

    .site-plan-img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .sidebar-form {
            position: static;
            margin-top: 40px;
        }

        .project-main-title {
            font-size: 32px;
        }
    }

    @media (max-width: 600px) {
        .key-stats {
            grid-template-columns: 1fr;
        }
        
        .gallery-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .detail-hero {
            height: 350px;
        }

        .hero-overlay {
            padding: 30px 20px 20px;
        }

        .project-main-title {
            font-size: 26px;
        }

        .content-card {
            padding: 25px;
        }
    }
</style>

<div class="project-detail-wrapper">
    <!-- Hero Section -->
    <div class="detail-hero">
        <img src="<?php echo BASE_URL . $project['featured_image']; ?>" class="hero-img" alt="<?php echo htmlspecialchars($project['title']); ?>">
        <div class="hero-overlay">
            <div class="hero-badges">
                <span class="badge-gold"><?php echo htmlspecialchars($project['project_type']); ?></span>
                <?php if($project['label']): ?>
                    <span class="badge-gold" style="background:#fff; color:var(--dark-bg);"><?php echo htmlspecialchars($project['label']); ?></span>
                <?php endif; ?>
            </div>
            <h1 class="project-main-title"><?php echo htmlspecialchars($project['title']); ?></h1>
            <div class="project-main-loc">
                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Main Content -->
        <div class="detail-content">
            
            <!-- Quick Stats -->
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i> Project Highlights
                </div>
                <div class="key-stats">
                    <div class="stat-item">
                        <span class="stat-label">Plot Sizes</span>
                        <span class="stat-value"><?php echo $project['plot_size_from']; ?> - <?php echo $project['plot_size_to']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Units</span>
                        <span class="stat-value"><?php echo $project['total_units']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Legitimacy</span>
                        <span class="stat-value"><?php echo $project['legitimate']; ?></span>
                    </div>
                </div>
                
                <div class="price-box">
                    <div>
                        <span class="stat-label" style="color:#555">Market Price Starting From</span>
                        <div class="price-amount">₹ <?php echo $project['price_range']; ?>*</div>
                    </div>
                    <?php if($project['brochure_pdf']): ?>
                        <a href="<?php echo BASE_URL . $project['brochure_pdf']; ?>" target="_blank" class="badge-gold" style="text-decoration:none; display:flex; gap:8px; align-items:center;">
                            <i class="fas fa-file-pdf"></i> Brochure
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- About Project -->
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-align-left"></i> About Project
                </div>
                <div class="about-text">
                    <?php echo $project['about_project']; ?>
                </div>
            </div>

            <!-- Gallery -->
            <?php if(!empty($slides)): ?>
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-images"></i> Project Gallery
                </div>
                <div class="gallery-container">
                    <?php foreach($slides as $slide): ?>
                        <div class="gallery-item" onclick="openLightbox('<?php echo BASE_URL . $slide['image_path']; ?>')">
                            <img src="<?php echo BASE_URL . $slide['image_path']; ?>" class="gallery-img">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Amenities -->
            <?php if(!empty($amenities)): ?>
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-swimmer"></i> Premium Amenities
                </div>
                <div class="amenities-grid">
                    <?php foreach($amenities as $amenity): ?>
                        <div class="amenity-card">
                            <span style="font-weight: 600; font-size:14px;"><?php echo htmlspecialchars($amenity['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Location Features -->
            <?php if(!empty($nearbys)): ?>
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-map-marked-alt"></i> Location Advantages
                </div>
                <div class="amenities-grid">
                    <?php foreach($nearbys as $nearby): ?>
                        <div class="amenity-card">
                            <div style="display:flex; flex-direction:column;">
                                <span style="font-weight: 700; font-size:15px;"><?php echo htmlspecialchars($nearby['name']); ?></span>
                                <span style="font-size: 12px; color:var(--text-muted);"><?php echo htmlspecialchars($nearby['distance']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Site Plan -->
            <?php if($project['site_plan_image']): ?>
            <div class="content-card">
                <div class="section-title">
                    <i class="fas fa-draw-polygon"></i> Site / Floor Plan
                </div>
                <div class="site-plan-wrapper">
                    <img src="<?php echo BASE_URL . $project['site_plan_image']; ?>" class="site-plan-img" alt="Site Plan">
                </div>
            </div>
            <?php endif; ?>

            <!-- Map -->
            <?php if($project['google_map_url']): ?>
            <div class="content-card" style="padding:0; overflow:hidden;">
                <iframe src="<?php echo $project['google_map_url']; ?>" width="100%" height="450" style="border:0; display:block;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <?php endif; ?>

        </div>

        <!-- Sticky Sidebar -->
        <div class="sidebar-form">
            <h3>Plan Your Visit</h3>
            <p class="form-desc">Request a personalized site tour of <?php echo htmlspecialchars($project['title']); ?> today.</p>
            
            <form id="siteVisitForm">
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                <input type="hidden" name="project_name" value="<?php echo htmlspecialchars($project['title']); ?>">
                
                <div class="input-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="tel" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="input-group">
                    <textarea name="message" rows="3" placeholder="Any special requirements?"></textarea>
                </div>
                <button type="submit" class="submit-visit-btn">Schedule Visit Now</button>
            </form>
        </div>
    </div>
</div>

<!-- Simple Lightbox Modal -->
<div id="lightbox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:9999; align-items:center; justify-content:center; cursor:pointer;" onclick="this.style.display='none'">
    <img id="lightboxImg" src="" style="max-width:90%; max-height:80%; border-radius:10px; box-shadow:0 0 50px rgba(0,0,0,0.5);">
</div>

<script>
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').style.display = 'flex';
    }

    // Site Visit Form Submission
    document.getElementById('siteVisitForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.submit-visit-btn');
        btn.disabled = true;
        btn.innerText = 'Processing...';

        const formData = new FormData(this);
        
        // We can reuse the callback or create a specific handler
        fetch('ajax/submit-visit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Success! Your site visit request has been sent. We will contact you soon.');
                this.reset();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => alert('A technical error occurred.'))
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Schedule Visit Now';
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
