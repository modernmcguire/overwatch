<?php

namespace Modernmcguire\Overwatch\Metrics;

use Laravel\Horizon\Contracts\SupervisorRepository;
use Laravel\Horizon\Repositories\RedisMetricsRepository;
use Laravel\Horizon\WaitTimeCalculator;
use Modernmcguire\Overwatch\Repositories\OverwatchJobRepository;

class HorizonStats extends Metric
{
    public function handle()
    {
        $jobs = app(RedisMetricsRepository::class)->measuredJobs();
        $jobRuntime = [];

        foreach ($jobs as $job) {
            $jobRuntime[$job] = app(RedisMetricsRepository::class)->runtimeForJob($job);
        }

        $queues = app(RedisMetricsRepository::class)->measuredQueues();
        $queueRuntime = [];

        foreach ($queues as $queue) {
            $queueRuntime[$queue] = app(RedisMetricsRepository::class)->runtimeForQueue($queue);
        }

        $supervisors = app(SupervisorRepository::class)->all();

        $processCount = collect($supervisors)->reduce(function ($carry, $supervisor) {
            return $carry + collect($supervisor->processes)->sum();
        }, 0);

        return [
            'completed' => app(OverwatchJobRepository::class)->countJobsByType('completed_jobs'),
            'failed' => app(OverwatchJobRepository::class)->countJobsByType('failed_jobs'),
            'measured_jobs' => app(RedisMetricsRepository::class)->measuredJobs(),
            'job_runtime' => $jobRuntime,
            'measured_queues' => app(RedisMetricsRepository::class)->measuredQueues(),
            'queue_runtime' => $queueRuntime,
            'jobs_per_minute' => app(RedisMetricsRepository::class)->jobsProcessedPerMinute(),
            'processes' => $processCount,
            'max_wait' => collect(app(WaitTimeCalculator::class)->calculate())->take(1),
        ];
    }
}
