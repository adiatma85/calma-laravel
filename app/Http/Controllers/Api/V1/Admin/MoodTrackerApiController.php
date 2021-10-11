<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMoodTrackerRequest;
use App\Http\Requests\UpdateMoodTrackerRequest;
use App\Http\Resources\Admin\MoodTrackerResource;
use App\Models\MoodTracker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoodTrackerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mood_tracker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MoodTrackerResource(MoodTracker::with(['user'])->get());
    }

    public function store(StoreMoodTrackerRequest $request)
    {
        $moodTracker = MoodTracker::create($request->all());

        return (new MoodTrackerResource($moodTracker))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MoodTracker $moodTracker)
    {
        abort_if(Gate::denies('mood_tracker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MoodTrackerResource($moodTracker->load(['user']));
    }

    public function update(UpdateMoodTrackerRequest $request, MoodTracker $moodTracker)
    {
        $moodTracker->update($request->all());

        return (new MoodTrackerResource($moodTracker))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MoodTracker $moodTracker)
    {
        abort_if(Gate::denies('mood_tracker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTracker->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
