<?php

namespace App\Commands;

use App\Git;
use LaravelZero\Framework\Commands\Command;

class Diff extends Command
{
    /** @var string */
    protected $signature = 'diff';

    /** @var string */
    protected $description = 'Show the files change in the working directory';

    protected Git $git;

    public function handle(): int
    {
        $this->git = new Git(getcwd());

        return Command::SUCCESS;
    }
}
