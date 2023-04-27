<?php

namespace Modernmcguire\Overwatch\Metrics;

class PhpVersion
{
    const KEY = 'php_version';

    public function handle()
    {
        return phpversion();
    }
}
