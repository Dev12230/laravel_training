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

<form role="news" action="{{route('events.store')}}" method ="POST" enctype="multipart/form-data">
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
    <label for="content">Content:</label>
    <textarea name="content" id="content"></textarea>
    </div>

    <div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="start_date">Start Date</label>
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input id="start_date" type="text" class="form-control" placeholder="start date .." name="start_date" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="end_date">End Date</label>
                <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input id="end_date" type="text" class="form-control" placeholder="end date .." name="end_date" autocomplete="off">
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Choose Visitors:</label>
    <select id="Visitor_id" data-placeholder="Choose Visitors..." class="chosen-select" multiple style="width:400px;" name="visitor_id[]">
    </select>
</div>

<div class="form-group">
            <label for="image">Image Upload(can load more than one)</label>
            <div class="needsclick dropzone" id="image-drop">
            </div>
</div>

    <div class="form-group">
        <label for="address_address">Address</label>
        <input type="text" id="address-input" name="address_address" class="form-control map-input">
        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
    </div>
    <div id="address-map-container" style="width:100%;height:400px; ">
        <div style="width: 100%; height: 100%" id="address-map"></div>
    </div>

<br>

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
<!-- data picker -->
<script>
$('#start_date').datetimepicker({ format: 'Y-M-D HH:mm:ss', });
$('#end_date').datetimepicker({ format: 'Y-M-D HH:mm:ss', });
</script>
<!-- Visitor ID -->
<script>
$(".chosen-select").select2({
    ajax: {
    type: "GET",
    url:"{{url('get-visitors')}}",
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
<!-- Drop Image -->
<script>
  Dropzone.autoDiscover = false;
  var uploadedImages = {}
  let imageDropzone = new Dropzone('#image-drop', {
    url: "{{url('event/upload-image')}}",
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
<!-- google map  -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>

<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\EventsRequest') !!}
@endpush
@endsection
