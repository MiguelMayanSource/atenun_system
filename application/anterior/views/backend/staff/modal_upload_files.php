<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/assets/appointments/js/fileupload/file-upload-with-preview.min.css">
<style>
.custom-file-container__custom-file__custom-file-control {
    background-color: #fff;
}
</style>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>Subir archivo.</span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">

        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <div id="show_result" style="display:none;" class="alert alert-success">El archivo se subió
                    correctamente</div>
            </div>
            <div class="col-sm-12 text-center">
                <p id="f1_upload_process" style="display:none;">Subiendo archivo, un momento por
                    favor.<br /><br /><img src="<?php echo base_url();?>public/uploads/loading.gif" style="width:65px" />
                </p>
                <div id="progressBar">
                    <div></div>
                </div>
                <div id="status"></div>
            </div>

            <div class="default-according style-1  faq-accordion job-accordion  col-xl-12">
                <div class="custom-file-container" data-upload-id="myFirstImage">
                    <label><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                    <label class="custom-file-container__custom-file">
                        <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" id="attachments" name="attachments[]" multiple="multiple">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                    <div class="custom-file-container__image-preview"></div>
                </div>
            </div>
            <div class="col-sm-12" id="target">
                <div class="form-group m-b-15">
                    <a class="btn btn-success" href="#" onclick="uploadFiles()">Subir Archivo</a>
                </div>
            </div>
        </div>

        <?php echo form_close();?>
    </div>
    <div class="modal-footer">
    </div>
</div>
<script src="<?php echo base_url() ?>public/assets/appointments/js/fileupload/file-upload-with-preview.min.js"></script>
<script language="javascript" type="text/javascript">
function startUpload() {
    $('#f1_upload_process').show(500);
    $('#target').hide(500);
    return true;
}

function stopUpload(success) {
    $('#f1_upload_process').hide(500);
    $('#target').show(500);
    $('#submit_btn').show(500);
    $('#file').val('');
    $('#show_result').show(500);
    $('#show_result').delay(3000).hide(500);
    deleteAll('<?php echo $param2;?>');
    return true;
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    //First upload
    var firstUpload = new FileUploadWithPreview('myFirstImage', {
        text: {
            browse: 'Buscar',
            chooseFile: 'Seleccionar archivos...'
        },
        multiple: true,
    })

    $(window).on('fileUploadWithPreview:imagesAdded', function(e) {

        // Get a reference to our file input
        const fileInput = document.querySelector('input[type="file"]');

        //Create a new DataTransfer object
        const dataTransfer = new DataTransfer

        //Add new files from the event's DataTransfer
        for (let i = 0; i < e.detail.cachedFileArray.length; i++)
            dataTransfer.items.add(e.detail.cachedFileArray[i])


        fileInput.files = dataTransfer.files
    });

    $("form").submit(function() {
        $(this).find(':button').prop('disabled', true);
    });

    $('.custom-file-container__image-clear').hide();
})

function uploadFiles() {
    console.log('uploadFiles');
    $('#f1_upload_process').show(500);
    var filesInput = $('#attachments')[0];
    var files = filesInput.files;
    var formData = new FormData();
    formData.append('patient_id', <?php echo $param2; ?>);
    formData.append('parent_id', <?php echo $param3; ?>);

    for (var i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    }
    console.log(formData.values());
    $.ajax({
        url: '<?php echo base_url();?>staff/patient_files/upload_files',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function(e) {
                $("#progressBar div").css("width", e.loaded / e.total * 100 + "%");
            };
            return xhr;
        },
        success: function(response) {
            console.log(response);
            $('#exampleModal').modal('toggle');
            load_view('patient_files', 'files', {
                'patient_id': <?php echo $param2; ?>,
                'parent_id': <?php echo $param3; ?>
            });
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}
</script>