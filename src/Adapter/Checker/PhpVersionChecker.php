<?php

namespace FluxAutoloadApi\Adapter\Checker;

use FluxAutoloadApi\Checker\Checker;
use Symfony\Polyfill\Php80\Php80;

class PhpVersionChecker implements Checker
{

    private string $name;
    private string $php_version;


    public static function new(string $php_version, string $name) : /*static*/ self
    {
        $handler = new static();

        $handler->php_version = $php_version;
        $handler->name = $name;

        return $handler;
    }


    public function check() : void
    {
        $php_version = $this->php_version;
        $operator = "";

        while (Php80::str_starts_with($php_version, "<") || Php80::str_starts_with($php_version, "=") || Php80::str_starts_with($php_version, ">")) {
            $operator .= substr($php_version, 0, 1);
            $php_version = substr($php_version, 1);
        }

        if (empty($php_version) || empty($operator)) {
            return;
        }

        if (!version_compare(PHP_VERSION, $php_version, $operator)) {
            die($this->name . " needs at least PHP " . $this->php_version);
        }
    }
}
