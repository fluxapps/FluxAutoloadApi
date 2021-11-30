<?php

namespace FluxAutoloadApi\Adapter\Checker;

use FluxAutoloadApi\Checker\Checker;

class PhpExtChecker implements Checker
{

    private array $ext;


    public static function new(array $ext) : /*static*/ self
    {
        $handler = new static();

        $handler->ext = $ext;

        return $handler;
    }


    public function check() : bool
    {
        foreach ($this->ext as $ext) {
            if (!$this->checkExt($ext)) {
                return false;
            }
        }

        return true;
    }


    public function checkAndDie(string $name) : void
    {
        foreach ($this->ext as $ext) {
            if (!$this->checkExt($ext)) {
                die($name . " needs PHP ext " . $ext);
            }
        }
    }


    private function checkExt(string $ext) : bool
    {
        return extension_loaded($ext);
    }
}
