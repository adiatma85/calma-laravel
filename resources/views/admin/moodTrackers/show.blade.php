@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moodTracker.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mood-trackers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTracker.fields.id') }}
                        </th>
                        <td>
                            {{ $moodTracker->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTracker.fields.mood') }}
                        </th>
                        <td>
                            {{ $moodTracker->mood }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moodTracker.fields.user') }}
                        </th>
                        <td>
                            {{ $moodTracker->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mood-trackers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection