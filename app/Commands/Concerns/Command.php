<?php

namespace App\Commands\Concerns;

use App\Git;
use Symfony\Component\Console\Terminal;

/**
 * @method \NunoMaduro\LaravelConsoleMenu\Menu menu(string $title, array $choices)
 */
abstract class Command extends \LaravelZero\Framework\Commands\Command
{
    protected Git $git;
    protected Terminal $terminal;

    public function __construct(Git $git)
    {
        parent::__construct();

        $this->git = $git;
        $this->terminal = new Terminal();
    }

    public function fatal(string $message): int
    {
        $this->line("<fg=red>Fatal:</> <comment>$message</comment>");

        return Command::FAILURE;
    }

    public function stream(string $message): void
    {
        $this->output->write($message);
    }
}
