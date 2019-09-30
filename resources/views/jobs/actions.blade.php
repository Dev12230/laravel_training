@if(auth()->user()->can('job-edit'))
<a href="/jobs/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}" {{ ($row->name == 'Writer'|| $row->name == 'Reporter') ? 'disabled' : '' }}><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif


@if(auth()->user()->can('job-delete'))

<form method="POST" style="display: inline;" action="jobs/{{$row->id}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger" {{ ($row->name == 'Writer'|| $row->name == 'Reporter') ? 'disabled' : '' }}>
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>

@endif