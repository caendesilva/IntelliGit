<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Models\GitLogObject;
use Carbon\Carbon;
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

    /** @param  array<GitLogObject>  $rows */
    protected function displayHistory(array $rows): void
    {
        foreach ($rows as $row) {
            $message = "<fg=default>{$row->message}</>";
            $hash = "<fg=gray>{$row->hash}</>";
            $date = "<fg=gray>{$this->formatDate($row->date)}</>";

            $this->line($message);
            $this->line(implode(' ', [$date, $hash]));
        }
    }

    protected function formatDate(Carbon $date): string
    {
        if ($date->isToday()) {
            return str_pad($date->diffForHumans(), 19, ' ');
        }

        return $date->format('Y-m-d H:i:s');
    }
}
