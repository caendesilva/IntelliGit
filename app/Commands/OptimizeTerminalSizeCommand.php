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
        $this->output->write("\e[8;50;164t");
        $this->info('Terminal size optimized to 50x164.');

        return Command::SUCCESS;
    }
}
