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
                            {{ trans('cruds.journey.fields.title') }}
                        </th>
                        <td>
                            {{ $journey->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.author') }}
                        </th>
                        <td>
                            {{ $journey->author }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.image') }}
                        </th>
                        <td>
                            @if($journey->image)
                                <a href="{{ $journey->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $journey->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.journey.fields.description') }}
                        </th>
                        <td>
                            {!! $journey->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2>Daftar-daftar Item Journey</h2>
            @php
                $questionIndex = 0;    
            @endphp
            <table class="table table-bordered table-striped">
                <tbody>
                    @foreach ($journey->components as $component)
                        @php
                            $routeNamePrefix = "";
                            switch ($component->model_type) {
                                case 'journals':
                                    $routeNamePrefix = "journals";
                                    break;
                                case 'music-items':
                                    $routeNamePrefix = "music-items";
                                    break;
                                case 'mood-trackers':
                                    $routeNamePrefix = "mood-trackers";
                                    break;
                            }
                            if ($component->model_type == 'journals') {
                                $routeNamePrefix = "journals";
                            } else {
                                $routeNamePrefix = "music-items";
                            }
                                
                        @endphp
                        <tr>
                            <th>
                                Item nomor {{ $component->urutan }} tipe {{ \App\Models\Journey::ITEM_JOURNEY_TYPE[$component->model_type] }}
                            </th>
                            <td>
                                <a href="{{ $component->in_model_id ? route("admin.$routeNamePrefix.show", $component->in_model_id) : '#' }}">
                                    {{ $component->model_type == 'mood_trackers' ? 'Mood Tracker' : $journey->items[$questionIndex]->name }}
                                </a>
                            </td>
                        </tr>
                        @php
                            $questionIndex++;
                        @endphp
                    @endforeach
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