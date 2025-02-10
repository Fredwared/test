<?php

namespace App\Actions\Core;

abstract class CoreAction
{
    abstract public function execute(...$args): mixed;
}
