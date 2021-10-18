<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\UserJournalAnswer;
use App\Models\UserJourneyComponentHistory;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class UserStoreJourneyComponentController
{

    use ResponseTrait;

    // POST
    public function storeJournalHistory(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "answers" => "required",
            "journey_component_id" => "required",
            "user_id" => "required",
            'journey_id' => 'required',
        ], [
            "answers" => [
                "required" => "answers field must exist",
            ],

            "user_id" => [
                "required" => "user_id field must exist",
            ],

            "journey_component_id" => [
                "required" => "journey_component_id field must exist",
            ],

            'journey_id' => [
                "required" => "journey_id field must exist",
            ]
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        foreach ($request->answers as $answerItem) {
            // return response()->json([
            //     'item' => $answerItem["id"]
            // ]);
            UserJournalAnswer::create([
                "user_id" => $request->user_id,
                "journal_question_id" => $answerItem["id"],
                'answer' => $answerItem["answer"],
                "journey_id" => $request->journey_id
            ]);
        }

        // Create History
        UserJourneyComponentHistory::create([
            'user_id' => $request->user_id,
            'journey_component_id' => $request->journey_component_id,
            'journey_id' => $request->journey_id,
        ]);

        return $this->response(true, Response::HTTP_NO_CONTENT, "Success to submit", null);
    }

    // HISTORY Untuk music juga
    public function storeMusicHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "journey_component_id" => "required",
            "user_id" => "required",
        ], [
            "user_id" => [
                "required" => "user_id field must exist",
            ],

            "journey_component_id" => [
                "required" => "journey_id field must exist",
            ],

            "journey_component_id" => [
                "required" => "journey_component_id field must exist",
            ],

            'journey_id' => [
                "required" => "journey_id field must exist",
            ]
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        // Create History
        UserJourneyComponentHistory::create([
            'user_id' => $request->user_id,
            'journey_component_id' => $request->journey_component_id,
        ]);

        return $this->response(true, Response::HTTP_NO_CONTENT, "Success to submit", null);
    }
}
