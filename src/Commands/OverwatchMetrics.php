<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Modernmcguire\Overwatch\Overwatch;

class OverwatchMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overwatch:metrics {--json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run your Overwatch metrics locally.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // check if the secret is set
        if (config('overwatch.secret') == null) {
            $this->error('Missing secret.');

            return;
        }

        // check if the metrics are set
        if (config('overwatch.metrics') == null) {
            $this->error('Missing metrics.');

            return;
        }

        // run the metrics
        $results = Overwatch::run();

        // output the results
        if($this->option('json')) {
            $this->line(json_encode($results));
        } else {
            $this->table(
                ['Metric', 'Value'],
                collect($results)->map(function ($value, $key) {
                    if(is_array($value)) {
                        $value = json_encode($value);
                    }

                    return [$key, $value];
                })
            );
        }
    }
}
