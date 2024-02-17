    <?php    $patient_id = $id_; ?>
    <div class="todo-app-w">
        <div class="todo-sidebar">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                    <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>patient/dashboard/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0703_users_profile_group_two"></i> Perfil <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/chat/"><i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i> Chat </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_history/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_security/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_prescriptions/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_files/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/treatment/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_appointments/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_financial/<?php echo base64_encode($patient_id);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    <div class="todo-content">
       
        <div class="row">
        <?php $this->db->order_by('notification_id','Desc');
        $notifications = $this->db->get_where('notification', array('to_user' => $patient_id,'to_type' => 'patient'));
            if($notifications->num_rows() > 0):
        ?>
            <div class="col-sm-9" style="float: none; margin: 0 auto;">
                 <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Centro de notificaciones - <?php echo $this->accounts_model->get_name('patient',$patient_id);?></span>
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
        <?php else:?>
            <div class="row">
                <div class="col-sm-9" style="float: none; margin: 0 auto;">
                     <h4 class="todo-content-header">
                      <i class="batch-icon-arrow-right"></i><span>Centro de notificaciones - <?php echo $patient_id.$this->accounts_model->get_name('patient',$patient_id);?></span>
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
                    
                    <img src="<?php echo base_url();?>public/uploads/notificaciones.svg" style="width:25%"/>
                </center>
            </div>
        <?php endif;?>    
                
                
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    
	    
    <script>
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>
 






 
 
    
    <script type="text/javascript">
        function mark_read(notification_id)
        {
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
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/notifications/mark_read/"+notification_id+"/<?php echo base64_encode($patient_id);?>";
                }
            })
        }
        function delete_this(notification_id)
        {
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
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/notifications/delete/"+notification_id+"/<?php echo base64_encode($patient_id);?>";
                }
            })
        }
    </script>