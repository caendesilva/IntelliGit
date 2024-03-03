<?php

namespace App;

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
}
