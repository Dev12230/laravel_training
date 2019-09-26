@if($data->user->isBanned())
<a href="{{ route('staff.active',$data->id) }}" class="btn btn-success btn-sm">Deactive</a>
@else
<a href="{{ route('staff.deActive',$data->id) }}" class="btn btn-success ban btn-sm">Active </a>
@endif