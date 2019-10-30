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

<form action="{{route('folders.store')}}" method ="POST">
@csrf
    <div class="form-group" style="width:500px">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>

    <div class="form-group" style="width:500px">
      <label for="description">Description</label>
      <input type="text" class="form-control" id="description" name="description">
    </div>


    <div class="form-group">
    <label>Staff :</label>
     <select id="staff" name="staff[]"  class="chosen-select" multiple style="width:400px;" >
    </select>
    </div>
  <br>

  <button type="submit" class="btn btn-primary">Add</button>


</form>
@push('scripts')
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
{!! JsValidator::formRequest('App\Http\Requests\FolderRequest') !!}
@endpush
@endsection