<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMusicItemRequest;
use App\Http\Requests\UpdateMusicItemRequest;
use App\Http\Resources\Admin\MusicItemResource;
use App\Models\MusicItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MusicItemApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('music_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MusicItemResource(MusicItem::with(['playlist'])->get());
    }

    public function store(StoreMusicItemRequest $request)
    {
        $musicItem = MusicItem::create($request->all());

        if ($request->input('music_file', false)) {
            $musicItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_file'))))->toMediaCollection('music_file');
        }

        return (new MusicItemResource($musicItem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MusicItem $musicItem)
    {
        abort_if(Gate::denies('music_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MusicItemResource($musicItem->load(['playlist']));
    }

    public function update(UpdateMusicItemRequest $request, MusicItem $musicItem)
    {
        $musicItem->update($request->all());

        if ($request->input('music_file', false)) {
            if (!$musicItem->music_file || $request->input('music_file') !== $musicItem->music_file->file_name) {
                if ($musicItem->music_file) {
                    $musicItem->music_file->delete();
                }
                $musicItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_file'))))->toMediaCollection('music_file');
            }
        } elseif ($musicItem->music_file) {
            $musicItem->music_file->delete();
        }

        return (new MusicItemResource($musicItem))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MusicItem $musicItem)
    {
        abort_if(Gate::denies('music_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicItem->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
