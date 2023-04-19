<?php

namespace Modernmcguire\Overwatch\Commands;

use Illuminate\Console\Command;

class OverwatchCommand extends Command
{
    public $signature = 'overwatch';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
