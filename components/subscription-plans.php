<style>
    :root {
        --blue-plan: #0080ff;
        --orange-plan: #ff4d4d;
        --purple-plan: #8a2be2;
        --green-plan: #32cd32;
        --text-dark: #1a202c;
        --text-muted: #718096;
        --bg-light: #f8fafc;
    }

    .subscription-section {
        background-color: var(--bg-light);
        padding: 100px 20px;
    }

    .subscription-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    .subscription-header {
        text-align: center;
        margin-bottom: 70px;
    }

    .subscription-header h2 {
        font-size: 48px;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .subscription-header p {
        font-size: 20px;
        color: var(--text-muted);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    /* Card Styles */
    .pricing-card-box {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        border: 1px solid #f0f0f0;
    }

    .pricing-card-box:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.12);
    }

    .card-header-v2 {
        height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #fff;
        padding: 30px;
        text-align: center;
    }

    .card-header-v2.blue { background: linear-gradient(135deg, #0080ff, #005bb7); }
    .card-header-v2.orange { background: linear-gradient(135deg, #ff4d4d, #d32f2f); }
    .card-header-v2.purple { background: linear-gradient(135deg, #8a2be2, #5e1f9c); }
    .card-header-v2.green { background: linear-gradient(135deg, #32cd32, #1b8a1b); }

    .plan-title-v2 {
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .plan-subtitle-v2 {
        font-size: 14px;
        opacity: 0.9;
        font-weight: 500;
    }

    .card-body-v2 {
        padding: 50px 35px;
        text-align: center;
        flex-grow: 1;
    }

    .price-value-box {
        margin-bottom: 35px;
    }

    .price-value-box .cur {
        font-size: 28px;
        font-weight: 700;
        vertical-align: top;
        margin-right: 4px;
        color: var(--text-dark);
    }

    .price-value-box .amt {
        font-size: 64px;
        font-weight: 900;
        color: var(--text-dark);
        line-height: 1;
    }

    .price-value-box .per {
        font-size: 16px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .action-btn-v2 {
        display: block;
        width: 100%;
        padding: 18px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 800;
        font-size: 18px;
        transition: 0.3s;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .action-btn-v2.filled-blue { background: var(--blue-plan); color: #fff; box-shadow: 0 10px 20px rgba(0, 128, 255, 0.2); }
    .action-btn-v2.filled-orange { background: var(--orange-plan); color: #fff; box-shadow: 0 10px 20px rgba(255, 77, 77, 0.2); }
    .action-btn-v2.outline-purple { background: #fff; color: var(--purple-plan); border: 2px solid var(--purple-plan); }
    .action-btn-v2.outline-green { background: #fff; color: var(--green-plan); border: 2px solid var(--green-plan); }

    .action-btn-v2:hover {
        filter: brightness(1.1);
        transform: scale(1.02);
    }

    .secure-msg {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .plan-features-v2 {
        text-align: left;
        list-style: none;
        padding-top: 30px;
        border-top: 1px solid #f0f0f0;
    }

    .plan-features-v2 li {
        font-size: 16px;
        color: #4a5568;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 500;
    }

    .plan-features-v2 li i {
        font-size: 16px;
    }

    .blue-check i { color: var(--blue-plan); }
    .orange-check i { color: var(--orange-plan); }
    .purple-check i { color: var(--purple-plan); }
    .green-check i { color: var(--green-plan); }

    /* Ribbon Styles */
    .popular-ribbon-v2 {
        position: absolute;
        top: 25px;
        right: -40px;
        background: #fff;
        padding: 8px 45px;
        font-size: 11px;
        font-weight: 900;
        transform: rotate(45deg);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 10;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .card-highlight-orange {
        border: 3px solid var(--orange-plan);
    }

    @media (max-width: 768px) {
        .subscription-header h2 { font-size: 36px; }
        .subscription-section { padding: 60px 20px; }
    }
</style>

<section id="marketing-plans" class="subscription-section">
    <div class="subscription-container">
        <div class="subscription-header">
            <h2>Digital Marketing Solutions</h2>
            <p>Accelerate your real estate sales with premium lead generation and targeted marketing strategies.</p>
        </div>

        <div class="pricing-grid">
            <!-- Starter -->
            <div class="pricing-card-box">
                <div class="popular-ribbon-v2" style="color: var(--blue-plan);">New</div>
                <div class="card-header-v2 blue">
                    <h3 class="plan-title-v2">Starter</h3>
                    <p class="plan-subtitle-v2">Perfect for individual agents</p>
                </div>
                <div class="card-body-v2">
                    <div class="price-value-box">
                        <span class="cur">₹</span>
                        <span class="amt">2,499</span>
                        <span class="per">/ month</span>
                    </div>
                    <a href="register.php" class="action-btn-v2 filled-blue">Get Started</a>
                    <span class="secure-msg"><i class="fas fa-shield-alt"></i> 14-day money back guarantee</span>
                    <ul class="plan-features-v2 blue-check">
                        <li><i class="fas fa-check-circle"></i> 50 Verified Leads / Mo</li>
                        <li><i class="fas fa-check-circle"></i> Basic Ad Campaign Setup</li>
                        <li><i class="fas fa-check-circle"></i> Email Notifications</li>
                        <li><i class="fas fa-check-circle"></i> Standard Support</li>
                        <li><i class="fas fa-check-circle"></i> CRM Tool Access</li>
                    </ul>
                </div>
            </div>

            <!-- Professional -->
            <div class="pricing-card-box card-highlight-orange">
                <div class="popular-ribbon-v2" style="color: var(--orange-plan); background: var(--orange-plan); color: #fff;">Popular</div>
                <div class="card-header-v2 orange">
                    <h3 class="plan-title-v2">Professional</h3>
                    <p class="plan-subtitle-v2">Best value for builders</p>
                </div>
                <div class="card-body-v2">
                    <div class="price-value-box">
                        <span class="cur">₹</span>
                        <span class="amt">4,999</span>
                        <span class="per">/ month</span>
                    </div>
                    <a href="register.php" class="action-btn-v2 filled-orange">Go Pro Now</a>
                    <span class="secure-msg"><i class="fas fa-shield-alt"></i> 14-day money back guarantee</span>
                    <ul class="plan-features-v2 orange-check">
                        <li><i class="fas fa-check-circle"></i> 150 Verified Leads / Mo</li>
                        <li><i class="fas fa-check-circle"></i> Multi-Channel Marketing</li>
                        <li><i class="fas fa-check-circle"></i> Automated CRM Integration</li>
                        <li><i class="fas fa-check-circle"></i> Dedicated Account Manager</li>
                        <li><i class="fas fa-check-circle"></i> Weekly Performance Reports</li>
                    </ul>
                </div>
            </div>

            <!-- Business -->
            <div class="pricing-card-box">
                <div class="popular-ribbon-v2" style="color: var(--purple-plan);">Growth</div>
                <div class="card-header-v2 purple">
                    <h3 class="plan-title-v2">Business</h3>
                    <p class="plan-subtitle-v2">Scale your team rapidly</p>
                </div>
                <div class="card-body-v2">
                    <div class="price-value-box">
                        <span class="cur">₹</span>
                        <span class="amt">9,999</span>
                        <span class="per">/ month</span>
                    </div>
                    <a href="register.php" class="action-btn-v2 outline-purple">Scale Business</a>
                    <span class="secure-msg"><i class="fas fa-shield-alt"></i> 14-day money back guarantee</span>
                    <ul class="plan-features-v2 purple-check">
                        <li><i class="fas fa-check-circle"></i> 500 Verified Leads / Mo</li>
                        <li><i class="fas fa-check-circle"></i> Advanced Data Analytics</li>
                        <li><i class="fas fa-check-circle"></i> Custom Landing Pages</li>
                        <li><i class="fas fa-check-circle"></i> SMS & Email Marketing</li>
                        <li><i class="fas fa-check-circle"></i> API Access & Integrations</li>
                    </ul>
                </div>
            </div>

            <!-- Enterprise -->
            <div class="pricing-card-box">
                <div class="popular-ribbon-v2" style="color: var(--green-plan);">Elite</div>
                <div class="card-header-v2 green">
                    <h3 class="plan-title-v2">Enterprise</h3>
                    <p class="plan-subtitle-v2">Maximum visibility & leads</p>
                </div>
                <div class="card-body-v2">
                    <div class="price-value-box">
                        <span class="cur">₹</span>
                        <span class="amt">19,999</span>
                        <span class="per">/ month</span>
                    </div>
                    <a href="register.php" class="action-btn-v2 outline-green">Contact Sales</a>
                    <span class="secure-msg"><i class="fas fa-shield-alt"></i> 14-day money back guarantee</span>
                    <ul class="plan-features-v2 green-check">
                        <li><i class="fas fa-check-circle"></i> Unlimited Lead Flow</li>
                        <li><i class="fas fa-check-circle"></i> Full Marketing Outsourcing</li>
                        <li><i class="fas fa-check-circle"></i> VIP 24/7 Priority Concierge</li>
                        <li><i class="fas fa-check-circle"></i> Brand Identity Solutions</li>
                        <li><i class="fas fa-check-circle"></i> Ultimate Listing Features</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
