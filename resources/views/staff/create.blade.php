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

<form action="{{route('staff.store')}}" method ="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group" style="width:500px">
      <label for="first_name">First Name:</label>
      <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="last_name">Last Name:</label>
      <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
    </div>

    <div class="form-group">
    <label for="disabledTextInput"> Gender:</label>
    <select  id="exampleFormControlSelect1" name="gender">
    <option value="male" >Male</option>
    <option value="female">Female</option>
    </select>
    </div>

    <div class="form-group" style="width:500px">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
    </div>

    <div class="form-group" style="width:500px">
      <label for="phone">Phone:</label>
      <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}">
    </div>


    <div class="form-group" style="width:500px">
      <label for="country_id">Country :</label>
      <select id="country_id" class="form-control" name="country_id">
        <option selected>Choose...</option>
        @foreach ($countries as $key =>$country)
      <option value="{{$key}}">{{$country}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="city_id">Select City:</label>
      <select name="city_id" id="city_id" class="form-control" style="width:350px">
      </select>
    </div>

    <div class="form-group" style="width:500px">
      <label for="job_id">Job:</label>
      <select id="job_id" class="form-control" name="job_id">
        <option selected>Choose...</option>
        @foreach ($jobs as $key => $job)
      <option value="{{$key}}">{{$job}}</option>
        @endforeach
      </select>
    </div>

    <div class="funkyradio" style="width:500px">
     <label for="role">Role:</label>
     <select id="role" class="form-control" name="role">
        <option selected>Choose...</option>
        @foreach ($roles as $key => $role)
      <option  value="{{$role}}" >{{$role}}</option>
        @endforeach
      </select>
      
    </div>


    <br>
    <div class="form-group" style="width:500px">
    <label for="image">Image:</label>
    <input type="file" name="image" >
    </div>


  <button type="submit" class="btn btn-primary">Add Staff</button>


</form>

@push('scripts')
<script type="text/javascript">
 $('#country_id').change(function(){
    var countryID = $(this).val();   
    if(countryID){
      $.ajax({
        type:"GET",
           url:"{{url('get-cities')}}?country_id="+countryID,
           success:function(data){  
            if(data){
                $("#city_id").empty();
                $("#city_id").append('<option>Select</option>');
                $.each(data,function(key,value){
                    $("#city_id").append(`<option value='${key}' >${value}</option>`);
                });
           }else{ 
             $("#city_id").empty(); 
           }             
          } 
      }); 
    }else{
     $("#city_id").empty(); 
    }       
  });
</script>
@endpush
@endsection