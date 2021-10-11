<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMoodTrackerRequest;
use App\Http\Requests\StoreMoodTrackerRequest;
use App\Http\Requests\UpdateMoodTrackerRequest;
use App\Models\MoodTracker;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoodTrackerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mood_tracker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTrackers = MoodTracker::with(['user'])->get();

        $users = User::get();

        return view('admin.moodTrackers.index', compact('moodTrackers', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('mood_tracker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.moodTrackers.create', compact('users'));
    }

    public function store(StoreMoodTrackerRequest $request)
    {
        $moodTracker = MoodTracker::create($request->all());

        return redirect()->route('admin.mood-trackers.index');
    }

    public function edit(MoodTracker $moodTracker)
    {
        abort_if(Gate::denies('mood_tracker_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moodTracker->load('user');

        return view('admin.moodTrackers.edit', compact('users', 'moodTracker'));
    }

    public function update(UpdateMoodTrackerRequest $request, MoodTracker $moodTracker)
    {
        $moodTracker->update($request->all());

        return redirect()->route('admin.mood-trackers.index');
    }

    public function show(MoodTracker $moodTracker)
    {
        abort_if(Gate::denies('mood_tracker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTracker->load('user');

        return view('admin.moodTrackers.show', compact('moodTracker'));
    }

    public function destroy(MoodTracker $moodTracker)
    {
        abort_if(Gate::denies('mood_tracker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moodTracker->delete();

        return back();
    }

    public function massDestroy(MassDestroyMoodTrackerRequest $request)
    {
        MoodTracker::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
