<?php

namespace App\Http\Requests;

use App\Models\MoodTrackerReason;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMoodTrackerReasonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mood_tracker_reason_create');
    }

    public function rules()
    {
        return [
            'reason' => [
                'string',
                'nullable',
            ],
        ];
    }
}
