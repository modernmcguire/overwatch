<?php

namespace Modernmcguire\Overwatch\Metrics;

class PhpVersion extends Metric
{
    public function handle()
    {
        return phpversion();
    }
}
