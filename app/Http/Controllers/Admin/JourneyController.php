<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyJourneyRequest;
use App\Http\Requests\StoreJourneyRequest;
use App\Http\Requests\UpdateJourneyRequest;
use App\Models\Journey;
use App\Models\MoodTracker;
use App\Models\Playlist;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JourneyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('journey_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journeys = Journey::with(['user', 'mood_tracker', 'playlist'])->get();

        $users = User::get();

        $mood_trackers = MoodTracker::get();

        $playlists = Playlist::get();

        return view('admin.journeys.index', compact('journeys', 'users', 'mood_trackers', 'playlists'));
    }

    public function create()
    {
        abort_if(Gate::denies('journey_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mood_trackers = MoodTracker::pluck('mood', 'id')->prepend(trans('global.pleaseSelect'), '');

        $playlists = Playlist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.journeys.create', compact('users', 'mood_trackers', 'playlists'));
    }

    public function store(StoreJourneyRequest $request)
    {
        $journey = Journey::create($request->all());

        return redirect()->route('admin.journeys.index');
    }

    public function edit(Journey $journey)
    {
        abort_if(Gate::denies('journey_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mood_trackers = MoodTracker::pluck('mood', 'id')->prepend(trans('global.pleaseSelect'), '');

        $playlists = Playlist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $journey->load('user', 'mood_tracker', 'playlist');

        return view('admin.journeys.edit', compact('users', 'mood_trackers', 'playlists', 'journey'));
    }

    public function update(UpdateJourneyRequest $request, Journey $journey)
    {
        $journey->update($request->all());

        return redirect()->route('admin.journeys.index');
    }

    public function show(Journey $journey)
    {
        abort_if(Gate::denies('journey_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journey->load('user', 'mood_tracker', 'playlist');

        return view('admin.journeys.show', compact('journey'));
    }

    public function destroy(Journey $journey)
    {
        abort_if(Gate::denies('journey_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journey->delete();

        return back();
    }

    public function massDestroy(MassDestroyJourneyRequest $request)
    {
        Journey::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
