@if(auth()->user()->can('news-show'))
<a href="/news/{{$row->id}}" class="bttn btn btn-xs btn-primary " data-id="{{$row->id}}"><span>Show</span></a> 
@enidif

@if(auth()->user()->can('news-edit'))
<a href="/news/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif

@if(auth()->user()->can('news-delete'))
<form method="POST" style="display: inline;" action="news/{{$row->id}}">
@csrf {{ method_field('DELETE ')}}
<button type="submit" onclick=" confirm('Are you sure \?');" class="bttn btn btn-xs btn-danger">
<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span>
</button>
</form>
@endif

