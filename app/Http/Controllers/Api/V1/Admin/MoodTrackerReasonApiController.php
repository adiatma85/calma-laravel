<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMoodTrackerReasonRequest;
use App\Http\Requests\UpdateMoodTrackerReasonRequest;
use App\Http\Resources\Admin\MoodTrackerReasonResource;
use App\Models\MoodTrackerReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoodTrackerReasonApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mood_tracker_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MoodTrackerReasonResource(MoodTrackerReason::with(['mood_tracker'])->get());
    }

    public function store(StoreMoodTrackerReasonRequest $request)
    {
        $moodTrackerReason = MoodTrackerReason::create($request->all());

        return (new MoodTrackerReasonResource($moodTrackerReason))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MoodTrackerReason $moodTrackerReason)
    {
        abort_if(Gate::denies('mood_tracker_reason_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MoodTrackerReasonResource($moodTrackerReason->load(['mood_tracker']));
    }

    public function update(UpdateMoodTrackerReasonRequest $request, MoodTrackerReason $moodTrackerReason)
    {
        $moodTrackerReason->update($request->all());

        return (new MoodTrackerReasonResource($moodTrackerReason))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MoodTrackerReason $moodTrackerReason)
    {
        abort_if(Gate::denies('mood_tracker_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTrackerReason->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
