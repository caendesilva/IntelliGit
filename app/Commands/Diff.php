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

    protected Git $git;

    public function handle(): int
    {
        $this->git = new Git(getcwd());

        if (! $this->git->isGitRepository()) {
            return $this->fatal('Not in a Git repository');
        }

        $this->git->passthru('git diff --color');

        return Command::SUCCESS;
    }
}
