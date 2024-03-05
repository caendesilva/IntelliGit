<?php

namespace App\Commands;

use App\Commands\Concerns\Command;

class Commit extends Command
{
    /** @var string */
    protected $signature = 'commit';

    /** @var string */
    protected $description = 'Create a new commit';

    protected array $filesToCommit;
    protected string $commitMessage;

    public function handle(): int
    {
        // TODO: Implement handle() method.

        // Stage files

        // Create message

        // Commit

        return Command::SUCCESS;
    }
}
