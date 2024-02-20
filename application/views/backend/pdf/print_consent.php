<?php 

  
	 $patient_consent = $this->db->get_where('patient_consent', array('patient_consent_id' => $patient_consent_id))->row_array();
      $user = $this->db->get_where('patient', array('patient_id' => $patient_consent['patient_id']))->row();
?>
<!doctype html>
<html>

<head>
    <style>
    @page {
        background-image: url("<?php echo base_url().'public/uploads/referencia.png'?>");
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
                <div style="position:absolute;top:280px;left:100px;width:500px">
                    <b><span><?php echo $this->accounts_model->get_full_name('patient',$patient_consent['patient_id']);?></span></b>
                </div>
                <div style="position:absolute;top:280px;left:720px;width:50px">
                    <b><span>0<?php echo $patient_consent_id;?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:90px;">
                    <b><span><?php echo date('Y-m-d');?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:300px;">
                    <b><span><?php echo $user->phone;;?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:550px;">
                    <b><span><?php echo $user->code;;?></span></b>
                </div>
                <div style="position:absolute;top:330px;left:692px;">
                    <b><span ><?php echo $user->gender; ?></span></b>
                </div>
                <div style="position:absolute;top:330px;left:730px;">
                    <b><span>
                            <?php $originalDate = $user->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                            <?php echo $this->accounts_model->get_age($originalDate);?>
                        </span></b>
                </div>
                <!------ Final datos del paciente ------>
                <!------ Inicio datos de la orden ------>

                <div style="position:absolute;top:460px;right:100px;">
                    <b><span>
                            <?php    setlocale(LC_ALL,"es_ES.UTF-8"); echo strftime("%A, %d de %B del %Y");
            ?>
                        </span>
                    </b>
                </div>
                <div style="position:absolute;top:510px; text-align:justify; padding:50px;font-weight: lighter;">
                    <b><span><?php echo $patient_consent['details'];?></span></b>
                </div>
  
    <!------ Final datos de la firma ------->
</body>

</html>