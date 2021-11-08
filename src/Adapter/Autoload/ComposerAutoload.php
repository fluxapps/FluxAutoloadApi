<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;
use FluxAutoloadApi\Autoload\Autoload;
use Symfony\Polyfill\Php80\Php80;

class ComposerAutoload implements Autoload
{

    private string $folder;


    public static function new(string $folder) : /*static*/ self
    {
        $handler = new static();

        $handler->folder = $folder;

        return $handler;
    }


    public function autoload() : void
    {
        if (file_exists($autoload_php_file = $this->folder . "/vendor/autoload.php")) {
            require_once $autoload_php_file;

            return;
        }

        if (!file_exists($composer_json_file = $this->folder . "/composer.json")) {
            return;
        }

        $composer = json_decode(file_get_contents($composer_json_file)) ?? (object) [];

        $config = $composer->config ?? (object) [];
        if (!empty($vendor_dir = $config->{"vendor-dir"} ?? null) && file_exists($autoload_php_file = $this->folder . "/" . $vendor_dir . "/autoload.php")) {
            require_once $autoload_php_file;

            return;
        }

        $autoload = $composer->autoload ?? (object) [];
        $require = $composer->require ?? (object) [];
        $psr4 = $autoload->{"psr-4"} ?? (object) [];

        PhpVersionChecker::new(
            $require->php ?? "",
            $this->folder
        )
            ->check();

        PhpExtChecker::new(array_map(fn(string $require) : string => substr($require, 4),
            array_filter(array_keys((array) $require), fn(string $require) : bool => /*str_starts_with*/ Php80::str_starts_with($require, "ext-"))),
            $this->folder
        )
            ->check();

        Psr4Autoload::new(
            array_combine(array_map(fn(string $namespace) : string => rtrim($namespace, "\\"), array_keys((array) $psr4)),
                array_map(fn(string $folder) : string => $this->folder . "/" . $folder, array_values((array) $psr4)))
        )
            ->autoload();

        foreach ($autoload->files ?? [] as $file) {
            if (file_exists($autoload_php_file = $this->folder . "/" . $file)) {
                require_once $autoload_php_file;
            }
        }
    }
}
