<?php

namespace App\Commands;

use App\Commands\Concerns\Command;

class OptimizeTerminalSizeCommand extends Command
{
    /** @var string */
    protected $signature = 'terminal:size';

    /** @var string */
    protected $description = 'Optimize terminal size for the current window.';

    public function handle(): int
    {
        $this->resize('164', '50');

        return Command::SUCCESS;
    }

    public function resize(string $w, string $h): void
    {
        $this->output->write("\e[8;{$h};{$w}t");
        $this->info("Terminal size optimized to {$w}x{$h}");
    }
}
