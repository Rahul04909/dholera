<?php
// Highlights Component
?>
<style>
    .highlights-section {
        display: flex;
        background-color: var(--primary-gold, #b8860b);
        min-height: 500px;
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
    }

    .highlights-content {
        flex: 1;
        padding: 60px 40px;
        position: relative;
        background-image: radial-gradient(rgba(0,0,0,0.1) 2px, transparent 2px);
        background-size: 30px 30px; /* Dotted texture */
    }

    .highlights-header {
        margin-bottom: 40px;
    }

    .highlights-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .highlights-header h2::after {
        content: "";
        height: 2px;
        width: 150px;
        background: rgba(255,255,255,0.6);
    }

    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 800px;
    }

    .highlight-card {
        background: #fff;
        padding: 20px 25px;
        position: relative;
        border-radius: 4px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        min-height: 100px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .highlight-card:hover {
        transform: translateY(-5px);
    }

    /* Asymmetric cut/style for the cards as seen in image */
    .highlight-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        background: #e0e0e0;
        clip-path: polygon(100% 0, 100% 100%, 0 100%);
        opacity: 0.5;
    }

    .highlight-text {
        font-size: 15px;
        font-weight: 500;
        color: #333;
        line-height: 1.4;
        z-index: 1;
    }

    .highlight-number {
        position: absolute;
        bottom: 5px;
        right: 8px;
        font-size: 20px;
        font-weight: 800;
        color: rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    .highlights-image-side {
        flex: 1;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') no-repeat center center;
        background-size: cover;
        min-height: 400px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .highlights-content {
            padding: 40px 20px;
        }
        .highlights-header h2 {
            font-size: 28px;
        }
    }

    @media (max-width: 992px) {
        .highlights-section {
            flex-direction: column;
        }
        .highlights-image-side {
            order: 2;
            height: 400px;
        }
        .highlights-content {
            order: 1;
        }
    }

    @media (max-width: 600px) {
        .highlights-grid {
            grid-template-columns: 1fr;
        }
        .highlights-header h2::after {
            width: 80px;
        }
        .highlight-card {
            padding: 15px 20px;
        }
    }
</style>

<section class="highlights-section">
    <!-- Left Side: Content -->
    <div class="highlights-content">
        <div class="highlights-header">
            <h2>Highlights</h2>
        </div>

        <div class="highlights-grid">
            <!-- 1 -->
            <div class="highlight-card">
                <div class="highlight-text">World-class infrastructure & connectivity: within & outside.</div>
                <div class="highlight-number">1</div>
            </div>
            <!-- 2 -->
            <div class="highlight-card">
                <div class="highlight-text">Airport & Sea Port in the vicinity.</div>
                <div class="highlight-number">2</div>
            </div>
            <!-- 3 -->
            <div class="highlight-card">
                <div class="highlight-text">Benefit of the sea coast, nature park, and golf course.</div>
                <div class="highlight-number">3</div>
            </div>
            <!-- 4 -->
            <div class="highlight-card">
                <div class="highlight-text">Premium civic amenities.</div>
                <div class="highlight-number">4</div>
            </div>
            <!-- 5 -->
            <div class="highlight-card">
                <div class="highlight-text">Capable to cater to both the International & Domestic Markets.</div>
                <div class="highlight-number">5</div>
            </div>
            <!-- 6 -->
            <div class="highlight-card">
                <div class="highlight-text">Close to Gujarat International Finance TechCity (GIFT).</div>
                <div class="highlight-number">6</div>
            </div>
            <!-- 7 -->
            <div class="highlight-card">
                <div class="highlight-text">Logistic support of the Dedicated Freight Corridor (DMIC).</div>
                <div class="highlight-number">7</div>
            </div>
            <!-- 8 -->
            <div class="highlight-card">
                <div class="highlight-text">Public investment in core infrastructure.</div>
                <div class="highlight-number">8</div>
            </div>
        </div>
    </div>

    <!-- Right Side: Decorative Image -->
    <div class="highlights-image-side"></div>
</section>
