<?php

namespace App\Http\Requests;

use App\Models\MusicTopic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMusicTopicRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('music_topic_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
