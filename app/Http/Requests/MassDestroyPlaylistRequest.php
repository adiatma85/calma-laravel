<?php

namespace App\Http\Requests;

use App\Models\Playlist;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlaylistRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('playlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:playlists,id',
        ];
    }
}
