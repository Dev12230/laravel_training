@if($data->user->isBanned())
<a href="{{ route('staff.unban',$data->id) }}" class="btn btn-success btn-sm">Deactive</a>
@else
<a href="{{ route('staff.ban',$data->id) }}" class="btn btn-success ban btn-sm">Active </a>
@endif