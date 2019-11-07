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
                   @include('folders/forms/image')
                </div>

                <div class="col-md-4">
                   @include('folders/forms/file')
                </div>

                <div class="col-md-4">
                   @include('folders/forms/video')
                </div>
            
 </div>

</div>
@push('scripts')
<!----------------------------------------- upload image------------------------------------------->
@stack('form-image-scripts')
<!----------------------------------------- upload file----------------------------------------- -->
@stack('form-file-scripts')
<!----------------------------------------- upload video------------------------------------------->
@stack('form-video-scripts')
<!-- ---------------------------------------------------------------------------------------->
<!-- error message -->
<script>
   function printErrorMsg (msg,k) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
              if(key == k || key== 'name' || key == 'description'){
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
              }
            });
        }
</script>
<!-- select staff -->
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

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\MediaRequest') !!}
@endpush
@endsection
