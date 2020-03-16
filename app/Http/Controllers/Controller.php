<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected function success($status, $message){
        return response()->json([
            'status' => 200,
            'code' => 0,
            'message' => $message,
            'errors' => [],
            'data' => null,
        ])->setStatusCode(200);;
    }
    
    protected function error($status, $code, $message){
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'errors' => [],
            'data' => null,
        ])->setStatusCode(200);
    }
}
