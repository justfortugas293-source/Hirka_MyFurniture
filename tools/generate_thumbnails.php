<?php
// Simple image thumbnail + webp generator for public/img
// Usage: php tools/generate_thumbnails.php

$sourceDir = __DIR__ . '/../public/img';
$thumbDir = $sourceDir . '/thumbs';
$webpDir = $sourceDir . '/webp';
$thumbWidth = 400; // px

if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);
if (!is_dir($webpDir)) mkdir($webpDir, 0755, true);

$files = glob($sourceDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
foreach ($files as $file) {
    $base = basename($file);
    echo "Processing $base...\n";
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // create thumbnail
    list($w, $h) = getimagesize($file);
    $ratio = $w / $h;
    $newW = $thumbWidth;
    $newH = (int)($thumbWidth / $ratio);

    // create source image
    switch ($ext) {
        case 'jpg': case 'jpeg': $src = imagecreatefromjpeg($file); break;
        case 'png': $src = imagecreatefrompng($file); break;
        case 'gif': $src = imagecreatefromgif($file); break;
        default: $src = null; break;
    }
    if (!$src) {
        echo "  skip: unsupported format\n";
        continue;
    }

    $thumb = imagecreatetruecolor($newW, $newH);
    // preserve PNG transparency
    if ($ext === 'png') {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
        imagefilledrectangle($thumb, 0, 0, $newW, $newH, $transparent);
    }

    imagecopyresampled($thumb, $src, 0,0,0,0, $newW, $newH, $w, $h);

    $thumbPath = $thumbDir . '/' . $base;
    if ($ext === 'png') {
        imagepng($thumb, $thumbPath, 6);
    } else {
        imagejpeg($thumb, $thumbPath, 82);
    }

    // try to output webp if supported
    $webpPath = $webpDir . '/' . pathinfo($base, PATHINFO_FILENAME) . '.webp';
    if (function_exists('imagewebp')) {
        // create a webp from original resized to original size (or create from thumb)
        imagewebp($thumb, $webpPath, 80);
    }

    imagedestroy($src);
    imagedestroy($thumb);
    echo "  done\n";
}

echo "All done. Thumbnails in public/img/thumbs and webp in public/img/webp (if supported).\n";
