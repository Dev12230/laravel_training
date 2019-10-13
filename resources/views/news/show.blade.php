@extends('layouts.admin')
@section('content')

{!! $news->content !!}
 
@foreach ($images as $image)
<div>
<img src="{{ Storage::url($image)}}" style="height:50px; width:50px;">
</div>
<br>
@endforeach
@endsection
