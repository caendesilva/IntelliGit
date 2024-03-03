<?php

namespace App\Commands\Concerns;

abstract class Command extends \LaravelZero\Framework\Commands\Command
{
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
