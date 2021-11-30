<?php

namespace FluxAutoloadApi\Checker;

interface Checker
{

    public function check() : bool;


    public function checkAndDie(string $name) : void;
}
