@extends('layouts.admin')
@section('content')

@include('flash-message')

<div class="alert alert-danger print-error-msg" style="display:none">
<ul></ul>
 </div>

<div class="row">
                <div class="form-group">
                    <label class="control-label" for="status">Name:</label>
                    <h4> {{$folder->name}} </h4>
                </div>
     
                @if(isset($folder->description))
                <div class="form-group">
                    <label class="control-label" for="status">Description:</label>
                    <h4> {{$folder->description}} </h4>
                </div>
                @endif


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

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\MediaRequest') !!}
@endpush
@endsection
