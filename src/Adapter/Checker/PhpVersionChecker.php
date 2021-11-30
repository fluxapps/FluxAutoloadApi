<?php

namespace FluxAutoloadApi\Adapter\Checker;

use FluxAutoloadApi\Checker\Checker;

class PhpVersionChecker implements Checker
{

    private string $php_version;


    public static function new(string $php_version) : /*static*/ self
    {
        $handler = new static();

        $handler->php_version = $php_version;

        return $handler;
    }


    public function check() : bool
    {
        $php_version = $this->php_version;
        $operator = "";

        while (in_array($php_version[0] ?? "", ["<", "=", ">", "^"])) {
            $operator_ = substr($php_version, 0, 1);
            if ($operator_ === "^") {
                $operator_ = ">=";
            }
            $operator .= $operator_;
            $php_version = substr($php_version, 1);
        }

        if (empty($php_version) || empty($operator)) {
            return false;
        }

        return version_compare(PHP_VERSION, $php_version, $operator);
    }


    public function checkAndDie(string $name) : void
    {
        if (!$this->check()) {
            die($name . " needs at least PHP " . $this->php_version);
        }
    }
}
