<?php

namespace App\Helpers;

class CommitMessageGenerator
{
    /** @var array<string> */
    protected array $filesToCommit;

    /** @var array<string> */
    protected array $messages;

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
