
<form action="/staff/{{$row->id}}/toggle" method ="POST" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH')}}
@if($row->user->active)
<button type="submit" class="bttn btn btn-xs btn-info">Active
@else
<button type="submit" class="bttn btn btn-xs btn-success">Deactive
@endif


