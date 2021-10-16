@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.journal.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.journals.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.journal.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journal.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
              <div class="col-12">
                <label for="">Daftar-daftar pertanyaan</label>
                <div class="row" id="addFieldAppend">

                </div>
                <div class="d-flex justify-content-center">
                  <button class="btn btn-info btn-block" id="addFieldButton">
                    Tambahkan pertanyaan
                    <i class="fa fa-plus-circle ml-2"></i>
                  </button>
                </div>
              </div>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.journals.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $journal->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>
{{-- Add On Script --}}
<script>
  let index = 0;
  $(document).ready(function() {
          // Listener for Addfieldbutton
          $("#addFieldButton").click(function(event) {
              event.preventDefault();
              $("#addFieldAppend").append(appendElement(index));
              document.getElementById(`removeSign-${index}`).addEventListener('click', removeFunction);
              index++;
          });

          // Helper dari #addFieldButton onClick (adder)
          function appendElement(numerical){
              $org = `<div class='form-group col-md-12' id='field-${numerical}'>` +
              "<div class='row'>" +
              "<div class='col-md-11'>" +
              "<input type='text' name='add_journal_questions[]' class='form-control' placeholder='Pertanyaan' required>" +
              "</div>" +
              "<div class='col-md-1'>" +
              `<button class='btn btn-warning btn-block' id='removeSign-${numerical}'>` +
                  "<i class='fas fa-times-circle'></i>" +
              "</button>" +
              "</div>" +
              "</div>" +
              "</div>";
              return $org;
          }

          // listener dari remover fieldbutton
          function removeFunction(event){
              event.preventDefault();
              if (event.target !== this) {
                  return;
              }
              let removeSignId = event.target.id
              let number = removeSignId.split("-")[1];
              let element = document.getElementById(`field-${number}`);
              element.remove();
              index--;
          } 
      });
  </script>
@endsection