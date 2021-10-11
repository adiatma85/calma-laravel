<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMusicTopicRequest;
use App\Http\Requests\StoreMusicTopicRequest;
use App\Http\Requests\UpdateMusicTopicRequest;
use App\Models\MusicTopic;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MusicTopicController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('music_topic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicTopics = MusicTopic::all();

        return view('admin.musicTopics.index', compact('musicTopics'));
    }

    public function create()
    {
        abort_if(Gate::denies('music_topic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.musicTopics.create');
    }

    public function store(StoreMusicTopicRequest $request)
    {
        $musicTopic = MusicTopic::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $musicTopic->id]);
        }

        return redirect()->route('admin.music-topics.index');
    }

    public function edit(MusicTopic $musicTopic)
    {
        abort_if(Gate::denies('music_topic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.musicTopics.edit', compact('musicTopic'));
    }

    public function update(UpdateMusicTopicRequest $request, MusicTopic $musicTopic)
    {
        $musicTopic->update($request->all());

        return redirect()->route('admin.music-topics.index');
    }

    public function show(MusicTopic $musicTopic)
    {
        abort_if(Gate::denies('music_topic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.musicTopics.show', compact('musicTopic'));
    }

    public function destroy(MusicTopic $musicTopic)
    {
        abort_if(Gate::denies('music_topic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicTopic->delete();

        return back();
    }

    public function massDestroy(MassDestroyMusicTopicRequest $request)
    {
        MusicTopic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('music_topic_create') && Gate::denies('music_topic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MusicTopic();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
