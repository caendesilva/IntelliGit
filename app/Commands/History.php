<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Git;
use App\Objects\GitLogObject;
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

        $this->displayHistory($commits->take($this->getHistoryLength())->toArray());

        return Command::SUCCESS;
    }

    protected function getCommits(): Collection
    {
        return collect($this->git->log());
    }

    protected function getHistoryLength(): int
    {
        return $this->terminal->getHeight() - 2;
    }

    /** @param  array<GitLogObject>  $rows */
    protected function displayHistory(array $rows): void
    {
        foreach ($rows as $number => $row) {
            $number = "<fg=gray>{$this->formatLineNumber($number, strlen(count($rows)))}</>";
            $message = "<fg=default>{$this->formatMessage($row->message)}</>";
            $hash = "<fg=gray>{$this->formatHash($row->hash)}</>";
            $date = "<fg=gray>{$this->formatDate($row->date)}</>";

            $this->line(sprintf("%s %s %s %s",
                $number,
                $message,
                $date,
                $hash,
            ));
        }
    }

    protected function formatMessage(string $message): string
    {
        if (strlen($message) > Git::MAX_COMMIT_LENGTH + 3) {
            $message = substr($message, 0, Git::MAX_COMMIT_LENGTH - 4).'...';
        }

        return str_pad($message, Git::MAX_COMMIT_LENGTH, ' ');
    }

    protected function formatHash(string $hash): string
    {
        return substr($hash, 0, $this->git->getCoreAbbrev());
    }

    protected function formatDate(Carbon $date): string
    {
        if ($date->diffInHours() < 24) {
            return str_pad($date->diffForHumans(), 19, ' ', STR_PAD_LEFT);
        }

        return $date->format('Y-m-d H:i:s');
    }

    protected function formatLineNumber(int|string $number, int $digits): string
    {
        return str_pad((string)($number + 1), $digits, ' ', STR_PAD_LEFT);
    }
}
