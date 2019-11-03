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

<form action="/folders/{{$folder->id}}" method ="POST">
@csrf
{{ method_field('PATCH')}}
    <div class="form-group" style="width:500px">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{$folder->name}}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="description">Description</label>
      <input type="text" class="form-control" id="description" name="description" value="{{$folder->description}}">
    </div>

    <div class="form-group">
    <label>Staff :</label>
     <select id="staff" name="staff[]"  class="chosen-select" multiple style="width:400px;" >
     @if(!empty($folder->permitted))
      @foreach($folder->permitted as $member)
      <option selected="selected" value="{{$member->id}}">{{$member->user->first_name}}</option>
      @endforeach
    @endif   
    </select>
    </div>

<br>
  <button type="submit" class="btn btn-primary">Edit</button>
</form>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\FolderRequest') !!}

<br><br>

<div class="container">
    <div class="row">
       <div id="display_image" class="col-md-4">
           @if(isset($folder->image))
            <img  src="{{ Storage::url($folder->image->image) }}" class="img-thumbnail" width="100" height="100" />
           @endif
        </div>
       <div id="display_file" class="col-md-4" >
           @if(isset($folder->file))
            <a href="{{ Storage::url($folder->file->file) }}">{{$folder->file->file}}</a>
            @endif
        </div>
       <div id="display_video" class="col-md-4" >
         @if(isset($folder->video))
         <b>{{$folder->video}}</b>
         @endif
       </div>
    </div>
</div>
<br>
<br>

<div class="container">
            <div class="row">
                <div class="col-md-4">
                    <button  id='btnImage'>Upload Image</button>
                    <form method="post" id="upload_image" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select Image:</label></td>
                    <input type="file" name="image" id="image"/>

                    <div class="form-group" style="width:300px">
                    <label for="name">Image Name: </label>
                    <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description"> Image Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;">
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload Image">
                    </form>
                </div>

                <div class="col-md-4">
                    <button  id='btnFile'>Upload File</button>
                    <form method="post" id="upload_file" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select File:</label></td>
                    <input type="file" name="file" id="file"/>

                    <div class="form-group" style="width:300px">
                    <label for="name">File Name: </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="name">
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description"> Image Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;" >
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload File">
                    </form>
                </div>

                <div class="col-md-4">
                    <button  id='btnVideo'>Upload Video</button>
                    <form method="post" id="upload_video" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select Video:</label></td><br>
                      <input type="radio" name="choose" value='pc'>Upload From Pc<br>
                      <input type="file" name="video_pc" id="pc" style="display:none;"/><br>
                      <input type="radio" name="choose" value='youtube'>Upload From Youtube<br>
                      <input type="text" name="video_youtube" id="youtube" style="display:none;"><br>

                    <div class="form-group" style="width:300px">
                    <label for="name">Video Name: </label>
                    <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description">Video Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;">
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload File">
                    </form>
                </div>
            
 </div>

</div>
<br>
<a class="btn btn-success " href="{{route('folders.index')}}"><span>Back</span></a><br><br>
@push('scripts')
<!-- upload image button click -->
<script>
$(".chosen-select").select2({
        ajax: {
            type: "GET",
            url: "{{ route('get-staff') }}",
            data: function (params) {
                if (params){
                    return {
                        search: params.term,
                    };
                }
            },
            processResults: function (data) {
                let result = data.map(function (item) {
                    return {id: item.id, text: item.user.first_name};
                });
                return {
                    results: result
                };
            }
        },
    });
  </script>
<!----------------------------------------- upload image------------------------------------------->
<script>
$("#btnImage").click(function() {          // button toggle
    $("#upload_image").toggle();
});

$(document).ready(function(){              // submit image form
$('#upload_image').on('submit', function(event){
 event.preventDefault();
 $.ajax({
  url:"{{url("upload-Folder-Image/$folder->id")}}",
  type: "POST",
  headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
  data:new FormData(this),
  dataType:'JSON',
  contentType: false,
  cache: false,
  processData: false,
  success:function(data){
    $('#display_image').html(`<img  src="{{ Storage::url('${data.name}') }}" class="img-thumbnail" width="100" height="100"" />`)
  },
  error: function(data){
    printErrorMsg (data.responseJSON.errors)
  }
 })
 $(this).hide();
});
});
</script>
<!----------------------------------------- upload file----------------------------------------- -->
<script>
$("#btnFile").click(function() {         // button toggle
    $("#upload_file").toggle();

});
 
$(document).ready(function(){            // submit file form
$('#upload_file').on('submit', function(event){
 event.preventDefault();
 $.ajax({
  url:"{{url("upload-Folder-File/$folder->id")}}",
  type: "POST",
  headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
  data:new FormData(this),
  dataType:'JSON',
  contentType: false,
  cache: false,
  processData: false,
  success:function(data){
    $('#display_file').html(`<a href="{{ Storage::url('${data.name}') }}">${data.name}</a>`)
  },
  error: function(data){
    printErrorMsg (data.responseJSON.errors)
  }
 })
 $(this).hide();
});
});
</script>
<!----------------------------------------- upload video------------------------------------------->
<script>
$("#btnVideo").click(function() {        // button toggle
    $("#upload_video").toggle();

});
</script>
<script>
// chose video type
$('input[name="choose"]').click(function(e) {
  if(e.target.value === 'pc') {
    $('#pc').show();
    $('#youtube').hide();
  } else if(e.target.value === 'youtube'){
    $('#youtube').show();
    $('#pc').hide();
  }
})
</script>
<script>
$(document).ready(function(){            // submit video form
$('#upload_video').on('submit', function(event){
 event.preventDefault();
 $.ajax({
  url:"{{url("upload-Folder-Video/$folder->id")}}",
  type: "POST",
  headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
  data:new FormData(this),
  dataType:'JSON',
  contentType: false,
  cache: false,
  processData: false,
  success:function(data){
    if(data.name.startsWith("videos")){
      $('#display_video').html(`<a href="{{ Storage::url('${data.name}') }}">${data.name}</a>`)
    }else{
      $('#display_video').html(`<iframe width="420" height="315" src="//www.youtube.com/embed/${data.name}" frameborder="0" allowfullscreen></iframe>`)
    },
  },
  error: function(data){
    printErrorMsg (data.responseJSON.errors)
  }
 })
 $(this).hide();
});
});
</script>
<!-- ---------------------------------------------------------------------------------------->
<!-- error message -->
<script>
   function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
</script>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\MediaRequest') !!}
@endpush
@endsection