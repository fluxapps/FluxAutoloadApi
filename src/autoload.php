<?php

namespace FluxAutoloadApi;

require_once __DIR__ . "/Autoload/Autoload.php";
require_once __DIR__ . "/Adapter/Autoload/FileAutoload.php";
require_once __DIR__ . "/Adapter/Autoload/Psr4Autoload.php";

use FluxAutoloadApi\Adapter\Autoload\ComposerAutoload;
use FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;
use FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;
use Symfony\Polyfill\Php80\Php80;
use Symfony\Polyfill\Php81\Php81;

$polyfill_php80_autoload = false;
if (!class_exists(Php80::class)) {
    $polyfill_php80_autoload = true;
    require_once __DIR__ . "/../libs/polyfill-php80/Php80.php";
}

Psr4Autoload::new(
    [
        __NAMESPACE__ => __DIR__
    ]
)
    ->autoload();

PhpVersionChecker::new(
    ">=8.1"
)
    ->checkAndDie(
        __NAMESPACE__
    );
PhpExtChecker::new(
    [
        "json"
    ]
)
    ->checkAndDie(
        __NAMESPACE__
    );

if ($polyfill_php80_autoload) {
    ComposerAutoload::new(
        __DIR__ . "/../libs/polyfill-php80"
    )
        ->autoload();
}
unset($polyfill_php80_autoload);

if (!class_exists(Php81::class)) {
    ComposerAutoload::new(
        __DIR__ . "/../libs/polyfill-php81"
    )
        ->autoload();
}
