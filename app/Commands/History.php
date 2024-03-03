<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Models\GitLogObject;
use Illuminate\Support\Collection;

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

        $this->displayHistory($commits->take(44)->toArray());

        return Command::SUCCESS;
    }

    protected function getCommits(): Collection
    {
        return collect($this->git->log());
    }

    protected function displayHistory(array $rows): void
    {
        $this->table(['Hash', 'Date', 'Message'], array_map(
            fn (GitLogObject $commit): array => [
                $commit->date,
                $commit->hash,
                $commit->message,
            ],
            $rows
        ));
    }
}
