<?php

namespace App\Http\Requests;

use App\Models\MusicItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMusicItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('music_item_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'music_file' => [
                'required',
            ],
            'playlist_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
