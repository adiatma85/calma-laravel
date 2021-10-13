<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\MoodTracker;
use App\Models\MoodTrackerReason;
use App\Models\Playlist;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;


class MoodTrackerController
{

    use ResponseTrait;


    // POST
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "mood" => "required|numeric",
            "user_id" => "required",
            "reasons" => "required"
        ], [
            "mood" => [
                "required" => "mood field must exist",
                "numeric" => "mood field must be a numeric"
            ],
            "user_id" => [
                "required" => "user_id must exist",
            ],
            "reasons" => [
                "required" => "reasons must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $moodTracker = MoodTracker::create($request->except('reasons'));
        foreach ($request->reasons as $reason) {
            MoodTrackerReason::create([
                "reason" => $reason,
                "mood_tracker_id" => $moodTracker->id,
            ]);
        }
        return $this->response(true, Response::HTTP_OK, "Success create mood-tracker for today", null);
    }

    // GET Harian
    public function indexHarian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "date_begin" => "required"
        ], [
            "user_id" => [
                "required" => "user_id must exist",
            ],
            "date_begin" => [
                "required" => "date_begin must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $date_begin = Carbon::make($request->date_begin);
        $date_end = $date_begin->addDay();
        $moodTracker = MoodTracker::where('user_id', $request->user_id)
            ->where('created_at', ">=", $date_begin)
            ->where('created_at', "<=", $date_end)
            ->first();

        if (!$moodTracker) {
            return $this->notFoundFailResponse();
        }

        // Playlist Reccomendation
        // For now, it's randomized
        $randomPlaylist = Playlist::inRandomOrder()->limit(5)->get();

        // Response
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", [
            "mood" => $moodTracker->mood,
            "reasons" => $moodTracker->reasons,
            "reccomended_playlists" => $randomPlaylist
        ]);
    }

    public function indexMingguan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "date_begin" => "required"
        ], [
            "user_id" => [
                "required" => "user_id must exist",
            ],
            "date_begin" => [
                "required" => "date_begin must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $date_begin = Carbon::make($request->date_begin);
        $date_end = $date_begin->addDay();
        $moodTrackers = MoodTracker::where('user_id', $request->user_id)
            ->where('created_at', ">=", $date_begin)
            ->where('created_at', "<=", $date_end)
            ->get();

        if (!$moodTrackers) {
            return $this->notFoundFailResponse();
        }

        return $this->response(true, Response::HTTP_OK, "Success fetching resources", [
            
        ]);
    }
}
