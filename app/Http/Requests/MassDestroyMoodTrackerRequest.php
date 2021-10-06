<?php

namespace App\Http\Requests;

use App\Models\MoodTracker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMoodTrackerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mood_tracker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mood_trackers,id',
        ];
    }
}
