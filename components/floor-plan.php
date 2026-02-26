<?php
// Floor Plan Component
?>
<style>
    .floor-plan-section {
        padding: 80px 20px;
        background-color: #f8fbff;
        font-family: 'Outfit', sans-serif;
    }

    .floor-plan-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .floor-plan-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .sketch-title {
        display: inline-block;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-gold, #b8860b);
        text-transform: uppercase;
        letter-spacing: 2px;
        border-left: 4px solid var(--primary-gold, #b8860b);
        border-top: 4px solid var(--primary-gold, #b8860b);
        padding: 5px 15px;
        margin-bottom: 15px;
    }

    .plan-main-title {
        font-size: 42px;
        font-weight: 800;
        color: #0d2c44;
        margin: 0;
    }

    /* Tabs Navigation */
    .floor-tabs-nav {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        border: 1px solid var(--primary-gold, #b8860b);
        border-radius: 4px;
        overflow: hidden;
    }

    .floor-tab-btn {
        flex: 1;
        padding: 15px 20px;
        background: transparent;
        border: none;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
        border-right: 1px solid var(--primary-gold, #b8860b);
        white-space: nowrap;
    }

    .floor-tab-btn:last-child {
        border-right: none;
    }

    .floor-tab-btn.active {
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
    }

    /* Tab Content Layout */
    .floor-tab-content {
        display: none;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        animation: fadeIn 0.5s ease;
    }

    .floor-tab-content.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Left Side: Info */
    .floor-info-side {
        flex: 1;
        padding: 50px;
        background-color: var(--primary-gold, #b8860b);
        color: #fff;
    }

    .floor-type-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .floor-desc {
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 35px;
        opacity: 0.9;
    }

    .specs-table {
        width: 100%;
        border-collapse: collapse;
    }

    .specs-table tr {
        border-bottom: 1px dashed rgba(255,255,255,0.3);
    }

    .specs-table tr:last-child {
        border-bottom: none;
    }

    .specs-table td {
        padding: 15px 0;
        font-size: 16px;
    }

    .spec-label {
        font-weight: 400;
        opacity: 0.8;
    }

    .spec-value {
        text-align: right;
        font-weight: 700;
    }

    /* Right Side: Image */
    .floor-image-side {
        flex: 1.2;
        background-color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    .floor-plan-img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .floor-tab-content.active {
            flex-direction: column;
        }
        .floor-info-side {
            padding: 40px 30px;
        }
    }

    @media (max-width: 768px) {
        .floor-tabs-nav {
            overflow-x: auto;
            justify-content: flex-start;
        }
        .floor-tab-btn {
            padding: 12px 25px;
        }
        .plan-main-title {
            font-size: 32px;
        }
    }

    @media (max-width: 480px) {
        .floor-info-side {
            padding: 30px 20px;
        }
        .floor-type-title {
            font-size: 26px;
        }
        .specs-table td {
            font-size: 14px;
        }
    }
</style>

<section class="floor-plan-section" id="floor-plans">
    <div class="floor-plan-container">
        <!-- Header -->
        <div class="floor-plan-header">
            <div class="sketch-title">Apartments Sketch</div>
            <h2 class="plan-main-title">Apartments Plan</h2>
        </div>

        <!-- Tabs Navigation -->
        <div class="floor-tabs-nav">
            <button class="floor-tab-btn active" onclick="switchTab(event, 'studio')">The Studio</button>
            <button class="floor-tab-btn" onclick="switchTab(event, 'deluxe')">Deluxe Portion</button>
            <button class="floor-tab-btn" onclick="switchTab(event, 'penthouse')">Penthouse</button>
            <button class="floor-tab-btn" onclick="switchTab(event, 'garden')">Top Garden</button>
            <button class="floor-tab-btn" onclick="switchTab(event, 'double')">Double Height</button>
        </div>

        <!-- Tab Contents -->
        
        <!-- Studio -->
        <div id="studio" class="floor-tab-content active">
            <div class="floor-info-side">
                <h3 class="floor-type-title">The Studio</h3>
                <p class="floor-desc">
                    A modern, open-concept studio apartment designed for efficiency and style. Perfect for individuals or small families seeking a premium Smart City lifestyle with optimized space management.
                </p>
                <table class="specs-table">
                    <tr>
                        <td class="spec-label">Total Area</td>
                        <td class="spec-value">2800 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bedroom</td>
                        <td class="spec-value">150 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bathroom</td>
                        <td class="spec-value">45 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Balcony/Pets</td>
                        <td class="spec-value">Allowed</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Lounge</td>
                        <td class="spec-value">650 Sq. Ft</td>
                    </tr>
                </table>
            </div>
            <div class="floor-image-side">
                <img src="https://images.unsplash.com/photo-1574362848149-11496d93a7c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Studio Floor Plan" class="floor-plan-img">
            </div>
        </div>

        <!-- Deluxe -->
        <div id="deluxe" class="floor-tab-content">
            <div class="floor-info-side">
                <h3 class="floor-type-title">Deluxe Portion</h3>
                <p class="floor-desc">
                    Spacious deluxe portions featuring enhanced privacy and larger living areas. These units offer high-end finishes and a perfect balance between luxury and functionality.
                </p>
                <table class="specs-table">
                    <tr>
                        <td class="spec-label">Total Area</td>
                        <td class="spec-value">3500 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bedroom</td>
                        <td class="spec-value">220 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bathroom</td>
                        <td class="spec-value">60 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Balcony/Pets</td>
                        <td class="spec-value">Allowed</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Lounge</td>
                        <td class="spec-value">800 Sq. Ft</td>
                    </tr>
                </table>
            </div>
            <div class="floor-image-side">
                <img src="https://images.unsplash.com/photo-1628592102751-ba83b03a442a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Deluxe Floor Plan" class="floor-plan-img">
            </div>
        </div>

        <!-- Penthouse -->
        <div id="penthouse" class="floor-tab-content">
            <div class="floor-info-side">
                <h3 class="floor-type-title">Penthouse</h3>
                <p class="floor-desc">
                    The pinnacle of luxury living. Our penthouses offer panoramic city views, expansive private terraces, and double-height ceilings for a truly majestic living experience.
                </p>
                <table class="specs-table">
                    <tr>
                        <td class="spec-label">Total Area</td>
                        <td class="spec-value">5200 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bedroom</td>
                        <td class="spec-value">450 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bathroom</td>
                        <td class="spec-value">120 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Terrace Area</td>
                        <td class="spec-value">1200 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Lounge</td>
                        <td class="spec-value">1200 Sq. Ft</td>
                    </tr>
                </table>
            </div>
            <div class="floor-image-side">
                <img src="https://images.unsplash.com/photo-1600607687989-ce8a6c72159c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Penthouse Floor Plan" class="floor-plan-img">
            </div>
        </div>

        <!-- Top Garden -->
        <div id="garden" class="floor-tab-content">
            <div class="floor-info-side">
                <h3 class="floor-type-title">Top Garden Units</h3>
                <p class="floor-desc">
                    Unique garden-facing apartments that bring nature to your doorstep. Featuring dedicated green zones and large glass walls to integrate indoor and outdoor living.
                </p>
                <table class="specs-table">
                    <tr>
                        <td class="spec-label">Total Area</td>
                        <td class="spec-value">4000 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Garden Space</td>
                        <td class="spec-value">500 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bedroom</td>
                        <td class="spec-value">200 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bathroom</td>
                        <td class="spec-value">55 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Lounge</td>
                        <td class="spec-value">750 Sq. Ft</td>
                    </tr>
                </table>
            </div>
            <div class="floor-image-side">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Garden Unit Floor Plan" class="floor-plan-img">
            </div>
        </div>

        <!-- Double Height -->
        <div id="double" class="floor-tab-content">
            <div class="floor-info-side">
                <h3 class="floor-type-title">Double Height</h3>
                <p class="floor-desc">
                    Architectural masterpieces featuring double-volume living rooms. These units create an incredible sense of scale and allow for massive artistic installations or libraries.
                </p>
                <table class="specs-table">
                    <tr>
                        <td class="spec-label">Total Area</td>
                        <td class="spec-value">4800 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Ceiling Height</td>
                        <td class="spec-value">22 Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bedroom</td>
                        <td class="spec-value">300 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Bathroom</td>
                        <td class="spec-value">90 Sq. Ft</td>
                    </tr>
                    <tr>
                        <td class="spec-label">Lounge</td>
                        <td class="spec-value">1100 Sq. Ft</td>
                    </tr>
                </table>
            </div>
            <div class="floor-image-side">
                <img src="https://images.unsplash.com/photo-1628592102173-b3a9920150d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Double Height Floor Plan" class="floor-plan-img">
            </div>
        </div>

    </div>
</section>

<script>
    function switchTab(evt, tabId) {
        // Hide all contents
        const contents = document.querySelectorAll('.floor-tab-content');
        contents.forEach(content => content.classList.remove('active'));

        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.floor-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }
</script>
