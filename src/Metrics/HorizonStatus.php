<?php

namespace Modernmcguire\Overwatch\Metrics;

use Laravel\Horizon\WaitTimeCalculator;
use Laravel\Horizon\Contracts\SupervisorRepository;
use Laravel\Horizon\Repositories\RedisMetricsRepository;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Modernmcguire\Overwatch\Repositories\OverwatchJobRepository;

class HorizonStatus extends Metric
{
    public function handle()
    {
        if (! $masters = app(MasterSupervisorRepository::class)->all()) {
            return [
                'status' => 'inactive',
            ];
        }

        $status = collect($masters)->every(function ($master) {
            return $master->status === 'paused';
        }) ? 'paused' : 'running';

        return [
            'status' => $status,
        ];
    }
}
