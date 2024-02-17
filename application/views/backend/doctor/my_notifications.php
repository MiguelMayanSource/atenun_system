    <div class="todo-app-w">
        <div class="todo-sidebar">
            <div id="sticky">
                <div class="todo-sidebar-section" style="border-bottom:0px">
                    <div class="todo-sidebar-section-contents">
                        <ul class="tasks-list">
                            <li class="side-li">
                                <a class="side-items" href="<?php echo base_url();?>doctor/my_profile/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i>Mi perfil</a>
                            </li>
                            <li class="side-li">
                                <a class="side-items active" href="<?php echo base_url();?>doctor/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones <span class="side-active"></span></a>
                            </li>

                            <li class="side-li">
                                <a class="side-items" href="<?php echo base_url();?>doctor/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                            </li>

                            <li class="side-li">
                                <a class="side-items" href="<?php echo base_url();?>doctor/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="todo-content" style="margin-bottom:10%">
            <?php
            $this->db->order_by('notification_id', 'DESC');
            $notifications = $this->db->get_where('notification', array('to_user' => $this->session->userdata('login_user_id'),'to_type' => 'doctor'));
            if($notifications->num_rows() > 0):
        ?>
            <div class="row">
                <div class="col-sm-9" style="float: none; margin: 0 auto;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span>Centro de notificaciones</span>
                    </h4>
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Mantente actualizado.</span>
                        <span class="alert-content">Aquí podrás visualizar todas las notificaciones de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span> y así mantenerte al tanto de lo que sucede, puedes eliminarlas o marcarlas como leídas.</span>
                    </div>
                    <br>
                    <div class="tasks-section" style="background: #fff; border-radius: 10px; padding: 12px;">
                        <div class="tasks-list-w">
                            <ul class="tasks-list">
                                <?php
                                foreach($notifications->result_array() as $dm):
                            ?>
                                <a style="text-decoration:none;color:#000" href="<?php echo $dm['url'];?>">
                                    <li class="draggable-task <?php if($dm['read_status'] == 0):?> danger <?php else:?> success <?php endif;?>">
                                        <div class="todo-task-drag drag-handle">
                                            <i class="os-icon os-icon-hamburger-menu-2 drag-handle"></i>
                                        </div>
                                        <div class="todo-task success">
                                            <span><?php echo $dm['message'];?> </span><br><small><?php echo $dm['date'];?></small>
                                            <div class="todo-task-buttons">
                                                <?php if($dm['read_status'] == 0):?>
                                                <a class="task-btn-done" onclick="mark_read(<?php echo $dm['notification_id'];?>)" href="javascript:void(0);"><span>Marcar como leída</span><i class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
                                                <?php endif;?>
                                                <a class="task-btn-delete" onclick="delete_this(<?php echo $dm['notification_id'];?>)" href="javascript:void(0);"><span>Eliminar</span><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>
                                            </div>
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
                        <i class="batch-icon-arrow-right"></i><span>Centro de notificaciones</span>
                    </h4>
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Mantente actualizado.</span>
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
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
    </script>
    <script type="text/javascript">
function mark_read(notification_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La notificación se marcará como leída",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/my_notifications/mark_read/" + notification_id;
        }
    })
}

function delete_this(notification_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/my_notifications/delete/" + notification_id;
        }
    })
}
    </script>