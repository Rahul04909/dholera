<?php
// Location Advantage Component
?>
<style>
    .location-section {
        display: flex;
        background-color: var(--primary-gold, #b8860b);
        min-height: 500px;
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
    }

    .location-content {
        flex: 1;
        padding: 60px 40px;
        position: relative;
        background-image: radial-gradient(rgba(0,0,0,0.1) 2px, transparent 2px);
        background-size: 30px 30px; /* Dotted texture */
    }

    .location-header {
        margin-bottom: 40px;
    }

    .location-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .location-header h2::after {
        content: "";
        height: 2px;
        width: 150px;
        background: rgba(255,255,255,0.6);
    }

    .location-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 800px;
    }

    .location-card {
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

    .location-card:hover {
        transform: translateY(-5px);
    }

    /* Asymmetric cut/style for the cards */
    .location-card::after {
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

    .location-card-text {
        font-size: 15px;
        font-weight: 500;
        color: #333;
        line-height: 1.4;
        z-index: 1;
    }

    .location-card-number {
        position: absolute;
        bottom: 5px;
        right: 8px;
        font-size: 20px;
        font-weight: 800;
        color: rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    .location-map-side {
        flex: 1;
        background-color: #eee;
        min-height: 450px;
        overflow: hidden;
    }

    .location-map-side iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .location-content {
            padding: 40px 20px;
        }
        .location-header h2 {
            font-size: 28px;
        }
    }

    @media (max-width: 992px) {
        .location-section {
            flex-direction: column;
        }
        .location-map-side {
            order: 2;
            height: 400px;
        }
        .location-content {
            order: 1;
        }
    }

    @media (max-width: 600px) {
        .location-grid {
            grid-template-columns: 1fr;
        }
        .location-header h2::after {
            width: 80px;
        }
        .location-card {
            padding: 15px 20px;
        }
    }
</style>

<section class="location-section" id="location">
    <!-- Left Side: Advantages -->
    <div class="location-content">
        <div class="location-header">
            <h2>Location Advantage</h2>
        </div>

        <div class="location-grid">
            <!-- 1 -->
            <div class="location-card">
                <div class="location-card-text">Close to Petrochemicals and Petroleum Inv. Region (PCPIR).</div>
                <div class="location-card-number">1</div>
            </div>
            <!-- 2 -->
            <div class="location-card">
                <div class="location-card-text">Close to Gujarat International Finance TechCity (GIFT).</div>
                <div class="location-card-number">2</div>
            </div>
            <!-- 3 -->
            <div class="location-card">
                <div class="location-card-text">Proximity to mega cities: Ahmedabad, Bhavnagar, Vadodara.</div>
                <div class="location-card-number">3</div>
            </div>
            <!-- 4 -->
            <div class="location-card">
                <div class="location-card-text">Airport & Sea Port in the vicinity.</div>
                <div class="location-card-number">4</div>
            </div>
            <!-- 5 -->
            <div class="location-card">
                <div class="location-card-text">Central spine express way & Metro Rail to link the SIR with megacities.</div>
                <div class="location-card-number">5</div>
            </div>
            <!-- 6 -->
            <div class="location-card">
                <div class="location-card-text">Benefit of the sea coast, nature park, and golf course.</div>
                <div class="location-card-number">6</div>
            </div>
        </div>
    </div>

    <!-- Right Side: Google Map -->
    <div class="location-map-side">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14777.291772645857!2d72.184762140608!3d22.246419513364235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395efdf979069631%3A0xcb161c569d300067!2sDholera%2C%20Gujarat%20382455!5e0!3m2!1sen!2sin!4v1709121600000!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
