<?php

namespace App\Objects;

/**
 * Object wrapper for parsed data from a git diff.
 *
 * @see https://git-scm.com/docs/diff-format
 */
readonly class SimpleFileDiff
{
    public string $file;
    public array $contents;
    public array $oldLines;
    public array $newLines;

    protected function __construct(string $file, array $contents, array $oldLines, array $newLines)
    {
        $this->file = $file;
        $this->contents = $contents;
        $this->oldLines = $oldLines;
        $this->newLines = $newLines;
    }

    public static function parse(string $file): SimpleFileDiff
    {
        /** @var \App\Git $git */
        $git = app('git');

        $diff = $git->exec("git diff $file");
        if (blank(trim($diff))) {
            // Check if file is new
            $diff = $git->exec("git diff /dev/null $file");
        }

        $lines = explode("\n", $diff);
        $oldLines = [];
        $newLines = [];
        foreach ($lines as $index => $line) {
            // Todo: Offset indexes at write operation to account for collapsed lines

            if (str_starts_with($line, '-') && !str_starts_with($line, '---')) {
                $oldLines[$index] = substr($line, 1);
            } elseif (str_starts_with($line, '+') && !str_starts_with($line, '+++')) {
                $newLines[$index] = substr($line, 1);
            }
        }

        $contents = explode("\n", file_get_contents($file));

        return new SimpleFileDiff(
            $file,
            $contents,
            $oldLines,
            $newLines
        );
    }
}
