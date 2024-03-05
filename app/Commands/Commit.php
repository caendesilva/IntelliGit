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
        // $this->filesToCommit = $this->stageFiles();

        // Create message
        // $this->commitMessage = $this->createMessage();

        // Commit
        // $this->git->commit($this->filesToCommit, $this->commitMessage);

        return Command::SUCCESS;
    }

    protected function stageFiles(): array
    {
        return [];
    }

    protected function createMessage(): string
    {
        return '';
    }
}
