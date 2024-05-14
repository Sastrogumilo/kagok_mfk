<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class apiBaseController extends Controller
{
    function jsonBerhasil($data, $message, $status = 200){
        
        return response()->json([
            'response' => $data,
            'metadata' => [
                'message' => $message,
                'status' => $status
            ]
        ], $status);
    }

    function jsonGagal($message, $status = 400){
        return response()->json([
            'response' => [],
            'metadata' => [
                'message' => $message,
                'status' => $status
            ]
        ], $status);
    }
}
