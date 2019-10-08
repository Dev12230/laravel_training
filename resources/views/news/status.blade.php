@if($row->is_publish)
<a href="/news/{{$row->id}}/toggle" class="btn btn-success btn-sm">Publish</a>
@else
<a href="/news/{{$row->id}}/toggle" class="btn btn-success ban btn-sm">Unpublish</a>
@endif