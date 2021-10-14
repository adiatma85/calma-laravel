<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Curhatan;
use App\Models\Comment;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class CommentController
{
    use ResponseTrait;

    // GET
    public function getCommentsFromCurhatanId($curhatanId)
    {
        $comments = Comment::where('curhatan_id', $curhatanId)->get();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('comments'));
    }

    // POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "content" => "required|string",
            "curhatan_id" => "required",
        ], [
            "content" => [
                "string" => "content field must be a string",
                "required" => "content field must exist",
            ],

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

        $comment = Comment::create($request->all());
        return $this->response(true, Response::HTTP_OK, "Success create curhatan", compact('comment'));
    }
}
