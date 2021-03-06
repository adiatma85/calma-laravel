<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class AuthController
{

    use ResponseTrait;

    private $userRoles = [2];

    // POST
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            "username" => 'required|string'
        ], [
            "name" => [
                "string" => "name field must string",
                "required" => "name field must exist",
            ],
            "email" => [
                "email" => "email field must email",
                "required" => "email field must exist",
            ],
            "password" => [
                "string" => "password field must string",
                "required" => "password field must exist",
                "min" => "password have minimum 8 character"
            ],
            "username" => [
                "string" => "username field must string",
                "required" => "username field must exist",
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $condition = User::where('email', $request->email)
            ->orWhere('username', $request->username)
            ->exists();
        if ($condition) {
            return $this->response(false, Response::HTTP_CONFLICT, "Email or Username is already exists", null);
        }
        $user = User::create($request->all());
        $user->roles()->sync($this->userRoles);
        return $this->response(true, Response::HTTP_OK, "Success create user", compact('user'));
    }

    // POST
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            "email" => [
                "email" => "email field must email",
                "required" => "email field must exist",
            ],
            "password" => [
                "string" => "password field must string",
                "required" => "password field must exist",
                "min" => "password have minimum 8 character"
            ],
        ]);

        if ($validator->fails()) {
            return $this->badRequestFailResponse($validator);
        }

        $user = User::where('email', $request->email)
            // ->orWhere('username', $request->username)
            ;
        if ($user->exists()) {
            $thisUser = $user->first();
            if (Hash::check($request->password, $thisUser->password)) {
                return $this->response(true, Response::HTTP_OK, "Success login", [
                    "user_id" => $thisUser->id,
                ]);
            }
        }
        return $this->response(false, Response::HTTP_NOT_FOUND, "Credentials not found", null);
    }
}
