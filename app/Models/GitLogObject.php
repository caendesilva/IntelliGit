<?php

namespace App\Models;

class GitLogObject extends \ArrayObject
{
    public string $hash;
    public string $date;
    public string $message;

    public function __construct(string $hash, string $date, string $message)
    {
        $this->hash = $hash;
        $this->date = $date;
        $this->message = $message;
    }
}
