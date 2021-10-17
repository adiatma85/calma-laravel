<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyJourneyRequest;
use App\Http\Requests\StoreJourneyRequest;
use App\Http\Requests\UpdateJourneyRequest;
use App\Models\Journey;
use App\Models\JourneyComponent;
use App\Models\Journal;
use App\Models\MusicItem;
use Gate;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JourneyController extends Controller
{

    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('journey_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journeys = Journey::with(['media'])->get();

        return view('admin.journeys.index', compact('journeys'));
    }

    public function create()
    {
        abort_if(Gate::denies('journey_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $musics = MusicItem::all();

        $journals = Journal::all();

        return view('admin.journeys.create', compact('musics', 'journals'));
    }

    public function store(StoreJourneyRequest $request)
    {
        $journey = Journey::create($request->all());

        if ($request->input('image', false)) {
            $journey->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $journey->id]);
        }

        // Store Journal
        if ($itemsJournal = $request->item_journal) {
            $index = 0;
            foreach ($itemsJournal as $item) {
                JourneyComponent::create([
                    'model_type' => 'journals',
                    'in_model_id' => $item,
                    'journey_id' => $journey->id,
                    'urutan' => $request->urutan_journal[$index],
                ]);
                $index++;
            }
        }

        // Store Music
        if ($itemsMusic = $request->item_music) {
            $index = 0;
            foreach ($itemsMusic as $item) {
                JourneyComponent::create([
                    'model_type' => 'music_items',
                    'in_model_id' => $item,
                    'journey_id' => $journey->id,
                    'urutan' => $request->urutan_music[$index],
                ]);
                $index++;
            }
        }

        return redirect()->route('admin.journeys.index');
    }

    public function edit(Journey $journey)
    {
        abort_if(Gate::denies('journey_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.journeys.edit', compact('journey'));
    }

    public function update(UpdateJourneyRequest $request, Journey $journey)
    {
        $journey->update($request->all());

        if ($request->input('image', false)) {
            if (!$journey->image || $request->input('image') !== $journey->image->file_name) {
                if ($journey->image) {
                    $journey->image->delete();
                }
                $journey->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($journey->image) {
            $journey->image->delete();
        }

        return redirect()->route('admin.journeys.index');
    }

    public function show($journey_id)
    {
        abort_if(Gate::denies('journey_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journey = Journey::find($journey_id);

        // $journey->load('components');

        $items = [];
        $components = $journey->components
            ->sortBy('urutan')
            ->values()
            ->all();

        foreach ($components as $component) {
            switch ($component->model_type) {
                case 'journals':
                    $item = Journal::find($component->in_model_id);
                    array_push($items, $item);
                    break;
                case 'music_items':
                    $item = MusicItem::find($component->in_model_id);
                    array_push($items, $item);
                    break;
            }
        }

        $journey->items = $items;
        
        return view('admin.journeys.show', compact('journey'));
    }

    public function destroy(Journey $journey)
    {
        abort_if(Gate::denies('journey_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journey->delete();

        return back();
    }

    public function massDestroy(MassDestroyJourneyRequest $request)
    {
        Journey::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('journey_create') && Gate::denies('journey_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Journey();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
