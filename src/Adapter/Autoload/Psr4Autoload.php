<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Autoload\Autoload;

class Psr4Autoload implements Autoload
{

    /**
     * @param string[] $map
     */
    private function __construct(
        private readonly array $map
    ) {

    }


    /**
     * @param string[] $map
     */
    public static function new(
        array $map
    ) : static {
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
            if (str_starts_with($class, $namespace . "\\")) {
                FileAutoload::new(
                    $folder . str_replace("\\", "/", substr($class, strlen($namespace))) . ".php"
                )
                    ->autoload();
                break;
            }
        }
    }
}
