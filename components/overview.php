<?php
// Overview Component
?>
<style>
    .overview-section {
        padding: 80px 20px;
        background: #fff url('/assets/overview-background-image.webp') no-repeat center center;
        background-size: cover;
        position: relative;
        overflow: hidden;
        font-family: 'Outfit', sans-serif;
    }

    /* Blueprint/Technical Overlay Effect */
    .overview-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.92); /* Soft white overlay to keep text readable */
        z-index: 0;
    }

    /* Blueprint image overlays as seen in the sample */
    .blueprint-overlay {
        position: absolute;
        width: 300px;
        opacity: 0.1;
        z-index: 1;
        pointer-events: none;
    }

    .blueprint-left {
        top: 50px;
        left: -50px;
        transform: rotate(-15deg);
    }

    .blueprint-right {
        bottom: -50px;
        right: -50px;
        transform: rotate(15deg);
    }

    .overview-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 50px;
        position: relative;
        z-index: 2;
    }

    .overview-content {
        flex: 1;
    }

    .overview-header {
        margin-bottom: 30px;
    }

    .overview-header h2 {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary-gold, #b8860b);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .overview-header h2::after {
        content: "";
        height: 2px;
        width: 100px;
        background: var(--primary-gold, #b8860b);
    }

    .overview-subtitle {
        font-size: 22px;
        font-weight: 700;
        color: #1a4a7c; /* Blueish tone from the image */
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .overview-text {
        font-size: 15px;
        line-height: 1.6;
        color: #444;
        margin-bottom: 30px;
        text-align: justify;
    }

    .overview-text p {
        margin-bottom: 15px;
    }

    .btn-brochure {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
        padding: 12px 25px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-brochure:hover {
        background-color: #966d09;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .overview-image-wrapper {
        flex: 1;
        position: relative;
        padding: 15px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 4px;
    }

    .overview-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 2px;
    }

    /* Decorative border for the image wrapper */
    .overview-image-wrapper::before {
        content: "";
        position: absolute;
        top: -10px;
        right: -10px;
        width: 100px;
        height: 100px;
        border-top: 5px solid var(--primary-gold, #b8860b);
        border-right: 5px solid var(--primary-gold, #b8860b);
        z-index: -1;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .overview-container {
            flex-direction: column;
            text-align: center;
            gap: 40px;
        }

        .overview-header h2 {
            justify-content: center;
        }

        .overview-header h2::after {
            display: none;
        }

        .overview-image-wrapper {
            max-width: 500px;
            margin: 0 auto;
        }
    }

    @media (max-width: 600px) {
        .overview-section {
            padding: 60px 15px;
        }
        .overview-header h2 {
            font-size: 26px;
        }
        .overview-subtitle {
            font-size: 18px;
        }
        .overview-text {
            font-size: 14px;
            text-align: left;
        }
    }
</style>

<section class="overview-section" id="overview">
    <!-- Blueprint decorative images (Assumed existing or illustrative tags) -->
    <img src="assets/overview.webp" class="blueprint-overlay blueprint-left" alt="">
    <img src="assets/overview.webp" class="blueprint-overlay blueprint-right" alt="">

    <div class="overview-container">
        <!-- Left Content -->
        <div class="overview-content">
            <div class="overview-header">
                <h2>Overview</h2>
            </div>
            
            <h3 class="overview-subtitle">India's First Greenfield Smart City</h3>
            
            <div class="overview-text">
                <p>
                    Dholera Special Investment Regions (SIR) is a Greenfield Industrial City, planned developed and managed by a SPV named Dholera Industrial City Development Limited (DICDL), incorporated between the Government of India represented by NICDIT and the State Government represented by Dholera Special Investment Region Development Authority (DSIRDA). The greenfield city is planned to be developed over 920 sq.km. with access to other proximate major cities like Ahmedabad, Rajkot, Baroda. The city is envisioned as a self-sustaining integrated ecosystem of urban and industrial economy. Being located in Gujarat, Dholera SIR has inherent advantages for industrial development.
                </p>
                <p>
                    DSIR, under Town Planning Schemes 1 to 6 covers an area of 422 sq. km. Initially an area of 22.54 sq. km is being developed as activation zone for industrial & residential uses. The city plan includes mixed, recreational, tourism, knowledge & IT, city center and logistics land use that will chart the economic road map of Dholera.
                </p>
            </div>

            <a href="#" class="btn-brochure">Download Brochure <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Right Image -->
        <div class="overview-image-wrapper">
            <img src="assets/overview.webp" alt="Dholera Smart City Overview" class="overview-image">
        </div>
    </div>
</section>
