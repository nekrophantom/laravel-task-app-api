<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function onSuccess($message, $data = null, $statusCode)
    {
        $response = [
            'message' => $message
        ];
    
        if($data !== null){
            $response['data'] = $data;
        }
    
        return new JsonResponse($response, $statusCode);
    }
    
    public static function onError($message, $statusCode)
    {
        return new JsonResponse(['message' => $message], $statusCode);
    }
}