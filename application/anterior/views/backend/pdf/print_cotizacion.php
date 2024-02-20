<?php 

    $sale = $this->db->get_where('sale', array('sale_id' => $sale_id))->row_array();
	$invoice = $this->db->get_where('emision', array('emision_id' => $sale['invoice']))->row_array();
	$doctor_id = $medic_order['user_id'];
	$patient_id = $medic_order['patient_id'];
	$patient = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
	$prescription_date = $medic_order['date'];
	$signature = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->signature;
    $currency = 'Q.';
?>
<!doctype html>
<html>

<head> 
    <style>
    @page {
        background-image: url("<?php echo 'public/uploads/sale/cotizacion.png'?>");
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
    <div style="position:absolute;top:170px;left:280px;">
        <b><span><?php echo $patient_id != '' ?  $this->accounts_model->get_full_name('patient',$patient_id) : 'Consumidor Final';?></span></b>
    </div>
    <div style="position:absolute;top:225px;left:230px;">
        <b><span><?php echo $sale['address'];?></span></b>
    </div>
    <div style="position:absolute;top:250px;left:400px;width:50px;">
        <b><span><?php echo $sale['nit'];?></span></b>
    </div>
   
    <div style="position:absolute;top:280px;left:400px;">
        <b><span><?php echo date('Y-m-d');?></span></b>
    </div>
    <div style="position:absolute;top:280px;left:400px;">
        <b><span><?php echo $sale['phone'];?></span></b>
    </div>
    <!------ Final datos del paciente ------>
    <!------ Inicio datos de la orden ------>

    <div style="position:absolute;top:420px;left:40px;">
 
        <table style="width:1000px;">
            <tbody>
                <?php  
                $cont = 1 ;
                $detalles = unserialize($sale['products']);  
                        foreach($detalles as $prod): 
                        $cart_total += $prod['amount']*$prod['subtotal'];
                    ?>
                <tr>
                     <td style="width:50px;min-width:50px;max-width:50px;font-size:20px;">
                        <?php echo $cont++; ?>
                    </td>
                    <td style="width:150px;min-width:150px;max-width:150px;font-size:20px;">
                        <?php echo $this->db->get_where('product',array('product_id'=>$prod['product_id']))->row()->code; ?>
                    </td>
                  
                    <td style="width:320px;min-width:320px;max-width:320px;font-size:18px;">
                        <?php  $products = $this->db->get_where('product', array('product_id'=>$prod['product_id']))->result_array();
                                foreach ($products as $product): ?>
                        <?php echo $product['name']?>
                        <?php endforeach;  ?>
                    </td>
                    <td  style="width:150px;min-width:100px;max-width:100px;font-size:20px;text-align:center">
                        <?php echo $currency.number_format($prod['subtotal'],2,'.',','); ?>
                    </td>
                     <td style="width:150px;min-width:140px;max-width:150px;font-size:18px;text-align:center">
                        <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?>
                    </td>
                    
                    <td  style="width:150px;min-width:150px;max-width:150px;font-size:20px;text-align:center">
                     <?php echo $currency.number_format($prod['total'],2,'.',','); ?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <!------ Final datos de la orden ------->
    <!------ Inicio datos de la pie de página ------>
    <div style="position:absolute;top:885px;left:560px;width:220px;text-align:center">
        <b><span><?php echo $currency.number_format($cart_total,2,'.',','); ?></span></b>
    </div>
    <div style="position:absolute;top:885px;left:110px;width:220px;text-align:center">
        <b><span><?php echo $this->accounts_model->get_full_name($sale['user_type'],$sale['user_id']);?></span></b>
    </div>
    <!------ Final datos de la firma ------->
</body>

</html>