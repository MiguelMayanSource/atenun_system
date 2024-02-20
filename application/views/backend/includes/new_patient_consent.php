<h5 class="panel-content-title">Nuevo consentimiento</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
    <form action="<?php echo base_url().'/'.$this->session->userdata('login_type').'/patient_consent/add_consent';?>" method="post" enctype="multipart/form-data" id="formSample">
        <input type='hidden' name="origin_id" value="<?php echo $origin_id;?>" />
        <input type='hidden' name="origin_type" value="<?php echo $origin_type;?>" />
        <input type='hidden' name="patient_id" value="<?php echo $patient_id;?>" />
        <div class="row" style="overflow-y:auto">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="datetime-local" class="form-control" name="date_solicite" id="order_date" placeholder="Fecha" value="<?php echo date('Y-m-d\TH:i');?>" onfocus="this.showPicker()">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="motive" id="motive" placeholder="motivo" value="">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea type="text"  class="form-control med" placeholder="Observaciones" autocomplete="off" id="order_med" style="height: 5em;"></textarea>
                </div>
            </div>
            <hr>
        </div>
        <hr>
    </div>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
        <div class="form-group">
            <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_consent','consent',{'patient_id':<?php echo $patient_id;?>,'origin_type':'<?php echo $origin_type;?>','origin_id':<?php echo $origin_id;?>})">Cancelar</a>
            <button style='Float:right;'  class="btn btn-primary submit" onclick="submit_form()">Guardar</button>
        </div>
    </div>
    </form>
</div>
<script>
CKEDITOR.disableAutoInline = true;
    if ($('#order_med').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('order_med');
    }

function submit_form() {
    console.log('enviando form');
    $('#formSample').submit();
}
$("#formSample").submit(function(e) {
    e.preventDefault();
    console.log('enviando form');
    $('.submit').attr('disabled', 'disabled');
    $('.submit').html('Guardando....');
    var form = $(this);
    var url = form.attr('action');

    var formData = new FormData(this);
    var contenido = CKEDITOR.instances.order_med.getData(); // Obtener el contenido del editor CKEditor

    // Agregar el contenido al FormData
    formData.append('details', contenido);


    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                type: 'success',
                title: 'Agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            });

            load_view('patient_consent', 'consent', {
                'patient_id': patient_id,
                'origin_id':'<?php echo $origin_id;?>',
                'origin_type':'<?php echo $origin_type; ?>',
            })


        },
        error: function() {
            console.log("error");
        }
    });



});
</script>