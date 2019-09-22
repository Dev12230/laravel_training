@if(auth()->user()->can('city-edit'))
<a href="/cities/{{$CityId}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$CityId}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif

@if(auth()->user()->can('city-delete'))
<form method="POST" style="display: inline;" action="cities/{{$CityId}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger">
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>
@endif