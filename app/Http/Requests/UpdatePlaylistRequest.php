<?php

namespace App\Http\Requests;

use App\Models\Playlist;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlaylistRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('playlist_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'image' => [
                'array',
            ],
            'topic_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
