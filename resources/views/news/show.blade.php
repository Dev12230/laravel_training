@extends('layouts.admin')
@section('content')


<div class="row">


                <div class="form-group">
                    <label class="control-label" for="status">Main Title:</label>
                    <h4> {{$news->main_title}} </h4>
                </div>
     
                <div class="form-group">
                    <label class="control-label" for="status">Secondary Title:</label>
                    <h4> {{$news->secondary_title}} </h4>
                </div>

                <br>
                <div class="form-group">
                    <label class="control-label" for="status">Content:</label>
                    {!! $news->content !!}
                </div>
 
                @if($news->file)
                <div class="form-group">
                    <label class="control-label" for="status"> Files:</label><br>
                    @foreach($news->file as $file)
                    <a href="{{Storage::url($file->file)}}" >{{explode("/",$file->file)[1]}}</a><br>
                    @endforeach
                </div>
                @endif

                @if($news->image)
                <div class="form-group">
                <div class="row">
                @foreach ($news->image as $image)
                <div class="col">
                    <img src="{{ Storage::url($image->image)}}"   style="height:200px; width:200px; float:left;">
                </div>
                @endforeach
                </div>
                </div>
                @endif


                <div class="form-group">
                    <label> Related links </label>
                @foreach ($news->related as $related)
                <div class="col">
                    <a ref="#">{{$related->news->main_title}}</a>
                </div>
                @endforeach
                </div>
                </div>

</div>








@push('scripts')
@endpush

@endsection
