<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJourneyRequest;
use App\Http\Requests\UpdateJourneyRequest;
use App\Http\Resources\Admin\JourneyResource;
use App\Models\Journey;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JourneyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('journey_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JourneyResource(Journey::with(['user', 'mood_tracker', 'playlist'])->get());
    }

    public function store(StoreJourneyRequest $request)
    {
        $journey = Journey::create($request->all());

        return (new JourneyResource($journey))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Journey $journey)
    {
        abort_if(Gate::denies('journey_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JourneyResource($journey->load(['user', 'mood_tracker', 'playlist']));
    }

    public function update(UpdateJourneyRequest $request, Journey $journey)
    {
        $journey->update($request->all());

        return (new JourneyResource($journey))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Journey $journey)
    {
        abort_if(Gate::denies('journey_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journey->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
