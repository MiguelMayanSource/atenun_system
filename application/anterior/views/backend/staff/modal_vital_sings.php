	<link href="<?php echo base_url();?>public/uploads/prescription_style.css" rel="stylesheet">
	<style>
._header-logo_ztkcf7,
._header-meta_ztkcf7 {
    width: 50% !important;
}
	</style>
	<?php $vital_sign = $this->db->get_where('vital_sign', array('vital_sign_id' => $param2))->result_array();
	    foreach($vital_sign as $content): 
            $patient_birth = $this->db->get_where('patient', array('patient_id' => $content['patient_id']))->row()->date_of_birth;
	?>
	<div class="modal-content animated fadeInDown" style="border-radius:20px;">
	    <div class="modal-body" style="background-color:#fff;border-radius:25px">
	        <div class="form-group">
	            <div class="container">
	                <div class="row">
	                    <div data-autoid="prescription" id="ember14040" class="_print-content_ztkcf7 ember-view">
	                        <div>
	                            <div class="_header_ztkcf7">
	                                <div class="_header-logo_ztkcf7">
	                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>" style="width:80%;">
	                                </div>
	                                <div class="_header-profile_ztkcf7">
	                                    <p><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?></p>
	                                </div>
	                                <div class="_header-meta_ztkcf7">
	                                    <p><b>Signos vitales registrados</b></p>
	                                    <p>Registrados por: <b><?php if($content['user_type'] != '') echo $this->accounts_model->short_name( $content['user_type'], $content['user_id']);?></b></p>
	                                    <p>Impreso por: <b>
	                                            <?php if($this->session->userdata('login_type') == 'staff'): echo $this->accounts_model->short_name('staff',$this->session->userdata('login_user_id'));
                                            elseif($this->session->userdata('login_type') == 'patient'): echo $this->accounts_model->short_name('patient',$this->session->userdata('login_user_id'));
                                            else: echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id')); endif;?></b></p>
	                                    <p>Fecha: <b><?php echo date('d/m/Y H:i a');?></b></p>
	                                </div>
	                            </div>
	                            <div class="_body_ztkcf7">
	                                <div class="_body-bg-image_ztkcf7">
	                                    <img src="https://app.nimbo-x.com/assets/images/caduceus-326bd300bcfe88a2e80e3bdfc18e80b6.png" alt="">
	                                </div>
	                                <div class="_body-person-info_ztkcf7">
	                                    <div class="_body-person-name_ztkcf7">
	                                        <b>Paciente: </b><span><?php echo $this->accounts_model->short_name('patient',$content['patient_id']);?></span>
	                                        <p data-autoid="print-prescription-consultation-cause">Motivo de Consulta: <b><?php echo $practice_name;?></b></p>
	                                    </div>
	                                    <div>Género: <b><?php echo $this->crud_model->get_gender($content['patient_id']);?></b></div>
	                                    <div class="_body-person-info-date_ztkcf7">Fecha de consulta:</div>
	                                    <div>
	                                        Fecha de Nacimiento: <b><?php echo date('d/m/Y', strtotime($patient_birth));?></b><br>
	                                        Fecha de registro: <b><?php echo $content['date'];?></b>
	                                    </div>
	                                </div>
	                                <div class="_body-prescription-info_ztkcf7">
	                                    <div class="col-sm-12 col-md-12 col-lg-12 text-left ">
	                                        <span style="margin-bottom:10px; display:block;font-weight:bold;font-size:16px;font-family:'Poppins', sans-serif">Signos Vitales</span>
	                                        <div class="col-sm-12 row">
	                                            <div class="col-sm-12">
	                                                <b>Peso:</b> <?php echo  $content['w'] ?> (lbs)
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>Altura:</b> <?php echo  $content['t'] ?> (cm)
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>IMC:</b> <?php echo  $content['imc'] ?>
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>Temp:</b> <?php echo  $content['temp'] ?> °C
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>FR:</b> <?php echo  $content['fr'] ?>
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>FC:</b> <?php echo  $content['fc'] ?> latidos por minuto
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>PA:</b> <?php echo  $content['pa'] ?> mmHg
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>SO2:</b> <?php echo  $content['so2'] ?>
	                                            </div>
	                                            <div class="col-sm-12">
	                                                <b>Glucometría:</b> <?php echo  $content['gl'] ?>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div style="width: 33%;  margin: 50px 0 30px auto;  padding-top: 5px; text-align: center;  font-size: 14px;">

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