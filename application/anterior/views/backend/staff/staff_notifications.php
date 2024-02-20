<?php 
    $staff_id = base64_decode($id_);
    $this->db->where('staff_id', $staff_id);
    $info = $this->db->get('staff')->result_array();    
    foreach($info as $details):
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/staff_profile/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>staff/staff_notifications/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/staff_security/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/staff_activity/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/staff_permissions/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="todo-content" style="margin-bottom:10%">
        <?php 
        $this->db->order_by('notification_id', 'DESC');
        $notifications = $this->db->get_where('notification', array('to_user' => $staff_id, 'to_type' => 'staff'));
            if($notifications->num_rows() > 0):
            ?>
        <div class="row">
            <div class="col-sm-9" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Notificaciones del usuario - <?php echo $this->accounts_model->get_name('staff',$details['staff_id']);?></span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Mantente informado.</span>
                    <span class="alert-content">Aquí podrás visualizar todas las notificaciones de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span> y así mantenerte al tanto de lo que sucede, puedes eliminarlas o marcarlas como leídas.</span>
                </div>
                <br>
                <div class="tasks-section" style="background: #fff; border-radius: 10px; padding: 12px;">
                    <div class="tasks-list-w">
                        <ul class="tasks-list">
                            <?php
                                            foreach($notifications->result_array() as $dm):
                                        ?>
                            <a style="text-decoration:none;color:#000" href="javascript:void(0)">
                                <li class="draggable-task <?php if($dm['read_status'] == 0):?> danger <?php else:?> success <?php endif;?>">
                                    <div class="todo-task-drag drag-handle">
                                        <i class="os-icon os-icon-hamburger-menu-2 drag-handle"></i>
                                    </div>
                                    <div class="todo-task success">
                                        <span><?php echo $dm['message'];?> </span><br><small><?php echo $dm['date'];?></small>
                                    </div>
                                </li>
                            </a>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php else:?>
        <div class="row">
            <div class="col-sm-9" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Notificaciones del usuario</span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Mantente informado.</span>
                    <span class="alert-content">Aquí podrás visualizar todas las notificaciones de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span> y así mantenerte al tanto de lo que sucede, puedes eliminarlas o marcarlas como leídas.</span>
                </div>
                <br>
            </div>
        </div>
        <div class="card-box">
            <center><br>
                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;"> No se tiene registro de notificaciones aún.</h4>

                <img src="<?php echo base_url();?>public/uploads/notificaciones.svg" style="width:25%" />
            </center>
        </div>
        <?php endif;?>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$(function() {
    'use strict';
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>





<!--     <div id="main-content">
	    <div class="row">

		    <div class="col-sm-4">

		        <div class="card-box">
					<div class="row">
					    <div class="col-sm-12 m-b-30 row">
                             
                                <div class="col-md-4">
                                    <input style="display:none" id="fpassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Nueva contraseña" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <span id="errorm"></span>
                                    <input style="display:none" id="spassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Repetir contraseña" class="form-control" required>
                                </div>
                            
					        <button style="display:none" class="btn btn-success" id="btnpassword" disabled onclick="changePass()" >Cambiar contraseña</button>
					    </div>

					
					</div>
				</div>
		    </div>
	    </div>
	</div>-->
<?php 
    endforeach;
    ?>
<script>
var bool = false;

function showPass() {
    if (bool) {
        bool = false;
        $('#fpassword').hide(500);
        $('#spassword').hide(500);
        $('#btnpassword').hide(500);
    } else {
        $('#fpassword').show(500);
        $('#spassword').show(500);
        $('#btnpassword').show(500);
        bool = true;
    }
}

function validatePass() {

    var fpass = $('#fpassword').val();
    var spass = $('#spassword').val();

    if (fpass == spass) {


        $('#btnpassword').prop('disabled', false);


        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');
        $('#errorm').text('');



    } else {
        $('#btnpassword').prop('disabled', true);
        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');
        $('#errorm').text('Las contraseñas no son iguales.').addClass('error').animate({}, 300);

    }




}

function changePass() {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Se enviará un correo al paciente con la información de la cita. ¿Seguro deseas continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo base_url();?>staff/password_change_pass",
                type: 'POST',
                data: {
                    'id': <?php echo base64_decode($id_);?>,
                    'pass': $('#spassword').val()


                },
                success: function(data) {

                    if (data = 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'cambiado correctamente'
                        });

                        $('#fpassword').hide(500);
                        $('#spassword').hide(500);
                        $('#btnpassword').hide(500);

                        $('#fpassword').val('');
                        $('#spassword').val('');

                        bool = false;

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'error',
                            title: data
                        })



                    }

                },
                error: function(data) {
                    /*
                     * Se ejecuta si la peticón ha sido erronea
                     * */
                    alert("Problemas al tratar de enviar el formulario");
                }
            });

        }
    });
}
</script>