<?php

namespace Modernmcguire\Overwatch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Modernmcguire\Overwatch\Overwatch
 */
class Overwatch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Modernmcguire\Overwatch\Overwatch::class;
    }
}
