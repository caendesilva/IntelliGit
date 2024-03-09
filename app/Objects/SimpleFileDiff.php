<?php

namespace App\Objects;

class SimpleFileDiff
{
    public readonly string $file;
    public readonly string $contents;
    public readonly array $oldLines;
    public readonly array $newLines;

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
