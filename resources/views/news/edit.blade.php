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

<form id="news" action="/news/{{$news->id}}" method ="POST" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH')}}

    <div class="form-group" style="width:500px">
      <label for="main_title">Main Title:</label>
      <input type="text" class="form-control" id="main_title" name="main_title" value="{{$news->main_title}}">
    </div>

   <input id="objId" type="hidden" name="id" value="{{$news->id}}">

    <div class="form-group" style="width:500px">
      <label for="secondary_title">Secondary Title:</label>
      <input type="text" class="form-control" id="secondary_title" name="secondary_title"  value="{{$news->secondary_title}}">
    </div>

    <div class="form-group">
    <label for="type"> Type:</label>
    <select  id="type" name="type">
        @foreach($types as $key =>$value)
        <option value="{{$key}}"{{ ($news->type == $value) ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
    </select>
    </div>

    <div class="form-group">
      <label for="staff_id">Author:</label>
      <select name="staff_id" id="staff_id" class="form-control" style="width:350px">
      @foreach ($authors as $key =>$author)
      <option value="{{$key}}" {{ ($news->staff->id== $key) ? 'selected' : '' }} >{{$author}}<option>
       @endforeach
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
    <select id="published" data-placeholder="Choose News..." class="chosen-select" multiple style="width:400px;" name="related[]">
    @if(!empty($selectedNews))
      @foreach($selectedNews as $key=>$news)
      <option selected="selected" value="{{$key}}">{{$news}}</option>
      @endforeach
    @endif  
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
<!-- Drop File -->
@include('script-methods/dropzone_file')
<!-- Drop Image -->
@include('script-methods/dropzone_image')

<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
@endsection