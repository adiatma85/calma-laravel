@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.journal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.journals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.journal.fields.id') }}
                        </th>
                        <td>
                            {{ $journal->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journal.fields.name') }}
                        </th>
                        <td>
                            {{ $journal->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journal.fields.cover_image') }}
                        </th>
                        <td>
                            @if($journal->cover_image)
                                <a href="{{ $journal->cover_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $journal->cover_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2>Daftar-daftar pertanyaan</h2>
            @php
                $questionIndex = 1;    
            @endphp
            <table class="table table-bordered table-striped">
                <tbody>
                    @foreach ($journal->questions as $questionItem)
                        <tr>
                            <th>
                                Pertanyaan nomor {{ $questionIndex }}
                            </th>
                            <td>
                                {{ $questionItem->question ?? "" }}
                            </td>
                        </tr>
                        @php
                            $questionIndex++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.journals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection