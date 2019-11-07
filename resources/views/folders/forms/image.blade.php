
<button  id='btnImage'>Upload Image</button>
                    <form method="post" id="upload_image" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select Image:</label></td>
                    <input type="file" name="image" id="image" required/>

                    <div class="form-group" style="width:300px">
                    <label for="name">Image Name: </label>
                    <input type="text" class="form-control" id="name" name="name" >
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description"> Image Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;">
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload Image">
</form>



@push('form-image-scripts')
<script>
$("#btnImage").click(function() { // button toggle
$("#upload_image").toggle();
});

$(document).ready(function(){ // submit image form
$('#upload_image').on('submit', function(event){
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
    $('#display_image').html(`<img src="{{ Storage::url('${data.name}') }}" class="img-thumbnail" width="100" height="100"" />`)
},
error: function(data){
  console.log(data)
printErrorMsg (data.responseJSON.errors,'image')
}
})
$(this).hide();
});
});
</script>
@endpush
