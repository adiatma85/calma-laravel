<?php

namespace App\Http\Controllers\Traits;

trait ResponseTrait
{
    public function response($isSuccess, $statusCode, $message, $data)
    {
        return response()->json([
            "success" => $isSuccess,
            "statusCode" => $statusCode,
            "mesage" => $message,
            "data" => $data,
        ], $statusCode);
    }
}
