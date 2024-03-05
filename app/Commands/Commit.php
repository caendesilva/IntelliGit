<?php

namespace App\Commands;

use App\Commands\Concerns\Command;

class Commit extends Command
{
    /** @var string */
    protected $signature = 'commit'; // Todo: Support --message for specific message, support --staged to use existing stage, --all to stage all files

    /** @var string */
    protected $description = 'Create a new commit';

    protected array $filesToCommit;
    protected string $commitMessage;

    public function handle(): int
    {
        // TODO: Implement handle() method.

        // Stage files
        $this->filesToCommit = $this->stageFiles();

        // Create message
        $this->commitMessage = $this->createMessage();

        // Commit
        $this->git->commit($this->filesToCommit, $this->commitMessage);

        return Command::SUCCESS;
    }

    protected function stageFiles(): array
    {
        // Unstage all files
        $this->git->exec('git reset');

        return [];
    }

    protected function createMessage(): string
    {
        return '';
    }
}
