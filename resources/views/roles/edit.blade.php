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

<form action="/roles/{{$role->id}}" method ="POST">
@csrf
{{ method_field('PATCH')}}

    <div class="form-group" style="width:500px">
      <label for="name">Role Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{$role->name}}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="description">Description</label>
      <input type="text" class="form-control" id="description" name="description" value="{{$role->description}}">
    </div>


     <h4>Permisssions:</h4>

    <div class="funkyradio">
        @foreach($permissions as $key =>$permission)
        <div class="funkyradio-default">
           @if(in_array($permission, $rolePermissions))
            <input type="checkbox" name="permission[]" id="permission"  value="{{$key}}" checked/>
           @else
            <input type="checkbox" name="permission[]" id="permission"  value="{{$key}}" />
           @endif
            <label for="permission">{{$permission}}</label>
        </div>
        @endforeach
    </div>

<br>

  <button type="submit" class="btn btn-primary">Add Role</button>


</form>
@endsection