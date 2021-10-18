<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuoteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quote_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:quotes,id',
        ];
    }
}