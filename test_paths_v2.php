<?php
// Test script for NEW robust BASE_URL logic
$project_root = str_replace('\\', '/', dirname(__DIR__));
$current_script_phys = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
$current_script_web = $_SERVER['SCRIPT_NAME'];

$relative_path = str_replace($project_root . '/', '', $current_script_phys);
$base_dir = str_replace($relative_path, '', $current_script_web);
$base_dir = rtrim($base_dir, '/');
if ($base_dir == '/') $base_dir = '';

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $base_dir . "/";

echo "Project Root Phys: $project_root\n";
echo "Current Script Phys: $current_script_phys\n";
echo "Current Script Web: $current_script_web\n";
echo "Relative Path: $relative_path\n";
echo "Base Dir: $base_dir\n";
echo "Base URL: $base_url\n";
?>
