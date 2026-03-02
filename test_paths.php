<?php
// Test script for BASE_URL logic
$project_root = str_replace('\\', '/', dirname(__DIR__));
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$base_dir = str_replace($doc_root, '', $project_root);
$base_dir = '/' . trim($base_dir, '/');
if ($base_dir == '/') $base_dir = '';

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $base_dir . "/";

echo "Project Root: $project_root\n";
echo "Doc Root: $doc_root\n";
echo "Base Dir: $base_dir\n";
echo "Base URL: $base_url\n";
?>
