<?php

namespace App\Http\Requests;

use App\Models\Journal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreJournalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('journal_create');
    }

    public function rules()
    {
        return [];
    }
}
