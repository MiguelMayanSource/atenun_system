<!doctype html>
<html>
<head>
</head>
<body>
    <?php 
        $info = $this->db->get_where('odonto_treatment', array('treatment_id' => $treatment_id))->result_array();
        foreach($info as $inf):
            $ex                  = $this->crud_model->appointment_status_treatment($inf['treatment_id']);
            $exp                 = explode('-', $ex);
            $stat                = $exp[0];
            $appointment_id      = $exp[1];
            $practice            = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
            $consulta            = $this->db->get_where('service', array('service_id' => $practice))->row()->cost;
            $currency            = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
            $appointment_comment = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_comment;
            $appoints            = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
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
                                <p style="font-size: 12px;"><b>Hoja de tratamiento dental</b></p>
                                <p style="font-size: 12px;">Generado por: <b>Medicaby</b></p>
                                <p style="font-size: 12px;">Impreso por: <b><?php echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id'));?></b></p>
                                <p style="font-size: 12px;">Fecha: <b><?php echo date('d/m/Y H:i a');?></b></p>
                                <p style="font-size: 12px;">Correlativo: <b><?php echo $treatment_id;?></b></p>
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
								Fecha: <b><?php echo $inf['date'];?></b><br>
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
                     <h3>Desgloce de la información del tratamiento</h3>
                 
                    <div>
                        <table style="width:100%">
                            <tbody >
                                <tr style="font-family:'Poppins';font-size:14px;">
                                <td >
                                    <b>Valor de la consulta:</b>
                                </td>
                                <td class="text-right">
                                    <strong><?php if($practice == '' || $practice == 0) echo $currency.'. 0.00'; else echo $currency.'. '.number_format($consulta,'2','.',',');?></strong>
                                </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                   
                    <?php
                        $this->db->group_by('tooth_id');
                        $this->db->where('odonto_treatment_id', $inf['treatment_id']);
                        $detalles = $this->db->get('tooth_treatment');
                        if($detalles->num_rows() > 0):
                    ?>
                      <h3>Tratamientos actuales</h3>
                <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; " >
            <tr style="border:1px; padding:5px;font-size: 12px; border-top:1px solid black">
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Pieza
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Procedimiento
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Fecha
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Descripción
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Estado
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Total
                </td>
            </tr>
           	<?php 
    		    $final = 0;
    			foreach($detalles->result_array() as $item):
    			$total1 = 0;
                $st = 0;
                $this->db->where('tooth_id', $item['tooth_id']);
                $this->db->where('odonto_treatment_id', $inf['treatment_id']);
                $treat = $this->db->get('tooth_treatment');
            ?>
                <tr >
                    <td style="padding:5px;font-size: 12px; ">
                        <b style="font-size: 12px;"><?php echo  $item['tooth_id'];?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <ul style="padding-left: 17px!important;">
                            <?php foreach($treat->result_array() as $row):?>
                            
                            <li>                          
                                <?php if($row['status'] > 0):?>
                                        <i style="color:green;font-weight:bold;" class="picons-thin-icon-thin-0154_ok_successful_check"></i>
                                <?php else:?>
                                        <?php $st++;?>
                                        <i style="color:grey;font-weight:bold;"  class="picons-thin-icon-thin-0154_ok_successful_check"></i>
                                <?php endif;?>
                            
                                <?php echo $this->db->get_where('process', array('process_id' => $row['process']))->row()->name;?>
                                    
                                <?php $total1 += $this->db->get_where('process', array('process_id' => $row['process']))->row()->price; ?>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    </td>
                    
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $item['date'];?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $item['comment'];?></b>
                    </td>
                     <?php if($st>0):?>
                      <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;">En progreso</b>
                    </td>
                    <?php else:?>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"> Finalizado</b>
                    </td>
                     <?php endif;?>
                    <?php $final += $total1;?>
                     <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($total1, '2', '.', ',');?></b>
                    </td>
                </tr>
            <?php endforeach;?>
            
                <tr >
                    <td style="padding:5px;font-size: 12px; ">
                        <b style="font-size: 12px;"></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        
                    </td>
                    
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"></b>
                    </td>
                    
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 13px;"> Total</b>
                    </td>
                  
                   
                     <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($final, '2', '.', ',');?></b>
                    </td>
                </tr>

        </table>
        <?php endif?>
        
        <hr>
        <br>
        
        	<?php 
    		    $refresh_query = $this->db->get_where('payment_credit', array('patient_id' =>$patient_id, 'tooth_treatment_id' =>  $inf['treatment_id']));
    		    if($refresh_query->num_rows() > 0):
    		    ?>
            <h3>Pagos abonados</h3>
            <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; " >
            <tr style="border:1px; padding:5px;font-size: 12px; border-top:1px solid black">
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    ID
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Fecha
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Hora
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Ingresado por
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Detalles
                </td>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                    Cantidad
                </td>
            </tr>
           	<?php 
    		    $total = 0;
    			foreach($refresh_query->result_array() as $tr):  $total +=  $tr['amount'];
            ?>
                <tr >
                    <td style="padding:5px;font-size: 12px; ">
                        <b style="font-size: 12px;"><?php echo  $tr['payment_credit_id'];?> </b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <?php echo date('d/m/Y', strtotime($tr['date']));?>
                    </td>
                    
                     <td style="padding:5px;font-size: 12px;">
                        <?php echo $tr['time'];?>
                    </td>
                    <?php if($tr['user_type'] == 'doctor'):?>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $this->accounts_model->short_name('admin', $this->session->userdata('login_user_id'));?></b>
                    </td>
                     <?php else:?>
                     <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"></b><?php echo $this->accounts_model->short_name($tr['user_type'], $this->session->userdata('login_user_id'));?></b>
                    </td>
                     <?php endif;?>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"> <?php echo $tr['details'];?></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($tr['amount'],'2','.',',');?></b>
                    </td>
                </tr>
            <?php endforeach;?>
                <tr >
                    <td style="padding:5px;font-size: 12px; ">
                        <b style="font-size: 12px;"></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        
                    </td>
                    
                     <td style="padding:5px;font-size: 12px;">
                      
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"></b>
                    </td>
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 13px;">Total</b>
                    </td>
                   
                    <td style="padding:5px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($total,'2','.',',');?></b>
                    </td>
                </tr>
        </table>
        <?php endif?>
        <hr>
        <br>
        
        
        <?php 
         
        if($inf['status'] != 2):
        $datamed = $this->db->get_where('prescription', array('appointment_id' => $appointment_id, 'patient_id' => $patient_id));
        if($datamed->num_rows() > 0):?>
        <table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:5px;" colspan="4">
                    Medicamentos
                </td>
            </tr>
            <?php
                foreach($datamed->result_array() as $dts):
            ?>
                <tr>
                    <td colspan="4" style="padding-top:15px;font-size: 12px;">
                        <b style="font-size: 12px;"><?php echo $dts['medicine'];?></b><br>
                        <?php echo $dts['quantity'];?> <?php echo $dts['frequency'];?> durante <?php echo $dts['duration'];?>.
                    </td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="4" style="padding-top:20px;font-size: 12px;">
                    Si ocurre una reacción alérgica, suspender el medicamento.
                </td>
            </tr>
            
            <?php if($rws['doctor_comment'] != ''):?>
              <tr>
                <td colspan="4" style="padding-top:30px;font-size: 12px;">
                    <b>Instrucciones Médicas:</b><br>
                    <?php echo $appointment_comment;?>
                </td>
            </tr>
            <?php endif;?>
        </table>
        <?php endif; 
        
        elseif($inf['status'] == 2):
        ?>
         <?php
             foreach($appoints as $rws):?>
        <table cellpadding="0" cellspacing="0"  style="width: 100%;line-height: inherit;text-align: left;">
            <tr>
                <td style="background: #eee;font-style:italic; font-weight:bold;padding:5px;" colspan="4">
                  Medicamentos de la fecha: <?php echo $rws['date'];?>
                </td>
            </tr>
            <?php     $datamed = $this->db->get_where('prescription', array('appointment_id' => $rws['appointment_id'], 'patient_id' => $patient_id));
                foreach($datamed->result_array() as $dts):
            ?>
            <tr>
                <td colspan="4" style="padding-top:15px;font-size: 12px;">
                    <b style="font-size: 12px;"><?php echo $dts['medicine'];?></b><br>
                    <?php echo $dts['quantity'];?> <?php echo $dts['frequency'];?> durante <?php echo $dts['duration'];?>.
                </td>
            </tr>
            <br>
            <?php endforeach;
            if($rws['doctor_comment'] != ''):?>
            <tr>
                <td colspan="4" style="padding-top:15px;font-size: 12px;">
                    <b>Instrucciones:</b> <?php echo $rws['doctor_comment'];?>
                </td>
            </tr>
            <?php endif; ?>
        </table>
        <br>
        <?php endforeach; endif;?>
        
        
        <table cellpadding="0" cellspacing="0"  style="width: 100%; text-align: left; margin-top:50px;">
            <tbody>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 13px;text-align:right;border:1px;">
                    <b>Total tratamiento: </b>
                    <?php echo $currency.'. '.number_format($final,'2','.',',');?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 13px;text-align:right;border:1px;">
                      <b>Descuento: </b>
                    <?php echo $currency.'. '.number_format($inf['discount'],'2','.',',');?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 13px;text-align:right;border:1px;">
                    <b>Consulta: </b>
                    <?php echo $currency.'. '.number_format($consulta,'2','.',',');?>
                </td>
            </tr>
            <?php if(count($appoints) > 1):
                $cts_ant = 0;
            foreach($appoints as $nrs)
            {
                if($nrs['appointment_id'] != $appointment_id)
                {
                    $cts_ant += $this->db->get_where('service', array('service_id' => $nrs['practice'] ))->row()->cost;
                }
            }
            ?>
             <tr>
                <td colspan="4" style="padding:3px;font-size: 13px;text-align:right;border:1px;">
                    <b>Consultas anteriores: </b>
                    <?php echo $currency.'. '.number_format($cts_ant,2,'.',',');?>
                </td>
            </tr>
            <?php endif;?>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 14px;text-align:right;border:1px; border-top:1px solid black">
                    <b>Total final: </b>
                    <?php echo $currency.'. '.number_format(($consulta+$final+$cts_ant)-$inf['discount'],'2','.',',');?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 13px;text-align:right;border:1px;">
                      <b>Abonos: </b>
                    <?php echo $currency.'. '.number_format($total,'2','.',',');?>
                </td>
            </tr>
            
            <?php if($total > 0):?>
            <tr>
                <td colspan="4" style="padding:3px;font-size: 14px;text-align:right;border:1px; border-top:1px solid black">
                    <b>Saldo: </b>
                    <?php echo $currency.'. '.number_format(($consulta+$final+$cts_ant)-($total+$inf['discount']) ,'2','.',',');?>
                </td>
            </tr>
            <?php endif;?>
            </tbody>
        </table>
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
    <?php endforeach;?>
</body> 
</html>
