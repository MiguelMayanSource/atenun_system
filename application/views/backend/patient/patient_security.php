<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/dashboard/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0703_users_profile_group_two"></i> Perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/chat/"><i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i> Chat </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>patient/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
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
                    <span class="alert-title"><i class="batch-icon-spam"></i> Control de seguridad.</span>
                    <span class="alert-content">Aquí podrás actualizar tu contraseña, además podrás activar la autenticación de doble factor para mejorar la  <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">seguridad</a></span> de tu cuenta. </span>
                </div>  
            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>patient/update_password/change_pass/<?php echo $details['patient_id'];?>" method="POST" id="patientPass" enctype="multipart/form-data">
                        <div class="row">
	                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Nueva contraseña:</label><span style="color:red">*</span>
	                                    <input type="password" style="border: 1px solid #198cff8f;" name="new_pass" required="" class="form-control">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group m-b-15">
       		                            <label for="simpleinput">Confirmar nueva contraseña:</label><span style="color:red">*</span>
	                                    <input type="password" style="border: 1px solid #198cff8f;" name="confirm_pass" required="" class="form-control">
	                                </div>
	                            </div>
	                            
		                        <div class="col-sm-12">
		                            <div class="form-group m-b-15">
                                         <button class="btn btn-primary" href="#" type="submit" >Aplicar cambios</button>
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
                        
                            <a onclick="remove_cessions();">
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
                            </div></a>
                    <br>    
                    <a <?php if($this->security_model->authPatientStatus() != ''): ?>onclick="remove_auth();"<?php else:?>onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_auth');"<?php endif;?>>
                        <div class="support-ticket <?php if($this->security_model->authPatientStatus() != '') echo 'active';?>">
                            <div class="st-body">
                                <div class="avatar">
                                    <img src="<?php echo base_url();?>public/uploads/icons/authentication.png" style="width: 40px;">
                                </div>
                                <div class="ticket-content">
                                    <div class="ticket-description">
                                        <div class="os-progress-bar primary">
                                            <div class="bar-labels">
                                                <div class="bar-label-left">
                                                    <span class="bigger"><b><?php if($this->security_model->authPatientStatus() != ''): ?>Desactivar<?php else:?>Usar<?php endif;?> autenticación en dos pasos</b></span>
                                                </div>
                                            </div>
                                            <div class="bar-level-1 auth-text">
                                                <?php if($this->security_model->authPatientStatus() != ''): ?>Desactiva<?php else:?>Activa<?php endif;?> la seguridad en tu cuenta.
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
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
     <script type="text/javascript">
    
     function remove_auth()
        {
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
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/auth_two_factor/remove_auth/";
                }
            })
        }
        
        function remove_cessions()
        {
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
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/auth_two_factor/remove_sessions/";
                }
            })
        }
        
    </script>
    <script>

$( "#patientPass" ).submit( function (event)
{

    pass1 = $("input[name='new_pass']").val();
    pass2 = $("input[name='confirm_pass']").val();
    console.log(pass1, '=', pass2);

        if(pass1 == pass2)
        {
        
        
           // $('#patientPass').submit();
        
        }else
        {

            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
            }); 
            Toast.fire({
                type: 'error',
                title: 'Las contraseñas no coinciden'
            })


        };

    });
    </script>
<?php  endforeach; ?>