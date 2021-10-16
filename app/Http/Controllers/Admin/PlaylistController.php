<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPlaylistRequest;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Models\MusicTopic;
use App\Models\Playlist;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PlaylistController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('playlist_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlists = Playlist::with(['topic', 'media'])->get();

        $music_topics = MusicTopic::get();

        return view('admin.playlists.index', compact('playlists', 'music_topics'));
    }

    public function create()
    {
        abort_if(Gate::denies('playlist_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topics = MusicTopic::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.playlists.create', compact('topics'));
    }

    public function store(StorePlaylistRequest $request)
    {
        $playlist = Playlist::create($request->all());

        if ($request->input('rounded_image', false)) {
            $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('rounded_image'))))->toMediaCollection('rounded_image');
        }

        if ($request->input('squared_image', false)) {
            $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('squared_image'))))->toMediaCollection('squared_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $playlist->id]);
        }

        return redirect()->route('admin.playlists.index');
    }

    public function edit(Playlist $playlist)
    {
        abort_if(Gate::denies('playlist_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topics = MusicTopic::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $playlist->load('topic');

        return view('admin.playlists.edit', compact('topics', 'playlist'));
    }

    public function update(UpdatePlaylistRequest $request, Playlist $playlist)
    {
        $playlist->update($request->all());

        if ($request->input('rounded_image', false)) {
            if (!$playlist->rounded_image || $request->input('rounded_image') !== $playlist->rounded_image->file_name) {
                if ($playlist->rounded_image) {
                    $playlist->rounded_image->delete();
                }
                $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('rounded_image'))))->toMediaCollection('rounded_image');
            }
        } elseif ($playlist->rounded_image) {
            $playlist->rounded_image->delete();
        }

        if ($request->input('squared_image', false)) {
            if (!$playlist->squared_image || $request->input('squared_image') !== $playlist->squared_image->file_name) {
                if ($playlist->squared_image) {
                    $playlist->squared_image->delete();
                }
                $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('squared_image'))))->toMediaCollection('squared_image');
            }
        } elseif ($playlist->squared_image) {
            $playlist->squared_image->delete();
        }

        return redirect()->route('admin.playlists.index');
    }

    public function show(Playlist $playlist)
    {
        abort_if(Gate::denies('playlist_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlist->load('topic', 'playlistMusicItems');

        return view('admin.playlists.show', compact('playlist'));
    }

    public function destroy(Playlist $playlist)
    {
        abort_if(Gate::denies('playlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlist->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlaylistRequest $request)
    {
        Playlist::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('playlist_create') && Gate::denies('playlist_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Playlist();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
