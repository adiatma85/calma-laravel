<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;


class UserController
{

    use ResponseTrait;

    // GET
    public function getUserById(Request $request)
    {
        $user = User::firstWhere('id', $request->user_id)
            // ->orWhere('username', $request->username)
            ;
        if ($user) {
            return $this->response(true, Response::HTTP_OK, "Success fetching resources", compact('user'));
        }
        return $this->response(false, Response::HTTP_NOT_FOUND, "Resources not found", null);
    }
}
