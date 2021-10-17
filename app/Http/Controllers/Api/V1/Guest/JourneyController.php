<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Journey;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class JourneyController
{
    use ResponseTrait;

    // GET
    public function index()
    {
        $journeys = Journey::all();

        return $this->response(true, Response::HTTP_OK, 'Success fetching resources', compact('journeys'));
    }

    public function show($journeyId)
    {
    }
}
