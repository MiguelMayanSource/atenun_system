	<link href="<?php echo base_url();?>public/uploads/prescription_style.css" rel="stylesheet">
	<?php $prescription_details = $this->db->get_where('prescription', array('prescription_id' => $param2))->result_array();
	    foreach($prescription_details as $content): 
	    $doctor_id = $this->db->get_where('appointment', array('appointment_id' => $content['appointment_id']))->row()->doctor_id;
	    $patient_birth = $this->db->get_where('patient', array('patient_id' => $content['patient_id']))->row()->date_of_birth;
	    $prescription_date = $this->db->get_where('appointment', array('appointment_id' => $content['appointment_id']))->row()->date;
	    $practice_id = $this->db->get_where('appointment', array('appointment_id' => $content['appointment_id']))->row()->practice;
	    if($practice_id > 0){
	        $practice_name = 'Otros servicios';
	    }else{
	        $practice_name = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;
	    }
	    $prescription_time = $this->db->get_where('appointment', array('appointment_id' => $content['appointment_id']))->row()->time;
	    $colegiado = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->no_college;
        $specialty_id_1 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_1;
        $specialty_id_2 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_2;
        $specialty_1 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_1))->row()->name;
        if($specialty_id_2 > 0)
        {
            $specialty_2 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_2))->row()->name;
        }
        $appointment_comment = $this->db->get_where('appointment', array('appointment_id' => $content['appointment_id']))->row()->doctor_comment;
	?>
    	<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    	    <div class="modal-body" style="background-color:#fff;border-radius:25px">
        		<div class="form-group">
    		        <div class="container">
        		        <div class="row">
    		                <input type="hidden" id="patient_id" value="<?php echo $param2;?>"/>
                            <div data-autoid="prescription" id="ember14040" class="_print-content_ztkcf7 ember-view">
                                <div>
                                    <div class="_header_ztkcf7">
                                        <div class="_header-logo_ztkcf7">
                                            <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>" style="width:80%;">
                                        </div>
                                        <div class="_header-profile_ztkcf7">
                                            <p><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?></p>
                                            <p class="_header-specialty_ztkcf7"><small style="font-weight:bold;"><?php echo $specialty_1;?> <?php if($specialty_id_2 > 0):?>- <?php echo $specialty_2;?><?php endif;?></small></p>
                                            <p class="_header-license_ztkcf7">Colegiado: <b><?php echo $colegiado;?></b></p>
                                        </div>
                                        <div class="_header-meta_ztkcf7">
                                            <p><b>Receta de Medicamentos</b></p>
                                            <p>Generado por: <b>Medicaby</b></p>
                                            <p>Impreso por: <b>
                                                 <?php if($this->session->userdata('login_type') == 'staff'): echo $this->accounts_model->short_name('staff',$this->session->userdata('login_user_id'));
                                            elseif($this->session->userdata('login_type') == 'patient'): echo $this->accounts_model->short_name('patient',$this->session->userdata('login_user_id'));
                                            else: echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id')); endif;?></b></p>
                                            <p>Fecha: <b><?php echo date('d/m/Y H:i a');?></b></p>
                                            <p data-autoid="prescription-header-folio">Correlativo: <b><?php echo $content['appointment_id'];?></b></p>
                                        </div>
                                    </div>
                                    <div class="_body_ztkcf7">
                                        <div class="_body-bg-image_ztkcf7">
                                            <img src="https://app.nimbo-x.com/assets/images/caduceus-326bd300bcfe88a2e80e3bdfc18e80b6.png" alt="">
                                        </div>
                                        <div class="_body-person-info_ztkcf7">
                                            <div class="_body-person-name_ztkcf7">
                                                <b>Paciente: <span><?php echo $this->accounts_model->short_name('patient',$content['patient_id']);?></span></b>
                                                <p data-autoid="print-prescription-consultation-cause">Motivo de Consulta: <b><?php echo $practice_name;?></b></p>
                                            </div>
                                            <div>Género: <b><?php echo $this->crud_model->get_gender($content['patient_id']);?></b></div>
                                            <div class="_body-person-info-date_ztkcf7">Fecha de consulta:</div>
                                            <div>
                                                Fecha de Nacimiento: <b><?php echo date('d/m/Y', strtotime($patient_birth));?></b><br>
                                                Fecha de consulta: <b><?php echo $prescription_date." ".$prescription_time;?> <?php if($prescription_time <= '12:00') echo "am"; else echo "pm";?></b>
                                            </div>
                                        </div>      
                                        <div class="_body-prescription-info_ztkcf7">
                                            <div data-autoid="body-prescription-drugs" id="ember14041" class="ember-view">
                                                <div>
                                                    <div id="ember14042" class="ember-view">
                                                        <div id="ember14043" class="_is-subtitle_1cmxxr ember-view">  
                                                            
                                                            Medicamentos
                                                        </div>
                                                    </div>
                                                    <div data-autoid="prescription-consultation-drugs-0" class="_prescription-drug_6ovcpi">
                                                        <?php
                                                            $data_info = $this->db->get_where('prescription', array('appointment_id' => $content['appointment_id']))->result_array();
                                                            foreach($data_info as $details):
                                                        ?>
                                                        <p><b><?php echo $details['medicine'];?></b></p>
                                                        <p><?php echo $details['quantity'];?> <?php echo $details['frequency'];?> durante <?php echo $details['duration'];?>.</p>
                                                        <br>
                                                        <?php endforeach;?>
                                                        <p>Si ocurre una reacción alérgica, suspender el medicamento.</p>
                                                    </div>
                                                </div>
                                                <div data-autoid="prescription-medical-instructions">
                                                    <p class="_medical-instructions-title_6ovcpi">Instrucciones Medicas:</p>
                                                    <div data-autoid="paragraph-0" id="ember14044" class="_wysiwyg-editor_2x3vh5 ember-view _viewerMode_2x3vh5 _printPdfView_2x3vh5">
                                                        <div id="ember14045" class="ember-view">
                                                            <div class="tui-editor-contents">
                                                                <p><?php echo $appointment_comment;?></p>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                      
                                                                <div style="width: 33%;  margin: 50px 0 30px auto;  padding-top: 5px; text-align: center;  font-size: 14px;" >
                                                                 <?php if($this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature!=""){ ?>
                                                                        <img src="<?php echo base_url();?>public/uploads/doctor_signature/<?php echo $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature; ?>" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>" style="width:40%; margin-bottom: 5px;"><br> 
                                                                <?php }?>
                                                                <div style="border-top: 2px solid #000;">
                                            
                                                                    <?php echo $this->accounts_model->gender($doctor_id);?> <?php echo $this->accounts_model->short_name('admin',$doctor_id);?>                                        
                                                                </div>
                                                            </div>
                                      
                                    </div>
                                    <div class="_footer_ztkcf7">
                                        <div>
                                            <div>Dirección:</div>
                                            <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->address;?>
                                        </div>
                                        <div>
                                            Teléfono: <br>
                                            <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?>
                                        </div>
                                        <div class="_footer-app-branding_ztkcf7">
                                            <p data-autoid="footer-prescription-info">Receta electrónica generada con Medicaby</p>
                                            <b><?php echo base_url();?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
    		            </div>
    		        </div>
                </div> 
            </div>
    	</div>
	<?php endforeach;?>