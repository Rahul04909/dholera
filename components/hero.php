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
        position: relative;
        width: 100%;
        overflow: hidden;
        z-index: 1;
    }

    /* 100% Full Width Hero Slider */
    .hero-slider-col {
        width: 100%;
        height: 430px;
        position: relative;
        overflow: hidden;
        background-color: #000;
    }

    .slider-container {
        display: flex;
        width:
            <?php echo $total_slides_count * 100; ?>
            %;
        height: 100%;
        transition: transform 0.8s cubic-bezier(0.7, 0, 0.3, 1);
    }

    .slide {
        width: 100%;
        height: 100%;
        position: relative;
        flex-shrink: 0;
        overflow: hidden;
    }

    /* Full Width cover styling */
    .slide img.foreground-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    /* Elegant Left-to-Right vignette gradient to ensure text readability */
    .slide::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.3) 60%, rgba(15, 23, 42, 0) 100%);
        z-index: 2;
    }

    /* Slider Navigation Indicators */
    .slider-nav {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .slider-dot {
        width: 40px;
        height: 5px;
        background: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .slider-dot.active {
        background: var(--primary-gold, #b8860b);
        width: 55px;
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
        transition: background 0.3s, transform 0.2s;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        backdrop-filter: blur(5px);
    }

    .slider-arrow:hover {
        background: rgba(184, 134, 11, 0.8);
        transform: translateY(-50%) scale(1.05);
    }

    .arrow-left {
        left: 30px;
    }

    .arrow-right {
        right: 30px;
    }

    /* High-Impact Centered Overlay Content */
    .slide-content {
        position: absolute;
        top: 50%;
        left: 8%;
        transform: translateY(-50%);
        color: #fff;
        max-width: 700px;
        z-index: 5;
        text-align: left;
    }

    .slide-content h2 {
        font-size: 34px;
        font-weight: 900;
        margin-bottom: 10px;
        line-height: 1.2;
        letter-spacing: -0.5px;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }

    .slide-content p {
        font-size: 16px;
        font-weight: 550;
        color: #e2e8f0;
        margin: 0;
        line-height: 1.4;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        font-family: 'Inter', sans-serif;
    }

    /* Dynamic Typing Cursor */
    .typing-title.typing-active::after,
    .typing-subtitle.typing-active::after {
        content: '|';
        display: inline-block;
        margin-left: 4px;
        color: var(--primary-gold, #b8860b);
        animation: cursorBlink 0.75s step-end infinite;
    }

    @keyframes cursorBlink {

        from,
        to {
            color: transparent
        }

        50% {
            color: var(--primary-gold, #b8860b)
        }
    }

    /* Symmetrical Premium Call To Action Button */
    .slide-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        color: #1c335a;
        border: none;
        padding: 16px 36px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: 'Outfit', sans-serif;
    }

    .slide-cta-btn:hover {
        background: var(--primary-gold, #b8860b);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(184, 134, 11, 0.35);
    }

    /* -------------------------------------------------------------
       PREMIUM POP-UP ENQUIRY MODAL (Frosted Glass Glassmorphism)
       ------------------------------------------------------------- */
    .hero-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .hero-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .hero-modal-content {
        background: #fff;
        width: 100%;
        max-width: 520px;
        border-radius: 20px;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        transform: scale(0.95) translateY(20px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: left;
        font-family: 'Outfit', sans-serif;
    }

    .hero-modal-overlay.active .hero-modal-content {
        transform: scale(1) translateY(0);
    }

    .hero-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 36px;
        height: 36px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 10;
    }

    .hero-modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: rotate(90deg);
    }

    .modal-interior {
        padding: 35px 30px;
        max-height: 90vh;
        overflow-y: auto;
    }

    /* Modal Layout Styles mapping the old form layout */
    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .info-header .logo-small img {
        height: 46px;
    }

    .location-badge {
        background: var(--primary-gold, #b8860b);
        color: #fff;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hero-title {
        font-size: 22px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 12px;
    }

    .badges-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .info-badge {
        background: #d4a75c;
        color: #fff;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
    }

    .highlights-list {
        list-style: none;
        margin-bottom: 22px;
        padding: 0;
    }

    .highlights-list li {
        font-size: 12.5px;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        font-family: 'Inter', sans-serif;
    }

    .highlights-list li::before {
        content: "\2022";
        color: var(--primary-gold, #b8860b);
        font-weight: bold;
        font-size: 18px;
    }

    .enquiry-form-container {
        border-top: 1.5px solid #f1f5f9;
        padding-top: 20px;
    }

    .form-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        font-weight: 700;
        color: #1c335a;
        margin-bottom: 15px;
    }

    .enquiry-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #edf2f7;
        border-radius: 6px;
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.3s;
        box-shadow: none;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        border-color: var(--primary-gold, #b8860b);
    }

    .submit-btn {
        grid-column: span 2;
        background: #1c335a;
        color: #fff;
        border: none;
        padding: 13px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        margin-top: 8px;
    }

    .submit-btn:hover {
        background: var(--primary-gold, #b8860b);
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.25);
    }

    /* Responsive Scaling */
    @media (max-width: 992px) {
        .hero-slider-col {
            height: 280px;
        }

        .slide-content {
            left: 5%;
            right: 5%;
            max-width: 90%;
        }

        .slide-content h2 {
            font-size: 22px;
        }

        .slide-content p {
            font-size: 13px;
            padding: 0;
            margin-bottom: 0;
        }

        .arrow-left {
            left: 15px;
        }

        .arrow-right {
            right: 15px;
        }
    }

    @media (max-width: 480px) {
        .hero-slider-col {
            height: 200px;
        }

        .slide-content h2 {
            font-size: 18px;
        }

        .slide-content p {
            font-size: 11px;
        }

        .enquiry-grid {
            grid-template-columns: 1fr;
        }

        .submit-btn {
            grid-column: span 1;
        }

        .modal-interior {
            padding: 25px 20px;
        }
    }
</style>

<section class="hero-section">
    <!-- Slider -->
    <div class="hero-slider-col">
        <div class="slider-container" id="slider">
            <?php foreach ($active_slides as $slide): ?>
                <div class="slide">
                    <!-- Background slide image -->
                    <img src="<?php echo htmlspecialchars($slide['image_path']); ?>" class="foreground-img"
                        alt="<?php echo isset($slide['title']) ? htmlspecialchars($slide['title']) : 'Dholera Hero Slide'; ?>">

                    <?php if (!empty($slide['title']) || !empty($slide['subtitle'])): ?>
                        <div class="slide-content">
                            <?php if (!empty($slide['title'])): ?>
                                <h2 class="typing-title" data-text="<?php echo htmlspecialchars($slide['title']); ?>"></h2>
                            <?php endif; ?>
                            <?php if (!empty($slide['subtitle'])): ?>
                                <p class="typing-subtitle" data-text="<?php echo htmlspecialchars($slide['subtitle']); ?>"></p>
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
                <?php for ($i = 0; $i < $total_slides_count; $i++): ?>
                    <div class="slider-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Sleek Frosted Glass Pop-up Enquiry Modal -->
<div class="hero-modal-overlay" id="heroEnquiryModal" onclick="closeHeroModal(event)">
    <div class="hero-modal-content" onclick="event.stopPropagation()">
        <div class="hero-modal-close" onclick="hideHeroModal()">
            <i class="fas fa-times"></i>
        </div>

        <div class="modal-interior">
            <div class="info-header">
                <div class="logo-small">
                    <!-- Uses the exact same branding logo as header -->
                    <img src="<?php echo BASE_URL; ?>assets/dholera-logo.png" alt="Dholera Smart City Branding Logo">
                </div>
                <div class="location-badge">
                    <i class="fas fa-map-marker-alt"></i> At Gujarat
                </div>
            </div>

            <h3 class="hero-title">Dholera Plots At Gujarat</h3>

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
                <form id="enquiryForm" class="enquiry-grid">
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
                    <button type="submit" class="submit-btn shadow-sm">Submit Form</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Popup Modal -->
<div id="successModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.85); z-index: 20000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div
        style="background: #fff; padding: 40px; border-radius: 16px; text-align: center; max-width: 400px; position: relative; border-top: 5px solid var(--primary-gold, #b8860b); box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <div
            style="width: 80px; height: 80px; background: #f0fff4; color: #38a169; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px;">
            <i class="fas fa-check"></i>
        </div>
        <h2 style="font-size: 24px; margin-bottom: 10px; color: #1c335a; font-weight: 800;">Thank You!</h2>
        <p style="color: #64748b; margin-bottom: 25px; font-family: 'Inter', sans-serif; font-size: 14.5px;">Your
            enquiry has been received. Our team will contact you shortly.</p>
        <button onclick="document.getElementById('successModal').style.display = 'none'"
            style="background: #1c335a; color: #fff; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; cursor: pointer; text-transform: uppercase; transition: 0.2s;"
            onmouseover="this.style.background='#b8860b'" onmouseout="this.style.background='#1c335a'">Close</button>
    </div>
</div>

<!-- GSAP Core & TextPlugin for Dynamic Typing Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>

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
            animateSlideText(currentSlide);
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

    /* Modal Interaction Logic */
    function openHeroModal(e) {
        if (e) e.preventDefault();
        const modal = document.getElementById('heroEnquiryModal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
    }

    function hideHeroModal() {
        const modal = document.getElementById('heroEnquiryModal');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function closeHeroModal(e) {
        if (e.target.id === 'heroEnquiryModal') {
            hideHeroModal();
        }
    }

    // AJAX Enquiry Submission
    document.getElementById('enquiryForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('.submit-btn');
        const originalBtnText = submitBtn.innerText;

        submitBtn.disabled = true;
        submitBtn.innerText = 'Submitting...';

        fetch('ajax/submit-enquiry.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    hideHeroModal();
                    document.getElementById('successModal').style.display = 'flex';
                    form.reset();
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('A technical error occurred.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
            });
    });

    // GSAP Text Typing Animation Logic
    gsap.registerPlugin(TextPlugin);

    function animateSlideText(slideIndex) {
        // Kill existing animations on titles and subtitles to prevent overlaps
        gsap.killTweensOf('.typing-title');
        gsap.killTweensOf('.typing-subtitle');

        const slides = document.querySelectorAll('.slide');
        slides.forEach((slide, idx) => {
            const titleEl = slide.querySelector('.typing-title');
            const subtitleEl = slide.querySelector('.typing-subtitle');

            if (idx === slideIndex) {
                // Animate active slide text
                if (titleEl) {
                    const titleText = titleEl.getAttribute('data-text') || '';
                    titleEl.textContent = '';
                    titleEl.classList.add('typing-active');
                    gsap.to(titleEl, {
                        duration: 1.5,
                        text: { value: titleText, delimiter: "" },
                        ease: "none",
                        onComplete: () => {
                            titleEl.classList.remove('typing-active');
                        }
                    });
                }

                if (subtitleEl) {
                    const subtitleText = subtitleEl.getAttribute('data-text') || '';
                    subtitleEl.textContent = '';
                    subtitleEl.classList.add('typing-active');
                    gsap.to(subtitleEl, {
                        duration: 2.0,
                        text: { value: subtitleText, delimiter: "" },
                        ease: "none",
                        delay: 1.5, // Start typing subtitle after title finishes
                        onComplete: () => {
                            subtitleEl.classList.remove('typing-active');
                        }
                    });
                }
            } else {
                // Clear inactive slides
                if (titleEl) titleEl.textContent = '';
                if (subtitleEl) subtitleEl.textContent = '';
            }
        });
    }

    // Automatically trigger frosted glass pop-up modal & start GSAP slide 1 text typing on page load
    window.addEventListener('DOMContentLoaded', () => {
        // Trigger first slide text typing immediately
        animateSlideText(0);

        setTimeout(() => {
            openHeroModal();
        }, 1000); // 1-second delay for premium appearance
    });
</script>