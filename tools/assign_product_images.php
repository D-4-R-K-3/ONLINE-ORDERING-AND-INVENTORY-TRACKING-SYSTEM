<?php
// Simple script to generate transparent HD SVG placeholders and assign them
// to products that have no image. Run from project root: php tools/assign_product_images.php

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'online_ordering';
$dbPort = 3306;

$uploadsDir = __DIR__ . '/../public/uploads/products';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
if ($mysqli->connect_errno) {
    echo "DB connect failed: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}

$res = $mysqli->query("SELECT id, name, image FROM products ORDER BY id ASC");
if (!$res) {
    echo "Query failed: " . $mysqli->error . PHP_EOL;
    exit(1);
}

$updated = 0;
while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $name = $row['name'] ?: 'Product';
    $image = $row['image'];

    if ($image && trim($image) !== '') {
        echo "Skipping product {$id} (already has image: {$image})\n";
        continue;
    }

    $safe = preg_replace('/[^A-Za-z0-9\- ]/', '', $name);
    $safe = substr(str_replace(' ', '-', strtolower($safe)), 0, 40);
    $filename = "aurea-product-{$id}-{$safe}.svg";
    $filepath = $uploadsDir . '/' . $filename;

    // Generate simple HD (1400x1400) transparent SVG with centered icon + name
    $svg = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $svg .= '<svg xmlns="http://www.w3.org/2000/svg" width="1400" height="1400" viewBox="0 0 1400 1400" role="img" aria-label="'.htmlspecialchars($name).'">';
    $svg .= '<defs><linearGradient id="g" x1="0" x2="1"><stop offset="0%" stop-color="#f09a65" stop-opacity="0.95"/><stop offset="100%" stop-color="#73bfab" stop-opacity="0.95"/></linearGradient></defs>';
    $svg .= '<rect width="100%" height="100%" fill="none"/>';
    $svg .= '<g transform="translate(700,500)">';
    $svg .= '<circle cx="0" cy="0" r="300" fill="url(#g)" opacity="0.95" />';
    $svg .= '<g transform="translate(-30,10)"><path fill="#fff" d="M-60-20 L60-20 L0 80 Z"/></g>'; // simple triangle mark
    $svg .= '</g>';
    $svg .= '<text x="50%" y="92%" text-anchor="middle" fill="#333" font-family="Helvetica, Arial, sans-serif" font-size="44">'.htmlspecialchars($name).'</text>';
    $svg .= '</svg>';

    file_put_contents($filepath, $svg);

    // Update DB
    $stmt = $mysqli->prepare("UPDATE products SET image = ? WHERE id = ?");
    $stmt->bind_param('si', $filename, $id);
    if ($stmt->execute()) {
        echo "Assigned image {$filename} to product {$id}\n";
        $updated++;
    } else {
        echo "Failed to update product {$id}: " . $stmt->error . PHP_EOL;
    }
}

echo "Done. Images assigned: {$updated}\n";

$mysqli->close();

?>
