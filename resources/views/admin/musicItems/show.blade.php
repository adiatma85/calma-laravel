@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.musicItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.music-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.id') }}
                        </th>
                        <td>
                            {{ $musicItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.name') }}
                        </th>
                        <td>
                            {{ $musicItem->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.squared_image') }}
                        </th>
                        <td>
                            @if($musicItem->squared_image)
                                <a href="{{ $musicItem->squared_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $musicItem->squared_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.rounded_image') }}
                        </th>
                        <td>
                            @if($musicItem->rounded_image)
                                <a href="{{ $musicItem->rounded_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $musicItem->rounded_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.duration') }}
                        </th>
                        <td>
                            {{ $musicItem->duration ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.musicItem.fields.playlist') }}
                        </th>
                        <td>
                            {{ $musicItem->playlist->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.music-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection