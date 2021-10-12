<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class LoginPostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
