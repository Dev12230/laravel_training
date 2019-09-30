@if($row->user->isBanned())
<a href="{{ route('staff.active',$row->id) }}" class="btn btn-success btn-sm">Deactive</a>
@else
<a href="{{ route('staff.deActive',$row->id) }}" class="btn btn-success ban btn-sm">Active </a>
@endif