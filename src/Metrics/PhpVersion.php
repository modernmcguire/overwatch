<?php

namespace Modernmcguire\Overwatch\Metrics;

use Modernmcguire\Overwatch\Metrics\Metric;

class PhpVersion extends Metric
{
    public function handle()
    {
        return phpversion();
    }
}
