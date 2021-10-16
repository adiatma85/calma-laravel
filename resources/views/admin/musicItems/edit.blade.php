@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.musicItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.music-items.update", [$musicItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.musicItem.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $musicItem->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.musicItem.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="music_file">{{ trans('cruds.musicItem.fields.music_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('music_file') ? 'is-invalid' : '' }}" id="music_file-dropzone">
                </div>
                @if($errors->has('music_file'))
                    <span class="text-danger">{{ $errors->first('music_file') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.musicItem.fields.music_file_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="duration">{{ trans('cruds.playlist.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $musicItem->duration ?? "") }}" required>
                @if($errors->has('duration'))
                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.playlist.fields.duration_helper') }}</span>
              </div>
            <div class="form-group">
                <label class="required" for="playlist_id">{{ trans('cruds.musicItem.fields.playlist') }}</label>
                <select class="form-control select2 {{ $errors->has('playlist') ? 'is-invalid' : '' }}" name="playlist_id" id="playlist_id" required>
                    @foreach($playlists as $id => $entry)
                        <option value="{{ $id }}" {{ (old('playlist_id') ? old('playlist_id') : $musicItem->playlist->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('playlist'))
                    <span class="text-danger">{{ $errors->first('playlist') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.musicItem.fields.playlist_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.musicFileDropzone = {
    url: '{{ route('admin.music-items.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="music_file"]').remove()
      $('form').append('<input type="hidden" name="music_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="music_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($musicItem) && $musicItem->music_file)
      var file = {!! json_encode($musicItem->music_file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="music_file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection