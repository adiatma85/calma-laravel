<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Journey;
use App\Models\JourneyComponent;
use App\Models\Journal;
use App\Models\MusicItem;
use App\Models\UserJourneyComponentHistory;
use App\Models\MoodTracker;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;


class JourneyController
{
    use ResponseTrait;

    // GET
    public function index(Request $request)
    {
        $journeys = Journey::all();

        $journeys->makeHidden('description');

        // $journeys->load('components');

        $journeys->makeHidden('components');

        foreach ($journeys as $journey) {
            $components = $journey->components;
            $userFinishedComponent = UserJourneyComponentHistory::where('user_id', $request->user_id)
                ->where('journey_id', $journey->id)
                ->get();

            // $journey->totalProgress = count($components);
            // $journey->finishedProgress = count($userFinishedComponent);

            // return response()->json(compact('journey'));

            $journey->finishedProgress = count($userFinishedComponent);
            $journey->totalProgress = count($components);
        }

        return $this->response(true, Response::HTTP_OK, 'Success fetching resources', compact('journeys'));
    }

    // GET
    public function show(Request $request, $journeyId)
    {
        $journey = Journey::find($journeyId);

        if (!$journey) {
            return $this->notFoundFailResponse();
        }

        $journey->load('components');

        $journey->makeHidden('description');

        $components = collect($journey->components);

        unset($journey->components);

        // COMPONENTS
        foreach ($components as $component) {
            $component->is_finished = UserJourneyComponentHistory::where([
                'journey_component_id' => $component->id,
                'user_id' => $request->user_id,
            ])->exists();

            switch ($component->model_type) {
                case 'music_items':
                    $component->name = MusicItem::find($component->in_model_id)->name;
                    break;

                case 'journals':
                    $component->name = Journal::find($component->in_model_id)->name;
                    break;

                case 'mood_trackers':
                    $component->name = null;
                    if (!$component->is_finished) {
                        $component->is_finished = $this->moodTrackerHandle($request->user_id, $component->id, $journey->id);
                    }
                    break;
            }
        }

        $journey->components = $components->sortBy('urutan')->values()->all();

        $userFinishedComponent = UserJourneyComponentHistory::where('user_id', $request->user_id)
            ->where('journey_id', $journey->id)
            ->get();

        $journey->is_finished = count($userFinishedComponent) / count($components) == 1 ? true : false;

        return $this->response(true, Response::HTTP_OK, "Success fetching resource", compact('journey'));
    }

    private function moodTrackerHandle($user_id, $component_id, $journey_id)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $todayMoodtracker = MoodTracker::where('user_id', $user_id)
            ->where('updated_at', "<=", $tomorrow)
            ->where("updated_at", ">=", $today);
        $moodTracker = null;
        if ($todayMoodtracker->exists()) {
            $moodTracker = $todayMoodtracker->first();

            // Create History
            UserJourneyComponentHistory::create([
                'user_id' => $user_id,
                'journey_component_id' => $component_id,
                'journey_id' => $journey_id,
            ]);
        }

        return $moodTracker ? true : false;
    }

    // GET Components
    public function getComponent($journeyComponentId)
    {
        $journeyComponent = JourneyComponent::find($journeyComponentId);

        if (!$journeyComponent) {
            return $this->notFoundFailResponse();
        }

        switch ($journeyComponent->model_type) {
            case 'journals':
                $item = Journal::with(['questions', 'media'])->firstwhere('id', $journeyComponent->in_model_id);
                break;

            case 'music_items':
                $item = MusicItem::find($journeyComponent->in_model_id);
                break;
        }

        $item->journey_component_id = intval($journeyComponentId);
        $item->journey_id = $journeyComponent->journey_id;

        return $this->response(true, Response::HTTP_OK, 'Successing fetching resource', [
            "item" => $item
        ]);
    }
}
