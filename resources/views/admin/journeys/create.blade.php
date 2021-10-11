@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.journey.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.journeys.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.journey.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.journey.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mood_tracker_id">{{ trans('cruds.journey.fields.mood_tracker') }}</label>
                <select class="form-control select2 {{ $errors->has('mood_tracker') ? 'is-invalid' : '' }}" name="mood_tracker_id" id="mood_tracker_id">
                    @foreach($mood_trackers as $id => $entry)
                        <option value="{{ $id }}" {{ old('mood_tracker_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('mood_tracker'))
                    <span class="text-danger">{{ $errors->first('mood_tracker') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.mood_tracker_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="playlist_id">{{ trans('cruds.journey.fields.playlist') }}</label>
                <select class="form-control select2 {{ $errors->has('playlist') ? 'is-invalid' : '' }}" name="playlist_id" id="playlist_id">
                    @foreach($playlists as $id => $entry)
                        <option value="{{ $id }}" {{ old('playlist_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('playlist'))
                    <span class="text-danger">{{ $errors->first('playlist') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.playlist_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection