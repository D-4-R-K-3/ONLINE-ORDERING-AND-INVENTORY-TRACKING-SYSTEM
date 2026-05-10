<?php
// Create admin view subdirectories
$basePath = 'c:\xampp\htdocs\TA3-OOITS\app\Views\admin';

$directories = [
    'products',
    'inventory', 
    'orders',
    'reports'
];

foreach ($directories as $dir) {
    $fullPath = $basePath . '\\' . $dir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "Created: $fullPath\n";
    } else {
        echo "Already exists: $fullPath\n";
    }
}

echo "Directories created successfully\n";
?>
