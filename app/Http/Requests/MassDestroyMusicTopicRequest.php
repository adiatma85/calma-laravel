<?php

namespace App\Http\Requests;

use App\Models\MusicTopic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMusicTopicRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('music_topic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:music_topics,id',
        ];
    }
}
