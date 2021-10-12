<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Validator;


class AuthController
{

    use ResponseTrait;

    private $userRoles = [2];

    // POST
    public function register(Request $request)
    {
        $condition = User::where('email', $request->email)->exists();
        if ($condition) {
            return $this->response(false, Response::HTTP_CONFLICT, "Email is already exists", null);
        }
        $user = User::create($request->all());
        $user->roles()->sync($this->userRoles);
        return $this->response(true, Response::HTTP_OK, "Success create user", compact('user'));
    }

    // POST
    public function login(Request $request)
    {
        $user = User::where('email', $request->email);
        if ($user->exists()) {
            $thisUser = $user->first();
            if (Hash::check($request->password(), $thisUser->password)) {
                return $this->response(true, Response::HTTP_OK, "Success login", [
                    "user_id" => $thisUser->id,
                ]);
            }
        }
    }
}
