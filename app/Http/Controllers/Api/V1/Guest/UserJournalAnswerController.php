<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\UserJournalAnswer;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class UserJournalAnswerController
{

    use ResponseTrait;

    // POST
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "answers" => "required",
            "journey_component_id" => "required",
            "user_id" => "required",
        ], [
            "answers" => [
                "required" => "answers field must exist",
            ],

            "user_id" => [
                "required" => "user_id field must exist",
            ],

            "journey_component_id" => [
                "required" => "journey_id field must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        foreach ($request->answers as $answerItem) {
            UserJournalAnswer::create([
                "user_id" => $request->user_id,
                "journal_question_id" => $answerItem->id,
                'answer' => $answerItem->answer,
                // "journey_id" => $request->journey_id
            ]);
        }

        // Create History

        return $this->response(true, Response::HTTP_NO_CONTENT, "Success to submit the answer", null);
    }
}
