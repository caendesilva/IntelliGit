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
            $this->error('Fatal: Not in a Git repository');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
