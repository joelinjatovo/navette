<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $statusCode;
    
    protected $status;
    
    public function __construct($statusCode, $status = 0){
        $this->statusCode = $statusCode;
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getStatusCode(){
        return $this->statusCode;
    }
}
