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
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_profile/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i>Mi perfil</a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>

                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>

                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad <span class="side-active"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom:10%">
        <?php
    $this->db->order_by('bitacora_id', 'DESC');
    $activities = $this->db->get_where('bitacora', array('user_id' => $doctor_id, 'clinic_id' => $this->session->userdata('current_clinic'), 'user_type' => 'admin'));
    if($activities->num_rows() > 0):
        ?>
        <div class="row">
            <div class="col-sm-9" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Tu actividad en Medicaby.</span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Registro de actividad diaria.</span>
                    <span class="alert-content">Aquí podrás visualizar todos los moviemientos que realices dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span>.</span>
                </div>
                <br>

                <div class="tasks-section" style="background: #fff; border-radius: 10px; padding: 12px;">
                    <div class="tasks-list-w">
                        <ul class="tasks-list">
                            <?php
                                foreach($activities->result_array() as $dm):
                            ?>
                            <a style="text-decoration:none;color:#000" href="javascript:void(0);">
                                <li class="draggable-task success">
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
                    <i class="batch-icon-arrow-right"></i><span>Tu actividad en Medicaby.</span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Registro de actividad diaria.</span>
                    <span class="alert-content">Aquí podrás visualizar todos los moviemientos que realices dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span>.</span>
                </div>
                <br>
            </div>
        </div>
        <div class="card-box">
            <center><br>
                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;"> Aún no tienes registro de actividad.</h4>

                <img src="<?php echo base_url();?>public/uploads/activity.svg" style="width:25%" />
            </center>
        </div>
        <?php endif;?>
    </div>
</div>
<?php  endforeach; ?>