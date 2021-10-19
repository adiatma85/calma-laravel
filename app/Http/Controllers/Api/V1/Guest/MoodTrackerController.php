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
use Illuminate\Support\Facades\DB;


class MoodTrackerController
{

    use ResponseTrait;

    // HOME
    public function home(Request $request)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $todayMoodtracker = MoodTracker::where('user_id', $request->user_id)
            ->where('updated_at', "<=", $tomorrow)
            ->where("updated_at", ">=", $today);
        $moodTracker = null;
        if ($todayMoodtracker->exists()) {
            $moodTracker = $todayMoodtracker->first();
        }

        // Rekomendasi musik
        // Untuk saat ini random dulu
        $randomPlaylist = Playlist::inRandomOrder()->limit(5)->get();

        return $this->response(true, Response::HTTP_OK, "Success fetching resources", [
            "is_today_finished" => $moodTracker ? true : false,
            "mood" => $moodTracker->mood ?? null,
            "reasons" => $moodTracker->reasons ?? null,
            "reccomended_playlists" => $randomPlaylist
        ]);
    }

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

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $todayMoodtracker = MoodTracker::where('user_id', $request->user_id)
            ->where('updated_at', "<=", $tomorrow)
            ->where("updated_at", ">=", $today);

        if ($todayMoodtracker->exists()) {
            $todayMoodtracker->delete();
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
        ], [
            "user_id" => [
                "required" => "user_id must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $date_begin = Carbon::today();
        $date_end = Carbon::tomorrow();
        $moodTracker = MoodTracker::where('user_id', $request->user_id)
            ->where('updated_at', ">=", $date_begin)
            ->where('updated_at', "<=", $date_end)
            ->first();

        if (!$moodTracker) {
            return $this->notFoundFailResponse();
        }

        // Playlist Reccomendation
        // $correlationArray = [
        //     "Tidur" => ["Tidur", "Relaksasi"],
        //     "Pekerjaan" => ["Produktif", "Kecemasan", "Relaksasi"],
        //     "Hubungan" => ["Hubungan", "Kecemasan"],
        //     'Keluarga' => ['Hubungan, Kecemasan'],
        //     'Teman' => ["Hubungan", "Kecemasan"],
        //     'Pendidikan' => ["Produkitf", "Relaksasi"],
        //     "Finansial" => ["Finansial"],
        // ];

        // PENDEKATAN 
        // NOT Partially Urgent
        // if ($moodTracker->reasons) {
        //     $basePlaylist = collect();
        //     foreach ($moodTracker->reasons as $itemReason) {

        //         $correlationItem = $correlationArray[$itemReason] ?? null;

        //         if (!$correlationItem) {
        //             continue;
        //         }

        //         $searchEachPlaylist = Playlist::where(function ($query) use ($correlationArray) {
                    
        //         })->get();
        //     }
        //     $playlist = Playlist::where(function ($query) use ($correlationArray) {
        //     })->get();
        // }

        $randomPlaylist = Playlist::inRandomOrder()->limit(5)->get();

        // Response
        return $this->response(true, Response::HTTP_OK, "Success fetching resources", [
            "is_today_finished" => $moodTracker->mood ? true : false,
            "mood" => $moodTracker->mood ?? null,
            "reasons" => $moodTracker->reasons ?? null,
            "reccomended_playlists" => $randomPlaylist,
        ]);
    }

    public function indexMingguan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "date_begin" => "string"
        ], [
            "user_id" => [
                "required" => "user_id must exist",
            ],
            "date_begin" => [
                "string" => "date_begin must be string if provided with format Y-m-d. Example 2021-10-18",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $dateBeginBase = $request->date_begin ?? Carbon::now()->startOfWeek()->format('Y-m-d');

        $date_begin = Carbon::make($dateBeginBase)->addDay(-1);
        $date_end = Carbon::make($dateBeginBase)->addWeek();
        $moodTrackers = MoodTracker::where('user_id', $request->user_id)
            // ->orderBy('updated_at', 'DESC')
            ->where('updated_at', ">=", $date_begin)
            ->where('updated_at', "<=", $date_end)
            ->with(['reasons'])
            ->get();


        if (!$moodTrackers) {
            return $this->notFoundFailResponse();
        }

        $accReasons = collect([]);

        // Experimental for mood tracker
        $index = 0;
        for ($i = $date_begin->addDay(); $i <= $date_end; $i->addDay()) {
            $existedItem = $moodTrackers->first(function ($item) use ($i) {
                return
                    $item->created_at >= $i->format('Y-m-d H:i:s')
                    &&
                    $item->created_at <= $i->copy()->addDay()->format('Y-m-d H:i:s');
            });

            if (!$existedItem) {
                $copyOfIndex = $i->copy();
                $newItem = [
                    "index" => $index,
                    "created_at" => $copyOfIndex->format("Y-m-d H:i:s"),
                    "updated_at" => $copyOfIndex->format("Y-m-d H:i:s"),
                    "mood" => 0,
                    "reasons" => [],
                ];
                $moodTrackers = $moodTrackers->push((object)$newItem);
                $index++;
                continue;
            }
            $existedItem->index = $index;
            $index++;
            $accReasons->push(...$existedItem->reasons);
        }

        // Sorted Moodtracker
        $sortedMoodTracker = $moodTrackers
            ->sortBy('created_at')
            ->values()
            ->all();

        // Sorted Mood
        $sortedMood = $moodTrackers->countBy(function ($item) {
            switch ($item->mood) {
                case '0':
                    return "Buruk";
                    break;

                case '1':
                    return "Biasa";
                    break;

                case '2':
                    return "Baik";
                    break;
            }
        })->sort()->toArray();
        $finalSortedMood = array_search(max($sortedMood), $sortedMood);

        // Sorted Accumulated Reason
        $listAccReason = $accReasons->countBy('reason');
        $accumulatedReason = [];
        foreach ($listAccReason as $key => $value) {
            $item = [
                "factor" => $key,
                "total" => $value
            ];
            array_push($accumulatedReason, $item);
        }

        return $this->response(true, Response::HTTP_OK, "Success fetching resources", [
            'moodTrackers' => $sortedMoodTracker,
            'sortedMood' => $finalSortedMood,
            'listAccReason' => $accumulatedReason,
        ]);
    }
}
