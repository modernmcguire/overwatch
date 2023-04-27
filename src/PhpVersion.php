<?php

namespace Modernmcguire\Overwatch;

class PhpVersion
{
    const KEY = 'php_version';

    public function handle(): array
    {
        return [
            'data' => phpversion(),
            'message' => 'Success',
            'code' => 200,
        ];
    }
}
