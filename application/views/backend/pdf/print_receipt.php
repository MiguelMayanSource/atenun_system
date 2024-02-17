<?php 

   
	$invoice = $this->db->get_where('emision', array('emision_id' => $emision_id))->row_array();
	$sale = $this->db->get_where('sale', array('invoice' => $emision_id))->row_array();
	$estb = $this->db->get_where('establecimiento', array('establecimiento_id' => $sale['institution_id']))->row_array();

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
        <b><span><?php echo $sale['name'];?></span></b>
    </div>
    <div style="position:absolute;top:306px;left:100px;width:50px;">
        <b><span><?php echo $sale['nit'];?></span></b>
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
                        $cart_total += $prod['total'];
                    ?>
                <tr>
                    <td style="width:100px">
                        <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?>
                    </td>
                    <td style="width:350px">
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
    <div style="position:absolute;top:825px;left:120px;width:250px;font-size:12px;">
        <b><span><?php echo $estb['nombre'];?></span></b>
    </div>
  
     <div style="position:absolute;top:865px;left:100px;width:250px;font-size:12px;">
        <b><span><?php echo $estb['nit'];?></span></b>
    </div>
    <div style="position:absolute;top:885px;left:140px;width:150px;font-size:12px;">
        <b><span><?php echo $estb['departamento'].', '.$estb['municipio'].', '.$estb['direccion'];?></span></b>
    </div>
    <div style="position:absolute;top:835px;left:300px;width:250px;font-size:12px;">
        <b><span><?php echo $invoice['no_autorizacion'];?></span></b>
    </div>
  
     <div style="position:absolute;top:875px;left:300px;width:250px;font-size:12px;">
        <b><span><?php echo $invoice['fecha'];?></span></b>
    </div>
     <div style="position:absolute;top:820px;left:640px;width:250px;font-size:12px;">
        <b><span>  Q.<?php $regimen = 12/100; $cart_taxt = $cart_total/($regimen + 1);  echo $currency.number_format($cart_taxt,2,'.',','); ?></span></b>
    </div>
     <div style="position:absolute;top:843px;left:640px;width:250px;font-size:12px;">
        <b><span>  Q.<?php echo $currency.number_format($cart_total*$regimen,2,'.',','); ?></span></b>
    </div>
    <div style="position:absolute;top:883px;left:640px;width:250px;font-size:12px;">
        <b><span>  Q.<?php echo $currency.number_format($cart_total,2,'.',','); ?></span></b>
    </div>
    <div style="position:absolute;top:930px;left:570px;width:250px;font-size:12px;">
        <b><span> <?php echo $sale['details'] != '' ? $sale['details']:'';; ?></span></b>
    </div>
  
    <!------ Final datos de la firma ------->
</body>

</html>