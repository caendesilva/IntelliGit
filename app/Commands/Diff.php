<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Diff extends Command
{
    /** @var string */
    protected $signature = 'diff';

    /** @var string */
    protected $description = 'Show the files change in the working directory';

    public function handle(): int
    {
        // Todo

        return Command::SUCCESS;
    }
}
