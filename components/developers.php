<?php
/**
 * Dholera Developers Component - Optimized & Side-by-Side Layout
 * Fixed 3-column layout for mobile as requested.
 */
?>

<style>
    .developers-section {
        padding: 80px 0;
        background-color: #fff;
        overflow: hidden;
    }

    .developers-container {
        display: flex;
        align-items: center;
        gap: 40px;
        background: #f0fdfa;
        border-radius: 40px;
        padding: 50px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    }

    .developers-text {
        flex: 0 0 30%;
        text-align: left;
        z-index: 2;
    }

    .developers-text h2 {
        font-size: 42px;
        color: #1e3a8a;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .developers-text p {
        font-size: 17px;
        color: #4b5563;
        line-height: 1.6;
        opacity: 0.9;
    }

    .developers-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        z-index: 2;
    }

    .developer-card {
        text-align: center;
        background: transparent;
        padding: 10px;
        border-radius: 20px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .developer-card:hover {
        transform: translateY(-10px) scale(1.05);
    }

    .developer-image-wrapper {
        width: 160px;
        height: 160px;
        margin: 0 auto 20px;
        position: relative;
        border-radius: 50%;
        padding: 6px;
        background: #fff;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .developer-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    .developer-info h3 {
        font-size: 20px;
        color: #1e3a8a;
        margin-bottom: 4px;
        font-weight: 700;
    }

    .developer-info .designation {
        font-size: 12px;
        color: #d97706;
        font-weight: 800;
        text-transform: uppercase;
        display: block;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .developer-info .project-name {
        font-size: 14px;
        color: #6b7280;
        font-style: italic;
        line-height: 1.4;
    }

    /* Decorative Background Elements */
    .developers-container::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border: 1px dashed rgba(30, 58, 138, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -50px;
        z-index: 1;
    }

    /* MOBILE RESPONSIVE: Fixed 3 Columns */
    @media (max-width: 992px) {
        .developers-text {
            flex: 0 0 35%;
        }
        .developers-text h2 {
            font-size: 32px;
        }
    }

    @media (max-width: 768px) {
        .developers-container {
            flex-direction: column;
            padding: 40px 20px;
            border-radius: 30px;
            gap: 30px;
        }

        .developers-text {
            flex: none;
            width: 100%;
            text-align: center;
        }

        .developers-text h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .developers-text p {
            font-size: 15px;
        }

        .developers-grid {
            width: 100%;
            grid-template-columns: repeat(3, 1fr); /* 3 COLUMNS ON MOBILE */
            gap: 12px;
        }

        .developer-image-wrapper {
            width: 100px; /* Reduced for 3-col mobile */
            height: 100px;
            padding: 4px;
            margin-bottom: 12px;
        }

        .developer-info h3 {
            font-size: 14px;
            line-height: 1.2;
        }

        .developer-info .designation {
            font-size: 9px;
            margin-bottom: 2px;
        }

        .developer-info .project-name {
            font-size: 10px;
        }
    }

    @media (max-width: 480px) {
        .developers-container {
            padding: 30px 10px;
        }
        .developer-image-wrapper {
            width: 85px;
            height: 85px;
        }
        .developer-info h3 {
            font-size: 12px;
        }
        .developer-grid {
            gap: 8px;
        }
    }
</style>

<section class="developers-section">
    <div class="container">
        <div class="developers-container">
            <div class="developers-text">
                <h2>Dholera Top Developers</h2>
                <p>Connect with the visionaries shaping the future of India's first smart city</p>
            </div>

            <div class="developers-grid">
                <!-- Developer 1 -->
                <div class="developer-card">
                    <div class="developer-image-wrapper">
                        <img src="<?php echo BASE_URL; ?>assets/images/developers/dev1.png" alt="Rajesh Mehta" loading="lazy">
                    </div>
                    <div class="developer-info">
                        <h3>Rajesh Mehta</h3>
                        <span class="designation">CHIEF ARCHITECT</span>
                        <p class="project-name">Dholera Heights</p>
                    </div>
                </div>

                <!-- Developer 2 -->
                <div class="developer-card">
                    <div class="developer-image-wrapper">
                        <img src="<?php echo BASE_URL; ?>assets/images/developers/dev2.png" alt="Priya Sharma" loading="lazy">
                    </div>
                    <div class="developer-info">
                        <h3>Priya Sharma</h3>
                        <span class="designation">PROJECT DIRECTOR</span>
                        <p class="project-name">Greenfield Res.</p>
                    </div>
                </div>

                <!-- Developer 3 -->
                <div class="developer-card">
                    <div class="developer-image-wrapper">
                        <img src="<?php echo BASE_URL; ?>assets/images/developers/dev3.png" alt="Amit Patel" loading="lazy">
                    </div>
                    <div class="developer-info">
                        <h3>Amit Patel</h3>
                        <span class="designation">SR. DEVELOPER</span>
                        <p class="project-name">Smart City Villas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
