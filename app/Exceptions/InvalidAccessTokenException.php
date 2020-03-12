<?php

namespace App\Exceptions;

use Exception;

class InvalidAccessTokenException extends Exception
{
    public function __construct($statusCode, $status = 0){
        parent::__construct($statusCode, 102);
    }
}
