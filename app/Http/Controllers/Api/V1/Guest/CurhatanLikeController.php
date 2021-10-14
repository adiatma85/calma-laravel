<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\CurhatLikes;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CurhatanLikeController
{
    use ResponseTrait;

    public function like(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "curhatan_id" => "required",
        ], [
            "user_id" => [
                "required" => "user_id field must exist",
            ],
            "curhatan_id" => [
                "required" => "curhatan_id field must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $likeItem = CurhatLikes::where($request->all());
        if ($likeItem->exists()) {
            $likeItem->delete();
        } else {
            CurhatLikes::create($request->all());
        }
        return $this->response(true, Response::HTTP_OK, "Success changing data", null);
    }
}
