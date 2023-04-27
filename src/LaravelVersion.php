<?php

namespace Modernmcguire\Overwatch;

class LaravelVersion
{
    const KEY = 'laravel_version';

    public function handle(): array
    {
        return [
            'data' => app()->version(),
            'message' => 'Success',
            'code' => 200,
        ];
    }
}
