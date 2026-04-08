<?php
require_once 'database/db_config.php';
include 'includes/header.php';
?>

<div style="padding: 100px 20px; text-align: center; background: #fff; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 600px;">
        <h1 style="font-size: 15vh; color: var(--primary-gold); font-weight: 900; margin: 0; line-height: 1;">404</h1>
        <h2 style="font-size: 32px; color: #333; margin-bottom: 20px; font-weight: 800;">Page Not Found</h2>
        <p style="font-size: 18px; color: #666; margin-bottom: 40px; line-height: 1.6;">Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo BASE_URL; ?>" style="background: var(--primary-gold); color: #fff; text-decoration: none; padding: 15px 40px; border-radius: 4px; font-weight: 700; text-transform: uppercase; transition: transform 0.3s ease; box-shadow: 0 4px 15px rgba(184, 134, 11, 0.3);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                Back to Home
            </a>
            <a href="<?php echo BASE_URL; ?>contact.php" style="background: #333; color: #fff; text-decoration: none; padding: 15px 40px; border-radius: 4px; font-weight: 700; text-transform: uppercase; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                Contact Support
            </a>
        </div>

        <div style="margin-top: 60px;">
            <p style="color: #999; font-size: 14px;">Looking for something else? Try our <a href="<?php echo BASE_URL; ?>#projects" style="color: var(--primary-gold); font-weight: 600;">Projects</a> or <a href="<?php echo BASE_URL; ?>about.php" style="color: var(--primary-gold); font-weight: 600;">About Us</a> page.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
