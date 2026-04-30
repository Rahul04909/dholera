<?php
/**
 * Image Optimizer Script
 * Uses Intervention Image to optimize images in the project.
 */

require 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());

function optimizeDirectory($dir, $manager) {
    if (!is_dir($dir)) return;

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $file;

        if (is_dir($path)) {
            optimizeDirectory($path, $manager);
        } else {
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                try {
                    $image = $manager->read($path);
                    
                    // Resize if too large (e.g., max width 1200px)
                    if ($image->width() > 1200) {
                        $image->scale(width: 1200);
                    }

                    // Save with optimization
                    if ($extension === 'png') {
                        // PNG optimization is tricky with GD, but we can try to reduce colors or just save
                        $image->save($path); 
                    } else {
                        $image->save($path, quality: 75);
                    }
                    echo "Optimized: $path\n";
                } catch (Exception $e) {
                    echo "Error optimizing $path: " . $e->getMessage() . "\n";
                }
            }
        }
    }
}

echo "Starting optimization...\n";
optimizeDirectory('assets/images', $manager);
optimizeDirectory('uploads', $manager);
echo "Optimization complete.\n";
