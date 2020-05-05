var base_url = base_url;
//alert(base_url);
$(".gallery").dropzone({
        url: "upload_files",
        maxFilesize: 1000,
       // acceptedFiles: 'image/*',
        init: function () {
            var submit2 = document.getElementById('submit2');
            if (this.getUploadingFiles().length != 0 && this.getQueuedFiles().length != 0) {
                submit2.disabled = true;
            }
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    submit2.disabled = false;
                }
            });
            this.on('success', function (file, resp) {
            });
        },
        success: function (result, xhr) {
            var obj = jQuery.parseJSON(xhr);
            result.customid = obj.path;
            if (obj.type == 0) {
                $("#hiddenimages").append('<input type="hidden" name="images[]" value="' + obj.path + '">');
            } else {
                $("#hiddenimages").append('<input type="hidden" name="images[]" value="' + obj.path + '">');
            }
        },
        addRemoveLinks: true,
        removedfile: function (file) {
            var path = file.customid;
            alert(path);
            var res = path.replace(base_url, '');
            $.ajax({
                type: 'POST',
                url: "delete_files",
                data: {path: res},
                success: function (data) {
                    $("#hiddenimages input[value='" + path + "']").remove();
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        sending: function () {
            var submit2 = document.getElementById('submit2');
            submit2.disabled = true;
        }
    });
 
 
 