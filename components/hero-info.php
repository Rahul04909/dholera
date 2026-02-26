<?php
// Hero Info Bar Component
?>
<style>
    .hero-info-bar {
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
        font-family: 'Outfit', sans-serif;
        padding: 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        position: relative;
        z-index: 10;
        margin-top: -5px; /* Slight overlap with hero if needed, but safe at 0 */
    }

    .hero-info-container {
        max-width: 1300px;
        margin: 0 auto;
        display: flex;
        align-items: stretch;
    }

    .info-items-wrapper {
        display: flex;
        flex: 1;
        justify-content: space-around;
        padding: 20px 10px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0 15px;
    }

    .info-icon-circle {
        width: 45px;
        height: 45px;
        border: 1px solid rgba(255,255,255,0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .info-text {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 13px;
        font-weight: 300;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
        line-height: 1.2;
    }

    /* Download Brochure Button */
    .brochure-btn-wrapper {
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        padding: 0 40px;
        text-decoration: none;
        color: #fff;
        transition: background 0.3s ease;
        cursor: pointer;
    }

    .brochure-btn-wrapper:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .brochure-icon {
        font-size: 32px;
        margin-right: 15px;
        opacity: 0.9;
    }

    .brochure-text {
        font-size: 20px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Responsive Styles */
    @media (max-width: 1100px) {
        .brochure-text {
            font-size: 16px;
        }
        .info-value {
            font-size: 16px;
        }
        .brochure-btn-wrapper {
            padding: 0 25px;
        }
    }

    @media (max-width: 900px) {
        .hero-info-container {
            flex-direction: column;
        }
        
        .info-items-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 30px 20px;
        }

        .info-item {
            justify-content: flex-start;
        }

        .brochure-btn-wrapper {
            padding: 25px;
            justify-content: center;
            background: rgba(0, 0, 0, 0.1);
        }
    }

    @media (max-width: 480px) {
        .info-items-wrapper {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 20px 10px;
        }
        .info-icon-circle {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
        .info-label {
            font-size: 11px;
        }
        .info-value {
            font-size: 14px;
        }
        .brochure-text {
            font-size: 18px;
        }
    }
</style>

<div class="hero-info-bar">
    <div class="hero-info-container">
        <!-- Info Stats -->
        <div class="info-items-wrapper">
            <!-- Land Parcel -->
            <div class="info-item">
                <div class="info-icon-circle">
                    <i class="fas fa-home"></i>
                </div>
                <div class="info-text">
                    <span class="info-label">Land Parcel</span>
                    <span class="info-value">130 Sq.Yd.</span>
                </div>
            </div>

            <!-- Type -->
            <div class="info-item">
                <div class="info-icon-circle">
                    <i class="fas fa-th-large"></i>
                </div>
                <div class="info-text">
                    <span class="info-label">Type</span>
                    <span class="info-value">Plots</span>
                </div>
            </div>

            <!-- Amenities -->
            <div class="info-item">
                <div class="info-icon-circle">
                    <i class="fas fa-road"></i>
                </div>
                <div class="info-text">
                    <span class="info-label">Amenities</span>
                    <span class="info-value">Infrastructure &<br>Connectivity</span>
                </div>
            </div>

            <!-- Price -->
            <div class="info-item">
                <div class="info-icon-circle">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="info-text">
                    <span class="info-label">Price</span>
                    <span class="info-value">₹ 12.5 Lacs*</span>
                </div>
            </div>
        </div>

        <!-- Download Brochure Action -->
        <a href="#" class="brochure-btn-wrapper">
            <i class="far fa-map brochure-icon"></i>
            <span class="brochure-text">Download Brochure</span>
        </a>
    </div>
</div>
