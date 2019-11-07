<button  id='btnVideo'>Upload Video</button>
                    <form method="post" id="upload_video" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select Video:</label></td><br>
                      <input type="radio" name="choose" value='pc'>Upload From Pc<br>
                      <input type="file" name="video_pc" id="pc" style="display:none;"/><br>
                      <input type="radio" name="choose" value='youtube'>Upload From Youtube<br>
                      <input type="text" name="video_youtube" id="youtube" style="display:none;"><br>

                    <div class="form-group" style="width:300px">
                    <label for="name">Video Name: </label>
                    <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description">Video Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;">
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload Video">
</form>


@push('form-video-scripts')
<script>
$("#btnVideo").click(function() {        // button toggle
    $("#upload_video").toggle();

});
</script>
<script>
// chose video type
$('input[name="choose"]').click(function(e) {
  if(e.target.value === 'pc') {
    $('#pc').show();
    $('#youtube').hide();
  } else if(e.target.value === 'youtube'){
    $('#youtube').show();
    $('#pc').hide();
  }
})
</script>
<script>
$(document).ready(function(){            // submit video form
$('#upload_video').on('submit', function(event){
 event.preventDefault();
 $.ajax({
  url:"{{url("upload/folder/$folder->id")}}",
  type: "POST",
  headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
  data:new FormData(this),
  dataType:'JSON',
  contentType: false,
  cache: false,
  processData: false,
  success:function(data){
    if(data.name.startsWith("videos")){
      $('#display_video').html(`<a href="{{ Storage::url('${data.name}') }}">${data.name}</a>`)
    }else{
      $('#display_video').html(`<iframe width="420" height="315" src="//www.youtube.com/embed/${data.name}" frameborder="0" allowfullscreen></iframe>`)
    }
  },
  error: function(data){
    printErrorMsg (data.responseJSON.errors , 'video_pc')
  }
 })
 $(this).hide();
});
});
</script>
@endpush