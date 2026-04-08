<?php
/**
 * Dynamic Sitemap Generator
 * Dholera Smart City
 */
require_once 'database/db_config.php';

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

// 1. Static Pages
$static_pages = [
    '',
    'about.php',
    'contact.php',
    'pricing.php',
    'register.php'
];

foreach ($static_pages as $page) {
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . BASE_URL . $page . '</loc>' . PHP_EOL;
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . PHP_EOL;
    echo '    <changefreq>weekly</changefreq>' . PHP_EOL;
    echo '    <priority>' . ($page === '' ? '1.0' : '0.8') . '</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;
}

// 2. Dynamic Projects
try {
    $stmt = $conn->query("SELECT slug, updated_at FROM projects WHERE status = 'active' ORDER BY updated_at DESC");
    while ($row = $stmt->fetch()) {
        $slug = $row['slug'] ? $row['slug'] : 'details.php?id=' . $row['id']; // Fallback
        $lastmod = date('Y-m-d', strtotime($row['updated_at']));
        
        echo '  <url>' . PHP_EOL;
        echo '    <loc>' . BASE_URL . 'project/' . $slug . '</loc>' . PHP_EOL;
        echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        echo '    <changefreq>monthly</changefreq>' . PHP_EOL;
        echo '    <priority>0.7</priority>' . PHP_EOL;
        echo '  </url>' . PHP_EOL;
    }
} catch (PDOException $e) {
    // Silence error for XML integrity
}

echo '</urlset>';
?>
