<?php

namespace Modernmcguire\Overwatch;

class Overwatch
{

    public function index()
    {
        $configs = config('overwatch.metrics');

        foreach ($configs as $config) {
            $class = new $config;
            $class->handle();
        }
    }
}
