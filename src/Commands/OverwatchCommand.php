<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;

class OverwatchCommand extends Command
{
    public $signature = 'overwatch make:secret';

    public $description = 'My command';

    public function handle(): int
    {
        $key = Encrypter::generateKey(Config::get('app.cipher'));
        config(['overwatch.secret' => $key]);

        $this->comment('Generated secret: ' . $key);

        return self::SUCCESS;
    }
}
