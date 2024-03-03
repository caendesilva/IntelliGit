<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Models\GitLogObject;

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

        $this->table(['Hash', 'Date', 'Message'], array_map(
            fn (GitLogObject $commit): array => [$commit->hash, $commit->date, $commit->message],
            $commits
        ));

        return Command::SUCCESS;
    }

    protected function getCommits(): array
    {
        return $this->git->log();
    }
}
