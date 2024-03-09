<?php

namespace App\Exceptions;

use RuntimeException;

class UserCancelException extends RuntimeException
{
    /** @var string */
    protected $code = 130;
}
