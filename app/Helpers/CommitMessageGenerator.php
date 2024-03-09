<?php

namespace App\Helpers;

use App\Objects\SimpleFileDiff;
use Illuminate\Support\Collection;

/**
 * Finds a few suggestions for commit messages based on the files to commit.
 * Sorted in the order of suspected relevance.
 */
class CommitMessageGenerator
{
    /** @var Collection<string> */
    protected Collection $filesToCommit;

    /** @var array<string, int> String is the message, int is the relevance priority */
    protected array $messages;

    /** Create a new generator instance which the supplied context */
    public function __construct(array $filesToCommit)
    {
        $this->filesToCommit = collect($filesToCommit);
    }

    public function generate(): void
    {
        $this->messages = [];

        if ($this->filesToCommit->count() === 1) {
            $this->generateSingleFileMessages($this->filesToCommit->first());
        }
    }

    /** @return array<string> */
    public function getSuggestions(): array
    {
        return collect($this->messages)
            ->sortByDesc(fn (int $priority, string $message): int => $priority)
            ->keys()
            ->toArray();
    }

    protected function generateSingleFileMessages(string $file): void
    {
        $diff = SimpleFileDiff::parse($file);
    }
}
