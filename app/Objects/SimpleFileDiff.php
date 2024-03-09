<?php

namespace App\Objects;

readonly class SimpleFileDiff
{
    public string $file;
    public string $contents;
    public array $oldLines;
    public array $newLines;

    protected function __construct(string $file, string $contents, array $oldLines, array $newLines)
    {
        $this->file = $file;
        $this->contents = $contents;
        $this->oldLines = $oldLines;
        $this->newLines = $newLines;
    }

    public static function parse(string $file): SimpleFileDiff
    {
        $diff = app('git')->exec("git diff $file");

        $lines = explode("\n", $diff);
        $oldLines = [];
        $newLines = [];
        foreach ($lines as $line) {
            if (str_starts_with($line, '-') && !str_starts_with($line, '---')) {
                $oldLines[] = substr($line, 1);
            } elseif (str_starts_with($line, '+') && !str_starts_with($line, '+++')) {
                $newLines[] = substr($line, 1);
            }
        }

        $contents = file_get_contents($file);

        return new SimpleFileDiff(
            $file,
            $contents,
            $oldLines,
            $newLines
        );
    }
}
