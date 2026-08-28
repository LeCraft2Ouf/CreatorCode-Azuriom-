<?php

/**
 * Inserts the creator code box into Deluxe shop offer views (idempotent).
 *
 * Usage (from Azuriom root or this folder):
 *   php tools/patch-deluxe.php
 */

$pluginDir = dirname(__DIR__);
$azuriomRoot = dirname($pluginDir, 2);

if (! is_file($azuriomRoot.'/artisan')) {
    fwrite(STDERR, "Azuriom root not found (expected artisan next to plugins/).\n");
    exit(1);
}

$snippet = <<<'BLADE'

        @if(plugins()->isEnabled('creatorcodes'))
            @include('creatorcodes::shop.box')
        @endif

BLADE;

$files = [
    'resources/themes/deluxe/views/plugins/shop/designs/1/offers/payment.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/1/offers/select.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/2/offers/payment.blade.php',
    'resources/themes/deluxe/views/plugins/shop/designs/2/offers/select.blade.php',
    'plugins/shop/resources/views/offers/payment.blade.php',
    'plugins/shop/resources/views/offers/select.blade.php',
    'plugins/paysafecardmanual/resources/views/pay.blade.php',
];

$markers = [
    "{{ trans('shop::messages.offers.gateway') }}</h6>",
    "{{ trans('shop::messages.offers.amount') }}</h6>",
    "<div class=\"card-body center\">",
];

$patched = 0;
$skipped = 0;

foreach ($files as $relative) {
    $path = $azuriomRoot.'/'.$relative;

    if (! is_file($path)) {
        echo "missing  {$relative}\n";
        continue;
    }

    $contents = file_get_contents($path);

    if (str_contains($contents, 'creatorcodes::shop.box')) {
        echo "skip     {$relative}\n";
        $skipped++;
        continue;
    }

    $updated = null;

    foreach ($markers as $marker) {
        if (! str_contains($contents, $marker)) {
            continue;
        }

        $updated = preg_replace('/'.preg_quote($marker, '/').'/', $marker.$snippet, $contents, 1);
        break;
    }

    if ($updated === null || $updated === $contents) {
        echo "fail     {$relative} (marker not found)\n";
        continue;
    }

    file_put_contents($path, $updated);
    echo "patched  {$relative}\n";
    $patched++;
}

echo "done patched={$patched} skipped={$skipped}\n";
exit($patched > 0 || $skipped > 0 ? 0 : 1);
