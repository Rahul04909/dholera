<?php
/**
 * Dholera Developers Component - Final Premium Version
 * 6 columns on Desktop, 3 columns on Mobile (Forced)
 * Full Autoplay Slider Logic
 */
?>

<style>
    .developers-section {
        padding: 30px 25px 0;
        margin: 40px 2% 60px;
        position: relative;
        overflow: visible;
        z-index: 1;
    }

    /* Stylized Background Overlay */
    .developers-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #a7ffeb 0%, #e0f2f1 100%);
        border-radius: 20px;
        z-index: -1;
    }

    /* Decorative Dashed Lines */
    .developers-section::before {
        content: '';
        position: absolute;
        top: -50px;
        right: 5%;
        width: 250px;
        height: 250px;
        border: 2px dashed rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        z-index: 0;
    }

    .developers-header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
    }

    .developers-title-text h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        color: #1c335a;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .developers-title-text p {
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: #555;
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
        transition: transform 0.5s ease-in-out;
        gap: 30px;
    }

    /* Developer Card */
    .developer-card {
        min-width: calc(16.666% - 25px);
        /* 6 items on desktop */
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .developer-card:hover {
        transform: translateY(-5px);
    }

    .developer-circle {
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background: radial-gradient(circle, #a7ffeb 0%, #e0f2f1 100%);
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .developer-circle img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
    }

    .developer-card h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        color: #1c335a;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .developer-card .designation {
        font-size: 11px;
        color: #b8860b;
        font-weight: 700;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }

    .developer-card p.project {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        color: #777;
    }

    /* Navigation Buttons */
    .dev-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        background: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        color: #1c335a;
    }

    .dev-nav-btn.prev {
        left: 5px;
    }

    .dev-nav-btn.next {
        right: 5px;
    }

    /* Mobile View */
    @media (max-width: 1024px) {
        .developer-card {
            min-width: calc(25% - 22.5px);
        }
    }

    @media (max-width: 768px) {
        .developers-section {
            padding: 20px 15px 0;
            margin: 15px 1.5% 40px;
        }

        .developers-section::after {
            height: 180px;
        }

        .developer-card {
            min-width: calc(33.333% - 20px);
        }

        .developer-circle {
            padding: 5px;
        }

        .developers-title-text h2 {
            font-size: 24px;
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
                ['name' => 'Mr. Rajdipsinh Chudasama', 'img' => 'rajdeepsinh.png', 'role' => 'Managing Director', 'project' => '7oak Dholera'],
                ['name' => 'Mr. Gopal Goswami', 'img' => 'gopal-goswami.webp', 'role' => 'Chairman', 'project' => 'SVNIT'],
                ['name' => 'Mr. Ambrish Parajiya', 'img' => 'ambrish-parajiya.webp', 'role' => 'Managing Director', 'project' => 'GAP Group Dholera'],
                ['name' => 'Sanjay Singh', 'img' => 'dev1.png', 'role' => 'Engineer', 'project' => 'Dholera Phase II'],
                ['name' => 'Anjali Gupta', 'img' => 'dev2.png', 'role' => 'Planning', 'project' => 'Metro Residency'],
                ['name' => 'Vikram Rao', 'img' => 'dev3.png', 'role' => 'Designer', 'project' => 'Smart Hub'],
                ['name' => 'Nisha Verma', 'img' => 'dev2.png', 'role' => 'Consultant', 'project' => 'Elite Plaza'],
                ['name' => 'Karan Johar', 'img' => 'dev1.png', 'role' => 'Manager', 'project' => 'Kings Landing'],
                ['name' => 'Meera Bai', 'img' => 'dev2.png', 'role' => 'Lead', 'project' => 'Lotus Garden'],
                ['name' => 'Rahul Bose', 'img' => 'dev3.png', 'role' => 'Specialist', 'project' => 'Dholera Central'],
            ];

            foreach ($devs as $dev) {
                ?>
                <div class="developer-card">
                    <div class="developer-circle">
                        <img src="<?php echo BASE_URL; ?>assets/images/developers/<?php echo $dev['img']; ?>"
                            alt="<?php echo $dev['name']; ?>" loading="lazy">
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
    (function () {
        const devWrapper = document.getElementById('dev-slider-wrapper');
        const devPrev = document.getElementById('dev-prev');
        const devNext = document.getElementById('dev-next');

        let devIndex = 0;

        function getVisibleDevItems() {
            if (window.innerWidth <= 768) return 3;
            if (window.innerWidth <= 1024) return 4;
            return 6;
        }

        function updateDevSlider() {
            const items = devWrapper.querySelectorAll('.developer-card');
            if (items.length === 0) return;

            const gap = 30;
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
        }, 3500);

        devWrapper.addEventListener('mouseenter', () => clearInterval(devAutoSlide));
        devWrapper.addEventListener('mouseleave', () => {
            devAutoSlide = setInterval(() => {
                devNext.click();
            }, 3500);
        });

        window.addEventListener('resize', () => {
            devIndex = 0;
            updateDevSlider();
        });

        setTimeout(updateDevSlider, 100);
    })();
</script>