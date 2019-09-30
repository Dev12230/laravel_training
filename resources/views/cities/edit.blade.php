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

<form action="/cities/{{$city->id}}" method ="POST">
@csrf
{{ method_field('PATCH')}}

    <div class="form-group" style="width:500px">
      <label for="city_name">City</label>
      <input type="text" class="form-control" id="city_name" name="city_name" value="{{$city->city_name}}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="country_id">Country</label>
      <select id="country_id" class="form-control" name="country_id">
        @foreach ($countries as $key =>$country)
      <option value="{{$key}}" {{ ($city->country->name == $country) ? 'selected' : '' }}>{{$country}}</option>
        @endforeach
      </select>
    </div>
  

  <button type="submit" class="btn btn-primary">Add</button>
</form>

@endsection