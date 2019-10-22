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

<form id="event" action="/events/{{$event->id}}" method ="POST" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH')}}
    <div class="form-group" style="width:500px">
      <label for="main_title">Main Title:</label>
      <input type="text" class="form-control" id="main_title" name="main_title" value="{{$event->main_title}}" >
    </div>

   <input id="objId" type="hidden" name="id" value="{{$event->id}}">

    <div class="form-group" style="width:500px">
      <label for="secondary_title">Secondary Title:</label>
      <input type="text" class="form-control" id="secondary_title" name="secondary_title"  value="{{$event->secondary_title}}">
    </div>

    <div class="form-group">
    <label for="content">Content:</label>
    <textarea name="content" id="content">{{$event->content}}</textarea>
    </div>

    <div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="start_date">Start Date</label>
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input id="start_date" type="text" class="form-control" placeholder="start date .." name="start_date" autocomplete="off" value="{{$event->start_date}}">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="end_date">End Date</label>
                <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input id="end_date" type="text" class="form-control" placeholder="end date .." name="end_date" autocomplete="off" value="{{$event->end_date}}">
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Choose Visitors:</label>
    <select id="Visitor_id" data-placeholder="Choose Visitors..." class="chosen-select" multiple style="width:400px;" name="visitor_id[]">
    @if(!empty($visitors))
      @foreach($visitors as $key=>$visitor)
      <option selected="selected" value="{{$key}}">{{$visitor}}</option>
      @endforeach
    @endif  
    </select>
</div>

<div class="form-group">
            <label for="image">Image Upload(can load more than one)</label>
            <div class="needsclick dropzone" id="image-drop">
            </div>
</div>

    <div class="form-group">
        <label for="address_address">Address</label>
        <input type="text" id="address-input" name="address_address" class="form-control map-input" value="{{$event->address_address}}" >
        <input type="hidden" name="address_latitude" id="address-latitude"  value="{{$event->address_latitude}}" />
        <input type="hidden" name="address_longitude" id="address-longitude"  value="{{$event->address_longitude}}"/>
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
<!-- google map  -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>

<!-- Drop Image -->
@include('script-methods/dropzone_image')

<!-- js validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\EventsRequest') !!}
@endpush
@endsection
