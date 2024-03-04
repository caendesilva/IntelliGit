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

        $limit = 44;
        $this->displayHistory($commits->take($limit)->toArray());

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
            $message = "<fg=default>{$this->formatMessage($row->message)}</>";
            $hash = "<fg=gray>{$this->formatHash($row->hash)}</>";
            $date = "<fg=gray>{$this->formatDate($row->date)}</>";

            $this->line("$message $date $hash");
        }
    }

    protected function formatMessage(string $message): string
    {
        return $message;
    }

    protected function formatHash(string $hash): string
    {
        return substr($hash, 0, $this->git->getCoreAbbrev());
    }

    protected function formatDate(Carbon $date): string
    {
        if ($date->isToday()) {
            return str_pad($date->diffForHumans(), 19, ' ');
        }

        return $date->format('Y-m-d H:i:s');
    }
}
