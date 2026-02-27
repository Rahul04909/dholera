<?php
// Hero Component for Real Estate Agency
require_once 'database/db_config.php';

// Fetch dynamic slides
try {
    $slide_stmt = $conn->query("SELECT * FROM hero_slides WHERE status = 'active' ORDER BY order_index ASC");
    $dynamic_slides = $slide_stmt->fetchAll();
} catch (PDOException $e) {
    $dynamic_slides = []; // Fallback to empty
}

// Default slides if no dynamic ones exist
$default_slides = [
    ['image_path' => 'assets/hero/hero-slide-3.webp'],
    ['image_path' => 'assets/hero/hero-slide-2.webp'],
    ['image_path' => 'assets/hero/hero-slide-1.webp']
];

$active_slides = !empty($dynamic_slides) ? $dynamic_slides : $default_slides;
$total_slides_count = count($active_slides);
?>
<style>
    .hero-section {
        display: flex;
        flex-wrap: wrap;
        background: #fff;
        min-height: 500px;
    }

    /* Left Column: Slider */
    .hero-slider-col {
        flex: 1 1 65%;
        position: relative;
        overflow: hidden;
        min-height: 400px;
        background-color: #000; /* Backdrop for loading/gaps */
    }

    .slider-container {
        display: flex;
        width: <?php echo $total_slides_count * 100; ?>%; /* Dynamic width based on slides */
        height: 100%;
        transition: transform 0.8s cubic-bezier(0.7, 0, 0.3, 1);
    }

    .slide {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    /* Ensure images look good on all screens by controlling aspect ratio */
    @media (min-width: 993px) {
        .hero-slider-col {
            aspect-ratio: 16 / 9;
            min-height: 500px;
        }
    }

    /* Slider Controls */
    .slider-nav {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .slider-dot {
        width: 40px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background 0.3s;
        border-radius: 2px;
    }

    .slider-dot.active {
        background: var(--primary-gold, #b8860b);
    }

    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.3);
        color: #fff;
        padding: 15px;
        cursor: pointer;
        z-index: 10;
        transition: background 0.3s;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }

    .slider-arrow:hover { background: rgba(184, 134, 11, 0.7); }
    .arrow-left { left: 20px; }
    .arrow-right { right: 20px; }

    /* Right Column: Enquiry */
    .hero-enquiry-col {
        flex: 1 1 35%;
        padding: 30px;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        border-left: 1px solid #eee;
    }

    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .info-header .logo-small img {
        height: 50px;
    }

    .location-badge {
        background: var(--primary-gold, #b8860b);
        color: #fff;
        padding: 5px 15px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hero-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .badges-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .info-badge {
        background: #d4a75c; /* Light gold background for text */
        color: #fff;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
    }

    .highlights-list {
        list-style: none;
        margin-bottom: 25px;
    }

    .highlights-list li {
        font-size: 14px;
        font-weight: 600;
        color: #444;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
    }

    .highlights-list li::before {
        content: "\2022";
        color: #333;
        font-weight: bold;
        font-size: 20px;
    }

    /* Enquiry Form */
    .enquiry-form-container {
        margin-top: auto;
    }

    .form-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .enquiry-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: var(--primary-gold, #b8860b);
    }

    .submit-btn {
        grid-column: span 2;
        background: var(--primary-gold, #b8860b);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
        text-transform: uppercase;
    }

    .submit-btn:hover {
        background: #966d09;
    }

    /* Dynamic Slide Title Overlay */
    .slide-content {
        position: absolute;
        top: 50%;
        left: 80px;
        transform: translateY(-50%);
        color: #fff;
        max-width: 600px;
        z-index: 5;
    }

    .slide-content h2 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 15px;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    .slide-content p {
        font-size: 20px;
        font-weight: 500;
        background: rgba(0,0,0,0.4);
        padding: 10px 20px;
        display: inline-block;
        border-left: 4px solid var(--primary-gold);
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .hero-slider-col {
            flex: 1 1 100%;
            min-height: 350px;
        }
        .hero-enquiry-col {
            flex: 1 1 100%;
            border-left: none;
            padding: 40px 20px;
        }
        .slide-content {
            left: 30px;
        }
        .slide-content h2 {
            font-size: 32px;
        }
    }

    @media (max-width: 480px) {
        .enquiry-grid {
            grid-template-columns: 1fr;
        }
        .submit-btn {
            grid-column: span 1;
        }
        .slide-content h2 {
            font-size: 26px;
        }
    }
</style>

<section class="hero-section">
    <!-- Left Column: Slider -->
    <div class="hero-slider-col">
        <div class="slider-container" id="slider">
            <?php foreach ($active_slides as $slide): ?>
                <div class="slide" style="background-image: url('<?php echo htmlspecialchars($slide['image_path']); ?>');">
                    <?php if (isset($slide['title']) && $slide['title']): ?>
                        <div class="slide-content">
                            <h2><?php echo htmlspecialchars($slide['title']); ?></h2>
                            <?php if (isset($slide['subtitle']) && $slide['subtitle']): ?>
                                <p><?php echo htmlspecialchars($slide['subtitle']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($total_slides_count > 1): ?>
            <div class="slider-arrow arrow-left" id="prevSlide">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="slider-arrow arrow-right" id="nextSlide">
                <i class="fas fa-chevron-right"></i>
            </div>

            <div class="slider-nav">
                <?php for($i = 0; $i < $total_slides_count; $i++): ?>
                    <div class="slider-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Enquiry Form -->
    <div class="hero-enquiry-col">
        <div class="info-header">
            <div class="logo-small">
                <img src="assets/logo.webp" alt="Dholera Logo">
            </div>
            <div class="location-badge">
                <i class="fas fa-map-marker-alt"></i> At Gujarat
            </div>
        </div>

        <h1 class="hero-title">Dholera Plots At Gujarat</h1>

        <div class="badges-container">
            <div class="info-badge">Starting From ₹ 12.5 Lacs*</div>
            <div class="info-badge">12% Assured Return</div>
        </div>

        <ul class="highlights-list">
            <li>PLAN, BUILD, MODELING, PUBLISH</li>
            <li>COMPLETE LEGALITY (N.A, N.O.C, PLAN PASS)</li>
            <li>EFFICIENT GOVERNANCE</li>
            <li>RERA APPROVED PROJECT</li>
        </ul>

        <div class="enquiry-form-container">
            <div class="form-heading">
                <i class="far fa-envelope-open"></i> Send A Message !
            </div>
            <form action="#" method="POST" class="enquiry-grid">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="number" class="form-control" placeholder="Enter Number" required>
                </div>
                <div class="form-group">
                    <input type="text" name="comments" class="form-control" placeholder="Enter Comments">
                </div>
                <button type="submit" class="submit-btn shadow-sm">Submit</button>
            </form>
        </div>
    </div>
</section>

<script>
    const sliderContainer = document.getElementById('slider');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    
    let currentSlide = 0;
    const totalSlides = <?php echo $total_slides_count; ?>;

    if (totalSlides > 1) {
        function updateSlider() {
            sliderContainer.style.transform = `translateX(-${(currentSlide * 100) / totalSlides}%)`;
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === currentSlide);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentSlide = parseInt(dot.dataset.index);
                updateSlider();
            });
        });

        // Autoplay
        setInterval(nextSlide, 5000);
    }
</script>
