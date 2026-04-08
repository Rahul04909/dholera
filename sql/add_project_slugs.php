<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . '/database/db_config.php';

function createSlug($str)
{
    if (!$str)
        return "";
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    return trim($str, '-');
}

try {
    // 1. Check if slug column exists
    $check_col = $conn->query("SHOW COLUMNS FROM `projects` LIKE 'slug'");
    if ($check_col->rowCount() == 0) {
        $conn->exec("ALTER TABLE `projects` ADD `slug` VARCHAR(255) NULL AFTER `title` ");
        echo "Slug column added successfully.<br>";
    } else {
        echo "Slug column already exists.<br>";
    }

    // 2. Check if index exists
    $check_idx = $conn->query("SHOW INDEX FROM `projects` WHERE Key_name = 'projects_slug_idx'");
    if ($check_idx->rowCount() == 0) {
        // Try simple index add if possible
        try {
            $conn->exec("ALTER TABLE `projects` ADD INDEX `projects_slug_idx` (`slug`)");
            echo "Index added successfully.<br>";
        } catch (Exception $e) {
            echo "Note: Could not add index (it may already exist or have a different name). Continuing...<br>";
        }
    }

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