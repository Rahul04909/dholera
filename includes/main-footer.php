<?php
/**
 * Main Footer Component
 * Professional Real Estate Footer for Dholera Smart City
 */
?>
<style>
    :root {
        --footer-bg: #0b1622;
        --footer-text: #e2e8f0;
        --footer-gold: #b8860b;
        --footer-border: rgba(255, 255, 255, 0.1);
    }

    .main-footer {
        background-color: var(--footer-bg);
        color: var(--footer-text);
        padding: 80px 0 0;
        font-family: 'Outfit', sans-serif;
        position: relative;
    }

    .footer-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px;
    }

    /* Column 1: Brand */
    .footer-col-brand .footer-logo {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .footer-col-brand .footer-logo i {
        color: var(--footer-gold);
    }

    .footer-col-brand p {
        font-size: 15px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 25px;
    }

    .footer-social-links {
        display: flex;
        gap: 15px;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--footer-border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: var(--footer-gold);
        transform: translateY(-5px);
        border-color: var(--footer-gold);
    }

    /* Columns: Menu */
    .footer-col h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-col h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background: var(--footer-gold);
    }

    .footer-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-menu li {
        margin-bottom: 15px;
    }

    .footer-menu a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .footer-menu a i {
        font-size: 12px;
        color: var(--footer-gold);
    }

    .footer-menu a:hover {
        color: var(--footer-gold);
        padding-left: 5px;
    }

    /* Blinking Menus */
    .blink-menu {
        color: var(--footer-gold) !important;
        font-weight: 700 !important;
        animation: menu-blink 1.5s infinite;
    }

    @keyframes menu-blink {
        0%, 100% { opacity: 1; text-shadow: 0 0 10px rgba(184, 134, 11, 0.5); }
        50% { opacity: 0.6; text-shadow: none; }
    }

    /* Contact Info */
    .footer-contact-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .contact-icon {
        font-size: 18px;
        color: var(--footer-gold);
        margin-top: 3px;
    }

    .contact-text {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.7);
    }

    .contact-text strong {
        display: block;
        color: #fff;
        margin-bottom: 3px;
    }

    /* Footer Bottom */
    .footer-bottom-bar {
        margin-top: 60px;
        padding: 30px 0;
        border-top: 1px solid var(--footer-border);
    }

    .footer-bottom-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .copyright-text {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.5);
    }

    .footer-bottom-links {
        display: flex;
        gap: 25px;
    }

    .footer-bottom-links a {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-bottom-links a:hover {
        color: var(--footer-gold);
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .footer-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
        }
    }

    @media (max-width: 768px) {
        .main-footer { padding: 60px 0 0; }
        .footer-container {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .footer-col h3::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-menu a {
            justify-content: center;
        }
        .footer-social-links {
            justify-content: center;
        }
        .footer-contact-item {
            flex-direction: column;
            align-items: center;
        }
        .footer-bottom-container {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<footer class="main-footer">
    <div class="footer-container">
        <!-- Brand Section -->
        <div class="footer-col footer-col-brand">
            <div class="footer-logo">
                <i class="fas fa-city"></i> DHOLERA SMART
            </div>
            <p>
                Developing sustainable and modern residential, commercial, and industrial projects in India's first greenfield smart city. Building the future of urban living.
            </p>
            <div class="footer-social-links">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-col">
            <h3>Quick Links</h3>
            <ul class="footer-menu">
                <li><a href="../../about.php"><i class="fas fa-chevron-right"></i> About Dholera</a></li>
                <li><a href="#" class="blink-menu"><i class="fas fa-chevron-right"></i> Book a Site Visit</a></li>
                <li><a href="../../contact.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                <!-- <li><a href="#"><i class="fas fa-chevron-right"></i> Floor Plans</a></li> -->
                <li><a href="#" class="blink-menu"><i class="fas fa-chevron-right"></i> Download Brochure</a></li>
            </ul>
        </div>

        <!-- Latest Projects -->
        <div class="footer-col">
            <h3>Our Projects</h3>
            <ul class="footer-menu">
                <li><a href="#"><i class="fas fa-chevron-right"></i> Residential Plots</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Industrial Lands</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Commercial Zones</a></li>
                <li><a href="#" class="blink-menu"><i class="fas fa-chevron-right"></i> Smart Homes</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Greenfield Townships</a></li>
            </ul>
        </div>

        <!-- Contact Section -->
        <div class="footer-col">
            <h3>Reach Us</h3>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="contact-text">
                    <strong>Our Location</strong>
                    Dholera Special Investment Region, Gujarat, India.
                </div>
            </div>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="contact-text">
                    <strong>Call Experts</strong>
                    +91 999 000 0000 / +91 888 000 0000
                </div>
            </div>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div class="contact-text">
                    <strong>Email Support</strong>
                    info@dholerasmartcity.com
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom-bar">
        <div class="footer-bottom-container">
            <div class="copyright-text">
                &copy; <?php echo date('Y'); ?> Dholera Smart City. All Rights Reserved. A Website Powerd By <a href="https://mineib.com">Mineib</a>
            </div>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Disclaimer</a>
            </div>
        </div>
    </div>
</footer>
