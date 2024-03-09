<?php

namespace App\Helpers;

/**
 * Finds a few suggestions for commit messages based on the files to commit.
 * Sorted in the order of suspected relevance.
 */
class CommitMessageGenerator
{
    /** @var array<string> */
    protected array $filesToCommit;

    /** @var array<string> */
    protected array $messages;

    /** Create a new generator instance which the supplied context */
    public function __construct(array $filesToCommit)
    {
        $this->filesToCommit = $filesToCommit;
    }

    public function generate(): void
    {
        //
    }

    /** @return array<string> */
    public function getSuggestions(): array
    {
        return $this->messages;
    }
}
