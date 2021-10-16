<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJournalRequest;
use App\Http\Requests\StoreJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use App\Models\Journal;
use App\Models\Journey;
use App\Models\JournalQuestion;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class JournalController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('journal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journals = Journal::with(['journey'])->get();

        $journeys = Journey::get();

        return view('admin.journals.index', compact('journals', 'journeys'));
    }

    public function create()
    {
        abort_if(Gate::denies('journal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.journals.create');
    }

    public function store(StoreJournalRequest $request)
    {
        $journal = Journal::create($request->only('name'));
        if ($questions = $request->input('add_journal_questions')) {
            foreach ($questions as $question) {
                JournalQuestion::create([
                    'question' => $question,
                    'journal_id' => $journal->id,
                ]);
            }
        }
        return redirect()->route('admin.journals.index');
    }

    public function edit(Journal $journal)
    {
        abort_if(Gate::denies('journal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journeys = Journey::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $journal->load('journey');

        return view('admin.journals.edit', compact('journeys', 'journal'));
    }

    public function update(UpdateJournalRequest $request, Journal $journal)
    {
        $journal->update($request->all());

        return redirect()->route('admin.journals.index');
    }

    public function show(Journal $journal)
    {
        abort_if(Gate::denies('journal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journal->load('questions');

        return view('admin.journals.show', compact('journal'));
    }

    public function destroy(Journal $journal)
    {
        abort_if(Gate::denies('journal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $journal->delete();

        return back();
    }

    public function massDestroy(MassDestroyJournalRequest $request)
    {
        Journal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('journal_create') && Gate::denies('journal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Journal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
