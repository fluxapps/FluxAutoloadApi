<?php

namespace FluxAutoloadApi\Adapter\Autoload;

class PhpExtChecker
{

    private array $ext;
    private string $name;


    public static function new(array $ext, string $name) : /*static*/ self
    {
        $handler = new static();

        $handler->ext = $ext;
        $handler->name = $name;

        return $handler;
    }


    public function check() : void
    {
        foreach ($this->ext as $ext) {
            if (!extension_loaded($ext)) {
                die(__NAMESPACE__ . " needs PHP ext " . $ext);
            }
        }
    }
}
