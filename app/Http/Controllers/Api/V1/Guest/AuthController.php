<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController
{
    public function register(Request $request)
    {
        User::create($request->all());
    }

    public function login()
    {

    }
}
