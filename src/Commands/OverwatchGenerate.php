<?php

namespace Modernmcguire\Overwatch\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class OverwatchGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overwatch:generate {--no-env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new overwatch secret';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $secret = 'base64:'.base64_encode(Encrypter::generateKey(config('app.cipher')));

        // only add to env if the no-env option isn't set
        if(!$this->option('no-env')) {
            $this->addToEnv($secret);
            $this->info('Overwatch secret added to .env: '.$secret);
        } else {
            $this->info('Overwatch secret: '.$secret);
        }
    }

    public function addToEnv(string $value): void
    {
        $key = 'OVERWATCH_SECRET';
        $path = base_path('.env');

        if (file_exists($path)) {
            if (strpos(file_get_contents($path), $key) !== false) {
                file_put_contents($path, str_replace(
                    $key.'='.config('overwatch.secret'),
                    $key.'='.$value,
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path)."\n".$key.'='.$value);
            }
        }
    }
}
