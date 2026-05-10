<?php
/**
 * Online Ordering and Inventory System - Setup Script
 * Run this file by accessing: http://localhost/TA3-OOITS/public/setup.php
 */

$basePath = dirname(__DIR__);

// Create required directories
$dirs = [
    $basePath . '/app/Views/auth',
    $basePath . '/app/Views/admin',
    $basePath . '/app/Views/layouts',
    $basePath . '/app/Views/shop',
    $basePath . '/public/uploads/products',
];

echo "<h2>Setting up directories...</h2>";
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created: $dir<br>";
    } else {
        echo "Already exists: $dir<br>";
    }
}

echo "<h2>Setup Complete!</h2>";
echo "Next steps:<br>";
echo "1. Run the database_setup.sql file using phpMyAdmin or MySQL command line<br>";
echo "2. Or access the database migrations using: php spark migrate<br>";
echo "3. Then access the application at http://localhost/TA3-OOITS/public/<br>";
echo "<br><a href='/TA3-OOITS/public/'>Go to Application</a>";
?>
