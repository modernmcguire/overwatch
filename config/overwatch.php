<?php

use Modernmcguire\Overwatch\Metrics\LaravelVersion;
use Modernmcguire\Overwatch\Metrics\PhpVersion;

return [
    'metrics' => [
        PhpVersion::class,
        LaravelVersion::class,
    ],
];
