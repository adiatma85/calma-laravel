<?php

namespace App\Http\Requests;

use App\Models\Journal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyJournalRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('journal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:journals,id',
        ];
    }
}
