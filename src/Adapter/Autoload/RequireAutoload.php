<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Autoload\Autoload;

class RequireAutoload implements Autoload
{

    private string $file;


    public static function new(string $file) : /*static*/ self
    {
        $handler = new static();

        $handler->file = $file;

        return $handler;
    }


    public function autoload() : void
    {
        if (file_exists($this->file)) {
            require_once $this->file;
        }
    }
}
