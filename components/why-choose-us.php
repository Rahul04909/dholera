<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #111;
        --card-bg: #fff;
        --text-dark: #1a202c;
        --text-muted: #718096;
        --soft-gray: #f7fafc;
    }

    .why-choose-section {
        padding: 100px 20px;
        background-color: var(--soft-gray);
        overflow: hidden;
    }

    .why-choose-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    .section-header-centered {
        text-align: center;
        margin-bottom: 70px;
    }

    .section-header-centered .badge-text {
        display: inline-block;
        background: rgba(184, 134, 11, 0.1);
        color: var(--primary-gold);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .section-header-centered h2 {
        font-size: 44px;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .section-header-centered p {
        font-size: 18px;
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .why-choose-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .choose-card {
        background: var(--card-bg);
        padding: 50px 40px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 1;
        text-align: left;
    }

    .choose-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(184, 134, 11, 0.1), rgba(184, 134, 11, 0));
        border-radius: 20px;
        opacity: 0;
        transition: 0.4s ease;
        z-index: -1;
    }

    .choose-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 35px 70px rgba(184, 134, 11, 0.08);
        border-color: var(--primary-gold);
    }

    .choose-card:hover::before {
        opacity: 1;
    }

    .icon-box-v3 {
        width: 70px;
        height: 70px;
        background: var(--soft-gray);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: var(--primary-gold);
        margin-bottom: 30px;
        transition: 0.4s ease;
    }

    .choose-card:hover .icon-box-v3 {
        background: var(--primary-gold);
        color: #fff;
        transform: rotateY(360deg);
    }

    .choose-card h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .choose-card p {
        font-size: 15px;
        color: var(--text-muted);
        line-height: 1.7;
    }

    .visit-cta-bar {
        margin-top: 80px;
        background: var(--dark-bg);
        border-radius: 25px;
        padding: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .visit-cta-bar::after {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(184, 134, 11, 0.15);
        filter: blur(50px);
        border-radius: 50%;
    }

    .visit-content h4 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 10px;
        color: var(--primary-gold);
    }

    .visit-content p {
        font-size: 17px;
        color: #a0aec0;
        max-width: 500px;
    }

    .btn-gold-visit {
        background: var(--primary-gold);
        color: #fff;
        padding: 18px 45px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 18px;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(184, 134, 11, 0.3);
    }

    .btn-gold-visit:hover {
        background: #966d09;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(184, 134, 11, 0.5);
    }

    @media (max-width: 1024px) {
        .why-choose-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .why-choose-section { padding: 60px 20px; }
        .section-header-centered h2 { font-size: 32px; }
        .why-choose-grid { grid-template-columns: 1fr; }
        .visit-cta-bar { flex-direction: column; text-align: center; gap: 40px; padding: 40px 25px; }
        .visit-content p { margin: 0 auto; }
    }
</style>

<section id="why-choose-us" class="why-choose-section">
    <div class="why-choose-container">
        <div class="section-header-centered">
            <span class="badge-text">Why Choose Us</span>
            <h2>Top Reasons to Partner with Dholera's Growth Experts</h2>
            <p>Our unique blend of Real Estate expertise and Modern IT solutions makes us the undisputed choice for developers, agents, and investors in Dholera Smart City.</p>
        </div>

        <div class="why-choose-grid">
            <!-- 1. Dholera Expertise -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-city"></i>
                </div>
                <h3>Dholera Specialist</h3>
                <p>We hyper-focus on Dholera Smart City projects, offering insider knowledge that generalized agencies simply don't have.</p>
            </div>

            <!-- 2. Verified Leads -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Targeted Lead Gen</h3>
                <p>Stop wasting money on junk leads. Our data-driven digital marketing ensures you get only high-intent, verified organic leads.</p>
            </div>

            <!-- 3. IT & CRM Solutions -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>Advanced IT Services</h3>
                <p>From automated CRM integrations to custom agent portals, we provide the tech infrastructure that scales your business.</p>
            </div>

            <!-- 4. Site Visit Master -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-route"></i>
                </div>
                <h3>Seamless Site Visits</h3>
                <p>We don't just generate leads; we help close them. Our planned site visit management ensures a premium experience for every potential buyer.</p>
            </div>

            <!-- 5. Marketing Dominance -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Digital Dominance</h3>
                <p>Leverage our expertise in Meta Ads, Google PPC, and SEO to keep your properties at the top of every investor's search list.</p>
            </div>

            <!-- 6. 24/7 Premium Support -->
            <div class="choose-card">
                <div class="icon-box-v3">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Dedicated Concierge</h3>
                <p>Our account managers work around the clock to provide technical support and marketing optimizations for your specific projects.</p>
            </div>
        </div>

        <!-- Site Visit CTA -->
        <div class="visit-cta-bar">
            <div class="visit-content">
                <h4>Experience Dholera in Person</h4>
                <p>Request a professional site visit plan today and witness the future of India's first smart city with our expert guides.</p>
            </div>
            <a href="contact.php" class="btn-gold-visit">Book A Site Visit <i class="fas fa-calendar-alt" style="margin-left: 10px;"></i></a>
        </div>
    </div>
</section>
