@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.moodTrackerReason.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.mood-tracker-reasons.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="mood_tracker_id">{{ trans('cruds.moodTrackerReason.fields.mood_tracker') }}</label>
                <select class="form-control select2 {{ $errors->has('mood_tracker') ? 'is-invalid' : '' }}" name="mood_tracker_id" id="mood_tracker_id">
                    @foreach($mood_trackers as $id => $entry)
                        <option value="{{ $id }}" {{ old('mood_tracker_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('mood_tracker'))
                    <span class="text-danger">{{ $errors->first('mood_tracker') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.moodTrackerReason.fields.mood_tracker_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reason">{{ trans('cruds.moodTrackerReason.fields.reason') }}</label>
                <input class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" type="text" name="reason" id="reason" value="{{ old('reason', '') }}">
                @if($errors->has('reason'))
                    <span class="text-danger">{{ $errors->first('reason') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.moodTrackerReason.fields.reason_helper') }}</span>
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