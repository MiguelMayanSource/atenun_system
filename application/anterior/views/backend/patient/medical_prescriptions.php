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
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
                            <a class="side-items" href="<?php echo base_url();?>patient/dashboard/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0703_users_profile_group_two"></i> Perfil </a>                       
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/chat/"><i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i> Chat </a>
                        </li>
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
                            <a class="side-items active" href="<?php echo base_url();?>patient/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas <span class="side-active"></span></a>
                        </li>
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
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
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li style="border-bottom: 1px solid #eee;padding-bottom: 15px;">
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
            <i class="batch-icon-arrow-right"></i><span>Recetas médicas</span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Recetas médicas.</span>
                    <span class="alert-content">Gestiona las recetas o prescripciones médicas que tu <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">médico</a></span> te ha proporcionado.</span>
                </div>  
            </div>
            <div class="col-sm-12">
                <div class="tasks-section">
                     <?php
				    $this->db->group_by('appointment_id');
				    $prescriptions = $this->db->get_where('prescription', array('patient_id' => $patient_id));
                    if($prescriptions->num_rows() > 0):
				?>
				    <div class="table-responsive">
                    <table class="table table-padded">
    				    <thead>
					        <th width="40px">#</th>
					        <th>Especialista</th>
					        <th>Motivo de la consulta</th>
					        <th>Fecha & Hora</th>
    					    <th>Acciones</th>
				        </thead>
                        <tbody>
                        <?php $n = 1; foreach($prescriptions->result_array() as $pres): ?>
                            <tr style="font-family:'Poppins';font-size:14px;">
                                <td><?php echo $n++;?></td>
                                <?php  $doctor_id = $this->db->get_where('appointment', array('appointment_id' => $pres['appointment_id']))->row()->doctor_id; ?>
                                <td>
                                    <img src="<?php echo $this->accounts_model->get_photo('admin', $doctor_id);?>" width="35px" style="padding-right:6px"> 
                                    <?php echo $this->accounts_model->gender($doctor_id);?> <?php echo $this->accounts_model->short_name('admin', $doctor_id);?>
                                </td>
                                <td>
                                    <?php
                                        $practice_id = $this->db->get_where('appointment', array('appointment_id' => $pres['appointment_id']))->row()->practice;
                                	    if($practice_id != ''){
                                	        $practice_name = 'Otros servicios';
                                	    }else{
                                	        $practice_name = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;
                                	    }
                                	    echo $practice_name;
                                    ?>
                                </td>
                                <td class="precio-ingreso"><?php echo $pres['date'];?></td>
                                <td>
                                    <i onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_prescription/<?php echo $pres['prescription_id'];?>');" class="picons-thin-icon-thin-0100_to_do_list_reminder_done" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Detalles"></i>
                                    <i onclick="window.open('<?php echo base_url();?>patient/print_prescription_details/<?php echo $pres['appointment_id'];?>', '_blank');" class="picons-thin-icon-thin-0333_printer" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Imprimir"></i>
                                    <i onclick="window.location.href='<?php echo base_url();?>patient/medical_prescriptions/pdf/<?php echo $pres['appointment_id'];?>';" class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size:22px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Descargar"></i>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                    </div>
                <?php else:?>
                    <div class="card-box">
                        <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">El paciente aún no tiene recetas médicas</h4>
                        <center><img src="<?php echo base_url();?>public/uploads/prescriptions.png" style="width:35%"/></center>
                    </div>
                <?php endif;?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
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
 
	<script type="text/javascript">
        function send_email(patient_id)
        {
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
                if (result.value) 
                {
                   $.ajax({
                        url: "<?php echo base_url();?>patient/medical_prescriptions/send/"+patient_id,
                        success: function(data){
                           if(data='success')
                           {
                               const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 5000
                                }); 
                                Toast.fire({
                                    type: 'success',
                                    title: 'enviado correctamente'
                                })
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
                                    title: data
                                })
                           }
                        },
                        error: function(data){
                            alert("Problemas al tratar de enviar el formulario");
                        }
                    });
                }
            })
        }
    </script>