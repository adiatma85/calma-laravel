<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('quote_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'content' => [
                'string',
                'required',
            ],
            'author' => [
                'string',
                'required',
            ],
        ];
    }
}