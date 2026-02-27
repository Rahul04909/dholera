<style>
    /* Footer Component Styling */
    footer {
        font-family: 'Outfit', sans-serif;
        background: #000;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    /* Main Footer section with dual tone */
    .footer-top {
        display: flex;
        flex-wrap: wrap;
        background-color: #b8860b; /* Primary Gold */
        position: relative;
    }

    /* About Developer Section */
    .about-developer {
        flex: 1 1 50%;
        padding: 50px;
        background-image: radial-gradient(rgba(0,0,0,0.1) 2px, transparent 2px);
        background-size: 20px 20px; /* Dotted pattern */
        position: relative;
        z-index: 1;
    }

    .about-developer h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .about-developer h2::after {
        content: "";
        height: 2px;
        flex-grow: 1;
        background: rgba(255,255,255,0.5);
    }

    .about-developer p {
        font-size: 16px;
        line-height: 1.6;
        color: rgba(255,255,255,0.9);
        margin-bottom: 20px;
    }

    /* Footer Enquiry Form Container */
    .footer-enquiry {
        flex: 1 1 50%;
        background: #c3ae8e; /* Lighter gold for form background */
        padding: 60px 60px 50px 100px; /* Increased left padding significantly */
        position: relative;
        clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%); /* Slightly reduced cut percentage */
        margin-left: -6%; /* Overlap for the diagonal look */
        z-index: 2;
    }

    .footer-enquiry-header {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #fff; /* Ensure text is white against the light gold for better contrast */
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .footer-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .footer-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .footer-form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .footer-form-control {
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
    }

    .footer-form-control:focus {
        border-color: #000;
    }

    .footer-submit-btn {
        grid-column: span 2;
        background: #000;
        color: #fff;
        border: none;
        padding: 15px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
        border-radius: 4px;
    }

    .footer-submit-btn:hover {
        background: #333;
    }

    /* Bottom Section / Disclaimer */
    .footer-bottom {
        background: #000;
        padding: 40px 20px;
        text-align: center;
    }

    .disclaimer-title {
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
        font-size: 16px;
    }

    .disclaimer-text {
        font-size: 14px;
        color: rgba(255,255,255,0.8);
        max-width: 1000px;
        margin: 0 auto 20px;
        line-height: 1.5;
    }

    .footer-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 10px;
    }

    .footer-links a {
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: #b8860b;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .about-developer, .footer-enquiry {
            flex: 1 1 100%;
            padding: 40px 20px;
            margin-left: 0;
            clip-path: none;
        }
        
        .footer-form-grid {
            padding-left: 0;
        }
        
        .footer-enquiry-header {
            padding-left: 0;
        }
    }

    @media (max-width: 576px) {
        .footer-form-grid {
            grid-template-columns: 1fr;
        }
        .footer-submit-btn {
            grid-column: span 1;
        }
    }
</style>

<footer>
    <div class="footer-top">
        <!-- About Developer -->
        <div class="about-developer">
            <h2>About Developer</h2>
            <p>
                We are the leading developer of India's First Greenfield Smart City Dholera Smart City in India, with a focus on developing sustainable and modern residential and commercial, and industrial projects. we aim to develop dholera's first green township..
            </p>
        </div>

        <!-- Enquiry Section -->
        <div class="footer-enquiry">
            <div class="footer-enquiry-header">
                <i class="fas fa-phone-volume"></i> Request A Callback !
            </div>
            <form id="callbackForm" class="footer-form-grid">
                <div class="footer-form-group">
                    <label>Enter Name</label>
                    <input type="text" class="footer-form-control" name="footer_name" placeholder="Name" required>
                </div>
                <div class="footer-form-group">
                    <label>Enter Email</label>
                    <input type="email" class="footer-form-control" name="footer_email" placeholder="Email" required>
                </div>
                <div class="footer-form-group">
                    <label>Enter Number</label>
                    <input type="tel" class="footer-form-control" name="footer_number" placeholder="Mobile Number" required>
                </div>
                <div class="footer-form-group">
                    <label>Preferred Time</label>
                    <select class="footer-form-control" name="callback_time" required>
                        <option value="">Select Timing</option>
                        <option value="Morning (9 AM - 12 PM)">Morning (9 AM - 12 PM)</option>
                        <option value="Afternoon (12 PM - 4 PM)">Afternoon (12 PM - 4 PM)</option>
                        <option value="Evening (4 PM - 7 PM)">Evening (4 PM - 7 PM)</option>
                        <option value="Anytime">Anytime</option>
                    </select>
                </div>
                <button type="submit" class="footer-submit-btn">Request A Call</button>
            </form>
        </div>
    </div>

    <!-- Disclaimer Section -->
    <div class="footer-bottom">
        <p class="disclaimer-text">
            <span class="disclaimer-title">Disclaimer :</span>
            The information provided on this website is intended exclusively for informational purposes and should not be construed as an offer of services. The pricing information presented on this website is subject to alteration without advance notification, and the assurance of property availability cannot be guaranteed. The images showcased on this website are for representational purposes only and may not accurately reflect the actual properties.
        </p>
        <div class="footer-links">
            <a href="#">Disclaimer</a>
            <a href="#">Privacy Policy</a>
        </div>
    </div>
</footer>

<!-- Callback Success Popup -->
<div id="callbackModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 40px; border-radius: 8px; text-align: center; max-width: 400px; position: relative; border-top: 5px solid #000;">
        <div style="width: 80px; height: 80px; background: #f0fff4; color: #38a169; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px;">
            <i class="fas fa-phone"></i>
        </div>
        <h2 style="font-size: 24px; margin-bottom: 10px; color: #333; font-family: 'Outfit', sans-serif;">Request Confirmed</h2>
        <p style="color: #666; margin-bottom: 25px; font-family: 'Outfit', sans-serif;">We've received your request. One of our specialists will call you at your preferred time.</p>
        <button onclick="document.getElementById('callbackModal').style.display = 'none'" style="background: #000; color: #fff; border: none; padding: 12px 30px; border-radius: 4px; font-weight: 700; cursor: pointer; text-transform: uppercase;">Awesome</button>
    </div>
</div>

<script>
    // AJAX Callback Request
    document.getElementById('callbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('.footer-submit-btn');
        const originalBtnText = submitBtn.innerText;

        submitBtn.disabled = true;
        submitBtn.innerText = 'Requesting...';

        fetch('ajax/submit-callback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('callbackModal').style.display = 'flex';
                form.reset();
            } else {
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A technical error occurred.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerText = originalBtnText;
        });
    });
</script>
