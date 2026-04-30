<?php
/**
 * Dholera Developers Component
 * Premium 3-column responsive layout
 */
?>

<style>
    .developers-section {
        padding: 80px 0;
        background-color: #fff;
        overflow: hidden;
    }

    .developers-banner {
        background: linear-gradient(135deg, #e0f7f3 0%, #ffffff 100%);
        border-radius: 30px;
        padding: 60px 20px 120px;
        text-align: center;
        position: relative;
        margin-bottom: -100px; /* Offset for floating cards */
    }

    .developers-banner h2 {
        font-size: 36px;
        color: #1a365d;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .developers-banner p {
        font-size: 18px;
        color: #4a5568;
        max-width: 600px;
        margin: 0 auto;
    }

    .developers-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        position: relative;
        z-index: 10;
        margin-top: 40px;
    }

    .developer-card {
        text-align: center;
        transition: transform 0.3s ease;
    }

    .developer-card:hover {
        transform: translateY(-10px);
    }

    .developer-image-wrapper {
        width: 220px;
        height: 220px;
        margin: 0 auto 20px;
        position: relative;
        border-radius: 50%;
        padding: 10px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 2px solid #e0f7f3;
    }

    .developer-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
    }

    .developer-info h3 {
        font-size: 22px;
        color: #1a365d;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .developer-info .designation {
        font-size: 14px;
        color: #b8860b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: block;
    }

    .developer-info .project-name {
        font-size: 16px;
        color: #718096;
        font-style: italic;
    }

    /* Decorative Circle */
    .developers-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border: 1px dashed rgba(0,0,0,0.1);
        border-radius: 50%;
        z-index: 0;
    }

    /* Mobile Responsiveness */
    @media (max-width: 992px) {
        .developers-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .developers-banner {
            padding: 40px 15px 100px;
            margin-bottom: -80px;
        }
        .developers-banner h2 {
            font-size: 28px;
        }
        .developers-grid {
            grid-template-columns: 1fr;
            gap: 50px;
        }
        .developer-image-wrapper {
            width: 180px;
            height: 180px;
        }
    }
</style>

<section class="developers-section">
    <div class="container">
        <div class="developers-banner">
            <h2>Dholera Top Developers</h2>
            <p>Connect with the visionaries shaping the future of India's first smart city</p>
        </div>

        <div class="developers-grid">
            <!-- Developer 1 -->
            <div class="developer-card">
                <div class="developer-image-wrapper">
                    <img src="<?php echo BASE_URL; ?>assets/images/developers/dev1.png" alt="Rajesh Mehta">
                </div>
                <div class="developer-info">
                    <h3>Rajesh Mehta</h3>
                    <span class="designation">Chief Architect</span>
                    <p class="project-name">Dholera Heights Phase I</p>
                </div>
            </div>

            <!-- Developer 2 -->
            <div class="developer-card">
                <div class="developer-image-wrapper">
                    <img src="<?php echo BASE_URL; ?>assets/images/developers/dev2.png" alt="Priya Sharma">
                </div>
                <div class="developer-info">
                    <h3>Priya Sharma</h3>
                    <span class="designation">Project Director</span>
                    <p class="project-name">Greenfield Residency</p>
                </div>
            </div>

            <!-- Developer 3 -->
            <div class="developer-card">
                <div class="developer-image-wrapper">
                    <img src="<?php echo BASE_URL; ?>assets/images/developers/dev3.png" alt="Amit Patel">
                </div>
                <div class="developer-info">
                    <h3>Amit Patel</h3>
                    <span class="designation">Senior Developer</span>
                    <p class="project-name">Smart City Villas</p>
                </div>
            </div>
        </div>
    </div>
</section>
