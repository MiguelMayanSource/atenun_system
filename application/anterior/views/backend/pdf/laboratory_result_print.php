<!doctype html>
<html>

<head>
    <title><?php $sample= $this->db->get_where('sample',array('sample_id'=>base64_decode($sample_id)))->row(); echo 'laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf' ?></title>
</head>
<style>
@page {

    background-image-resize: 6;
    background-size: contain;
    margin-top: 350px;
    margin-bottom: 90px;
}
</style>

<body>
    <?php 
    $laboratory = $this->db->get_where('sample',array('sample_id'=>base64_decode($sample_id)))->result_array(); 
    foreach($laboratory as $row):
        $patient = $this->db->get_where('patient',array('patient_id'=>$row['patient_id']))->row_array();
        $age = $this->accounts_model->get_age_card($patient['date_of_birth']);
    ?>
          <div style="position:absolute;top:215px;left:300px;">
            <b style="font-size: 12px;"> <?php echo  $patient['first_name'].' '.$patient['second_name'].' '.$patient['last_name']; ?></b><br>
          </div>
          <div style="position:absolute;top:245px;left:220px;">
            <b style="font-size: 12px;"> <?php echo $patient['address']?></b><br>
          </div>
          <div style="position:absolute;top:270px;left:170px;">
            <b style="font-size: 12px;"> <?php echo  $age?></b><br>
          </div>
          <div style="position:absolute;top:310px;left:220px; whidth:400px;text-align:center;display:block;height:25px">
            <b style="font-size: 12px;white-space:nowrap;whidth:200px;display:inline"><?php echo $patient['patient_id']; ?></b>
          </div>
          <div style="position:absolute;top:310px;left:420px;">
            <b style="font-size: 12px;"> <?php echo $row['code']?></b>
          </div>
          <div style="position:absolute;top:310px;left:640px;">
            <b style="font-size: 12px;"> <?php echo $patient['gender']?></b>
          </div>
    <div class="">
  
        <div style="text-align: center; ">
            <?php 
            
                
            $cont=0;  $laboratories = $this->db->get_where('sample_piece',array('sample_id'=>base64_decode($sample_id)))->result_array(); 
                            foreach($laboratories as $laboratory):
                                 $fields = json_decode($laboratory['results'],true);
                                /* $cont +=  count($fields);
                                    if( $cont >= 26 && count($fields) < 11 )
                                    {
                                        echo '<div class="page_break"></div>';
                                        $cont =  count($fields);
                                    }
                                */
                            ?>
            <table class="table table-bordered" style="border-collapse: collapse; font-size:16px;page-break-inside: avoid; ">
                <tbody class="">
                    <tr>
                        <th colspan="5" style="text-align:center;width:250px;padding:2px; font-weight:bold;"> <?php echo $this->db->get_where("product",array("product_id"=>$laboratory['laboratory_id']))->row()->name  ?></th>
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
            ?>
            <br>
            <br>
        </div>
        <br>
    </div>
    <?php endforeach; ?>
</body>

</html>