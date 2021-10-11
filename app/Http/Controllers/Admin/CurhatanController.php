<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCurhatanRequest;
use App\Http\Requests\StoreCurhatanRequest;
use App\Http\Requests\UpdateCurhatanRequest;
use App\Models\Curhatan;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CurhatanController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('curhatan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curhatans = Curhatan::with(['user'])->get();

        $users = User::get();

        return view('admin.curhatans.index', compact('curhatans', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('curhatan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.curhatans.create', compact('users'));
    }

    public function store(StoreCurhatanRequest $request)
    {
        $curhatan = Curhatan::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $curhatan->id]);
        }

        return redirect()->route('admin.curhatans.index');
    }

    public function edit(Curhatan $curhatan)
    {
        abort_if(Gate::denies('curhatan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $curhatan->load('user');

        return view('admin.curhatans.edit', compact('users', 'curhatan'));
    }

    public function update(UpdateCurhatanRequest $request, Curhatan $curhatan)
    {
        $curhatan->update($request->all());

        return redirect()->route('admin.curhatans.index');
    }

    public function show(Curhatan $curhatan)
    {
        abort_if(Gate::denies('curhatan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curhatan->load('user');

        return view('admin.curhatans.show', compact('curhatan'));
    }

    public function destroy(Curhatan $curhatan)
    {
        abort_if(Gate::denies('curhatan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curhatan->delete();

        return back();
    }

    public function massDestroy(MassDestroyCurhatanRequest $request)
    {
        Curhatan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('curhatan_create') && Gate::denies('curhatan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Curhatan();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
