<?php
// Hero Component for Real Estate Agency
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
        width: 300%; /* For 3 slides */
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

    /* Mock Slider Images - Real estate themed placeholders */
    .slide-1 { background-image: url('assets/hero/hero-slide-3.webp'); }
    .slide-2 { background-image: url('assets/hero/hero-slide-2.webp'); }
    .slide-3 { background-image: url('assets/hero/hero-slide-1.webp'); }

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
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background 0.3s;
        border-radius: 2px;
    }

    .slider-dot.active {
        background: #fff;
    }

    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.3);
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

    .slider-arrow:hover { background: rgba(255, 255, 255, 0.5); }
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
        margin-bottom: 10px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-gold, #b8860b);
    }

    .submit-btn {
        grid-column: span 2;
        background: #d4a75c;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .submit-btn:hover {
        background: #c39243;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .hero-slider-col {
            flex: 1 1 100%;
            min-height: 300px;
            aspect-ratio: 4 / 3;
        }
        .hero-enquiry-col {
            flex: 1 1 100%;
            border-left: none;
            border-top: 5px solid #eee;
        }
        .hero-title {
            font-size: 28px;
        }
    }

    @media (max-width: 480px) {
        .enquiry-grid {
            grid-template-columns: 1fr;
        }
        .submit-btn {
            grid-column: span 1;
        }
        .info-badge {
            font-size: 14px;
        }
    }
</style>

<section class="hero-section">
    <!-- Left Column: Slider -->
    <div class="hero-slider-col">
        <div class="slider-container" id="slider">
            <div class="slide slide-1"></div>
            <div class="slide slide-2"></div>
            <div class="slide slide-3"></div>
        </div>

        <div class="slider-arrow arrow-left" id="prevSlide">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="slider-arrow arrow-right" id="nextSlide">
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="slider-nav">
            <div class="slider-dot active" data-index="0"></div>
            <div class="slider-dot" data-index="1"></div>
            <div class="slider-dot" data-index="2"></div>
        </div>
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
    const totalSlides = 3;

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

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentSlide = parseInt(dot.dataset.index);
            updateSlider();
        });
    });

    // Autoplay
    setInterval(nextSlide, 5000);
</script>
