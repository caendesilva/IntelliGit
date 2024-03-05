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
        // Get changed files
        $files = $this->git->getChangedFiles();

        $files = [
            // test
            'app/Commands/Commit.php',
            'app/Helpers/ResultWindowHelper.php',
            'app/Commands/Concerns/Command.php',
        ];


        // Windows fallback
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || ! $this->input->isInteractive()) {
            $selection = $this->choice('Select files to commit', $files, null, null, true);
        } else {
            // Interactive selection
            $this->info('Select files to commit');

            $bullet = '•';

            foreach ($files as $index => $file) {
                $this->line(" <fg=gray>{$bullet}</> <fg=default>{$file}</>");
            }
        }

        dd($selection);
    }

    protected function createMessage(): string
    {
        return '';
    }
}
