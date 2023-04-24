<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class OverwatchCommand extends Command
{
    public $signature = 'overwatch make:secret';

    public $description = 'My command';

    public function handle(): int
    {
        $key = Encrypter::generateKey(Config::get('app.cipher'));
        config(['overwatch.secret' => $key]);

        // Save the configuration to a file
        Artisan::call('config:cache');

        $this->comment('Generated secret: '.$key);

        return self::SUCCESS;
    }
}
