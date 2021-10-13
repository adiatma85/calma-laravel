<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Curhatan;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class CurhatController
{

    use ResponseTrait;


    // GET
    public function index()
    {
        $curhatans = Curhatan::with(['user', 'comments'])->get();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('curhatans'));
    }

    // GET
    public function getIndexFromTopic($topicName)
    {
        $curhatans = Curhatan::with(['user', 'comments'])->where('topic', $topicName)->get();
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('curhatans'));
    }

    // GET
    public function show($curhatId)
    {
        $curhatan = Curhatan::with(['user', 'comments'])->firstWhere('id', $curhatId);
        if (!$curhatan->exists()) {
            return $this->notFoundFailResponse();
        }
        return $this->response(true, Response::HTTP_OK, "Success fetching particular resource", ["curhatan" => $curhatan->first()]);
    }

    // POST
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "content" => "required|string",
            "user_id" => "required"
        ], [
            "content" => [
                "string" => "content field must be a string",
                "required" => "content field must exist",
            ],

            "user_id" => [
                "required" => "user_id field must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $curhatan = Curhatan::create($request->all());
        return $this->response(true, Response::HTTP_OK, "Success create curhatan", compact('curhatan'));
    }

    // PUT
    public function update(Request $request, $curhatanId)
    {
        $validator = Validator::make($request->all(), [
            "content" => "string",
            "user_id" => "required"
        ], [
            "content" => [
                "string" => "content field must be a string",
                "required" => "content field must exist",
            ],

            "user_id" => [
                "required" => "user_id field must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $curhatan = Curhatan::where('id', $curhatanId);

        if (!$curhatan->exists()) {
            return $this->notFoundFailResponse();
        }
        $curhatan->update($request->all());
        return $this->response(true, Response::HTTP_NO_CONTENT, "", null);
    }

    // DELETE
    public function delete($curhatanId)
    {
        $curhatan = Curhatan::where('id', $curhatanId);

        if (!$curhatan->exists()) {
            return $this->notFoundFailResponse();
        }
        $curhatan->delete();
        return $this->response(true, Response::HTTP_NO_CONTENT, "", null);
    }
}
