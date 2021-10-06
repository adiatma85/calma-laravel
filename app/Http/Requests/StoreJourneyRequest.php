<?php

namespace App\Http\Requests;

use App\Models\Journey;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreJourneyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('journey_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
