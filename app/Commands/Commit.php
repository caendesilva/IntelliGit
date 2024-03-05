<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;

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

        // Windows fallback
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || ! $this->input->isInteractive()) {
            $selection = $this->choice('Select files to commit', $files, null, null, true);
        } else {
            $selection = null;

            $itemCallable = function (CliMenu $menu) use (&$selection) {
                $selection[] = $menu->getSelectedItem()->getText();
            };
            $items = array_map(
                fn (string $file): array => [
                    'text' => $file,
                    'itemCallable' => $itemCallable,
                ],
               array_merge(['all' => 'Select all files'], $files)
            );

            $menu = (new CliMenuBuilder)
                ->setTitle('Select files to commit')
                ->addCheckboxItems($items)
                ->addLineBreak('-')
                ->build();

            $menu->open();
        }

        return $selection;
    }

    protected function createMessage(): string
    {
        return '';
    }
}
