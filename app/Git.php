<?php

namespace App;

use App\Models\GitLogObject;

/**
 * Wrapper for the Git integration with the current directory.
 */
class Git
{
    protected string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function isGitRepository(): bool
    {
        return is_dir($this->directory . '/.git');
    }

    public function exec(string $command): string
    {
        return shell_exec("cd {$this->directory} && $command") ?? '';
    }

    public function passthru(string $command): void
    {
        passthru("cd {$this->directory} && $command");
    }

    public function log(): array
    {
        $output = $this->exec('git log --pretty=format:"%H|%ad|%s" --date=iso');

        return array_map(
            fn (string $line): GitLogObject => new GitLogObject(...explode('|', $line)),
            array_filter(explode("\n", $output))
        );
    }
}
