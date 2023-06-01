<?php

namespace Modernmcguire\Overwatch\Metrics;

use Carbon\Carbon;
use Modernmcguire\Overwatch\Repositories\OverwatchJobRepository;

class HorizonFailedJobs extends Metric
{
    public function handle()
    {
        $failedJobs = app(OverwatchJobRepository::class)->getFailed();

        $failedInLastHour = $failedJobs->filter(function($job) {
            return Carbon::parse($job->failed_at) >= now()->subHour();
        });

        return $failedInLastHour;
    }
}
