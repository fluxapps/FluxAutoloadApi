<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Autoload\Autoload;
use Symfony\Polyfill\Php80\Php80;

class Psr4Autoload implements Autoload
{

    private array $map;


    private function __construct(
        /*private readonly*/ array $map
    ) {
        $this->map = $map;
    }


    public static function new(
        array $map
    ) : /*static*/ self
    {
        return new static(
            $map
        );
    }


    public function autoload() : void
    {
        spl_autoload_register(function (string $class) : void {
            $this->autoloadClass(
                $class
            );
        });
    }


    private function autoloadClass(string $class) : void
    {
        foreach ($this->map as $namespace => $folder) {
            if (/*str_starts_with*/ Php80::str_starts_with($class, $namespace . "\\")) {
                FileAutoload::new(
                    $folder . str_replace("\\", "/", substr($class, strlen($namespace))) . ".php"
                )
                    ->autoload();
                break;
            }
        }
    }
}
