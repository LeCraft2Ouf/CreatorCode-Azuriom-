<?php

/**
 * Removes previous Deluxe/shop Blade includes (no longer needed).
 */

$pluginDir = dirname(__DIR__);
$azuriomRoot = dirname($pluginDir, 2);

if (! is_file($azuriomRoot.'/artisan')) {
    fwrite(STDERR, "Azuriom root not found.\n");
    exit(1);
}

$files = [
    'resources/themes/deluxe/views/plugins/shop/designs/1/offers/payment.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/1/offers/select.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/2/offers/payment.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/2/offers/select.blade.php',
    'plugins/shop/resources/views/offers/payment.blade.php',
    'plugins/shop/resources/views/offers/select.blade.php',
    'plugins/paysafecardmanual/resources/views/pay.blade.php',
];

$pattern = '/\s*@if\(plugins\(\)->isEnabled\(\'creatorcodes\'\)\)\s*@include\(\'creatorcodes::shop\.box\'\)\s*@endif\s*/';
$wrapper = '/\s*<div class="mt-3">\s*@if\(plugins\(\)->isEnabled\(\'creatorcodes\'\)\)\s*@include\(\'creatorcodes::shop\.box\'\)\s*@endif\s*<\/div>\s*/';

foreach ($files as $relative) {
    $path = $azuriomRoot.'/'.$relative;

    if (! is_file($path)) {
        continue;
    }

    $contents = file_get_contents($path);

    if (! str_contains($contents, 'creatorcodes::shop.box')) {
        echo "ok       {$relative}\n";
        continue;
    }

    $updated = preg_replace($wrapper, "\n", $contents);
    $updated = preg_replace($pattern, "\n", $updated);

    file_put_contents($path, $updated);
    echo "reverted {$relative}\n";
}

echo "done\n";
