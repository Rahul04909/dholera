<?php
/**
 * Contact Us Page
 * Dholera Smart City
 */
require_once 'database/db_config.php';
include 'includes/header.php';
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #0b1622;
        --text-dark: #2d3748;
        --text-muted: #718096;
        --section-bg: #f8fafc;
    }

    body {
        background-color: #fff;
        color: var(--text-dark);
        font-family: 'Outfit', sans-serif;
    }

    /* Contact Hero */
    .contact-hero {
        position: relative;
        height: 400px;
        background: url('assets/contact-hero.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(11, 22, 34, 0.85), rgba(11, 22, 34, 0.5));
    }

    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-content h1 {
        font-size: 44px;
        font-weight: 800;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .hero-content p {
        font-size: 18px;
        opacity: 0.9;
    }

    /* Contact Details Grid */
    .contact-wrapper {
        padding: 80px 0;
        background: #fff;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 60px;
        margin-bottom: 60px;
    }

    /* Info Cards */
    .info-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .contact-card {
        background: var(--section-bg);
        padding: 30px;
        border-radius: 15px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .contact-card:hover {
        transform: translateX(10px);
        background: #fff;
        border-color: var(--primary-gold);
        box-shadow: 0 10px 30px rgba(184, 134, 11, 0.1);
    }

    .card-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-gold);
        color: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .card-text h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--dark-bg);
    }

    .card-text p {
        font-size: 15px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Form Column */
    .form-column {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
    }

    .form-header {
        margin-bottom: 30px;
    }

    .form-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark-bg);
        margin-bottom: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-gold);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1);
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background: var(--primary-gold);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .submit-btn:hover {
        background: #966d09;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .hero-content h1 {
            font-size: 32px;
        }
    }

    @media (max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
        .form-column {
            padding: 30px 20px;
        }
        .contact-wrapper {
            padding: 50px 0;
        }
    }
</style>

<main>
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="hero-content">
            <h1>Get In Touch</h1>
            <p>Have questions about Dholera Smart City? Our experts are here to help you find the perfect investment opportunity.</p>
        </div>
    </div>

    <!-- Contact Content -->
    <section class="contact-wrapper">
        <div class="container">
            <div class="contact-grid">
                <!-- Info Column -->
                <div class="info-column">
                    <div class="contact-card">
                        <div class="card-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="card-text">
                            <h3>Project HQ</h3>
                            <p>Dholera Special Investment Region, DHOLERA, Gujarat 382455, India.</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="card-text">
                            <h3>Call Experts</h3>
                            <p>+91 999 000 0000<br>+91 888 000 0000</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon"><i class="fas fa-envelope"></i></div>
                        <div class="card-text">
                            <h3>Email Support</h3>
                            <p>info@dholerasmartcity.com<br>support@dholerasmartcity.com</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon"><i class="fas fa-clock"></i></div>
                        <div class="card-text">
                            <h3>Business Hours</h3>
                            <p>Mon - Sat: 10:00 AM - 07:00 PM<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="form-column">
                    <div class="form-header">
                        <h2>Send us a Message</h2>
                        <p style="color: var(--text-muted); font-size: 14px;">Fill out the form below and we'll get back to you within 24 hours.</p>
                    </div>

                    <form id="contactForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="number" class="form-control" placeholder="+91 00000 00000" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Subject</label>
                                <select class="form-control" name="subject">
                                    <option value="General Enquiry">General Enquiry</option>
                                    <option value="Residential Plots">Residential Plots</option>
                                    <option value="Commercial Plots">Commercial Plots</option>
                                    <option value="Site Visit Request">Site Visit Request</option>
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label">Message</label>
                                <textarea name="comments" class="form-control" rows="5" placeholder="How can we help you today?" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="far fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Component Integration -->
    <?php include 'components/location.php'; ?>
</main>

<!-- Success Modal -->
<div id="contactSuccessModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div style="background: #fff; padding: 40px; border-radius: 20px; text-align: center; max-width: 400px; position: relative; border-top: 6px solid var(--primary-gold); box-shadow: 0 30px 60px rgba(0,0,0,0.2);">
        <div style="width: 80px; height: 80px; background: #f0fff4; color: #38a169; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px;">
            <i class="fas fa-check"></i>
        </div>
        <h2 style="font-size: 26px; font-weight: 800; margin-bottom: 15px; color: var(--dark-bg);">Message Sent!</h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Thank you for reaching out. Our team will contact you shortly to assist with your requirements.</p>
        <button onclick="document.getElementById('contactSuccessModal').style.display = 'none'" style="background: var(--primary-gold); color: #fff; border: none; padding: 14px 40px; border-radius: 10px; font-weight: 700; cursor: pointer; text-transform: uppercase; width: 100%;">Close</button>
    </div>
</div>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

        fetch('ajax/submit-enquiry.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('contactSuccessModal').style.display = 'flex';
                form.reset();
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A technical error occurred while sending your message.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>

<?php include 'includes/main-footer.php'; ?>
