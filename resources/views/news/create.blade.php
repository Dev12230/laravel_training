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
        @foreach($types as $key =>$value)
        <option value="{{$key}}">{{$value}}</option>
        @endforeach
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
    <select id="published" data-placeholder="Choose News..." class="chosen-select" multiple style="width:400px;" name="related[]">
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
<!-- published news -->
<script>
$(".chosen-select").select2({
        ajax: {
            type: "GET",
            url:"{{url('get-published')}}",
            data: function (params) {
                if (params){
                    return {
                        search: params.term,
                    };
                }
            },
            processResults: function (data) {
                let result = data.map(function (item) {
                    return {id: item.id, text: item.main_title};
                });
                return {
                    results: result
                };
            }
        },
    });
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
    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
    success: function (image, response) {
      $('form').append('<input id="my" type="hidden" name="image[]" value="' + response.id + '">')
      uploadedImages[image.name] = response.id
    },
    removedfile: function (image) {
      image.previewElement.remove()
      let id = '';
      id = uploadedImages[image.name];
        $.ajax({
        type:"GET",
        url:'/delete-image/'+id ,
        });
      $('form').find('input[name="image[]"][value="'+ id +'"]').remove()
    },

  })
</script>
<!-- Drop File -->
<script>
  Dropzone.autoDiscover = false;
  var uploadedFiles = {}
  let fileDropzone = new Dropzone('#file-drop', {
      url: "{{ route('uploads') }}",
      paramName: "file",
      maxThumbnailFilesize: 1, // MB
      acceptedFiles: ".pdf,.xlsx",
      addRemoveLinks: true,
      headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
      success: function (file, response) {
          console.log(response)
          $('form').append('<input id="my" type="hidden" name="file[]" value="' + response.id + '">')
          uploadedFiles[file.name] = response.id
          console.log(uploadedFiles)
        },
      removedfile: function (file) {
          file.previewElement.remove()
          let id = '';
          id = uploadedFiles[file.name];
            $.ajax({
            type:"GET",
            url:'/delete-file/'+id ,
            });
          $('form').find('input[name="file[]"][value="'+ id +'"]').remove()
        },

  })
</script>
<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
@endsection