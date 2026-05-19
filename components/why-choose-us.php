<?php
/**
 * Professional Why Choose Us Component
 * Staggered Connecting Process Timeline with Responsive Falling Stack
 * Replicates the visual aesthetics of user's reference process flow
 */
?>
<style>
    :root {
        --primary-gold-v4: #b8860b;
        --text-dark-v4: #1c335a;
        --text-muted-v4: #718096;
    }

    .why-us-section {
        padding: 100px 0;
        background: #fff;
        position: relative;
        overflow: hidden;
        text-align: center;
        font-family: 'Outfit', sans-serif;
    }

    .container-v4 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Subtitle and Title Headers */
    .why-us-header {
        max-width: 800px;
        margin: 0 auto 50px;
    }

    .why-us-header span {
        color: #2e7d32;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 12px;
    }

    .why-us-header h2 {
        font-size: 38px;
        font-weight: 900;
        color: var(--text-dark-v4);
        line-height: 1.2;
        margin: 0;
        letter-spacing: -0.5px;
    }

    /* Staggered Horizontal Process Timeline */
    .process-timeline {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1100px;
        margin: 80px auto;
        padding: 0;
    }

    /* Connecting Dotted Line for desktop staggered nodes */
    .process-timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 80px;
        right: 80px;
        height: 2px;
        border-top: 2px dashed #cbd5e1;
        z-index: 1;
        transform: translateY(-50px);
    }

    .process-node {
        position: relative;
        z-index: 2;
        width: 22%;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Offset positioning to stagger nodes high-low on desktop */
    .process-node.node-high {
        transform: translateY(-30px);
    }

    .process-node.node-low {
        transform: translateY(30px);
    }

    .node-circle {
        width: 90px;
        height: 90px;
        background: #fff;
        border: 2px solid #edf2f7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(28, 51, 90, 0.05);
        font-size: 28px;
        color: var(--text-dark-v4);
        margin-bottom: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .node-circle::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border: 2px solid transparent;
        border-radius: 50%;
        transition: all 0.4s ease;
        opacity: 0;
    }

    .process-node:hover .node-circle {
        transform: scale(1.1);
        border-color: var(--primary-gold-v4);
        box-shadow: 0 15px 30px rgba(184, 134, 11, 0.2);
        color: var(--primary-gold-v4);
    }

    .process-node:hover .node-circle::after {
        border-color: var(--primary-gold-v4);
        transform: scale(1.05);
        opacity: 0.3;
    }

    .node-info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .node-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-dark-v4);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .node-desc {
        font-size: 13.5px;
        color: var(--text-muted-v4);
        line-height: 1.5;
        font-family: 'Inter', sans-serif;
    }

    /* Bottom Bullets Grid Section */
    .bullets-section {
        border-top: 1px solid #f1f5f9;
        margin-top: 80px;
        padding-top: 60px;
        text-align: left;
    }

    .bullets-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .bullet-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .bullet-icon {
        color: #2e7d32;
        font-size: 15px;
        margin-top: 4px;
        flex-shrink: 0;
    }

    .bullet-text {
        font-size: 14.5px;
        color: #4a5568;
        line-height: 1.6;
        font-family: 'Inter', sans-serif;
    }

    .bullet-text strong {
        color: var(--text-dark-v4);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
    }

    /* Responsive Adaptabilities */
    @media (max-width: 991px) {
        .why-us-section {
            padding: 70px 0;
        }

        .why-us-header h2 {
            font-size: 30px;
        }

        .process-timeline {
            flex-direction: column;
            gap: 25px;
            margin: 40px auto;
        }

        .process-timeline::before {
            display: none;
        }

        .process-node {
            width: 100%;
            transform: none !important;
            flex-direction: row;
            text-align: left;
            gap: 20px;
            align-items: flex-start;
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .process-node:hover {
            transform: translateY(-3px);
            border-color: rgba(184, 134, 11, 0.2);
            box-shadow: 0 10px 25px rgba(28, 51, 90, 0.05);
        }

        .node-circle {
            width: 65px;
            height: 65px;
            font-size: 22px;
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .node-info {
            align-items: flex-start;
        }

        .node-title {
            font-size: 14.5px;
            margin-bottom: 5px;
        }
    }

    @media (max-width: 768px) {
        .bullets-section {
            margin-top: 40px;
            padding-top: 40px;
        }

        .bullets-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>

<section class="why-us-section">
    <div class="container-v4">
        
        <!-- Header Text -->
        <div class="why-us-header">
            <span>Our Core Process & Features</span>
            <h2>Why Choose Dholera By Us</h2>
        </div>

        <!-- Staggered Connecting Process Timeline -->
        <div class="process-timeline">
            
            <!-- Step 1: High -->
            <div class="process-node node-high">
                <div class="node-circle">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="node-info">
                    <h4 class="node-title">Safe Guarantee</h4>
                    <p class="node-desc">We offer a 100% safety guarantee because every plot is government & RERA approved.</p>
                </div>
            </div>

            <!-- Step 2: Low -->
            <div class="process-node node-low">
                <div class="node-circle">
                    <i class="fa-solid fa-car-side"></i>
                </div>
                <div class="node-info">
                    <h4 class="node-title">Free Site Visits</h4>
                    <p class="node-desc">Complimentary luxury transit pick-ups from Ahmedabad or Dholera for hassle-free physical tours.</p>
                </div>
            </div>

            <!-- Step 3: High -->
            <div class="process-node node-high">
                <div class="node-circle" style="font-weight: 700;">
                    ₹
                </div>
                <div class="node-info">
                    <h4 class="node-title">Competitive Pricing</h4>
                    <p class="node-desc">Direct developer rate listings, meaning zero high-commission agent brokerage fees.</p>
                </div>
            </div>

            <!-- Step 4: Low -->
            <div class="process-node node-low">
                <div class="node-circle">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="node-info">
                    <h4 class="node-title">Expert Support</h4>
                    <p class="node-desc">24/7 dedicated support from verified smart city development experts.</p>
                </div>
            </div>

        </div>

        <!-- Lower Detailed Bullets Section -->
        <div class="bullets-section">
            <div class="bullets-grid">
                
                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>RERA Registered Properties:</strong> Rest assured that all sites cataloged on Dholera By Us are fully cleared, certified, and compliant with all state planning departments.
                    </div>
                </div>

                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>Transparent Pricing Options:</strong> No hidden costs, paper fees, or surprises. The pricing shown is straight from primary developers, ensuring maximum value.
                    </div>
                </div>

                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>Ahmedabad-to-SIR Guided Tours:</strong> We plan and schedule a comfortable, guided site-seeing package to make your decision process smooth and clear.
                    </div>
                </div>

                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>Zoning & Land Use Advisory:</strong> Get deep consulting on which corridors (residential, commercial, industrial, or logistics) offer the highest capital appreciation rates.
                    </div>
                </div>

                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>24/7 Assistance Desk:</strong> Need immediate paperwork guidance or local developer updates? Our consultants are just a chat or phone call away, anytime.
                    </div>
                </div>

                <div class="bullet-item">
                    <i class="fa-solid fa-circle-check bullet-icon"></i>
                    <div class="bullet-text">
                        <strong>High-growth Infrastructure Mapping:</strong> Invest in prime hotspots positioned alongside the Ahmedabad-Dholera Expressway and international airport boundary zones.
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
