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

<form action="{{route('roles.store')}}" method ="POST">
@csrf
    <div class="form-group" style="width:500px">
      <label for="name">Role Name</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>

    <div class="form-group" style="width:500px">
      <label for="description">Description</label>
      <input type="text" class="form-control" id="description" name="description">
    </div>


     <h4>Permisssions:</h4>

    <div class="funkyradio">
        @foreach($permissions as $permission)
        <div class="funkyradio-default">
            <input type="checkbox" name="permission[]" id="permission"  value="{{$permission->id}}" />
            <label for="permission">{{$permission->name}}</label>
        </div>
        @endforeach
    </div>

<br>

  <button type="submit" class="btn btn-primary">Add Role</button>


</form>
@endsection