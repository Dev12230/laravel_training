@if(auth()->user()->can('role-edit'))
<a href="/roles/{{$RoleId}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$RoleId}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif

@if(auth()->user()->can('role-delete'))
<form method="POST" style="display: inline;" action="roles/{{$RoleId}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger">
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>
@endif