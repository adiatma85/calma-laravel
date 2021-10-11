<?php

namespace App\Http\Requests;

use App\Models\MusicItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMusicItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('music_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:music_items,id',
        ];
    }
}
