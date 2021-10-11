<?php

namespace App\Http\Requests;

use App\Models\MusicTopic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMusicTopicRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('music_topic_create');
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
