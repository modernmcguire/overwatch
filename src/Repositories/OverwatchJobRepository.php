<?php

namespace Modernmcguire\Overwatch\Repositories;

use Carbon\CarbonImmutable;
use Laravel\Horizon\Repositories\RedisJobRepository;

class OverwatchJobRepository extends RedisJobRepository
{
    // Override Horizon method so we can get Failed jobs by the hour, not from the last 7 days.
    public function countJobsByType($type, $minutes = 60)
    {
        return $this->connection()->zcount(
            $type, '-inf', CarbonImmutable::now()->subMinutes($minutes)->getTimestamp() * -1
        );
    }
}
