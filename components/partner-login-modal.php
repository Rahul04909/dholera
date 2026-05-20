<!-- Partner/Agent Login Modal -->
<style>
    /* Premium Modal Style System */
    .partner-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 22, 34, 0.7); /* Deep dark navy with opacity */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .partner-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .partner-modal-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(184, 134, 11, 0.2);
        width: 100%;
        max-width: 440px;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(11, 22, 34, 0.25);
        overflow: hidden;
        position: relative;
        transform: translateY(20px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .partner-modal-overlay.active .partner-modal-card {
        transform: translateY(0) scale(1);
    }

    /* Top gold progress border */
    .partner-modal-progress {
        height: 5px;
        background: linear-gradient(90deg, #b8860b, #e5a93b, #b8860b);
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    /* Modal Close Button */
    .partner-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.05);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #718096;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .partner-modal-close:hover {
        background: rgba(229, 62, 62, 0.1);
        color: #e53e3e;
        transform: rotate(90deg);
    }

    /* Modal Header & Content */
    .partner-modal-body {
        padding: 40px 35px 35px 35px;
        text-align: center;
    }

    .partner-modal-logo {
        margin-bottom: 20px;
    }

    .partner-modal-logo img {
        height: 55px;
        object-fit: contain;
    }

    .partner-modal-title {
        font-size: 24px;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .partner-modal-subtitle {
        font-size: 14px;
        color: #718096;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* Views Layout */
    .partner-view-screen {
        display: none;
        animation: slideFadeIn 0.4s ease forwards;
    }

    .partner-view-screen.active {
        display: block;
    }

    @keyframes slideFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Design */
    .partner-form-group {
        margin-bottom: 22px;
        text-align: left;
        position: relative;
    }

    .partner-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .partner-input-wrapper {
        position: relative;
    }

    .partner-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #b8860b;
        font-size: 16px;
        transition: all 0.3s;
    }

    .partner-form-control {
        width: 100%;
        padding: 14px 15px 14px 45px;
        border: 1.5px solid #edf2f7;
        border-radius: 10px;
        font-size: 15px;
        font-family: 'Outfit', sans-serif;
        background: #f7fafc;
        color: #2d3748;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .partner-form-control:focus {
        outline: none;
        border-color: #b8860b;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1);
    }

    .partner-form-control:focus + i {
        transform: translateY(-50%) scale(1.1);
    }

    /* OTP Code Styled Box */
    .partner-otp-input {
        letter-spacing: 8px;
        font-size: 22px;
        font-weight: 800;
        text-align: center;
        padding-left: 15px;
    }

    /* Beautiful Premium Button */
    .partner-submit-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #b8860b, #966d09);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 800;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-sizing: border-box;
    }

    .partner-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(184, 134, 11, 0.35);
    }

    .partner-submit-btn:active {
        transform: translateY(0);
    }

    .partner-submit-btn:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* Alert Message system */
    .partner-alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 22px;
        text-align: left;
        display: none;
        align-items: center;
        gap: 12px;
        animation: shakeError 0.4s ease;
    }

    .partner-alert.error {
        background: #fff5f5;
        color: #c53030;
        border-left: 4px solid #c53030;
        display: flex;
    }

    .partner-alert.success {
        background: #f0fff4;
        color: #38a169;
        border-left: 4px solid #38a169;
        display: flex;
    }

    @keyframes shakeError {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Resend OTP Layout */
    .partner-resend-container {
        margin-top: 25px;
        font-size: 13px;
        color: #718096;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .partner-resend-btn {
        background: none;
        border: none;
        color: #b8860b;
        font-weight: 700;
        cursor: pointer;
        padding: 0;
        font-family: inherit;
        transition: all 0.2s;
    }

    .partner-resend-btn:hover:not(:disabled) {
        text-decoration: underline;
        color: #966d09;
    }

    .partner-resend-btn:disabled {
        color: #a0aec0;
        cursor: not-allowed;
    }

    .partner-back-btn {
        background: none;
        border: none;
        color: #718096;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 25px;
        transition: all 0.3s;
    }

    .partner-back-btn:hover {
        color: #1a202c;
    }

    /* Loading Spinner */
    .partner-spinner {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.8s linear infinite;
        display: none;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Extra Info Section */
    .partner-modal-info {
        background: rgba(184, 134, 11, 0.05);
        border-radius: 10px;
        padding: 15px;
        margin-top: 25px;
        font-size: 12px;
        color: #718096;
        line-height: 1.5;
        border-left: 3px solid #b8860b;
        text-align: left;
    }
</style>

<div class="partner-modal-overlay" id="partnerLoginModal">
    <div class="partner-modal-card">
        <div class="partner-modal-progress"></div>
        <button class="partner-modal-close" id="partnerModalCloseBtn" title="Close Modal">
            <i class="fas fa-times"></i>
        </button>

        <div class="partner-modal-body">
            <div class="partner-modal-logo">
                <img src="<?php echo BASE_URL; ?>assets/logo.webp" alt="Dholera Smart City">
            </div>
            
            <h3 class="partner-modal-title" id="partnerModalTitle">Partner Access</h3>
            <p class="partner-modal-subtitle" id="partnerModalSubtitle">Sign in to your real estate business command center.</p>

            <!-- Status Alerts -->
            <div class="partner-alert" id="partnerModalAlert"></div>

            <!-- View 1: Request OTP Screen -->
            <div class="partner-view-screen active" id="screenRequestOtp">
                <form id="partnerRequestForm">
                    <div class="partner-form-group">
                        <label>Email Address</label>
                        <div class="partner-input-wrapper">
                            <input type="email" id="partnerEmail" class="partner-form-control" placeholder="partner@dholera.com" required autocomplete="email">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <button type="submit" class="partner-submit-btn" id="btnSendOtp">
                        <span class="partner-spinner" id="spinnerSendOtp"></span>
                        <span id="textSendOtp">Send Secure OTP</span>
                        <i class="fas fa-arrow-right" id="iconSendOtp"></i>
                    </button>
                </form>
                
                <div class="partner-modal-info">
                    <strong>Note:</strong> We will check if your email is registered in our network and send a 6-digit authentication token valid for 10 minutes.
                </div>
            </div>

            <!-- View 2: Verification Screen -->
            <div class="partner-view-screen" id="screenVerifyOtp">
                <form id="partnerVerifyForm">
                    <div class="partner-form-group">
                        <label>Verification Code</label>
                        <div class="partner-input-wrapper">
                            <input type="text" id="partnerOtp" class="partner-form-control partner-otp-input" placeholder="••••••" maxlength="6" pattern="\d{6}" required autocomplete="one-time-code">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>

                    <button type="submit" class="partner-submit-btn" id="btnVerifyOtp">
                        <span class="partner-spinner" id="spinnerVerifyOtp"></span>
                        <span id="textVerifyOtp">Verify & Sign In</span>
                        <i class="fas fa-sign-in-alt" id="iconVerifyOtp"></i>
                    </button>
                </form>

                <div class="partner-resend-container">
                    <span id="otpTimerText">Expires in <strong id="otpTimer">10:00</strong></span>
                    <button class="partner-resend-btn" id="btnResendOtp" disabled>Resend Code</button>
                </div>

                <button class="partner-back-btn" id="btnBackToEmail">
                    <i class="fas fa-arrow-left"></i> Change Email Address
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('partnerLoginModal');
        const triggers = document.querySelectorAll('#partner-login-btn, [id="partner-login-trigger"]');
        const closeBtn = document.getElementById('partnerModalCloseBtn');
        
        // Views
        const screenRequest = document.getElementById('screenRequestOtp');
        const screenVerify = document.getElementById('screenVerifyOtp');
        
        // Forms
        const requestForm = document.getElementById('partnerRequestForm');
        const verifyForm = document.getElementById('partnerVerifyForm');
        
        // Fields & Elements
        const emailInput = document.getElementById('partnerEmail');
        const otpInput = document.getElementById('partnerOtp');
        const alertBox = document.getElementById('partnerModalAlert');
        const modalTitle = document.getElementById('partnerModalTitle');
        const modalSubtitle = document.getElementById('partnerModalSubtitle');
        
        // Action Buttons & Loaders
        const btnSend = document.getElementById('btnSendOtp');
        const spinnerSend = document.getElementById('spinnerSendOtp');
        const iconSend = document.getElementById('iconSendOtp');
        const textSend = document.getElementById('textSendOtp');

        const btnVerify = document.getElementById('btnVerifyOtp');
        const spinnerVerify = document.getElementById('spinnerVerifyOtp');
        const iconVerify = document.getElementById('iconVerifyOtp');
        const textVerify = document.getElementById('textVerifyOtp');

        const btnResend = document.getElementById('btnResendOtp');
        const btnBack = document.getElementById('btnBackToEmail');
        const timerEl = document.getElementById('otpTimer');
        
        // State variables
        let activeEmail = '';
        let timerInterval = null;
        let countdownSeconds = 600; // 10 minutes default
        
        // Event Listeners for trigger
        triggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        // Close on overlay click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });

        // Form 1: Request OTP Submission
        requestForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = emailInput.value.trim();
            if (!email) return;

            showAlert(false); // Hide alerts
            setLoadingState(btnSend, spinnerSend, iconSend, textSend, true, 'Sending...');

            const formData = new FormData();
            formData.append('email', email);

            fetch('<?php echo BASE_URL; ?>ajax/agent-otp-request.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    activeEmail = email;
                    showAlert(true, 'success', data.message);
                    
                    // Smooth Transition to Verify screen
                    setTimeout(() => {
                        screenRequest.classList.remove('active');
                        screenVerify.classList.add('active');
                        modalTitle.innerText = "Security Code";
                        modalSubtitle.innerText = `Enter the 6-digit OTP code sent to ${email}`;
                        showAlert(false);
                        otpInput.value = '';
                        otpInput.focus();
                        
                        // Start timer (10 mins)
                        startOtpTimer(600);
                    }, 800);
                } else {
                    showAlert(true, 'error', data.message);
                }
            })
            .catch(err => {
                console.error(err);
                showAlert(true, 'error', 'A connection error occurred. Please try again.');
            })
            .finally(() => {
                setLoadingState(btnSend, spinnerSend, iconSend, textSend, false, 'Send Secure OTP');
            });
        });

        // Form 2: Verify OTP Submission
        verifyForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const otp = otpInput.value.trim();
            if (!otp || otp.length !== 6) {
                showAlert(true, 'error', 'Please enter a valid 6-digit verification code.');
                return;
            }

            showAlert(false);
            setLoadingState(btnVerify, spinnerVerify, iconVerify, textVerify, true, 'Verifying...');

            const formData = new FormData();
            formData.append('email', activeEmail);
            formData.append('otp', otp);

            fetch('<?php echo BASE_URL; ?>ajax/agent-otp-verify.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert(true, 'success', data.message);
                    clearInterval(timerInterval);
                    
                    // Redirect to dashboard on success after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1200);
                } else {
                    showAlert(true, 'error', data.message);
                }
            })
            .catch(err => {
                console.error(err);
                showAlert(true, 'error', 'A verification error occurred. Please try again.');
            })
            .finally(() => {
                setLoadingState(btnVerify, spinnerVerify, iconVerify, textVerify, false, 'Verify & Sign In');
            });
        });

        // Resend OTP trigger
        btnResend.addEventListener('click', (e) => {
            e.preventDefault();
            if (btnResend.disabled) return;

            showAlert(false);
            btnResend.disabled = true;
            btnResend.innerText = "Sending...";

            const formData = new FormData();
            formData.append('email', activeEmail);

            fetch('<?php echo BASE_URL; ?>ajax/agent-otp-request.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert(true, 'success', 'A new verification code has been generated and sent.');
                    startOtpTimer(600); // Reset timer
                } else {
                    showAlert(true, 'error', data.message);
                    btnResend.disabled = false;
                    btnResend.innerText = "Resend Code";
                }
            })
            .catch(err => {
                console.error(err);
                showAlert(true, 'error', 'Resend failed. Please check connection.');
                btnResend.disabled = false;
                btnResend.innerText = "Resend Code";
            });
        });

        // Back to Request Screen
        btnBack.addEventListener('click', (e) => {
            e.preventDefault();
            clearInterval(timerInterval);
            showAlert(false);
            
            screenVerify.classList.remove('active');
            screenRequest.classList.add('active');
            modalTitle.innerText = "Partner Access";
            modalSubtitle.innerText = "Sign in to your real estate business command center.";
        });

        // Functions
        function openModal() {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            showAlert(false);
            
            // Default View reset
            screenVerify.classList.remove('active');
            screenRequest.classList.add('active');
            modalTitle.innerText = "Partner Access";
            modalSubtitle.innerText = "Sign in to your real estate business command center.";
            emailInput.value = '';
            
            setTimeout(() => {
                emailInput.focus();
            }, 300);
        }

        function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            clearInterval(timerInterval);
        }

        function showAlert(show, type = '', text = '') {
            if (!show) {
                alertBox.className = 'partner-alert';
                alertBox.style.display = 'none';
                alertBox.innerText = '';
                return;
            }

            alertBox.className = `partner-alert ${type}`;
            alertBox.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> <span>${text}</span>`;
            alertBox.style.display = 'flex';
        }

        function setLoadingState(btn, spinner, icon, textEl, loading, loadingText = '') {
            btn.disabled = loading;
            if (loading) {
                spinner.style.display = 'inline-block';
                icon.style.display = 'none';
                textEl.innerText = loadingText;
            } else {
                spinner.style.display = 'none';
                icon.style.display = 'inline-block';
                textEl.innerText = loadingText;
            }
        }

        function startOtpTimer(duration) {
            clearInterval(timerInterval);
            countdownSeconds = duration;
            btnResend.disabled = true;
            btnResend.innerText = "Resend Code";
            
            updateTimerDisplay();

            timerInterval = setInterval(() => {
                countdownSeconds--;
                updateTimerDisplay();

                if (countdownSeconds <= 0) {
                    clearInterval(timerInterval);
                    btnResend.disabled = false;
                    btnResend.innerText = "Resend Code";
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(countdownSeconds / 60);
            const seconds = countdownSeconds % 60;
            timerEl.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
        
        // Auto-focus logic for 6-digit OTP code entry
        otpInput.addEventListener('input', (e) => {
            // Remove non-numeric values
            otpInput.value = otpInput.value.replace(/\D/g, '');
            
            // Auto submit form when 6 digits entered
            if (otpInput.value.length === 6) {
                verifyForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
