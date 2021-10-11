<div class="m-3">
    @can('music_item_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.music-items.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.musicItem.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.musicItem.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-playlistMusicItems">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.musicItem.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.musicItem.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.musicItem.fields.music_file') }}
                            </th>
                            <th>
                                {{ trans('cruds.musicItem.fields.playlist') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($musicItems as $key => $musicItem)
                            <tr data-entry-id="{{ $musicItem->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $musicItem->id ?? '' }}
                                </td>
                                <td>
                                    {{ $musicItem->name ?? '' }}
                                </td>
                                <td>
                                    @if($musicItem->music_file)
                                        <a href="{{ $musicItem->music_file->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $musicItem->playlist->name ?? '' }}
                                </td>
                                <td>
                                    @can('music_item_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.music-items.show', $musicItem->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('music_item_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.music-items.edit', $musicItem->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('music_item_delete')
                                        <form action="{{ route('admin.music-items.destroy', $musicItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('music_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.music-items.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-playlistMusicItems:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection