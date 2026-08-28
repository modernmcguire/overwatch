<?php

namespace Modernmcguire\Overwatch\Tests\Fixtures;

use Modernmcguire\Overwatch\Metrics\Metric;

class TotalUsers extends Metric
{
    const KEY = 'app_users';

    public function handle()
    {
        return 10;
    }
}
