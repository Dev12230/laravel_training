@if(auth()->user()->can('job-edit'))
@if( !($JobName == 'Writer' || $JobName == 'Reporter') )
<a href="/jobs/{{$JobId}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$JobId}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@else
<a href="/jobs/{{$JobId}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$JobId}}" disabled><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif
@endif

@if(auth()->user()->can('job-delete'))
@if( !($JobName == 'Writer' || $JobName == 'Reporter') )
<form method="POST" style="display: inline;" action="jobs/{{$JobId}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger">
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>
@else
<a href="#" class="bttn btn btn-xs btn-danger"  disabled><i class="fa fa-edit"></i><span>Delete</span></a> 
@endif
@endif