<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class OverwatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overwatch';

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
        $key = Encrypter::generateKey(config('app.cipher'));
        config(['overwatch.secret' => $key]);
        self::setEnv('OVERWATCH_SECRET', $key);
        Artisan::command('config:cache');
    }

    static public function setEnv(string $key, string $value): void
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $configKey = Str::replace('_', '.', strtolower($key));
            file_put_contents($path, str_replace(
                $key . '=' . config($configKey),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
