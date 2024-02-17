<?php 

log_message('error',$code);

    $prescription_details = $this->db->get_where('prescription_ref', array('code' => $code))->row_array();
	
	$doctor_id = $prescription_details['user_id'];
	$patient_id = $prescription_details['patient_id'];
	$patient_birth = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->date_of_birth;;
	$prescription_date = $prescription_details['date'];
	$patient = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
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
<!doctype html>
<html>

<head>
    <style>
    @page {
        background-image: url("<?php echo 'public/uploads/receta.jpg'?>");
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
    <div style="position:absolute;top:285px;left:130px;">
        <b><span><?php echo $patient_id != '' ?  $this->accounts_model->get_full_name('patient',$patient_id) : 'Consumidor Final';?></span></b>
    </div>
    <div style="position:absolute;top:320px;left:280px;">
        <b><span><?php echo $patient->phone; ?></span></b>
    </div>
    <div style="position:absolute;top:320px;left:550px;">
        <b><span><?php echo $patient->dpi; ?></span></b>
    </div>
    <div style="position:absolute;top:330px;left:685px;">
        <b><span style="font-size:20px"><?php echo $patient->gender; ?></span></b>
    </div>
    <div style="position:absolute;top:330px;left:730px;">
        <b><span>
                <?php $originalDate = $patient->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                <?php echo $this->accounts_model->get_age($originalDate);?>
            </span></b>
    </div>
    <div style="position:absolute;top:350px; padding:10px">
        <br>

        <table cellpadding="0" cellspacing="0" style="position:absolute; top:500px; width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td style=" font-weight:bold;padding:5px;" colspan="4">
                    Medicamentos
                </td>
            </tr>
            <?php
                $data_info = $this->db->get_where('prescription', array('code' => $code))->result_array();
                foreach($data_info as $details):
            ?>
            <tr>
                <td colspan="4" style="padding-top:15px;font-size: 12px;">
                    <pre><?php echo $details['medicine'];?></pre>
                </td>
            </tr>
            <?php endforeach;?>

            <?php if($appointment_comment != ''):?>
            <tr>
                <td colspan="4" style="padding-top:30px;font-size: 12px;">
                    <b>Observaciones:</b><br>
                    <?php echo $appointment_comment;?>
                </td>
            </tr>
            <?php endif;?>
        </table>
    </div>

    <div style="position:absolute;top:900px;left:160px;">
    <?php if($this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature!= ""):?>
        <img src="<?php echo base_url();?>public/uploads/doctor_signature/<?php echo $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature; ?>" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>" style="width:20%;">
    <?php endif;?>
        <b style="right:10px"><?php echo $this->accounts_model->gender($doctor_id);?> <?php echo $this->accounts_model->short_name('admin',$doctor_id);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
    </div>
</body>

</html>