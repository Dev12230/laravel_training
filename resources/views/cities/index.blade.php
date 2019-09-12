@extends('layouts.admin')

@section('content')

@include('flash-message')


<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>city</th>
            <th>country</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      @foreach($cities as $city)    
        <tr>
            <td>{{ $city->city_name }}</td>
            <td>{{ $city->country->name }}</td>
      
            <td><a class="btn btn btn-primary" href=""><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
    <form method='POST'  action="#">
    @csrf
    {{ method_field('DELETE')}}
    <button   class="btn btn btn-danger" type="submit"  onclick="return myFunction();" ><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
    <script>
      function myFunction(){
        var agree = confirm("Are you sure you want to delete this Post?");
          if(agree == true){
            return true
            }
            else{
            return false;
            }
      }
    </script>
    </form>
  </td>
        </tr>
      @endforeach  
         
    </tbody>
</table>

@endsection