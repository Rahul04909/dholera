<?php
// Amenities Component
?>
<style>
    .amenities-section {
        padding: 80px 20px;
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    /* Subtle dotted background pattern like the footer */
    .amenities-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(rgba(0,0,0,0.05) 2px, transparent 2px);
        background-size: 30px 30px;
        pointer-events: none;
    }

    .amenities-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .amenities-header {
        margin-bottom: 50px;
    }

    .amenities-header h2 {
        font-size: 36px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .amenities-header h2::after {
        content: "";
        height: 2px;
        flex-grow: 1;
        background: rgba(255, 255, 255, 0.4);
        max-width: 300px;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    .amenity-card {
        background-color: #fff;
        border-radius: 8px; /* Subtle rounding for a modern look */
        overflow: hidden;
        position: relative;
        aspect-ratio: 4 / 3;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .amenity-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.25);
    }

    .amenity-img {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.6s ease;
    }

    .amenity-card:hover .amenity-img {
        transform: scale(1.1);
    }

    /* Gradient Overlay */
    .amenity-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.7) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding: 20px;
        transition: background 0.3s ease;
    }

    .amenity-card:hover .amenity-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.85) 100%);
    }

    .amenity-info {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
    }

    .amenity-info i {
        font-size: 24px;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
    }

    .amenity-info span {
        font-size: 18px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* Responsive Breakpoints */
    @media (max-width: 1200px) {
        .amenities-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .amenities-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .amenities-header h2 {
            font-size: 28px;
        }
    }

    @media (max-width: 576px) {
        .amenities-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 columns for mobile as requested */
            gap: 15px;
        }
        .amenities-section {
            padding: 50px 10px;
        }
        .amenity-card {
            aspect-ratio: 1 / 1; /* Square cards look better in 2-column layout */
        }
        .amenity-info span {
            font-size: 14px;
        }
        .amenity-info i {
            font-size: 18px;
        }
    }
</style>

<section class="amenities-section" id="amenities">
    <div class="amenities-container">
        <div class="amenities-header">
            <h2>Amenities</h2>
        </div>

        <div class="amenities-grid">
            <!-- Car Parking -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1506521781263-d8422e8ecf27?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-parking"></i>
                        <span>Car Parking</span>
                    </div>
                </div>
            </div>

            <!-- Power Backup -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1544724569-5f546fd6f2b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-bolt"></i>
                        <span>Power Backup</span>
                    </div>
                </div>
            </div>

            <!-- 24*7 Security -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-shield-alt"></i>
                        <span>24*7 Security</span>
                    </div>
                </div>
            </div>

            <!-- Kids Play Area -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1472162014302-7235d7f98e95?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-child"></i>
                        <span>Kids Play Area</span>
                    </div>
                </div>
            </div>

            <!-- CCTV Cameras -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1557597774-9d273605dfa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-video"></i>
                        <span>CCTV Cameras</span>
                    </div>
                </div>
            </div>

            <!-- 24*7 Water Supply -->
            <div class="amenity-card">
                <div class="amenity-img" style="background-image: url('https://images.unsplash.com/photo-1520038410233-7141ec7ae74d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="amenity-overlay">
                    <div class="amenity-info">
                        <i class="fas fa-faucet"></i>
                        <span>24*7 Water Supply</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
