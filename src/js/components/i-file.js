let fileInput = document.querySelector("[data-upload-id='file-input']")

if(fileInput){
    console.log(fileInput)
    const upload = new FileUploadWithPreview.FileUploadWithPreview('file-input');

    upload.options.multiple = true

    $(document).on('change', '.input-container input', function(e) {
        $(this).parents(".file-input").addClass("_uploaded")
    })

    $(document).on('click', '.image-preview-item-clear', function(e) {
        let count = $(this).parents(".file-input").find(".image-preview-item").length
        if(count === 1){
            $(this).parents(".file-input").removeClass("_uploaded")
        }
    })
}


