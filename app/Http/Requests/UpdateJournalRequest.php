<?php

namespace App\Http\Requests;

use App\Models\Journal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJournalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('journal_edit');
    }

    public function rules()
    {
        return [];
    }
}
