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

<form action="{{route('cities.store')}}" method ="POST">
@csrf
    <div class="form-group" style="width:500px">
      <label for="city_name">City</label>
      <input type="text" class="form-control" id="city_name" name="city_name">
    </div>

    <div class="form-group" style="width:500px">
      <label for="country_id">Country</label>
      <select id="country_id" class="form-control" name="country_id">
        <option selected>Choose...</option>
        @foreach ($countries as $key =>$country)
      <option value="{{$key}}">{{$country}}</option>
        @endforeach
      </select>
    </div>
  

  <button type="submit" class="btn btn-primary">Add</button>
</form>
@endsection