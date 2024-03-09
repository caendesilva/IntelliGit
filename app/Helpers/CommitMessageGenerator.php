<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

/**
 * Finds a few suggestions for commit messages based on the files to commit.
 * Sorted in the order of suspected relevance.
 */
class CommitMessageGenerator
{
    /** @var Collection<string> */
    protected Collection $filesToCommit;

    /** @var array<string> */
    protected array $messages;

    /** Create a new generator instance which the supplied context */
    public function __construct(array $filesToCommit)
    {
        $this->filesToCommit = collect($filesToCommit);
    }

    public function generate(): void
    {
        $this->messages = [];
    }

    /** @return array<string> */
    public function getSuggestions(): array
    {
        return $this->messages;
    }
}
