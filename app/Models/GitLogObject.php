<?php

namespace App\Models;

use Carbon\Carbon;

readonly class GitLogObject
{
    public string $hash;

    public Carbon $date;

    public string $message;

    public function __construct(string $hash, string $date, string $message)
    {
        $this->hash = $hash;
        $this->date = Carbon::parse($date);
        $this->message = $message;
    }
}
