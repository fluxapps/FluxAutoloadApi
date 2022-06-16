<?php

namespace FluxAutoloadApi\Adapter\Autoload;

use FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;
use FluxAutoloadApi\Autoload\Autoload;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Polyfill\Php80\Php80;

class ComposerAutoload implements Autoload
{

    private function __construct(
        private readonly string $folder
    ) {

    }


    public static function new(
        string $folder
    ) : static {
        return new static(
            $folder
        );
    }


    public function autoload() : void
    {
        if (file_exists($autoload_php_file = $this->folder . "/vendor/autoload.php")) {
            FileAutoload::new(
                $autoload_php_file
            )
                ->autoload();

            return;
        }

        if (!file_exists($composer_json_file = $this->folder . "/composer.json")) {
            return;
        }

        $composer = json_decode(file_get_contents($composer_json_file)) ?? (object) [];

        $config = $composer->config ?? (object) [];
        if (!empty($vendor_dir = $config->{"vendor-dir"} ?? null) && file_exists($autoload_php_file = $this->folder . "/" . $vendor_dir . "/autoload.php")) {
            FileAutoload::new(
                $autoload_php_file
            )
                ->autoload();

            return;
        }

        $autoload = $composer->autoload ?? (object) [];
        $require = $composer->require ?? (object) [];
        $psr4 = $autoload->{"psr-4"} ?? (object) [];

        PhpVersionChecker::new(
            $require->php ?? ""
        )
            ->checkAndDie(
                $this->folder
            );

        PhpExtChecker::new(
            array_map(fn(string $require) : string => substr($require, 4),
                array_filter(array_keys((array) $require), fn(string $require) : bool => /*str_starts_with*/ Php80::str_starts_with($require, "ext-")))
        )
            ->checkAndDie(
                $this->folder
            );

        Psr4Autoload::new(
            array_combine(array_map(fn(string $namespace) : string => rtrim($namespace, "\\"), array_keys((array) $psr4)),
                array_map(fn(string $folder) : string => $this->folder . "/" . $folder, array_values((array) $psr4)))
        )
            ->autoload();

        foreach ($autoload->classmap ?? [] as $folder) {
            if (!file_exists($folder = $this->folder . "/" . $folder)) {
                continue;
            }

            if (is_file($folder)) {
                FileAutoload::new(
                    $folder
                )
                    ->autoload();
            } else {
                foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
                    if (!$file->isFile()) {
                        continue;
                    }

                    if (!/*str_ends_with*/Php80::str_ends_with($file->getPathName(), ".php")) {
                        continue;
                    }

                    FileAutoload::new(
                        $file->getPathName()
                    )
                        ->autoload();
                }
            }
        }

        foreach ($autoload->files ?? [] as $file) {
            FileAutoload::new(
                $this->folder . "/" . $file
            )
                ->autoload();
        }
    }
}
