<script type="text/javascript">
//get name of model (news or event) from id of form 
if(document.getElementById("news")){
var model= 'news'
}else if(document.getElementById("event")){
var model= 'event'
}
//------------------------------------------------
Dropzone.autoDiscover = false;
    var uploadedImages = {}
      let imageDropzone = new Dropzone('#image-drop', {
      url: `{{url('${model}/upload-image')}}`,  //use ${model-name} in url 
      paramName: "image",
      maxThumbnailFilesize: 1, // MB
      acceptedFiles: ".png,.jpg",
      addRemoveLinks: true,
      headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
      success: function (image, response) {
        $('form').append('<input id="my" type="hidden" name="image[]" value="' + response.id + '">')
        uploadedImages[image.name] = response.id
      },
      removedfile: function (image) {
        image.previewElement.remove()
        let id = '';
        id = uploadedImages[image.name];
          $.ajax({
          type:"GET",
          url:'/delete-image/'+id ,
          });
        $('form').find('input[name="image[]"][value="'+ id +'"]').remove()
      },
      init:function(){
        @if(isset($news) || isset($event))   // if method update, in case of (news or event) 
        var Id = $('#objId').val(); 
        myDropzone = this;
        $.ajax({
          type:"POST",
          headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
          url:`{{url('${model}/get-images')}}?id=`+Id,    //use ${model-name} in url 
          success: function(data){
            if(data){
              data.forEach(myFunction);
              function myFunction(item, index) {
                var mockFile = {name: item.image};
                myDropzone.options.addedfile.call(myDropzone, mockFile)
                myDropzone.options.thumbnail.call(myDropzone, mockFile,`{{ Storage::url('${mockFile.name}') }}`)
                $('form').append('<input id="my" type="hidden" name="image[]" value="' + item.id + '">')
                uploadedImages[mockFile.name]=item.id
              } 
            }else{ 
            $("#form").empty()
            } 
          }
        });
        @endif

       if (model=='event'){       // cover image if model is event
        this.on("complete",function(image){
                 var radio = document.createElement('input')
                 radio.type='radio'
                 radio.name='cover_image'
                 radio.value=uploadedImages[image.name]
                 radio.id='cover'
                 var label = document.createElement('label')
                 label.htmlFor = 'cover'
                 label.appendChild(document.createTextNode('Mark As Cover'))                   
                 image.previewTemplate.appendChild(radio)
                 image.previewTemplate.appendChild(label)
            });
       }
    }, 
})
</script>