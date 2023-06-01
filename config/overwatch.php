<?php

use Modernmcguire\Overwatch\Metrics\HorizonFailedJobs;
use Modernmcguire\Overwatch\Metrics\HorizonStats;
use Modernmcguire\Overwatch\Metrics\LaravelVersion;
use Modernmcguire\Overwatch\Metrics\PhpVersion;

return [

    'secret' => env('OVERWATCH_SECRET'),

    'metrics' => [
        PhpVersion::class,
        LaravelVersion::class,
    ],

    'horizon' => [
        HorizonStats::class,
        HorizonFailedJobs::class,
    ],

    'mothership_url' => env('OVERWATCH_MOTHERSHIP_URL'),
    'project_id' => env('OVERWATCH_PROJECT_ID'),
];
