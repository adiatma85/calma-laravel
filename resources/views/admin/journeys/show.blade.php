@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.journey.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.journeys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.id') }}
                        </th>
                        <td>
                            {{ $journey->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.name') }}
                        </th>
                        <td>
                            {{ $journey->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.user') }}
                        </th>
                        <td>
                            {{ $journey->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.mood_tracker') }}
                        </th>
                        <td>
                            {{ $journey->mood_tracker->mood ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.playlist') }}
                        </th>
                        <td>
                            {{ $journey->playlist->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.journeys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection