<div class="modal-content animated fadeInDown">
<div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i
                class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>Subir archivo.</span></h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<?php echo form_open(base_url().'drive/createFile/', array('enctype' => 'multipart/form-data', 'target' => 'upload_target', 'id' => 'frm')); ?>
    <div class="form-group row">
        <div class="col-sm-12 text-center">
            <div id="show_result" style="display:none;" class="alert alert-success">El archivo se subió
                correctamente</div>
        </div>
        <div class="col-sm-12 text-center">
            <p id="f1_upload_process" style="display:none;">Subiendo archivo, un momento por
                favor.<br /><br /><img src="<?php echo base_url();?>public/uploads/loading.gif"
                    style="width:65px" /></p>
            <p id="upload_result"></p>
        </div>
        <div class="col-sm-12" id="target">
            <div class="form-group m-b-15">
                <label class="labelx" for="apply"><input type="file" name="file" class="inputx" id="apply"
                        onchange="startUpload()">Seleccionar archivo</label>
                <small id="fileResponse"></small>
            </div>
        </div>

        <input type="hidden" id="folderId" name="folderId" value="<?php echo $param2;?>">
        <input type="hidden" id="patient_id" name="patient_id" value="<?php echo $param3;?>">
    </div>
    <iframe id="upload_target" name="upload_target" src="javascript:void(0)"
        style="width:0;height:0;border:0px solid #fff;"></iframe>
    <?php echo form_close();?>
</div>
<div class="modal-footer">
</div>
</div>

    <script language="javascript" type="text/javascript">

        function startUpload() {
    $('#f1_upload_process').show(500);
    $('#target').hide(500);
    $('#frm').submit();

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