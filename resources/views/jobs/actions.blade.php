@if(auth()->user()->can('job-edit'))
<a href="/jobs/{{$data->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$data->id}}" {{ ($data->name == 'Writer'|| $data->name == 'Reporter') ? 'disabled' : '' }}><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif


@if(auth()->user()->can('job-delete'))

<form method="POST" style="display: inline;" action="jobs/{{$data->id}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger" {{ ($data->name == 'Writer'|| $data->name == 'Reporter') ? 'disabled' : '' }}>
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>

@endif