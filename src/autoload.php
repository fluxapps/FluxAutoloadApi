<?php

namespace FluxAutoloadApi;

require_once __DIR__ . "/Autoload/Autoload.php";
require_once __DIR__ . "/Adapter/Autoload/RequireAutoload.php";
require_once __DIR__ . "/Adapter/Autoload/Psr4Autoload.php";
require_once __DIR__ . "/../libs/polyfill-php80/Php80.php";

use FluxAutoloadApi\Adapter\Autoload\ComposerAutoload;
use FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;
use FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;

Psr4Autoload::new(
    [
        __NAMESPACE__ => __DIR__
    ]
)
    ->autoload();

PhpVersionChecker::new(
    ">=7.4",
    __NAMESPACE__
)
    ->check();
PhpExtChecker::new(
    [
        "json"
    ],
    __NAMESPACE__
)
    ->check();

ComposerAutoload::new(
    __DIR__ . "/../libs/polyfill-php80"
)
    ->autoload();
