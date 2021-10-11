<?php

namespace App\Http\Requests;

use App\Models\Curhatan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCurhatanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('curhatan_create');
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
