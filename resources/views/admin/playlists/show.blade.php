@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.playlist.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.playlists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.playlist.fields.id') }}
                        </th>
                        <td>
                            {{ $playlist->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.playlist.fields.name') }}
                        </th>
                        <td>
                            {{ $playlist->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.playlist.fields.description') }}
                        </th>
                        <td>
                            {!! $playlist->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.playlist.fields.duration') }}
                        </th>
                        <td>
                            {!! $playlist->duration !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.playlist.fields.topic') }}
                        </th>
                        <td>
                            {{ $playlist->topic->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.playlists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#playlist_music_items" role="tab" data-toggle="tab">
                {{ trans('cruds.musicItem.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="playlist_music_items">
            @includeIf('admin.playlists.relationships.playlistMusicItems', ['musicItems' => $playlist->playlistMusicItems])
        </div>
    </div>
</div>

@endsection