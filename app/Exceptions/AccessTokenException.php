<?php

namespace App\Exceptions;

class AccessTokenException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
