<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Git;

class History extends Command
{
    /** @var string */
    protected $signature = 'history';

    /** @var string */
    protected $description = 'Show Git history';

    public function handle(Git $git): int
    {
        if (! $git->isGitRepository()) {
            return $this->fatal('Not in a Git repository');
        }

        return Command::SUCCESS;
    }
}
