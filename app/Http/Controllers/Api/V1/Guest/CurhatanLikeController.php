<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\User;
use App\Http\Controllers\Traits\ResponseTrait;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CurhatanLikeController
{
    use ResponseTrait;

    public function like(Request $request)
    {
        User::where('id', $request->user_id)->curhat_like()->syncWithoudDetaching([$request->curhatan_id]);
        return $this->response(true, Response::HTTP_OK, "Success changing data", null);
    }
}
