<?php
/**
 * Stats Counter Component
 * Dholera Smart City
 */
?>
<style>
    .stats-section {
        padding: 80px 20px;
        background: radial-gradient(circle at top right, #0d2c44, #061622);
        color: #fff;
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
        position: relative;
    }

    .stats-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        opacity: 0.1;
        pointer-events: none;
    }

    .stats-container {
        max-width: 1300px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 30px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .stat-item {
        padding: 30px 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
    }

    .stat-item:hover {
        transform: translateY(-10px);
        background: rgba(184, 134, 11, 0.1);
        border-color: var(--primary-gold, #b8860b);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .stat-value {
        font-size: 42px;
        font-weight: 800;
        color: var(--primary-gold, #b8860b);
        margin-bottom: 10px;
        display: block;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        font-weight: 700;
        color: #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        line-height: 1.4;
    }

    /* Icon or suffix styling */
    .stat-suffix {
        font-size: 0.6em;
        margin-left: 2px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .stat-value { font-size: 36px; }
        .stats-container { gap: 20px; }
    }

    @media (max-width: 992px) {
        .stats-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-section { padding: 60px 20px; }
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
        .stat-item { padding: 40px 20px; }
        .stat-value { font-size: 48px; }
    }
</style>

<div class="stats-section">
    <div class="stats-container">
        <!-- 1: Land Area -->
        <div class="stat-item">
            <span class="stat-value counter" data-target="22">0</span>
            <span class="stat-label">LACS<br>SQ.YD. OF LAND</span>
        </div>

        <!-- 2: Countries -->
        <div class="stat-item">
            <span class="stat-value"><span class="counter" data-target="10">0</span><span class="stat-suffix">+</span></span>
            <span class="stat-label">COUNTRIES</span>
        </div>

        <!-- 3: States -->
        <div class="stat-item">
            <span class="stat-value counter" data-target="28">0</span>
            <span class="stat-label">STATES/UT</span>
        </div>

        <!-- 4: Cities -->
        <div class="stat-item">
            <span class="stat-value"><span class="counter" data-target="500">0</span><span class="stat-suffix">+</span></span>
            <span class="stat-label">CITIES</span>
        </div>

        <!-- 5: Happy Clients -->
        <div class="stat-item">
            <span class="stat-value"><span class="counter" data-target="10000">0</span><span class="stat-suffix">+</span></span>
            <span class="stat-label">HAPPY CLIENTS</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // The lower the slower

    const startCounter = (counter) => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText.replace(/,/g, '');

            // Lower inc means smoother and slower
            const inc = target / speed;

            if (count < target) {
                const nextVal = Math.ceil(count + inc);
                counter.innerText = nextVal > target ? target.toLocaleString() : nextVal.toLocaleString();
                setTimeout(updateCount, 15);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        updateCount();
    };

    // Intersection Observer to trigger animation when visible
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
