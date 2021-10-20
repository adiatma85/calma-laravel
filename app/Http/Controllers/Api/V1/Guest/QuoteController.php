<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Quote;
use App\Http\Controllers\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;


class QuoteController
{

    use ResponseTrait;

    // GET from journey_id
    public function show($journey_id)
    {
        $quote = Quote::firstWhere('journey_id', $journey_id);

        if (!$quote) {
            $this->notFoundFailResponse();
        }

        return $this->response(true, Response::HTTP_OK, "Success fetching resource", compact('quote'));
    }

    // GET
    public function getRandomQuote()
    {
        $quote = Quote::inRandomOrder()->first();

        return $this->response(true, Response::HTTP_OK, "Success fetchin resource", compact('quote'));
    }
}
