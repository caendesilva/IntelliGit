<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class History extends Command
{
    /** @var string */
    protected $signature = 'history';

    /** @var string */
    protected $description = 'Show Git history';

    public function handle(): int
    {
        // Todo

        return Command::SUCCESS;
    }
}
