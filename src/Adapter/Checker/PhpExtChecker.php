<?php

namespace FluxAutoloadApi\Adapter\Checker;

use FluxAutoloadApi\Checker\Checker;

class PhpExtChecker implements Checker
{

    /**
     * @var string[]
     */
    private array $ext;


    /**
     * @param string[] $ext
     */
    private function __construct(
        /*private readonly*/ array $ext
    ) {
        $this->ext = $ext;
    }


    /**
     * @param string[] $ext
     */
    public static function new(
        array $ext
    ) : /*static*/ self
    {
        return new static(
            $ext
        );
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
