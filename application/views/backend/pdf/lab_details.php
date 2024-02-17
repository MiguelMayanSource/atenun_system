<?php 

log_message('error',$code);

    $medic_order = $this->db->get_where('medic_order', array('medic_order_id' => $code))->row_array();
	
	$doctor_id = $medic_order['user_id'];
	$patient_id = $medic_order['patient_id'];
	$patient = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
	$prescription_date = $medic_order['date'];
	$signature = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature;
   
?>
<!doctype html>
<html>

<head>
    <style>
    @page {
        background-image: url("<?php echo 'public/uploads/appointment_details/orden_laboratorio.png'?>");
        background-image-resize: 6;
        background-size: contain;
        margin-top: 90px;
        margin-bottom: 90px;
    }

    .page_break {
        page-break-before: always;
    }
    </style>
</head>

<body>
    <!------ Inicio datos del paciente ------>
    <div style="position:absolute;top:310px;left:150px;">
        <b><span><?php echo $this->accounts_model->get_full_name('patient',$patient_id);?></span></b>
    </div>
    <div style="position:absolute;top:310px;left:700px;">
        <b><span><?php echo date('Y-m-d', strtotime($medic_order['date'])); ?></span></b>
    </div>
    <div style="position:absolute;top:350px;left:190px;">
        <b><span><?php echo $this->accounts_model->get_full_name('admin',$doctor_id);?></span></span></b>
    </div>
    <div style="position:absolute;top:320px;left:550px;">
        <b><span><?php echo $patient->code;;?></span></b>
    </div>
    <!------ Final datos del paciente ------>
    <!------ Inicio datos de la orden ------>

    <div style="position:absolute;top:460px;left:40px;">
        <b><span><?php echo $medic_order['order'];?></span></b>
    </div>
    <!------ Final datos de la orden ------->
    <!------ Inicio datos de la firma ------>

    <div style="position:absolute;top:800px;left:550px;width:250px;text-align:center">
        <img src="<?php echo base_url() ?>public/uploads/doctor_signature/<?php echo $signature; ?>" width="150px">
        <br>
        <b><span><?php echo $this->accounts_model->get_full_name('admin',$doctor_id);?></span></b>
    </div>
    <!------ Final datos de la firma ------->
</body>

</html>