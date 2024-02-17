<style>

</style>
<link href="<?php echo base_url();?>public/assets/input/script.css" media="all" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/input/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/input/font-fileuploader.css" rel="stylesheet">
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/whatsapp/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0317_send_post_paper_plane"></i></div> <span>Enviar Mensaje</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/send_email/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0288_mobile_phone_call"></i></div> <span>Enviar correo</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/whatsapp_notifications/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></div> <span>Notificaciones</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <?php 
            $notificatons = $this->db->get('whatsapp_notification')->result_array();
            foreach($notificatons as $noti):
        ?>
        <div class="col-md-4 m-b-30">
            <div class="card-box">
                <div class="card-h">
                    <h5 class="card-caption"><?php echo $noti['title'];?></h5>
                </div>
                <div class="card-b">
                    <form action="<?php echo base_url();?>staff/whatsapp_notifications/update/<?php echo $noti['type'];?>" method="POST" enctype="multipart/form-data" id="formWhatsapp">
                        <div class="form-group">
                            <label for="simpleinput">Mensaje</label><span class="error_show" id="errorpat"></span>
                            <textarea class="form-control" rows="5" name="message" id="message" required><?php echo $noti['message'];?></textarea>
                        </div>
                        <div class="form-group " style="text-align:right">
                            <button type="submit" class="btn btn-success"> Actualizar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<script src="<?php echo base_url();?>public/assets/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {

    $('#formWhatsapp').submit(function() {
        // Deshabilitar el botón de envío del formulario
        $('button[type="submit"]').attr('disabled', 'disabled');
        $('button[type="submit"]').html('Enviando...');
        $('button[type="submit"]').append('<i class="loading" ></i>');
    });

    validate(0);
    getPatients(0);
    getUsers(0);
    $('.select2').select2();

    $('input[name="archivo"]').fileuploader({
        theme: 'One-button',
    });


})

function validate(value) {
    if (value == 0) {
        $("#patients").show();
        $("#users").hide();
    } else {
        $("#users").show();
        $("#patients").hide();
    }

}

function getPatients(value) {
    $.ajax({
        url: "<?php echo base_url().'staff/getPatientsWhatsapp/';?>",
        type: "POST",
        data: {
            insurance_id: value,
        },
        success: function(response) {


            $('#patients_list').html(response);
            // console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}

function getUsers(value) {
    console.log(value);
    $.ajax({
        url: "<?php echo base_url().'staff/getStaffWhatsapp/';?>",
        type: "POST",
        data: {
            category_id: value,
        },
        success: function(response) {


            $('#users_list').html(response);
            // console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}
</script>