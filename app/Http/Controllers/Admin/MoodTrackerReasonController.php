<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMoodTrackerReasonRequest;
use App\Http\Requests\StoreMoodTrackerReasonRequest;
use App\Http\Requests\UpdateMoodTrackerReasonRequest;
use App\Models\MoodTracker;
use App\Models\MoodTrackerReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoodTrackerReasonController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mood_tracker_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTrackerReasons = MoodTrackerReason::with(['mood_tracker'])->get();

        $mood_trackers = MoodTracker::get();

        return view('admin.moodTrackerReasons.index', compact('moodTrackerReasons', 'mood_trackers'));
    }

    public function create()
    {
        abort_if(Gate::denies('mood_tracker_reason_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mood_trackers = MoodTracker::pluck('mood', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.moodTrackerReasons.create', compact('mood_trackers'));
    }

    public function store(StoreMoodTrackerReasonRequest $request)
    {
        $moodTrackerReason = MoodTrackerReason::create($request->all());

        return redirect()->route('admin.mood-tracker-reasons.index');
    }

    public function edit(MoodTrackerReason $moodTrackerReason)
    {
        abort_if(Gate::denies('mood_tracker_reason_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mood_trackers = MoodTracker::pluck('mood', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moodTrackerReason->load('mood_tracker');

        return view('admin.moodTrackerReasons.edit', compact('mood_trackers', 'moodTrackerReason'));
    }

    public function update(UpdateMoodTrackerReasonRequest $request, MoodTrackerReason $moodTrackerReason)
    {
        $moodTrackerReason->update($request->all());

        return redirect()->route('admin.mood-tracker-reasons.index');
    }

    public function show(MoodTrackerReason $moodTrackerReason)
    {
        abort_if(Gate::denies('mood_tracker_reason_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTrackerReason->load('mood_tracker');

        return view('admin.moodTrackerReasons.show', compact('moodTrackerReason'));
    }

    public function destroy(MoodTrackerReason $moodTrackerReason)
    {
        abort_if(Gate::denies('mood_tracker_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTrackerReason->delete();

        return back();
    }

    public function massDestroy(MassDestroyMoodTrackerReasonRequest $request)
    {
        MoodTrackerReason::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
