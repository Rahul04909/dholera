<?php
/**
 * Dholera Developers Component - Premium Slider Version
 * Adapted from user sample code with forced 3-column mobile layout.
 */
?>

<style>
    .developers-section {
        padding: 40px 20px 0;
        margin: 40px 2% 60px;
        position: relative;
        overflow: visible;
    }

    /* Stylized Background Overlay */
    .developers-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 240px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); /* Light Green Gradient */
        border-radius: 30px;
        z-index: -1;
    }

    /* Decorative Dashed Lines */
    .developers-section::before {
        content: '';
        position: absolute;
        top: -40px;
        right: 5%;
        width: 250px;
        height: 250px;
        border: 2px dashed rgba(22, 163, 74, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    .developers-header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
    }

    .developers-title-text h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 36px;
        color: #064e3b;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .developers-title-text p {
        font-size: 16px;
        color: #374151;
        font-weight: 500;
    }

    /* Slider Layout */
    .developers-slider-container {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        z-index: 1;
    }

    .developers-slider-wrapper {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 30px;
    }

    /* Developer Card */
    .developer-card {
        min-width: calc(33.333% - 20px); /* Default 3 items */
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .developer-card:hover {
        transform: translateY(-8px);
    }

    .developer-circle {
        width: 100%;
        max-width: 180px;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background: radial-gradient(circle, #f0fdf4 0%, #bbf7d0 100%);
        padding: 8px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .developer-circle img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
    }

    .developer-card h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        color: #064e3b;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .developer-card .designation {
        font-size: 12px;
        color: #b8860b;
        font-weight: 700;
        text-transform: uppercase;
        display: block;
        margin-bottom: 4px;
    }

    .developer-card .project {
        font-size: 13px;
        color: #6b7280;
        font-style: italic;
    }

    /* Navigation Buttons */
    .dev-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: #064e3b;
        transition: all 0.2s;
    }

    .dev-nav-btn:hover {
        background: #064e3b;
        color: #fff;
    }

    .dev-nav-btn.prev { left: 0px; }
    .dev-nav-btn.next { right: 0px; }

    /* Mobile View - Forced 3 Columns */
    @media (max-width: 768px) {
        .developers-section {
            padding: 20px 10px 0;
            margin: 20px 1.5% 40px;
        }

        .developers-section::after {
            height: 160px;
        }

        .developers-title-text h2 {
            font-size: 26px;
        }

        .developers-slider-wrapper {
            gap: 10px;
        }

        .developer-card {
            min-width: calc(33.333% - 7px); /* 3 items on mobile as requested */
        }

        .developer-circle {
            padding: 4px;
            max-width: 100px;
        }

        .developer-card h3 {
            font-size: 12px;
        }

        .developer-card .designation {
            font-size: 9px;
        }

        .developer-card .project {
            font-size: 10px;
        }

        .dev-nav-btn {
            width: 30px;
            height: 30px;
        }
    }
</style>

<section class="developers-section">
    <div class="developers-header">
        <div class="developers-title-text">
            <h2>Dholera Top Developers</h2>
            <p>Connect with the visionaries of India's Smart City</p>
        </div>
    </div>

    <div class="developers-slider-container">
        <div class="developers-slider-wrapper" id="dev-slider-wrapper">
            <?php
            $devs = [
                ['name' => 'Rajesh Mehta', 'img' => 'dev1.png', 'role' => 'CHIEF ARCHITECT', 'project' => 'Dholera Heights'],
                ['name' => 'Priya Sharma', 'img' => 'dev2.png', 'role' => 'PROJECT DIRECTOR', 'project' => 'Greenfield Res.'],
                ['name' => 'Amit Patel', 'img' => 'dev3.png', 'role' => 'SR. DEVELOPER', 'project' => 'Smart City Villas'],
                // Adding more to demonstrate slider (using existing images for now)
                ['name' => 'Sanjay Singh', 'img' => 'dev1.png', 'role' => 'SITE ENGINEER', 'project' => 'Dholera Phase II'],
                ['name' => 'Anjali Gupta', 'img' => 'dev2.png', 'role' => 'PLANNING HEAD', 'project' => 'Metro Residency'],
                ['name' => 'Vikram Rao', 'img' => 'dev3.png', 'role' => 'LEAD DESIGNER', 'project' => 'Smart Hub'],
            ];

            foreach ($devs as $dev) {
                ?>
                <div class="developer-card">
                    <div class="developer-circle">
                        <img src="<?php echo BASE_URL; ?>assets/images/developers/<?php echo $dev['img']; ?>" alt="<?php echo $dev['name']; ?>" loading="lazy">
                    </div>
                    <span class="designation"><?php echo $dev['role']; ?></span>
                    <h3><?php echo $dev['name']; ?></h3>
                    <p class="project"><?php echo $dev['project']; ?></p>
                </div>
                <?php
            }
            ?>
        </div>

        <button class="dev-nav-btn prev" id="dev-prev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="dev-nav-btn next" id="dev-next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>

<script>
    const devWrapper = document.getElementById('dev-slider-wrapper');
    const devPrev = document.getElementById('dev-prev');
    const devNext = document.getElementById('dev-next');
    
    let devIndex = 0;

    function getVisibleDevItems() {
        if (window.innerWidth <= 768) return 3; // FORCED 3 ON MOBILE
        if (window.innerWidth <= 1024) return 3;
        return 3; // Keep 3 for developers as requested
    }

    function updateDevSlider() {
        const items = devWrapper.querySelectorAll('.developer-card');
        if (items.length === 0) return;
        
        const gap = parseInt(window.getComputedStyle(devWrapper).gap) || 30;
        const itemWidth = items[0].offsetWidth + gap;
        devWrapper.style.transform = `translateX(-${devIndex * itemWidth}px)`;
    }

    devNext.addEventListener('click', () => {
        const visible = getVisibleDevItems();
        const total = devWrapper.querySelectorAll('.developer-card').length;
        if (devIndex < total - visible) {
            devIndex++;
        } else {
            devIndex = 0;
        }
        updateDevSlider();
    });

    devPrev.addEventListener('click', () => {
        if (devIndex > 0) {
            devIndex--;
        } else {
            const visible = getVisibleDevItems();
            const total = devWrapper.querySelectorAll('.developer-card').length;
            devIndex = total - visible;
        }
        updateDevSlider();
    });

    let devAutoSlide = setInterval(() => {
        devNext.click();
    }, 4000);

    devWrapper.addEventListener('mouseenter', () => clearInterval(devAutoSlide));
    devWrapper.addEventListener('mouseleave', () => {
        devAutoSlide = setInterval(() => {
            devNext.click();
        }, 4000);
    });

    window.addEventListener('resize', () => {
        devIndex = 0; // Reset index on resize to prevent layout breaking
        updateDevSlider();
    });
</script>
