@if($row->user->active)
<a href="/staff/{{$row->id}}/toggle" class="btn btn-success btn-sm">Active</a>
@else
<a href="/staff/{{$row->id}}/toggle" class="btn btn-success ban btn-sm">Deactive </a>
@endif