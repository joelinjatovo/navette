<?php

namespace App\Exceptions;

class ApiKeyException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
