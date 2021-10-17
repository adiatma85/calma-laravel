<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Models\Journey;
use App\Models\JourneyComponent;
use App\Models\Journal;
use App\Models\MusicItem;
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

        $journeys->makeHidden('description');

        return $this->response(true, Response::HTTP_OK, 'Success fetching resources', compact('journeys'));
    }

    // GET
    public function show($journeyId)
    {
        $journey = Journey::find($journeyId);

        if (!$journey) {
            return $this->notFoundFailResponse();
        }

        $journey->load('components');

        unset($journey->description);

        return $this->response(true, Response::HTTP_OK, "Success fetching resource", compact('journey'));
    }

    // GET Components
    public function getComponent($journeyComponentId)
    {
        $journeyComponent = JourneyComponent::find($journeyComponentId);

        if (!$journeyComponent) {
            return $this->notFoundFailResponse();
        }

        switch ($journeyComponent->model_type) {
            case 'journals':
                $item = Journal::with(['questions', 'media'])->firstwhere('id', $journeyComponent->in_model_id);

                break;

            case 'music_items':
                $item = MusicItem::find($journeyComponent->in_model_id);
                break;
        }

        return $this->response(true, Response::HTTP_OK, 'Successing fetching resource', [
            "item" => $item
        ]);
    }

}
