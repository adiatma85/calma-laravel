<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMusicItemRequest;
use App\Http\Requests\StoreMusicItemRequest;
use App\Http\Requests\UpdateMusicItemRequest;
use App\Models\MusicItem;
use App\Models\Playlist;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MusicItemController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('music_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicItems = MusicItem::with(['playlist', 'media'])->get();

        $playlists = Playlist::get();

        return view('admin.musicItems.index', compact('musicItems', 'playlists'));
    }

    public function create()
    {
        abort_if(Gate::denies('music_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlists = Playlist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.musicItems.create', compact('playlists'));
    }

    public function store(StoreMusicItemRequest $request)
    {
        $musicItem = MusicItem::create($request->all());

        if ($request->input('music_file', false)) {
            $musicItem->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_file'))))->toMediaCollection('music_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $musicItem->id]);
        }

        return redirect()->route('admin.music-items.index');
    }

    public function edit(MusicItem $musicItem)
    {
        abort_if(Gate::denies('music_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlists = Playlist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $musicItem->load('playlist');

        return view('admin.musicItems.edit', compact('playlists', 'musicItem'));
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

        return redirect()->route('admin.music-items.index');
    }

    public function show(MusicItem $musicItem)
    {
        abort_if(Gate::denies('music_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicItem->load('playlist');

        return view('admin.musicItems.show', compact('musicItem'));
    }

    public function destroy(MusicItem $musicItem)
    {
        abort_if(Gate::denies('music_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyMusicItemRequest $request)
    {
        MusicItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('music_item_create') && Gate::denies('music_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MusicItem();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
