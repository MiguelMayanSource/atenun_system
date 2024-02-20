<?php 

    $sale = $this->db->get_where('sale', array('sale_id' => $sale_id))->row_array();
	$invoice = $this->db->get_where('emision', array('emision_id' => $sale['invoice']))->row_array();
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
        background-image: url("<?php echo 'public/uploads/sale/factura.jpg'?>");
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
    <div style="position:absolute;top:285px;left:130px;">
        <b><span><?php echo $patient_id != '' ?  $this->accounts_model->get_full_name('patient',$patient_id) : 'Consumidor Final';?></span></b>
    </div>
    <div style="position:absolute;top:306px;left:100px;">
        <b><span><?php echo $sale['nit'].'d'.$sale['invoice'];?></span></b>
    </div>
    <div style="position:absolute;top:330px;left:136px;">
        <b><span><?php echo $sale['address'];?></span></b>
    </div>
   
    <div style="position:absolute;top:250px;left:658px;">
        <b><span><?php echo date('Y');?></span></b>
    </div>
    <div style="position:absolute;top:250px;left:700px;width:50px">
        <b><span><?php echo date('m');?></span></b>
    </div>
    <div style="position:absolute;top:250px;left:730px;width:50px">
        <b><span><?php echo date('d');?></span></b>
    </div>
    <?php if($patient->gender == 'M' ): ?>
    <div style="position:absolute;top:320px;left:705px;">
        <b><span style="font-size:28px">x</span></b>
    </div>
    <?php else: ?>
    <div style="position:absolute;top:310px;left:678px;">
        <b><span><?php echo $invoice['no_serie']?></b>
    </div>
    <?php endif; ?>
    <div style="position:absolute;top:330px;left:678px;">
        <b><?php echo $invoice['numero_factura']?></b>
    </div>
    <!------ Final datos del paciente ------>
    <!------ Inicio datos de la orden ------>

    <div style="position:absolute;top:420px;left:80px;">
 
        <table >
            <tbody>
                <?php  
                
                $detalles = unserialize($sale['products']);  
                        foreach($detalles as $prod): 
                        $cart_total += $prod['ordered_quantity']*$item['selling_price'];
                    ?>
                <tr>
                    <td style="width:150px">
                        <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?>
                    </td>
                    <td style="width:320px">
                        <?php  $products = $this->db->get_where('product', array('product_id'=>$prod['product_id']))->result_array();
                                            foreach ($products as $product): ?>
                        <?php echo $product['code'].' - '.$product['name']?>
                        <?php endforeach;  ?>
                    </td>
                   
                    <td  style="width:150px">
                        Q.<?php echo $currency.number_format($prod['subtotal'],2,'.',','); ?>
                    </td>
                    <td  style="width:150px">
                    Q.<?php echo $currency.number_format($prod['total'],2,'.',','); ?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <!------ Final datos de la orden ------->
    <!------ Inicio datos de la pie de página ------>
    <div style="position:absolute;top:800px;left:300px;width:250px;text-align:center">
        <b><span><?php echo $this->accounts_model->get_full_name('admin',$doctor_id);?></span></b>
    </div>
    <div style="position:absolute;top:800px;left:550px;width:250px;text-align:center">
        <img src="<?php echo base_url() ?>public/uploads/doctor_signature/<?php echo $signature; ?>" width="150px">
        <br>
        <b><span><?php echo $this->accounts_model->get_full_name('admin',$doctor_id);?></span></b>
    </div>
    <!------ Final datos de la firma ------->
</body>

</html>