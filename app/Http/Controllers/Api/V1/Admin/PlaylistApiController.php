<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Resources\Admin\PlaylistResource;
use App\Models\Playlist;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaylistApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('playlist_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlaylistResource(Playlist::with(['topic'])->get());
    }

    public function store(StorePlaylistRequest $request)
    {
        $playlist = Playlist::create($request->all());

        if ($request->input('image', false)) {
            $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new PlaylistResource($playlist))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Playlist $playlist)
    {
        abort_if(Gate::denies('playlist_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlaylistResource($playlist->load(['topic']));
    }

    public function update(UpdatePlaylistRequest $request, Playlist $playlist)
    {
        $playlist->update($request->all());

        if ($request->input('image', false)) {
            if (!$playlist->image || $request->input('image') !== $playlist->image->file_name) {
                if ($playlist->image) {
                    $playlist->image->delete();
                }
                $playlist->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($playlist->image) {
            $playlist->image->delete();
        }

        return (new PlaylistResource($playlist))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Playlist $playlist)
    {
        abort_if(Gate::denies('playlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlist->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
