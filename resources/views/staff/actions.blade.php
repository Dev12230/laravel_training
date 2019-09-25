
<a href="/staff/{{$data->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$data->id}}"><i class="fa fa-edit"></i><span>Edit</span></a> 



<form method="POST" style="display: inline;" action="staff/{{$data->id}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger">
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>
