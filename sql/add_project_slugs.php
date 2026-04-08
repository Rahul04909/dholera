<?php
/**
 * Database Migration: Add Project Slugs
 * Dholera Smart City
 */
require_once 'database/db_config.php';

function createSlug($str) {
    if(!$str) return "";
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    return trim($str, '-');
}

try {
    // 1. Add slug column if it doesn't exist
    $conn->exec("ALTER TABLE projects ADD COLUMN IF NOT EXISTS slug VARCHAR(255) AFTER title");
    $conn->exec("ALTER TABLE projects ADD INDEX IF NOT EXISTS (slug)");
    
    echo "Slug column checked/added.<br>";

    // 2. Fetch projects without slugs or with empty slugs
    $stmt = $conn->query("SELECT id, title FROM projects WHERE slug IS NULL OR slug = ''");
    $projects = $stmt->fetchAll();

    foreach ($projects as $proj) {
        $slug = createSlug($proj['title']);
        
        // Ensure slug is unique
        $check = $conn->prepare("SELECT id FROM projects WHERE slug = ? AND id != ?");
        $check->execute([$slug, $proj['id']]);
        if ($check->rowCount() > 0) {
            $slug .= '-' . $proj['id'];
        }

        $update = $conn->prepare("UPDATE projects SET slug = ? WHERE id = ?");
        $update->execute([$slug, $proj['id']]);
        echo "Updated Project #{$proj['id']}: {$slug}<br>";
    }

    echo "Migration complete.";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
