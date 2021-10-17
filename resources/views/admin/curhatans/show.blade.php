@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.curhatan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.curhatans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.curhatan.fields.id') }}
                        </th>
                        <td>
                            {{ $curhatan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.curhatan.fields.content') }}
                        </th>
                        <td>
                            {!! $curhatan->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.curhatan.fields.category') }}
                        </th>
                        <td>
                            {!! $curhatan->category !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.curhatan.fields.is_anonymous') }}
                        </th>
                        <td>
                            <span class="badge badge-pill badge-{{ !$curhatan->is_anonymous ? 'success' : 'warning' }}">
                                {{ !$curhatan->is_anonymous ? 'Anonymous' : 'Non-Anonymous' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.curhatan.fields.user') }}
                        </th>
                        <td>
                            {{ $curhatan->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.curhatans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection