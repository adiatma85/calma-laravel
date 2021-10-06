<?php

namespace App\Http\Requests;

use App\Models\MoodTracker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMoodTrackerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mood_tracker_edit');
    }

    public function rules()
    {
        return [
            'mood' => [
                'string',
                'required',
            ],
        ];
    }
}
