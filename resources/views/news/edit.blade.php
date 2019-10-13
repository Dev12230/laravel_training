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

<form action="/news/{{$news->id}}" method ="POST" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH')}}
    <div class="form-group" style="width:500px">
      <label for="main_title">Main Title:</label>
      <input type="text" class="form-control" id="main_title" name="main_title" value="{{$news->main_title}}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="secondary_title">Secondary Title:</label>
      <input type="text" class="form-control" id="secondary_title" name="secondary_title"  value="{{$news->secondary_title}}">
    </div>

    <div class="form-group">
    <label for="type"> Type:</label>
    <select  id="type" name="type">
        <option value="1" {{ ($news->type == 'artical') ? 'selected' : '' }}>Article</option>
        <option value="2" {{ ($news->type == 'news') ? 'selected' : '' }}>News</option>
    </select>
    </div>

    <div class="form-group">
      <label for="staff_id">Author:</label>
      <select name="staff_id" id="staff_id" class="form-control" style="width:350px">
      <option value="{{$news->staff->id}}">{{$news->staff->user->first_name}}<option>
      </select>
    </div>
      
    </div>

    <div class="form-group">
    <label for="content">Content:</label>
    <textarea name="content" id="content">{{$news->content}}</textarea>
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
    @foreach ($relNews as $key => $news)
         @if(in_array($news, $selectedNews))
          <option value="{{$key}}" selected>{{$news}}</option>
          @else
          <option value="{{$key}}" >{{$news}}</option>
          @endif
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
  var uploadedImages = []
  let imageDropzone = new Dropzone('#image-drop', {
    url: "{{ route('uploads') }}",
    paramName: "image",
    maxThumbnailFilesize: 1, // MB
    acceptedFiles: ".png,.jpg",
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (image, response) {
      $('form').append('<input id="my" type="hidden" name="image[]" value="' + response.url + '">')
      uploadedImages.push(response.url)
    },
    removedfile: function (image) {
      image.previewElement.remove()
      var name = ''
        uploadedImages.forEach(myFunction);
        function myFunction(item) {
          var n = item.includes(image.name);
           if (n ==true){
            name = item
           }
      }
      $('form').find('input[name="image[]"][value="' + name + '"]').remove()  
    },

  })
</script>
<script>
Dropzone.autoDiscover = false;
  var uploadedFiles = []
  let fileDropzone = new Dropzone('#file-drop', {
    paramName: "file",
    url: "{{ route('uploads') }}",
    maxThumbnailFilesize: 1, // MB
    acceptedFiles: ".pdf,.xlsx",
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="file[]" value="' + response.url + '">')
      uploadedFiles.push(response.url)
    }, 
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      uploadedFiles.forEach(myFunction);
        function myFunction(item) {
          var n = item.includes(file.name);
           if (n ==true){
            name = item
           }
      }
      $('form').find('input[name="file[]"][value="' + name + '"]').remove()  
    },
  })
  </script>
<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
@endsection