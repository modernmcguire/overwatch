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
        $secret = 'base64:' . base64_encode(Encrypter::generateKey(config('app.cipher')));
        self::setEnv('OVERWATCH_SECRET', $secret);
        config(['overwatch.secret' => $secret]);
        Artisan::call('config:cache');
    }

    static public function setEnv(string $key, string $value): void
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $configKey = Str::replace('_', '.', strtolower($key));
            if (strpos(file_get_contents($path), $key) !== false) {
                file_put_contents($path, str_replace(
                    $key . '=' . config($configKey),
                    $key . '=' . $value,
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path) . "\n" . $key . '=' . $value);
            }
        }
    }
}
