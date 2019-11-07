<button  id='btnFile'>Upload File</button>
                    <form method="post" id="upload_file" enctype="multipart/form-data" style="display:none;">
                    {{ csrf_field() }}
                    <label>Select File:</label></td>
                    <input type="file" name="file" id="file"/>

                    <div class="form-group" style="width:300px">
                    <label for="name">File Name: </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="name">
                    </div>

                    <div class="form-group" style="width:300px;" >
                    <label for="description"> Image Description:</label>
                    <input type="text" class="form-control" id="description" name="description" style="height:100px;" >
                    </div>

                    <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload File">
</form>

@push('form-file-scripts')
<script>
$("#btnFile").click(function() { // button toggle
$("#upload_file").toggle();
});
$(document).ready(function(){ // submit file form
$('#upload_file').on('submit', function(event){
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
$('#display_file').html(`<a href="{{ Storage::url('${data.name}') }}">${data.name}</a>`)
},
error: function(data){
printErrorMsg (data.responseJSON.errors,'file')
}
})
$(this).hide();
});
});
</script>
@endpush