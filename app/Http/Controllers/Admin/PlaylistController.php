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

        foreach ($request->input('image', []) as $file) {
            $playlist->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
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

        if (count($playlist->image) > 0) {
            foreach ($playlist->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $playlist->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $playlist->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
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
