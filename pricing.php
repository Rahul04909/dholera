<?php
/**
 * Pricing Page
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
    }

    body {
        background-color: #fff;
        color: var(--text-dark);
        font-family: 'Outfit', sans-serif;
    }

    /* Pricing Hero */
    .pricing-hero {
        position: relative;
        height: 400px;
        background: url('assets/pricing-hero.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .pricing-hero::before {
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

    /* Padding for included component */
    .pricing-page-content {
        margin-top: -60px;
        position: relative;
        z-index: 20;
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 32px;
        }
    }
</style>

<main>
    <!-- Hero Section -->
    <div class="pricing-hero">
        <div class="hero-content">
            <h1>Our Subscription Plans</h1>
            <p>Transparent pricing specifically designed for Dholera real estate agents and developers. Choose the plan that fits your growth strategy.</p>
        </div>
    </div>

    <!-- Pricing Component -->
    <div class="pricing-page-content">
        <?php include 'components/subscription-plans.php'; ?>
    </div>
</main>

<?php include 'includes/main-footer.php'; ?>
