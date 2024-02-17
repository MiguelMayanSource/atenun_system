<!doctype html>
<html>
<head>
</head>
<body>
    <?php 
        $info_date = $this->db->get_where('cart', array('appointment_id' => $appointment_id))->row()->date;
        $info_productos = $this->db->get_where('cart', array('appointment_id' => $appointment_id))->row()->products;
        $info_total = $this->db->get_where('cart', array('appointment_id' => $appointment_id))->row()->total;
        $appointment_comment = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_comment;
    ?>
    <div style="width:100%; font-size: 16px; line-height: 24px; font-family: 'nunito'; color: #555;">
	<table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td colspan="2">
                    <table  style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td style="padding-bottom: 20px; vertical-align: top;">
                                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" alt="Medicaby" style="max-width:15%;">
                            </td>
                            <td style="padding-bottom: 20px; vertical-align: top;text-align:center;padding-top:5px;">
                            </td>
                            <td style="text-align: right;" >
                                <p style="font-size: 12px;"><b>Recibo de compra</b></p>
                                <p style="font-size: 12px;">Generado por: <b>Medicaby</b></p>
                                <p style="font-size: 12px;">Impreso por: <b><?php if($this->session->userdata('login_type') == 'doctor'){
                                            echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id'));}
                                            else{
                                            echo $this->accounts_model->short_name($this->session->userdata('login_type'),$this->session->userdata('login_user_id'));    
                                            }
                                ?></b></p>
                                <p style="font-size: 12px;">Fecha: <b><?php echo date('d/m/Y H:i a');?></b></p>
                                <p style="font-size: 12px;">Correlativo: <b><?php echo $sale_id;?></b></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="2">
                    <table  style="width: 100%;line-height: inherit;text-align: left;">
                        <tr style="">
                            <td style="padding-top:15px;padding-bottom: 15px; border-top: 2px solid black; border-bottom: 2px solid black;">
                                <b style="font-size: 12px;">Paciente:</b> <span><?php echo $this->accounts_model->short_name('patient',$patient_id);?></span><br>
                                <b style="font-size: 12px;">Dirección:</b> <span><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->address;?></span><br>
                            </td>
                            <td style="padding-top:15px;padding-bottom: 15px; border-top: 2px solid black; border-bottom: 2px solid black;">
                                <div style="font-size: 12px;"></div>
                            </td>
                            <td style="padding-top:15px;text-align: right;padding-bottom: 15px;border-top: 2px solid black; border-bottom: 2px solid black;margin-bottom:50px;font-size:12px">
                                <b style="font-size: 12px;">Teléfono:</b> <span><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->phone;?></span><br>
                                <?php if($info_date != ''): ?>
								Fecha de compra: <b><?php echo $info_date;?></b>
								<?php endif; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
		<br>
         <div>
                <div >
                    <div >
                    <hr>
                     <h3>Cargos de la consulta</h3>
                 
                    <div>
                        <table style="width:100%">
                            <tbody >
                                <tr style="font-family:'Poppins';font-size:14px;">
                                <td >
                                    <b>Valor de la consulta:</b>
                                </td>
                                <td class="text-right">
                                    <strong><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency.'. '.number_format($this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->charges,'2','.',','); ?></strong>
                                </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                   
                    <?php 
                   if($info_productos != ''):
                    $detalles = unserialize($info_productos);  
                    
                    if(count($detalles)>0):
                    ?>
                      <h3>Medicamentos</h3>
                <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; " >
            <tr style="border:1px; padding:5px;font-size: 12px; border-top:1px solid black">
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;width:60%;">
                    Producto
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Precio
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Cantidad
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Subtotal
                </td>
            </tr>
            <?php  
                foreach($detalles as $item): 
            ?>
                <tr >
                    <td style="padding:5px;font-size: 12px; ">
                        <b style="font-size: 12px;"><?php echo $this->db->get_where('product', array('product_id' => $item['variant_id']))->row()->name;?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($item['selling_price'],'2','.',',');?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $item['ordered_quantity'];?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($item['selling_price']*$item['ordered_quantity'],'2','.',',');?></b><br><br>
                    </td>
                </tr>
            <?php endforeach;?>

        </table>
        
        
        
        <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; margin-top:50px;">
            <tbody>
            <tr>
                <td colspan="4" style="padding:10px;font-size: 17px;text-align:right;border:1px; border-top:1px solid black">
                    <b>TOTAL: </b>
                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($info_total+$this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->charges,'2','.',',');?>
                </td>
            </tr>
            </tbody>
        </table>
        <?php endif;?>
        <?php endif;?>
        
        
        <?php $data_info = $this->db->get_where('prescription', array('appointment_id' => $appointment_id))->result_array();
        if(count($data_info) > 0):?>
        <table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:5px;" colspan="4">
                    Medicamentos
                </td>
            </tr>
            <?php
                foreach($data_info as $details):
            ?>
                <tr>
                    <td colspan="4" style="padding-top:15px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $details['medicine'];?></b><br>
                        <?php echo $details['quantity'];?> <?php echo $details['frequency'];?> durante <?php echo $details['duration'];?>.
                    </td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="4" style="padding-top:20px;font-size: 12px;">
                    Si ocurre una reacción alérgica, suspender el medicamento.
                </td>
            </tr>
            <?php if($appointment_comment != ''):?>
            <tr>
                <td colspan="4" style="padding-top:30px;font-size: 12px;">
                    <b>Instrucciones Médicas:</b><br>
                    <?php echo $appointment_comment;?>
                </td>
            </tr>
            <?php endif;?>
            
        </table>
        <?php endif;?>
        </div>
    </div>
</div>






		<table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;padding-top:30px">
            <tr>
                <td colspan="2" style="padding-bottom: 40px;border-top:2px solid black;">
                    <table  style="width: 100%;line-height: inherit;text-align: left;vertical-align:top">
                        <tr>
                            <td style="font-size: 12px;">
                                <b>Dirección:</b><br>
                                <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->address;?>
                            </td>
                            <td style="font-size: 12px;">
                                <b>Teléfono:</b><br>
                                <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?>
                            </td>
                            <?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
                            <td style="text-align: right;font-size: 12px;">
								Recibo electrónico generado con <?php echo $sys_name;?><br>
                                <b><?php echo base_url();?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
    </div> 
  
</body> 
</html>
