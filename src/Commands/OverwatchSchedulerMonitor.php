<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class OverwatchSchedulerMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overwatch:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor & report Laravel scheduler status back to the Mothership.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // We only need to report that the scheduler can run this command
        // If ran, that means the scheduler is active.
        Http::baseUrl(config('overwatch.mothership_url'))
            ->acceptJson()
            ->asJson()
            ->withOptions([
                'verify' => config('app.env') == 'production',
            ])
            ->post('/api/overwatch-monitor/'.config('overwatch.project_id'), [
                'site' => config('app.url'),
                'scheduler' => true,
            ]);
    }
}
