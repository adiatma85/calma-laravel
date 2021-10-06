<?php

namespace App\Http\Requests;

use App\Models\Journey;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJourneyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('journey_edit');
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
