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
                            <a class="side-items " href="<?php echo base_url();?>patient/chat/"><i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i> Chat </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
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
                            <a class="side-items active" href="<?php echo base_url();?>patient/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                        <li class="side-li" style="border:none"></li>
                        <li class="side-li" style="border:none"></li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
    <div class="todo-content" style="margin-bottom:20%">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Historial de citas</span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial de citas.</span>
                    <span class="alert-content">Gestiona todas las citas que haz tenido con tu paciente desde el primer <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">día</a>.</span></span>
                </div>  
            </div>
            <div class="col-sm-12">
                <div class="row">
		            <div class="col-sm-12 col-xl-3">
		                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas reprogramadas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 3))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas canceladas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 2))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas finalizadas
                            </div>
                            <div class="value">
                                <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 4))->num_rows(); ?>
                            </div>
                        </a>
			        </div>
			        <div class="col-sm-12 col-xl-3">
			            <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                            <div class="label">
                                Citas pendientes y confirmadas
                            </div>
                            <div class="value">
                                <?php echo $this->crud_model->count_patient_archived($patient_id); ?>
                            </div>
                        </a>
			        </div>
			    </div><br>
            </div>
            <div class="col-sm-12">
                <div class="tasks-section">
                    <div class="table-responsive">
                    <table class="table table-padded">
    				    <thead>
    				        <th>#</th>
					        <th>Paciente</th>
    					   <th>Especialista</th>
    					   <th>Fecha & Hora</th>
    					   <th>Estado</th>
				        </thead>
                        <tbody>
                        <?php 
                        $this->db->order_by('appointment_id','desc');
                        $this->db->where('patient_id', $patient_id);
                        $appointments = $this->db->get('appointment');
                        
                        $n = 1; foreach($appointments->result_array() as $appointment): ?>
                            <tr style="font-family:'Poppins';font-size:14px;">
                                <td><?php echo $n++;?></td>
                                 <?php if($appointment['treatment_id'] == 0):?>
                                    <td><a href="<?php echo base_url();?>patient/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>">
                                <?php else: ?>
                                    <td><a href="<?php echo base_url();?>patient/treatment_details/<?php echo base64_encode($appointment['treatment_id']);?>">
                                <?php endif; ?>
                                
                                <img src="<?php echo $this->accounts_model->get_photo('patient', $appointment['patient_id']);?>" width="35px" style="padding-right:6px"> 
                                <?php echo $this->accounts_model->short_name('patient', $appointment['patient_id']);?>
                            </a></td>
                            <td><?php echo $this->accounts_model->gender($appointment['doctor_id']).' '.$this->accounts_model->short_name('admin',$appointment['doctor_id']);?></td>
                            <td class="precio-ingreso"><?php echo $this->crud_model->formatear($appointment['date']);?> - <?php echo $appointment['time'];?> <?php if($appointment['time'] < '12:00') echo 'AM'; else echo 'PM';?></td>
                            <td>
                                <?php if($appointment['status'] == 0):?>
                                    <span class="badge badge-celeste" style="color: #fff;background-color: #5bb3f5;">Pendiente</span>
                                <?php elseif($appointment['status'] == 1):?>
                                    <span class="badge badge-verde" style="color: #fff;background-color: #528410 ;">Confirmada</span>
                                <?php elseif($appointment['status'] == 2):?>
                                    <span class="badge badge-rosa" style="color: #fff;background-color: #e0345e;">Cancelada</span>
                                <?php elseif($appointment['status'] == 3):?>
                                    <span class="badge badge-marron" style="color: #fff;background-color: #a66767;">Reprogramada</span>
                                <?php elseif($appointment['status'] == 4):?>
                                    <span class="badge badge-azul" style="color: #fff;background-color: #0044e9;">Finalizada</span>
                                <?php elseif($appointment['status'] == 10):?>
                                    <span class="badge badge-amarillo" style="color: #fff;background-color: #e6b517;">Pendiente de cobro</span>
                                <?php endif;?>
                            </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script>

    var sidebar = new StickySidebar('#sticky', {topSpacing: 0});
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>
<?php  endforeach; ?>