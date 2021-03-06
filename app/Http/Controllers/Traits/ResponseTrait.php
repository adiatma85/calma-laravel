<?php

namespace App\Http\Controllers\Traits;

use Symfony\Component\HttpFoundation\Response;

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

    // bad request fail response
    public function badRequestFailResponse($validator)
    {
        return $this->response(false, Response::HTTP_BAD_REQUEST, "Bad Request", ["details" => $validator]);
    }

    // not found fail response
    public function notFoundFailResponse()
    {
        return $this->response(false, Response::HTTP_NOT_FOUND, "Particular resource does not exists", null);
    }
}
