@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moodTrackerReason.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mood-tracker-reasons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTrackerReason.fields.id') }}
                        </th>
                        <td>
                            {{ $moodTrackerReason->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTrackerReason.fields.mood_tracker') }}
                        </th>
                        <td>
                            {{ $moodTrackerReason->mood_tracker->mood ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTrackerReason.fields.reason') }}
                        </th>
                        <td>
                            {{ $moodTrackerReason->reason }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mood-tracker-reasons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection