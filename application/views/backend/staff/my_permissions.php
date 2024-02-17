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
                             <a class="side-items" href="<?php echo base_url();?>staff/my_profile/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Mi perfil</a>
                         </li>
                         <li class="side-li">
                             <a class="side-items" href="<?php echo base_url();?>staff/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                         </li>

                         <li class="side-li">
                             <a class="side-items" href="<?php echo base_url();?>staff/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                         </li>
                         <li class="side-li">
                             <a class="side-items" href="<?php echo base_url();?>staff/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                         </li>
                         <li class="side-li">
                             <a class="side-items" href="<?php echo base_url();?>staff/my_calendar/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario </a>
                         </li>
                         <li class="side-li">
                             <a class="side-items" href="<?php echo base_url();?>staff/my_appointments/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                         </li>
                         <li class="side-li">
                             <a class="side-items active" href="<?php echo base_url();?>staff/my_permissions/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos <span class="side-active"></span> </a>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <div class="todo-content">

         <div class="row">
             <div class="col-sm-9" style="float: none; margin: 0 auto;">
                 <h4 class="todo-content-header">
                     <i class="batch-icon-arrow-right"></i><span>Permisos de su usuario </span>
                 </h4>
                 <div class="alert alert-info">
                     <span class="alert-title"><i class="batch-icon-spam"></i> Controla el acceso a Medicaby.</span>
                     <span class="alert-content">Aquí podrás gestionar a donde tendrás acceso dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                 </div><br>

                 <div class="col-sm-12">
                     <label>Módulos a los que tendrá usted acceso?</label><br><br>

                     <form action="<?php echo base_url();?>staff/doctors/update_profile_modules/<?php echo $details['admin_id'];?>" method="POST" id="doctorUpdate" enctype="multipart/form-data">

                         <div class="row">
                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Podrá dar permisos?</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['moduls'] == '1') echo "checked";?> class="radiobutton" type="radio" name="moduls" id="moduls1" value="1"><label class="radiobutton-label" for="moduls1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['moduls'] == '0') echo "checked";?> class="radiobutton" type="radio" name="moduls" id="moduls2" value="0"><label class="radiobutton-label" for="moduls2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Tablero</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['panel'] == '1') echo "checked";?> class="radiobutton" type="radio" name="panel" id="panel1" value="1"><label class="radiobutton-label" for="panel1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['panel'] == '0') echo "checked";?> class="radiobutton" type="radio" name="panel" id="panel2" value="0"><label class="radiobutton-label" for="panel2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Chat</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['chat'] == '1') echo "checked";?> class="radiobutton" type="radio" name="chat" id="chat1" value="1"><label class="radiobutton-label" for="chat1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['chat'] == '0') echo "checked";?> class="radiobutton" type="radio" name="chat" id="chat2" value="0"><label class="radiobutton-label" for="chat2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Citas</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['appointments'] == '1') echo "checked";?> class="radiobutton" type="radio" name="appointments" id="appointments1" value="1"><label class="radiobutton-label" for="appointments1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['appointments'] == '0') echo "checked";?> class="radiobutton" type="radio" name="appointments" id="appointments2" value="0"><label class="radiobutton-label" for="appointments2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Pacientes</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['patients'] == '1') echo "checked";?> class="radiobutton" type="radio" name="patients" id="patients1" value="1"><label class="radiobutton-label" for="patients1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['patients'] == '0') echo "checked";?> class="radiobutton" type="radio" name="patients" id="patients2" value="0"><label class="radiobutton-label" for="patients2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Doctores</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['doctors'] == '1') echo "checked";?> class="radiobutton" type="radio" name="doctors" id="doctors1" value="1"><label class="radiobutton-label" for="doctors1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['doctors'] == '0') echo "checked";?> class="radiobutton" type="radio" name="doctors" id="doctors2" value="0"><label class="radiobutton-label" for="doctors2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Equipo</label>

                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['staff'] == '1') echo "checked";?> class="radiobutton" type="radio" name="staff" id="staff1" value="1"><label class="radiobutton-label" for="staff1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['staff'] == '0') echo "checked";?> class="radiobutton" type="radio" name="staff" id="staff2" value="0"><label class="radiobutton-label" for="staff2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Inventario</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['inventory'] == '1') echo "checked";?> class="radiobutton" type="radio" name="inventory" id="inventory1" value="1"><label class="radiobutton-label" for="inventory1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['inventory'] == '0') echo "checked";?> class="radiobutton" type="radio" name="inventory" id="inventory2" value="0"><label class="radiobutton-label" for="inventory2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Finanzas</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['financial'] == '1') echo "checked";?> class="radiobutton" type="radio" name="financial" id="financial1" value="1"><label class="radiobutton-label" for="financial1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['financial'] == '0') echo "checked";?> class="radiobutton" type="radio" name="financial" id="financial2" value="0"><label class="radiobutton-label" for="financial2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Reportes</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['reports'] == '1') echo "checked";?> class="radiobutton" type="radio" name="reports" id="reports1" value="1"><label class="radiobutton-label" for="reports1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['reports'] == '0') echo "checked";?> class="radiobutton" type="radio" name="reports" id="reports2" value="0"><label class="radiobutton-label" for="reports2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group m-b-15">
                                     <label>Configuración</label>
                                     <div class="input-group">
                                         <div class="form-check" style="padding-left: 0px;">
                                             <input <?php if($details['settings'] == '1') echo "checked";?> class="radiobutton" type="radio" name="settings" id="settings1" value="1"><label class="radiobutton-label" for="settings1">Sí</label>
                                         </div>
                                         <div class="form-check mr-3">
                                             <input <?php if($details['settings'] == '0') echo "checked";?> class="radiobutton" type="radio" name="settings" id="settings2" value="0"><label class="radiobutton-label" for="settings2">No</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-sm-12"><br>
                                 <div class="form-group m-b-15">
                                     <button class="btn btn-primary">Aplicar cambios</button>
                                 </div>
                             </div>


                         </div>
                     </form>

                 </div>

             </div>

         </div>
     </div>
 </div>
 <script src="<?php echo base_url();?>style/back/js/jquery-3.1.1.min.js"></script>


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







 <?php endforeach; ?>


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
            location.href = "<?php echo base_url();?>staff/notifications/mark_read/" + notification_id;
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
            location.href = "<?php echo base_url();?>staff/notifications/delete/" + notification_id;
        }
    })
}
 </script>