<?php

namespace App\Commands;

use App\Commands\Concerns\Command;

class History extends Command
{
    /** @var string */
    protected $signature = 'history';

    /** @var string */
    protected $description = 'Show Git history';

    public function handle(): int
    {
        if (! $this->git->isGitRepository()) {
            return $this->fatal('Not in a Git repository');
        }

        $commits = $this->getCommits();

        return Command::SUCCESS;
    }

    protected function getCommits(): array
    {
        $commits = $this->git->log();

        $this->table(['hash', 'date', 'message'], $commits);

        return $commits;
    }
}
