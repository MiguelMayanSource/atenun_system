<html>

<head>
    <style>
    body {
        font-size: 16px;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    b {
        font-weight: bolder;
    }

    small {
        font-size: 80%;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    small {
        font-size: 80%;
        font-weight: 400;
    }

    @media print {

        *,
        ::after,
        ::before {
            text-shadow: none !important;
            box-shadow: none !important;
        }

        img {
            page-break-inside: avoid;
        }

        p {
            orphans: 3;
            widows: 3;
        }
    }

    ._print-content_ztkcf7 {
        width: 100%;
        color: #000;
        page-break-inside: avoid;
    }

    ._print-content_ztkcf7 p {
        margin: 0;
    }

    ._prescription-drug_6ovcpi {
        margin-bottom: 10px;
    }

    ._medical-instructions-title_6ovcpi {
        font-weight: 700;
    }

    ._header_ztkcf7 {
        display: flex;
        padding-bottom: 10px;
    }

    ._header_ztkcf7 img {
        margin: 0;
        padding: 0;
    }

    ._header-logo_ztkcf7,
    ._header-meta_ztkcf7 {
        width: 25%;
    }

    ._header-logo_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    ._header-logo_ztkcf7 img {
        max-height: 100px;
    }

    ._header-meta_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-end;
        font-size: 12px;
    }

    ._header-profile_ztkcf7 {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        width: 50%;
        align-items: center;
    }

    ._header-specialty_ztkcf7 {
        text-transform: uppercase;
        font-weight: 700;
    }

    ._header-specialty_ztkcf7 {
        font-size: 16px;
    }

    ._body_ztkcf7 {
        font-size: 13px;
    }

    ._body-bg-image_ztkcf7 {
        display: none;
    }

    ._body-person-info_ztkcf7 {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 8px 0;
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
    }

    ._body-person-info-date_ztkcf7 {
        display: none;
    }

    ._body-prescription-info_ztkcf7 {
        min-height: 150px;
    }

    ._body-signature_ztkcf7 {
        width: 33%;
        margin: 50px 0 30px auto;
        padding-top: 5px;
        border-top: 2px solid #000;
        text-align: center;
        font-size: 14px;
    }

    ._footer_ztkcf7 {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
        padding: 10px 0;
        border-top: 2px solid #000;
        font-size: 10px;
    }

    ._footer-app-branding_ztkcf7 {
        text-align: right;
    }

    ._is-subtitle_1cmxxr img {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
    }

    ._is-subtitle_1cmxxr {
        position: relative;
        float: none;
        margin: 0 0 10px;
        padding: 3px 8px 3px 10px;
        font-size: 13px;
        font-weight: 700;
        font-style: italic;
        z-index: 0;
    }
    </style>
</head>
<?php 
    $prescription_details = $this->db->get_where('prescription', array('code' => $code))->row_array();
	
	$doctor_id = $prescription_details['doctor_id'];
	$patient_id = $prescription_details['patient_id'];
	$patient_birth = $prescription_details['date_of_birth'];
	$prescription_date = $prescription_details['date'];
	
	$colegiado = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->no_college;
    $specialty_id_1 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_1;
    $specialty_id_2 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_2;
    $specialty_1 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_1))->row()->name;
    if($specialty_id_2 > 0)
    {
        $specialty_2 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_2))->row()->name;
    }
    $appointment_comment = $prescription_details['observations'];
?>

<body>
    <div id="printMe" class="_print-content_ztkcf7 ember-view">
        <div>
            <div class="_header_ztkcf7">
                <div class="_header-logo_ztkcf7">
                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" style="max-width:70%;" alt="medicaby">
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
                    <p>Correlativo: <b><?php echo $prescription_details['prescription_ref_id'];;?></b></p>
                </div>
            </div>
            <div class="_body_ztkcf7">
                <div class="_body-person-info_ztkcf7">
                    <div class="_body-person-name_ztkcf7">
                        Paciente: <b><span><?php echo $this->accounts_model->short_name('patient',$patient_id);?></span></b>
                        <p data-autoid="print-prescription-consultation-cause">Motivo de Consulta: <b><?php echo $practice_name;?></b></p>
                    </div>
                    <div>Género: <b><?php echo $this->crud_model->get_gender($patient_id);?></b></div>
                    <div>
                        Fecha de Nacimiento: <b><?php echo date('d/m/Y', strtotime($patient_birth));?></b><br>
                        Fecha de consulta: <b><?php echo $prescription_date." ".$prescription_time;?> <?php if($prescription_time <= '12:00') echo "am"; else echo "pm";?></b>
                    </div>
                </div>
                <div class="_body-prescription-info_ztkcf7">
                    <div class="ember-view">
                        <div>
                            <div class="ember-view">
                                <div class="_is-subtitle_1cmxxr ember-view">
                                    <img src="<?php echo base_url();?>public/uploads/pattern.png" alt=""> Medicamentos
                                </div>
                            </div>
                            <div class="_prescription-drug_6ovcpi">
                                <?php
                                    $data_info = $this->db->get_where('prescription', array('code' => $code))->result_array();
                                    foreach($data_info as $details):
                                ?>
                                <p><b><?php echo $details['medicine'];?></b></p>
                                <p><?php echo $details['quantity'];?> <?php echo $details['frequency'];?> durante <?php echo $details['duration'];?>.</p>
                                <br>
                                <?php endforeach;?>
                                <p>Si ocurre una reacción alérgica, suspender el medicamento.</p>
                            </div>
                            <?php if($appointment_comment != ''): ?>
                            <div>
                                <p class="_medical-instructions-title_6ovcpi">Instrucciones Médicas:</p>
                                <div class="_wysiwyg-editor_2x3vh5 ember-view _viewerMode_2x3vh5 _printPdfView_2x3vh5">
                                    <div class="ember-view">
                                        <div class="tui-editor-contents">
                                            <p><?php echo $appointment_comment;?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div style="width: 33%;  margin: 50px 0 30px auto;  padding-top: 5px; text-align: center;  font-size: 14px;">
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
                        <?php $sys_name =  $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
                        <p>Receta electrónica generada con <?php echo $sys_name;?> </p>
                        <b><?php echo base_url();?></b>
                    </div>
                </div>
            </div>
        </div>
</body>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
<script>
// Esperar a que se termine de imprimir
$(window).on('load', function() {
    // Cerrar la ventana actual
    window.print()
});
// Esperar a que se termine de imprimir
$(window).on('afterprint', function() {
    // Cerrar la ventana actual
    window.close();
});
</script>

</html>