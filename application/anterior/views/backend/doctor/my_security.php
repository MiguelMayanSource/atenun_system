<?php 
    $doctor_id = $this->session->userdata('login_user_id');
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">

                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_profile/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Mi perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad <span class="side-active"></span> </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Contraseña y Seguridad</span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Manten tu cuenta protegida.</span>
                    <span class="alert-content">Tu seguridad y la de tu información es nuestra <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">prioridad</a></span>, sin embargo sugerimos que tu contraseña sea actualizada cada 3 meses como mínimo. </span>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>doctor/doctors/update_password/<?php echo $doctor_id;?>" method="POST" id="doctorUpdate" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nueva contraseña:</label>
                                    <input type="password" style="border: 1px solid #198cff8f;" name="new_pass" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Confirmar nueva contraseña:</label>
                                    <input type="password" style="border: 1px solid #198cff8f;" name="confirm_pass" required="" onkeyup="validatePass()" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <button class="btn btn-primary">Aplicar cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <br>

                <h5 class="panel-content-title" style="font-weight:100">Otras opciones de seguridad.</h5>
                <span class="app-divider2"></span>
                <a onclick="remove_session();">
                    <div class="support-ticket">
                        <div class="st-body">
                            <div class="avatar">
                                <img src="<?php echo base_url();?>public/uploads/icons/password.png" style="width: 40px;">
                            </div>
                            <div class="ticket-content">
                                <div class="ticket-description">
                                    <div class="os-progress-bar primary">
                                        <div class="bar-labels">
                                            <div class="bar-label-left">
                                                <span class="bigger"><b>Desconectar dispositivos</b></span>
                                            </div>
                                        </div>
                                        <div class="bar-level-1 auth-text">
                                            Cierra todas las sesiones abiertas.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <br>
                <a <?php if($this->security_model->authStatus() != ''): ?>onclick="remove_auth();" <?php else:?>onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_auth');" <?php endif;?>>
                    <div class="support-ticket <?php if($this->security_model->authStatus() != '') echo 'active';?>">
                        <div class="st-body">
                            <div class="avatar">
                                <img src="<?php echo base_url();?>public/uploads/icons/authentication.png" style="width: 40px;">
                            </div>
                            <div class="ticket-content">
                                <div class="ticket-description">
                                    <div class="os-progress-bar primary">
                                        <div class="bar-labels">
                                            <div class="bar-label-left">
                                                <span class="bigger"><b><?php if($this->security_model->authStatus() != ''): ?>Desactivar<?php else:?>Usar<?php endif;?> autenticación en dos pasos</b></span>
                                            </div>
                                        </div>
                                        <div class="bar-level-1 auth-text">
                                            <?php if($this->security_model->authStatus() != ''): ?>Desactiva<?php else:?>Activa<?php endif;?> la seguridad en tu cuenta.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function remove_auth() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se desactivará la autenticación de doble factor para tu cuenta..",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/doctors/remove_auth/";
        }
    })
}


function remove_session() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminarán tus sesiones en todos los dispositivos, incluyendo este y en los que has iniciado sesión...",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/doctors/remove_sessions/<?php echo $this->session->userdata('login_user_id');?>";
        }
    })
}
</script>

<?php  endforeach; ?>

<script type="text/javascript">
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


startApp();

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
</script>