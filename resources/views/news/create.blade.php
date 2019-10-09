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

<form action="{{route('news.store')}}" method ="POST" enctype="multipart/form-data">
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
    <input type="file" class="form-control" name="image[]" multiple="multiple" />
    </div>

    <div class="form-group">
    <label for="file">File Upload(can load more than one)</label>
    <input type="file" class="form-control" name="file[]" multiple="multiple" />
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
<script>
$('#multi').picker({
  search :true
});
</script>

<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
@endsection