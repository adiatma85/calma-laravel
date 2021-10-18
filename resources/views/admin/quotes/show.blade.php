@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quote.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quotes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quote.fields.id') }}
                        </th>
                        <td>
                            {{ $quote->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quote.fields.title') }}
                        </th>
                        <td>
                            {{ $quote->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quote.fields.content') }}
                        </th>
                        <td>
                            {{ $quote->content }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quote.fields.author') }}
                        </th>
                        <td>
                            {{ $quote->author }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quotes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection