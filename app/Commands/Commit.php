<?php

namespace App\Commands;

use App\Commands\Concerns\Command;
use App\Exceptions\UserCancelException;
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
            // See https://github.com/php-school/cli-menu

            $selection = [];

            $itemCallable = function (CliMenu $menu) use (&$selection) {
                if (isset($selection[$menu->getSelectedItem()->getText()])) {
                    unset($selection[$menu->getSelectedItem()->getText()]);
                } else {
                    $selection[$menu->getSelectedItem()->getText()] = true;
                }

                if ($menu->getSelectedItem()->getText() === 'Select all files [A]') {
                    $menu->close();
                }
                if ($menu->getSelectedItem()->getText() === 'Stage selected [S]') {
                    if (empty($selection) || $selection === ['Stage selected [S]' => true]) {
                        $flash = $menu->flash('No files selected');
                        $flash->display();
                    } else {
                        $menu->close();
                    }
                }
                if ($menu->getSelectedItem()->getText() === 'Cancel and quit [Q]') {
                    $menu->close();
                    throw new UserCancelException();
                }
            };
            $items = array_map(
                fn (string $file): array => [
                    'text' => $file,
                    'itemCallable' => $itemCallable,
                ],
                $files
            );

            $menu = (new CliMenuBuilder)
                ->setTitle('Select files to commit')
                ->setTitleSeparator('')
                ->disableDefaultItems()
                ->enableAutoShortcuts()
                ->addRadioItem('Select all files [A]', $itemCallable)
                ->addLineBreak('')
                ->addCheckboxItems($items)
                ->addLineBreak('')
                ->addRadioItem('Stage selected [S]', $itemCallable)
                ->addRadioItem('Cancel and quit [Q]', $itemCallable)
                ->build();

            $menu->open();

            $selection = array_keys($selection);

            if (in_array('Select all files', $selection)) {
                $selection = $files;
            }
        }

        return $selection;
    }

    protected function createMessage(): string
    {
        return '';
    }
}
