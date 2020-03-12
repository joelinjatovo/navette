<?php

namespace App\Http\Resources;

class ResponseMessage
{
    public $status;
    
    public $message;

    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status = $status;
    }
}
