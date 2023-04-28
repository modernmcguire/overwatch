<?php

use Modernmcguire\Overwatch\Metrics\LaravelVersion;
use Modernmcguire\Overwatch\Metrics\PhpVersion;

return [
    'secret' => env('OVERWATCH_SECRET'),
    'metrics' => [
        PhpVersion::class,
        LaravelVersion::class,
    ],
];
