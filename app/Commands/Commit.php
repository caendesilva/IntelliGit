<?php

namespace App\Commands;

use App\Commands\Concerns\Command;

class Commit extends Command
{
    /** @var string */
    protected $signature = 'commit';

    /** @var string */
    protected $description = 'Create a new commit';

    public function handle(): int
    {
        // TODO: Implement handle() method.

        return Command::SUCCESS;
    }
}
