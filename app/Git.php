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
}
