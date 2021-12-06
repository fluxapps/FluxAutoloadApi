<?php

namespace FluxAutoloadApi;

require_once __DIR__ . "/Autoload/Autoload.php";
require_once __DIR__ . "/Adapter/Autoload/FileAutoload.php";
require_once __DIR__ . "/Adapter/Autoload/Psr4Autoload.php";
require_once __DIR__ . "/../libs/polyfill-php80/Php80.php";

use FluxAutoloadApi\Adapter\Autoload\ComposerAutoload;
use FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;

Psr4Autoload::new(
    [
        __NAMESPACE__ => __DIR__
    ]
)
    ->autoload();

ComposerAutoload::new(
    __DIR__ . "/../libs/polyfill-php80"
)
    ->autoload();
ComposerAutoload::new(
    __DIR__ . "/../libs/polyfill-php81"
)
    ->autoload();
