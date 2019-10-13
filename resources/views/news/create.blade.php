@extends('layouts.admin')

@section('content')

@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
@endif

<form role="news" action="{{route('news.store')}}" method ="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group" style="width:500px">
      <label for="main_title">Main Title:</label>
      <input type="text" class="form-control" id="main_title" name="main_title" >
    </div>

    <div class="form-group" style="width:500px">
      <label for="secondary_title">Secondary Title:</label>
      <input type="text" class="form-control" id="secondary_title" name="secondary_title" >
    </div>

    <div class="form-group">
    <label for="type"> Type:</label>
    <select  id="type" name="type">
        <option>Select ..</option>
        <option value="1">Article</option>
        <option value="2">News</option>
    </select>
    </div>

    <div class="form-group">
      <label for="staff_id">Author:</label>
      <select name="staff_id" id="staff_id" class="form-control" style="width:350px">
      </select>
    </div>
      
    </div>

    <div class="form-group">
    <label for="content">Content:</label>
    <textarea name="content" id="content"></textarea>
    </div>

    <div class="form-group">
            <label for="image">Image Upload(can load more than one)</label>
            <div class="needsclick dropzone" id="image-drop">
            </div>
      </div>

  
    <div class="form-group">
            <label for="file">File Upload(can load more than one)</label>
            <div class="needsclick dropzone" id="file-drop">
            </div>
      </div>  


    <div class="form-group">
    <label>Choose Related News</label>
    <select data-placeholder="Choose News..." class="chosen-select" multiple style="width:400px;" name="related[]">
          <option value="">Select</option>
          @foreach ($relNews as $key => $news)
          <option value="{{$key}}">{{$news}}</option>
          @endforeach>
      </select>
    </div>
    
  <button type="submit" class="btn btn-primary">Add</button>

</form>

@push('scripts')

<!-- ckEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
<script>
        ClassicEditor
            .create( document.querySelector('#content') )    
            .catch( error => {
                console.error( error );
            } );

</script>

<!-- staff_id ajax request -->
<script type="text/javascript">
 $('#type').change(function(){
    var jobId = $(this).val();   
    if(jobId){
      $.ajax({
        type:"GET",
           url:"{{url('get-authors')}}?job_id="+jobId,
           success:function(data){  
            if(data){
                $("#staff_id").empty();
                $("#staff_id").append('<option>Select</option>');
                $.each(data,function(key,value){
                    $("#staff_id").append(`<option value='${key}' >${value}</option>`);
                });
           }else{ 
             $("#staff_id").empty(); 
           }             
          } 
      }); 
    }else{
     $("#staff_id").empty(); 
    }       
  });
</script>
<!-- Drop Image -->
<script>
  Dropzone.autoDiscover = false;
  var uploadedImages = {}
  let imageDropzone = new Dropzone('#image-drop', {
    url: "{{ route('uploads') }}",
    paramName: "image",
    maxThumbnailFilesize: 1, // MB
    acceptedFiles: ".png,.jpg",
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    renameFile: function(image) {
                var dt = new Date();
                var time = dt.getTime();
                console.log(time+image.name)
               return time+image.name;
    },
    success: function (image, response) {
      $('form').append('<input id="my" type="hidden" name="image[]" value="' + response.url + '">')
      uploadedImages[image.name] = response.url
    },
    removedfile: function (image) {
                image.previewElement.remove()
                let name = '';
                if (typeof image.file_name !== 'undefined') {
                    name = image.file_name;
                } else {
                    name = uploadedImages[image.name];
                }
                $('form').find('input[name="image[]"][value="'+ name +'"]').remove()
            },

  })
</script>
<!-- Drop File -->
<script>
Dropzone.autoDiscover = false;
  var uploadedFiles = {}
  let fileDropzone = new Dropzone('#file-drop', {
    url: "{{ route('uploads') }}",
    maxThumbnailFilesize: 1, // MB
    acceptedFiles: ".pdf,.xlsx",
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="file[]" value="' + response.url + '">')
      uploadedFiles[file.name]=response.url
      console.log(uploadedFiles)
    }, 
    removedfile: function (file) {
      console.log(file.name)
                file.previewElement.remove()
                let name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name;
                } else {
                    name = uploadedFiles[file.name];
                }
                console.log(name)
                $('form').find('input[name="file[]"][value="'+ name +'"]').remove()
            },
  })
  </script>
<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
@endsection