<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCurhatanRequest;
use App\Http\Requests\UpdateCurhatanRequest;
use App\Http\Resources\Admin\CurhatanResource;
use App\Models\Curhatan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurhatanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('curhatan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CurhatanResource(Curhatan::with(['user'])->get());
    }

    public function store(StoreCurhatanRequest $request)
    {
        $curhatan = Curhatan::create($request->all());

        return (new CurhatanResource($curhatan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Curhatan $curhatan)
    {
        abort_if(Gate::denies('curhatan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CurhatanResource($curhatan->load(['user']));
    }

    public function update(UpdateCurhatanRequest $request, Curhatan $curhatan)
    {
        $curhatan->update($request->all());

        return (new CurhatanResource($curhatan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Curhatan $curhatan)
    {
        abort_if(Gate::denies('curhatan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curhatan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
