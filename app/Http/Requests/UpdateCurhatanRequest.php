<?php

namespace App\Http\Requests;

use App\Models\Curhatan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCurhatanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('curhatan_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
