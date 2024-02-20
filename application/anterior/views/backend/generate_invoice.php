<!doctype html>
<html>
<head>
</head>
<body>
     <?php 
        $info = $this->db->get_where('cart', array('appointment_id' => $appointment_id))->result_array();
        foreach($info as $inf):
    ?>
    <?php
		$doctor_id = $this->db->get_where('appointment', array('appointment_id' => $inf['appointment_id']))->row()->doctor_id;
		$practice_id = $this->db->get_where('appointment', array('appointment_id' => $inf['appointment_id']))->row()->practice;
		if($practice_id > 0){
	        $practice_name = 'Otros servicios';
	    }else{
	        $practice_name = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;
	    }
	    $patient_birth = $this->db->get_where('patient', array('patient_id' => $inf['patient_id']))->row()->date_of_birth;
	    $prescription_date = $this->db->get_where('appointment', array('appointment_id' => $inf['appointment_id']))->row()->date;
	    $prescription_time = $this->db->get_where('appointment', array('appointment_id' => $inf['appointment_id']))->row()->time;
		$specialty_id_1 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_1;
		$colegiado = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->no_college;
        $specialty_id_2 = $this->db->get_where('admin', array('admin_id' => $doctor_id))->row()->specialty_2;
        $specialty_1 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_1))->row()->name;
        $specialty_2 = $this->db->get_where('specialtie', array('specialtie_id' => $specialty_id_2))->row()->name;
	?>
    <div style="width:100%; font-size: 16px; line-height: 24px; font-family: 'nunito'; color: #555;">
	    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td colspan="2">
                    <table  style="width: 100%;line-height: inherit;">
                        <tr>
                            <td style="padding-bottom: 20px; vertical-align: top;">
                                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" alt="Medicaby" style="width:15%;">
                            </td>
                            <td style="padding-bottom: 20px; vertical-align: top;text-align:center;padding-top:5px;">
                                <p><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?></p>
                                <p><small style="font-weight:bold; text-transform:uppercase"><?php echo $specialty_1;?> <?php if($specialty_id_2 > 0):?>- <?php echo $specialty_2;?><?php endif;?></small></p>
                                <p>Colegiado: <b><?php echo $colegiado;?></b></p>
                            </td>
                            <td style="text-align: right;" >
                                <p style="font-size: 12px; text-transform:uppercase"><b>RECIBO</b></p>
                                <p style="font-size: 12px;">No. Recibo: <b><?php echo $inf['appointment_id'];?></b></p>
                                <p style="font-size: 12px;">Impresión: <b><?php echo date('d/m/Y H:i');?></b></p>
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
                                <b >Paciente:</b> <span><?php echo $this->accounts_model->short_name('patient', $inf['patient_id']);?></span>
                                <p >Motivo de Consulta: <b><?php echo $practice_name;?></b></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
		<br>
        <table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td colspan="4" style="padding-top:15px;font-size: 15px;">
                    <b style="font-size: 15px;">Especailista</b><br>
                    <?php echo $this->accounts_model->gender($doctor_id);?> <?php echo $this->accounts_model->short_name('admin',$doctor_id);?>.
                </td>
            </tr>
            <tr>
               <td><br><br></td> 
            </tr>
            <tr>
                <td colspan="4"  style="font-size: 15px;padding:2px;">
                   <b>Cargos de la consulta</b>
                </td>
            </tr>
            
            <tr style="font-family:'Poppins';font-size:14px;">
                <td >
                    Valor de la consulta:
                </td>
                <td class="text-right">
                    <strong><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency.'. '.number_format($this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->charges,'2','.',','); ?></strong>
                </td>
            </tr> 
            
            
        </table>
                           
                    <?php $detalles = unserialize($inf['products']);  
                    
                    if(count($detalles)>0):
                    ?>
                      <h6>Medicamentos</h6>
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
        <?php endif?>
        
        
        <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; margin-top:50px;">
            <tbody>
            <tr>
                <td colspan="4" style="padding:10px;font-size: 17px;text-align:right;border:1px; border-top:1px solid black">
                    <b>TOTAL: </b>
                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($inf['total']+$this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->charges,'2','.',',');?>
                </td>
            </tr>
            </tbody>
        </table>
        
        
        
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
                            </td><?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
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
    <?php endforeach;?>
</body>
</html>
