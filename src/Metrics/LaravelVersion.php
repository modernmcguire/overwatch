<?php

namespace Modernmcguire\Overwatch\Metrics;

class LaravelVersion
{
    public const KEY = 'laravel_version';

    public function handle()
    {
        return app()->version();
    }
}
