<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Autoload\Autoload;

class FileAutoload implements Autoload
{

    private readonly string $file;


    private function __construct(
        /*private readonly*/ string $file
    ) {
        $this->file = $file;
    }


    public static function new(
        string $file
    ) : static {
        return new static(
            $file
        );
    }


    public function autoload() : void
    {
        if (file_exists($this->file)) {
            require_once $this->file;
        }
    }
}
