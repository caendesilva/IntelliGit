<?php

namespace App\Commands;

use App\Git;
use App\Commands\Concerns\Command;

class Diff extends Command
{
    /** @var string */
    protected $signature = 'diff';

    /** @var string */
    protected $description = 'Show the files change in the working directory';

    public function handle(Git $git): int
    {
        if (! $git->isGitRepository()) {
            return $this->fatal('Not in a Git repository');
        }

        $diff = $git->exec('git diff --color');

        if (empty($diff)) {
            $this->info('No changes! Working tree clean.');
        } else {
            $this->line($diff);
        }

        return Command::SUCCESS;
    }
}
