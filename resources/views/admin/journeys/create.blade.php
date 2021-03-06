@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.journey.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.journeys.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.journey.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="author">{{ trans('cruds.journey.fields.author') }}</label>
                <input class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}" type="text" name="author" id="author" value="{{ old('author', '') }}" required>
                @if($errors->has('author'))
                    <span class="text-danger">{{ $errors->first('author') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.author_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.journey.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.journey.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.journey.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
              <div class="col-12">
                <label for="">Daftar Item Journey</label>
                <div class="row" id="addFieldAppend">

                </div>
                <div class="d-flex justify-content-center">
                  <button class="btn btn-info btn-block" id="addFieldButton">
                    Tambahkan Item Journey
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
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.journeys.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($journey) && $journey->image)
      var file = {!! json_encode($journey->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
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
                xhr.open('POST', '{{ route('admin.journeys.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $journey->id ?? 0 }}');
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
              document.getElementById(`optionNumber-${index}`).addEventListener('change', onChangeValueNumber);
              index++;
          });

          // Helper dari #addFieldButton onClick (adder)
          function appendElement(numerical){
              $org = `<div class='form-group col-md-12' id='field-${numerical}'>` +
              "<div class='row'>" +
              "<div class='col-md-1'>" +
              `<select class='search option-class form-control' id='optionNumber-${numerical}'>` + 
                "<option value='' selected>Please Select</option>" + 
                "<option value='journal'>Journal</option>" + 
                "<option value='music'>Music</option>" + 
              "</select>" + 
              "</div>" +
              "<div class='col-md-8'>" +
                  `<select class='search option-class form-control' id='valueNumber-${numerical}'> name=''` + 
                    "<option value''>Please Select</option>" + 
                    // Nanti tambahannya di sini!
                  "</select>" + 
                "</div>" +
              "</div>" +
              "<div class='col-md-2'>" +
                `<input type='text' name='' class='form-control' placeholder='Urutan' id='urutanNumber-${numerical}'>` +
                "</div>" +
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

          function onChangeValueNumber(event){
              event.preventDefault();
              if (event.target !== this) {
                  return;
              }
              let optioNumberId = event.target.id;
                let number = optioNumberId.split("-")[1];
                let arrayFill = [];
                let targetValue = event.target.value;

                switch (targetValue) {
                  case "journal":
                    arrayFill = @json($journals);
                    break;
                  case "music":
                    arrayFill = @json($musics);
                    break;
                }
                // console.log(targetValue)
                // console.log(number)
                // console.log(arrayFill)
                arrayFill.forEach( (value) => {
                  // console.log(value);
                  $(`#valueNumber-${number}`).append(literalLoop(value.id, value.name));
                } );

                $(`#valueNumber-${number}`).attr('name', `item_${targetValue}[]`);
                $(`#urutanNumber-${number}`).attr('name', `urutan_${targetValue}[]`);
          }

          function literalLoop(itemValue, itemName){
            $org = `<option value='${itemValue}'>${itemName}</option>`;
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