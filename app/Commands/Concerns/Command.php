<?php

namespace App\Commands\Concerns;

use App\Git;

abstract class Command extends \LaravelZero\Framework\Commands\Command
{
    protected Git $git;

    public function __construct(Git $git)
    {
        parent::__construct();

        $this->git = $git;
    }

    public function fatal(string $message): int
    {
        $this->line("<fg=red>Fatal:</> <comment>$message</comment>");

        return Command::FAILURE;
    }

    // Print with syntax highlighting
    public function highlight(string $message): void
    {
        $highlighted = $message; // Todo

        $this->output->write($highlighted);
    }
}
