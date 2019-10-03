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

<form action="{{route('jobs.store')}}" method ="POST">
@csrf
    <div class="form-group" style="width:500px">
      <label for="name">Job Name</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>

    <div class="form-group" style="width:500px">
      <label for="description">Description </label>
      <input type="text" class="form-control" id="description" name="description">
    </div>
  

  <button type="submit" class="btn btn-primary">Add job</button>
</form>

@push('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\JobRequest') !!}
@endpush
@endsection