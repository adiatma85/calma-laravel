<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMusicTopicRequest;
use App\Http\Requests\UpdateMusicTopicRequest;
use App\Http\Resources\Admin\MusicTopicResource;
use App\Models\MusicTopic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MusicTopicApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('music_topic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MusicTopicResource(MusicTopic::all());
    }

    public function store(StoreMusicTopicRequest $request)
    {
        $musicTopic = MusicTopic::create($request->all());

        return (new MusicTopicResource($musicTopic))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MusicTopic $musicTopic)
    {
        abort_if(Gate::denies('music_topic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MusicTopicResource($musicTopic);
    }

    public function update(UpdateMusicTopicRequest $request, MusicTopic $musicTopic)
    {
        $musicTopic->update($request->all());

        return (new MusicTopicResource($musicTopic))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MusicTopic $musicTopic)
    {
        abort_if(Gate::denies('music_topic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musicTopic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
