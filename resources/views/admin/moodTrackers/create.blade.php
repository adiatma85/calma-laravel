@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.moodTracker.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.mood-trackers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="mood">{{ trans('cruds.moodTracker.fields.mood') }}</label>
                <input class="form-control {{ $errors->has('mood') ? 'is-invalid' : '' }}" type="text" name="mood" id="mood" value="{{ old('mood', '') }}" required>
                @if($errors->has('mood'))
                    <span class="text-danger">{{ $errors->first('mood') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.moodTracker.fields.mood_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.moodTracker.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.moodTracker.fields.user_helper') }}</span>
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