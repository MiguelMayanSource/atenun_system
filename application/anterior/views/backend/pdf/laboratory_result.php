<!doctype html>
<html>

<head>
    <title><?php $sample= $this->db->get_where('sample',array('sample_id'=>base64_decode($sample_id)))->row(); echo 'laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf' ?></title>
</head>
<style>
@page {
    background-image: url("<?php echo 'public/uploads/sheet_result.jpg'?>");
    background-image-resize: 6;
    background-size: contain;
    margin-top: 200px;
    margin-bottom: 10px;
}
</style>

<body style="font-family: 'Arial';">
    <?php 
    $laboratory = $this->db->get_where('sample',array('sample_id'=>base64_decode($sample_id)))->result_array(); 
    foreach($laboratory as $row):
        $patient = $this->db->get_where('patient',array('patient_id'=>$row['patient_id']))->row_array();
        $age = $this->accounts_model->get_age_card($patient['date_of_birth']);

        if($row['doctors_id'] != 0){
            $doctor = $this->accounts_model->get_name('admin',$row['doctors_id']);

        }else
        {
            $doctor = $row['doctor_name'];
        }
    ?>
    <div style="height:130px"></div>
    <div style="position:absolute;top:205px;left:100px;height:125px;width:595px;border:1.2px solid #002758;border-radius:25px"></div>
    <div style="font-family: 'Arial';position:absolute;top:215px;left:115px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Nombre Completo:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:230px;left:240px;width:430px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:215px;left:300px;width:500px;">
        <b style="font-size: 12px;"> <?php echo  $patient['first_name'].' '.$patient['second_name'].' '.$patient['last_name']; ?></b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:245px;left:115px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Dirección:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:260px;left:183px;width:488px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:245px;left:220px;width:400px; ">
        <b style="font-size: 12px;"> <?php echo $patient['address']?></b><br>
    </div>

    <div style="font-family: 'Arial';position:absolute;top:270px;left:115px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Edad:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:285px;left:155px;width:145px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:270px;left:170px;">
        <b style="font-size: 12px;"> <?php echo  $age?></b><br>
    </div>

    <div style="font-family: 'Arial';position:absolute;top:270px;left:310px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Médico:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:285px;left:363px;width:307px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:270px;left:370px;">
        <b style="font-size: 12px;"> <?php echo $doctor; ?></b><br>
    </div>

    <div style="font-family: 'Arial';position:absolute;top:310px;left:115px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Registro:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:325px;left:175px;width:160px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:310px;left:200px; width:100px;text-align:center;display:block;height:25px">
        <b style="font-size: 12px;white-space:nowrap;width:200px;display:inline"><?php echo $patient['dpi']; ?></b>
    </div>

    <div style="font-family: 'Arial';position:absolute;top:310px;left:345px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Orden:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:325px;left:395px;width:150px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:310px;left:420px;">
        <b style="font-size: 12px;"> <?php echo $row['code']?></b>
    </div>

    <div style="font-family: 'Arial';position:absolute;top:310px;left:555px;width:500px;">
        <span style="font-size: 14px;color:#002758;">Género:</b><br>
    </div>
    <div style="font-family: 'Arial';position:absolute;top:325px;left:610px;width:60px;border:1.2px solid #002758"></div>
    <div style="position:absolute;top:310px;left:640px;">
        <b style="font-size: 12px;"> <?php echo $patient['gender']?></b>
    </div>
    <div class="">
        <div style="text-align: center; ">
            <?php 
             $cont1 = 0;
             $laboratories = $this->db->group_by('laboratory_id')->get_where('sample_piece',array('sample_id'=>base64_decode($sample_id)))->result_array(); 
            
           foreach($laboratories as $exm): ?>
            <h3><?php echo $this->db->get_where("subcategory",array("id"=>$exm['laboratory_id']))->row()->name;  ?></h3>
            <?php 
                
                $cont=0;  $exmans = $this->db->get_where('sample_piece',array('sample_id'=>base64_decode($sample_id),'laboratory_id'=>$exm['laboratory_id']))->result_array(); 
                foreach($exmans as $laboratory):?>
            <?php    $fields = json_decode($laboratory['results'],true); ?>
            <table class="table table-bordered" style="border-collapse: collapse; font-size:16px;page-break-inside: avoid; ">
                <tbody class="">
                    <tr>
                        <th colspan="5" style="text-align:center;width:250px;padding:2px; font-weight:bold;"> <?php echo $this->db->get_where("product",array("product_id"=>$laboratory['exams']))->row()->name  ?></th>
                    </tr>
                    <tr>
                        <th style=" font-size:16px;width:250px;padding:5px; font-weight:bold;text-align:left">PARÁMETRO</th>
                        <th style=" font-size:16px;width:250px;padding:5px; font-weight:bold;text-align:left">RESULTADO</th>
                        <th style=" font-size:16px;width:250px;padding:5px; font-weight:bold;text-align:left">DIMENSIONALES</th>
                        <th style=" font-size:16px;width:250px;padding:5px; font-weight:bold;text-align:left">VALOR DE REFERENCIA</th>
                    </tr>
                    <?php 
                      foreach($fields as $results):
                        $field =  $this->db->query("SELECT * FROM `laboratory_fields` WHERE laboratory_fields_id = ".array_keys($results)[0])->row_array();
                    ?>
                    <tr>
                        <td style="width:250px;padding:5px; font-weight:bold;"><?php echo $field['name']?></td>
                        <td style="width:250px;padding:5px;text-align:center"><?php echo array_values($results)[0]; ?></td>
                        <td style="width:250px;padding:5px;"><?php echo $field['unity']?></td>
                        <td style="width:250px;padding:5px;"><?php echo $field['reference']?></td>
                    </tr>
                    <?php 
                    endforeach;?>
                </tbody>
            </table>
            <?php 
                endforeach; 
             endforeach; 
            ?>
         
            <br>
        </div>
        <br>
    </div>
    <?php endforeach; ?>
</body>

</html>