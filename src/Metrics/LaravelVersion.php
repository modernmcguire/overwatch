<?php

namespace Modernmcguire\Overwatch\Metrics;

class LaravelVersion extends Metric
{
    public function handle()
    {
        return app()->version();
    }
}
