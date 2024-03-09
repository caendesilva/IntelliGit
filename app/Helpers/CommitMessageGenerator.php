<?php

namespace App\Helpers;

class CommitMessageGenerator
{
    /** @var array<string> */
    protected array $filesToCommit;

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
        return [
            //
        ];
    }
}
