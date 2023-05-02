<?php

namespace Modernmcguire\Overwatch\Metrics;

use Modernmcguire\Overwatch\Metrics\Metric;

class LaravelVersion extends Metric
{
    public function handle()
    {
        return app()->version();
    }
}
