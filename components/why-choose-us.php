<style>
    :root {
        --primary-gold-v4: #b8860b;
        --dark-bg-v4: #111;
        --text-dark-v4: #1a202c;
        --text-muted-v4: #718096;
        --bg-white: #fff;
    }

    .why-us-v4 {
        padding: 120px 0;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .container-v4 {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 25px;
    }

    .why-us-row {
        display: flex;
        align-items: center;
        gap: 60px;
        margin-bottom: 80px;
    }

    .why-us-text {
        flex: 1;
    }

    .why-us-image {
        flex: 1;
        position: relative;
    }

    .badge-v4 {
        background: rgba(184, 134, 11, 0.1);
        color: var(--primary-gold-v4);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 25px;
    }

    .why-us-text h2 {
        font-size: 45px;
        font-weight: 850;
        color: var(--text-dark-v4);
        margin-bottom: 30px;
        line-height: 1.1;
    }

    .primary-para {
        font-size: 18px;
        line-height: 1.8;
        color: var(--text-muted-v4);
        margin-bottom: 40px;
        text-align: justify;
    }

    .feature-list-v4 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .feature-item-v4 {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .feature-item-v4 .icon-v4 {
        width: 45px;
        height: 45px;
        background: #fdfaf0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-gold-v4);
        font-size: 18px;
        flex-shrink: 0;
    }

    .feature-item-v4 h4 {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text-dark-v4);
    }

    .feature-item-v4 p {
        font-size: 14px;
        color: var(--text-muted-v4);
        line-height: 1.5;
    }

    .img-wrapper-v4 {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(0,0,0,0.1);
        transform: perspective(1000px) rotateY(-5deg);
        transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .img-wrapper-v4:hover {
        transform: perspective(1000px) rotateY(0deg);
    }

    .img-wrapper-v4 img {
        width: 100%;
        display: block;
    }

    .floating-stats {
        position: absolute;
        bottom: -30px;
        left: -30px;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        z-index: 10;
        border: 1px solid #f0f0f0;
    }

    .floating-stats h5 {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary-gold-v4);
        margin: 0;
    }

    .floating-stats span {
        font-size: 14px;
        color: var(--text-muted-v4);
    }

    /* Lower Points Section */
    .lower-points-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        border-top: 1px solid #f3f3f3;
        padding-top: 60px;
    }

    .point-card-v4 {
        padding: 35px;
        background: #fdfaf0;
        border-radius: 20px;
        text-align: left;
        transition: 0.3s;
    }

    .point-card-v4:hover {
        background: var(--primary-gold-v4);
        transform: translateY(-10px);
    }

    .point-card-v4:hover * {
        color: #fff !important;
    }

    .point-card-v4 i {
        font-size: 28px;
        color: var(--primary-gold-v4);
        margin-bottom: 20px;
        display: block;
    }

    .point-card-v4 h5 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    @media (max-width: 1024px) {
        .why-us-row { flex-direction: column; text-align: center; }
        .primary-para { text-align: center; }
        .feature-list-v4 { text-align: left; }
        .img-wrapper-v4 { transform: none !important; margin-top: 50px; }
        .floating-stats { position: static; margin-top: 20px; display: inline-block; }
    }

    @media (max-width: 768px) {
        .lower-points-grid { grid-template-columns: 1fr; }
        .why-us-text h2 { font-size: 32px; }
        .primary-para { font-size: 16px; }
        .why-us-v4 { padding: 80px 0; }
    }
</style>

<section id="why-choose-us-detailed" class="why-us-v4">
    <div class="container-v4">
        <div class="why-us-row">
            <!-- Left Side: Paragraph & Content -->
            <div class="why-us-text">
                <span class="badge-v4">Trusted Partner</span>
                <h2>Why Leading Real Estate Agents Choose Our Marketing Ecosystem</h2>
                
                <p class="primary-para">
                    In the rapidly evolving landscape of Dholera Smart City, standing out requires more than just standard advertising. We offer a comprehensive Digital Marketing and IT ecosystem specifically engineered for the real estate sector. Our platform leverages cutting-edge AI-driven lead filtering and automated CRM workflows to ensure that your sales team only focuses on high-converting prospects. Whether it's managing property listings or executing multi-channel ad campaigns across Meta and Google, we provide the technical superiority and market-specific intelligence needed to dominate the Dholera property market.
                </p>

                <div class="feature-list-v4">
                    <div class="feature-item-v4">
                        <div class="icon-v4"><i class="fas fa-microchip"></i></div>
                        <div>
                            <h4>Smart IT Infrastructure</h4>
                            <p>Automated API integrations for instant lead tracking.</p>
                        </div>
                    </div>
                    <div class="feature-item-v4">
                        <div class="icon-v4"><i class="fas fa-funnel-dollar"></i></div>
                        <div>
                            <h4>Verified Lead Flow</h4>
                            <p>Proprietary filtering for organic, high-intent leads.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Interactive Image -->
            <div class="why-us-image">
                <div class="img-wrapper-v4">
                    <img src="<?php echo BASE_URL; ?>assets/images/why-choose-us.png" alt="Dholera Smart City Digital Marketing Dashboard">
                </div>
                <div class="floating-stats">
                    <h5>98%</h5>
                    <span>Customer ROI Success</span>
                </div>
            </div>
        </div>

        <!-- Lower Grid: Core pillars -->
        <div class="lower-points-grid">
            <div class="point-card-v4">
                <i class="fas fa-building"></i>
                <h5>Dholera Property Experts</h5>
                <p>We specialized in residential and commercial plots across all activation areas of Dholera SIR.</p>
            </div>
            <div class="point-card-v4">
                <i class="fas fa-users-cog"></i>
                <h5>Scale Your Team</h5>
                <p>Our automation tools allow your sales team to handle 10x more leads without any manual data entry.</p>
            </div>
            <div class="point-card-v4">
                <i class="fas fa-plane-arrival"></i>
                <h5>Managed Site Visits</h5>
                <p>From pick-up to expert site guidance, we plan the perfect physical tour for your potential investors.</p>
            </div>
        </div>
    </div>
</section>
